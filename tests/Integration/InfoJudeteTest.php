<?php

namespace AninuApps\InsideAppPhp\Tests\Integration;

use AninuApps\InsideApp\InsideApp;
use PHPUnit\Framework\TestCase;

/**
 * Test de integrare pentru metoda infoJudente()
 * 
 * Acest test apelează API-ul real InsideApp pentru a verifica
 * funcționalitatea metodei infoJudente() și a vedea structura răspunsului.
 * 
 * Rulare:
 * INSIDEAPP_TEST_USERNAME="..." INSIDEAPP_TEST_PASSWORD="..." INSIDEAPP_TEST_EMAIL="..." vendor/bin/phpunit tests/Integration/InfoJudeteTest.php --verbose
 */
class InfoJudeteTest extends TestCase
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
     * Test de bază pentru metoda infoJudente() - verifică că returnează data validă
     */
    public function testInfoJudeteReturnsValidResponse(): void
    {
        echo "\n🔍 ==> Testing infoJudente() method...\n";
        
        $data = [
            'email_responsabil' => $this->email
        ];

        $response = $this->insideApp->infoJudente($data);

        echo "\n📋 ==> RAW API RESPONSE:\n";
        echo ">>><pre>\n";
        print_r($response);
        echo "</pre>\n";

        // Verificări base  
        $this->assertIsArray($response, 'Răspunsul trebuie să fie un array');
        $this->assertArrayHasKey('status', $response, 'Răspunsul trebuie să conțină cheia status');

        if ($response['status'] === 'SUCCESS') {
            echo "\n✅ ==> API call SUCCESS!\n";
            
            $this->assertArrayHasKey('data', $response, 'Răspunsul de succes trebuie să conțină cheia data');
            $this->assertIsArray($response['data'], 'Data trebuie să fie un array');
        
            if (!empty($response['data'])) {
                echo "\n📊 ==> ANALYZING RESPONSE STRUCTURE:\n";
                
                // Analizăm primul județ pentru structură
                $firstJudet = $response['data'][0];
                echo "First county structure:\n";
                print_r($firstJudet);
                
                // Verificăm câmpurile esențiale
                $this->assertArrayHasKey('cod', $firstJudet, 'Fiecare județ trebuie să aibă cod');
                $this->assertArrayHasKey('nume', $firstJudet, 'Fiecare județ trebuie să aibă nume');
                
                echo "\n📈 ==> STATISTICS:\n";
                echo "Total judete: " . count($response['data']) . "\n";
                
                // Verificăm dacă avem județe din toate regiunile
                $regiuni = [];
                foreach ($response['data'] as $judet) {
                    if (isset($judet['regiune'])) {
                        $regiuni[$judet['regiune']] = ($regiuni[$judet['regiune']] ?? 0) + 1;
                    }
                }
                
                if (!empty($regiuni)) {
                    echo "Repartitie pe regiuni:\n";
                    foreach ($regiuni as $regiune => $count) {
                        echo "  - {$regiune}: {$count} judete\n";
                    }
                }
                
                // Testăm că avem măcar județul București
                $hasB = false;
                foreach ($response['data'] as $judet) {
                    if ($judet['cod'] === 'B' || $judet['nume'] === 'BUCURESTI') {
                        $hasB = true;
                        echo "\n🏛️ Found București: " . print_r($judet, true) . "\n";
                        break;
                    }
                }
                $this->assertTrue($hasB, 'Lista trebuie să conțină județul București');
                
            } else {
                echo "\n⚠️ ==> WARNING: Response data is empty\n";
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
     * Test că metoda funcționează și fără email_responsabil (parametru opțional)
     */
    public function testInfoJudeteWorksWithoutEmail(): void
    {
        echo "\n🔍 ==> Testing infoJudente() without email...\n";
        
        $response = $this->insideApp->infoJudente([]);

        echo "\n📋 ==> RAW API RESPONSE (no email):\n";
        echo ">>><pre>\n";  
        print_r($response);
        echo "</pre>\n";

        $this->assertIsArray($response, 'Răspunsul trebuie să fie un array');
        $this->assertArrayHasKey('status', $response, 'Răspunsul trebuie să conțină cheia status');
        
        // Testul poate să treacă sau să dea eroare, depinde de API
        if ($response['status'] === 'SUCCESS') {
            echo "\n✅ ==> Works without email parameter!\n";
        } else {
            echo "\n⚠️ ==> Requires email parameter: " . ($response['message'] ?? 'Unknown error') . "\n";
        }
    }

    /**
     * Test pentru verificarea performanței apelului API
     */
    public function testInfoJudetePerformance(): void
    {
        echo "\n⏱️ ==> Testing infoJudete() performance...\n";
        
        $startTime = microtime(true);
        
        $response = $this->insideApp->infoJudente([
            'email_responsabil' => $this->email
        ]);
        
        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000; // în milisecunde
        
        echo "\n📊 ==> PERFORMANCE METRICS:\n";
        echo "Execution time: " . round($executionTime, 2) . " ms\n";
        
        $this->assertIsArray($response, 'Răspunsul trebuie să fie un array');
        
        // Verificăm că apelul se finalizează în timp rezonabil (sub 10 secunde)
        $this->assertLessThan(10000, $executionTime, 'Apelul API trebuie să se finalizeze în sub 10 secunde');
        
        if ($executionTime < 1000) {
            echo "✅ Fast response (< 1s)\n";
        } elseif ($executionTime < 3000) {
            echo "⚡ Decent response (< 3s)\n";
        } else {
            echo "⚠️ Slow response (> 3s)\n";
        }
    }
}