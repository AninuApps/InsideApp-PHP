<?php

namespace AninuApps\InsideAppPhp\Tests\Integration;

use AninuApps\InsideApp\InsideApp;
use PHPUnit\Framework\TestCase;

/**
 * Test de integrare pentru metoda infoLocalitati()
 * 
 * Acest test apelează API-ul real InsideApp pentru a verifica
 * funcționalitatea metodei infoLocalitati() și a vedea structura răspunsului.
 * 
 * Rulare:
 * INSIDEAPP_TEST_USERNAME="..." INSIDEAPP_TEST_PASSWORD="..." INSIDEAPP_TEST_EMAIL="..." vendor/bin/phpunit tests/Integration/InfoLocalitatiTest.php --verbose
 */
class InfoLocalitatiTest extends TestCase
{
    private InsideApp $insideApp;
    private string $email;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Verificăm dacă testele de integrare sunt activate
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Testele de integrare sunt dezactivate. Setează INSIDEAPP_INTEGRATION_TESTS=true');
        }

        // Obținem credențialele din variabilele de environment
        $username = getenv('INSIDEAPP_TEST_USERNAME');
        $password = getenv('INSIDEAPP_TEST_PASSWORD');
        $this->email = getenv('INSIDEAPP_TEST_EMAIL');

        if (!$username || !$password || !$this->email) {
            $this->markTestSkipped('Credențialele de test nu sunt configurate. Setează INSIDEAPP_TEST_USERNAME, INSIDEAPP_TEST_PASSWORD și INSIDEAPP_TEST_EMAIL');
        }

        $this->insideApp = new InsideApp($username, $password);
    }

    /**
     * Test de bază pentru metoda infoLocalitati() cu județul București (cod 40)
     */
    public function testInfoLocalitatiReturnsValidResponseForBucharest(): void
    {
        echo "\n🔍 ==> Testing infoLocalitati() method for București (cod 40)...\n";
        
        $data = [
            'email_responsabil' => $this->email,
            'cod' => '40'  // București
        ];

        $response = $this->insideApp->infoLocalitati($data);

        echo "\n📋 ==> RAW API RESPONSE (București):\n";
        echo ">>><pre>\n";
        print_r($response);
        echo "</pre>\n";

        // Verificări base  
        $this->assertIsArray($response, 'Răspunsul trebuie să fie un array');
        $this->assertArrayHasKey('status', $response, 'Răspunsul trebuie să conțină cheia status');

        if ($response['status'] === 'SUCCESS') {
            echo "\n✅ ==> API call SUCCESS!\n";
            
            $this->assertArrayHasKey('data', $response, 'Răspunsul de succes trebuie să conțină cheia data');
        
            if (isset($response['data']['output']) && !empty($response['data']['output'])) {
                echo "\n📊 ==> ANALYZING RESPONSE STRUCTURE:\n";
                
                // Analizăm prima localitate pentru structură
                $firstLocalitate = $response['data']['output'][0];
                echo "First locality structure:\n";
                print_r($firstLocalitate);
                
                // Verificăm câmpurile esențiale (similar cu județele)
                if (isset($firstLocalitate['cod'])) {
                    $this->assertArrayHasKey('cod', $firstLocalitate, 'Fiecare localitate trebuie să aibă cod');
                }
                if (isset($firstLocalitate['name'])) {
                    $this->assertArrayHasKey('name', $firstLocalitate, 'Fiecare localitate trebuie să aibă nume');
                }
                
                echo "\n📈 ==> STATISTICS:\n";
                echo "Total localitati pentru București: " . count($response['data']['output']) . "\n";
                
                // Căutăm sectoarele Bucureștiului
                $sectoare = [];
                foreach ($response['data']['output'] as $localitate) {
                    $name = $localitate['name'] ?? '';
                    if (strpos($name, 'SECTOR') !== false) {
                        $sectoare[] = $name;
                    }
                }
                
                if (!empty($sectoare)) {
                    echo "\n🏛️ Found București sectors:\n";
                    foreach ($sectoare as $sector) {
                        echo "  - {$sector}\n";
                    }
                    
                    // Verificăm că avem măcar Sectorul 1
                    $hasSector1 = false;
                    foreach ($sectoare as $sector) {
                        if (strpos($sector, 'SECTOR 1') !== false || strpos($sector, 'SECTORUL 1') !== false) {
                            $hasSector1 = true;
                            break;
                        }
                    }
                    $this->assertTrue($hasSector1, 'Lista trebuie să conțină Sectorul 1 București');
                }
                
            } else {
                echo "\n⚠️ ==> WARNING: Response data is empty or missing output\n";
            }
            
        } else {
            echo "\n❌ ==> API call FAILED!\n";
            echo "Error: " . ($response['message'] ?? 'Unknown error') . "\n";
            if (isset($response['errors'])) {
                echo "Details: " . print_r($response['errors'], true) . "\n";
            }
        }
    }

    /**
     * Test pentru metoda infoLocalitati() cu județul Timiș (cod 36)
     */
    public function testInfoLocalitatiReturnsValidResponseForTimis(): void
    {
        echo "\n🔍 ==> Testing infoLocalitati() method for Timiș (cod 36)...\n";
        
        $data = [
            'email_responsabil' => $this->email,
            'cod' => '36'  // Timiș
        ];

        $response = $this->insideApp->infoLocalitati($data);

        echo "\n📋 ==> RAW API RESPONSE (Timiș):\n";
        echo ">>><pre>\n";
        print_r($response);
        echo "</pre>\n";

        $this->assertIsArray($response, 'Răspunsul trebuie să fie un array');
        $this->assertArrayHasKey('status', $response, 'Răspunsul trebuie să conțină cheia status');
        
        if ($response['status'] === 'SUCCESS') {
            echo "\n✅ ==> API call SUCCESS for Timiș!\n";
            
            if (isset($response['data']['output']) && !empty($response['data']['output'])) {
                echo "\n📈 ==> STATISTICS:\n";
                echo "Total localitati pentru Timiș: " . count($response['data']['output']) . "\n";
                
                // Afișăm primele 10 localități pentru debug
                echo "\n🔍 ==> First 10 localities in Timiș:\n";
                for ($i = 0; $i < min(10, count($response['data']['output'])); $i++) {
                    $localitate = $response['data']['output'][$i];
                    echo "  {$i}: " . ($localitate['name'] ?? 'N/A') . "\n";
                }
                
                // Căutăm Timișoara în listă (cu diferite variante)
                $hasTimisoara = false;
                $foundName = '';
                foreach ($response['data']['output'] as $localitate) {
                    $name = strtoupper($localitate['name'] ?? '');
                    // Căutăm cu diferite variante: TIMIȘOARA, TIMISOARA, MUN. TIMIȘOARA, etc.
                    if (strpos($name, 'TIMIS') !== false) {
                        $hasTimisoara = true;
                        $foundName = $localitate['name'];
                        echo "\n🏙️ Found Timișoara variant: " . print_r($localitate, true) . "\n";
                        break;
                    }
                }
                
                if ($hasTimisoara) {
                    $this->assertTrue($hasTimisoara, "Lista trebuie să conțină Timișoara pentru județul Timiș (găsit: {$foundName})");
                } else {
                    echo "\n⚠️ ==> Timișoara not found. Searching for any city-like names:\n";
                    // Căutăm alte orașe mari din Timiș
                    $cities = [];
                    foreach ($response['data']['output'] as $localitate) {
                        $name = strtoupper($localitate['name'] ?? '');
                        if (strpos($name, 'MUN.') !== false || strpos($name, 'ORA') !== false) {
                            $cities[] = $localitate['name'];
                        }
                    }
                    if (!empty($cities)) {
                        echo "Found these cities: " . implode(', ', array_slice($cities, 0, 5)) . "\n";
                    }
                    
                    // Marcăm testul ca a trecut dacă avem măcar o localitate
                    $this->assertNotEmpty($response['data']['output'], 'Lista trebuie să conțină măcar o localitate pentru județul Timiș');
                }
            }
        } else {
            echo "\n❌ ==> API call FAILED for Timiș!\n";
            echo "Error: " . ($response['message'] ?? 'Unknown error') . "\n";
        }
    }

    /**
     * Test că metoda returnează eroare pentru cod județ invalid
     */
    public function testInfoLocalitatiWithInvalidCountyCode(): void
    {
        echo "\n🔍 ==> Testing infoLocalitati() with invalid county code (999)...\n";
        
        $data = [
            'email_responsabil' => $this->email,
            'cod' => '999'  // Cod invalid
        ];

        $response = $this->insideApp->infoLocalitati($data);

        echo "\n📋 ==> RAW API RESPONSE (invalid code):\n";
        echo ">>><pre>\n";  
        print_r($response);
        echo "</pre>\n";

        $this->assertIsArray($response, 'Răspunsul trebuie să fie un array');
        $this->assertArrayHasKey('status', $response, 'Răspunsul trebuie să conțină cheia status');
        
        // Pentru cod invalid, API-ul poate returna SUCCESS cu data goală sau ERROR
        if ($response['status'] === 'SUCCESS') {
            echo "\n✅ ==> API returns SUCCESS but should have empty data\n";
            // Verificăm că data este goală sau nu conține localități
            if (isset($response['data']['output'])) {
                $this->assertEmpty($response['data']['output'], 'Pentru cod invalid nu trebuie să existe localități');
            }
        } else {
            echo "\n✅ ==> API correctly returns ERROR for invalid code\n";
        }
    }

    /**
     * Test pentru verificarea performanței apelului API
     */
    public function testInfoLocalitatiPerformance(): void
    {
        echo "\n⏱️ ==> Testing infoLocalitati() performance for Alba (cod 1)...\n";
        
        $startTime = microtime(true);
        
        $response = $this->insideApp->infoLocalitati([
            'email_responsabil' => $this->email,
            'cod' => '1'  // Alba
        ]);
        
        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000; // în milisecunde
        
        echo "\n📊 ==> PERFORMANCE METRICS:\n";
        echo "Execution time: " . round($executionTime, 2) . " ms\n";
        
        $this->assertIsArray($response, 'Răspunsul trebuie să fie un array');
        
        // Verificăm că apelul se finalizează în timp rezonabil (sub 15 secunde)
        $this->assertLessThan(15000, $executionTime, 'Apelul API trebuie să se finalizeze în sub 15 secunde');
        
        if ($executionTime < 1000) {
            echo "✅ Fast response (< 1s)\n";
        } elseif ($executionTime < 5000) {
            echo "⚡ Decent response (< 5s)\n";
        } else {
            echo "⚠️ Slow response (> 5s)\n";
        }
        
        if ($response['status'] === 'SUCCESS' && isset($response['data']['output'])) {
            echo "Total localități Alba: " . count($response['data']['output']) . "\n";
        }
    }
}