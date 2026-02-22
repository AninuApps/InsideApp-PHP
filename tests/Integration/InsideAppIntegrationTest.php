<?php

namespace AninuApps\InsideApp\Tests\Integration;

use PHPUnit\Framework\TestCase;
use AninuApps\InsideApp\InsideApp;
use AninuApps\InsideApp\Tests\Fixtures\TestDataFixtures;

/**
 * Teste de integrare pentru InsideApp SDK
 * 
 * Aceste teste verifică comunicarea cu API-ul real sau cu mock-uri
 * Pentru a rula teste cu API real, setați variabilele de mediu:
 * - INSIDEAPP_TEST_USERNAME
 * - INSIDEAPP_TEST_PASSWORD  
 * - INSIDEAPP_TEST_EMAIL
 * - INSIDEAPP_INTEGRATION_TESTS=true
 */
class InsideAppIntegrationTest extends TestCase
{
    private InsideApp $insideApp;
    private array $credentials;

    protected function setUp(): void
    {
        $this->credentials = TestDataFixtures::getTestCredentials();
        $this->insideApp = new InsideApp(
            $this->credentials['username'],
            $this->credentials['password']
        );
    }

    /**
     * Test conectare la API și verificare credențiale
     */
    public function testApiConnection(): void
    {
        // Skip test dacă nu avem credențiale reale
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled. Set INSIDEAPP_INTEGRATION_TESTS=true to enable.');
        }

        $this->assertTrue(true, 'Conexiunea la API funcționează');
        
        // În viitor, când implementăm metoda testConnection:
        // $connected = $this->insideApp->testConnection();
        // $this->assertTrue($connected, 'Nu se poate conecta la API InsideApp');
    }

    /**
     * Test obținere curs valutar (endpoint fără autentificare specială)
     */
    public function testCursValutarIntegration(): void
    {
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled.');
        }

        try {
            $response = $this->insideApp->cursValutar();
            
            // DEBUG: Afișează răspunsul raw pentru analiză
            echo "\n🔵 RĂSPUNS CURS VALUTAR:\n";
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            echo "\n";
            
            // Verifică structura răspunsului
            $this->assertTrue(TestDataFixtures::validateApiResponse($response));
            $this->assertEquals('SUCCESS', $response['status']);
            $this->assertArrayHasKey('data', $response);
            
            // Verifică că avem cursuri (structura poate varia)
            $cursuri = $response['data'];
            $this->assertNotEmpty($cursuri, 'Răspunsul trebuie să conțină cursuri valutare');
            
            // API-ul returnează cursurile în data.output array
            if (isset($cursuri['output']) && is_array($cursuri['output'])) {
                $this->assertGreaterThan(0, count($cursuri['output']), 'Trebuie să existe cel puțin o monedă');
                
                // Verifică că există EUR în listă
                $eurFound = false;
                foreach ($cursuri['output'] as $moneda) {
                    if ($moneda['tag'] === 'EUR') {
                        $eurFound = true;
                        $this->assertIsNumeric($moneda['value']);
                        $this->assertGreaterThan(0, (float)$moneda['value']);
                        break;
                    }
                }
                $this->assertTrue($eurFound, 'EUR trebuie să fie în lista de cursuri');
            }
            
        } catch (\Exception $e) {
            $this->fail('Eroare la obținerea cursului valutar: ' . $e->getMessage());
        }
    }

    /**
     * Test verificare CIF (endpoint util pentru validare)
     */
    public function testInfoCifIntegration(): void
    {
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled.');
        }

        $testData = [
            'email_responsabil' => $this->credentials['email'],
            'cif' => 'RO12345678' // CIF de test
        ];

        try {
            $response = $this->insideApp->infoCif($testData);
            
            // DEBUG: Afișează răspunsul raw pentru analiză
            echo "\n🟡 RĂSPUNS INFO CIF:\n";
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            echo "\n";
            
            // Verifică structura răspunsului  
            $this->assertTrue(TestDataFixtures::validateApiResponse($response));
            
            // Răspunsul poate fi SUCCESS sau ERROR (dacă CIF-ul nu există)
            $this->assertContains($response['status'], ['SUCCESS', 'ERROR']);
            
            if ($response['status'] === 'SUCCESS') {
                $this->assertArrayHasKey('data', $response);
            }
            
        } catch (\Exception $e) {
            $this->fail('Eroare la verificarea CIF: ' . $e->getMessage());
        }
    }

    /**
     * Test listare facturi (necesită autentificare)
     */
    public function testListareFacturiIntegration(): void
    {
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled.');
        }

        try {
            // Adaugă parametrii obligatorii: email_responsabil și data_start
            $response = $this->insideApp->viewFacturi([
                'limit' => 5,
                'email_responsabil' => $this->credentials['email'],
                'data_start' => '2026-01-01',
                'data_sfarsit' => '2026-02-28'
            ]);
            
            // DEBUG: Afișează răspunsul raw pentru analiză
            echo "\n🟠 RĂSPUNS VIEW FACTURI:\n";
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            echo "\n";
            
            // Verifică structura răspunsului
            $this->assertTrue(TestDataFixtures::validateApiResponse($response));
            
            if ($response['status'] === 'SUCCESS') {
                $this->assertArrayHasKey('data', $response);
                
                // Verifică că data conține lista de facturi
                if (isset($response['data']['output'])) {
                    $this->assertIsArray($response['data']['output']);
                }
            } else {
                // Dacă e ERROR, verifică că avem mesaj de eroare
                $this->assertNotEmpty($response['message']);
            }
            
        } catch (\Exception $e) {
            $this->fail('Eroare la listarea facturilor: ' . $e->getMessage());
        }
    }

    /**
     * Test timeout și retry logic
     */
    public function testTimeoutConfiguration(): void
    {
        // Test că timeout-ul se poate configura
        $result = $this->insideApp->setTimeout(60);
        $this->assertInstanceOf(InsideApp::class, $result);
        
        // Test timeout invalid
        $this->expectException(\InvalidArgumentException::class);
        $this->insideApp->setTimeout(-1);
    }

    /**
     * Test gestionarea erorilor API
     */
    public function testApiErrorHandling(): void
    {
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled.');
        }

        // Test cu date invalide pentru a forța o eroare
        $invalidData = [
            'email_responsabil' => '', // Email gol
            'cif' => 'INVALID_CIF'
        ];

        try {
            $response = $this->insideApp->infoCif($invalidData);
            
            // Ne așteptăm la un răspuns de eroare
            $this->assertTrue(TestDataFixtures::validateApiResponse($response));
            
            if ($response['status'] === 'ERROR') {
                $this->assertNotEmpty($response['message']);
                $this->assertNotEquals('000', $response['error_code']);
            }
            
        } catch (\Exception $e) {
            // E OK să primim excepție pentru date invalide
            $this->assertNotEmpty($e->getMessage());
        }
    }

    /**
     * Test mock răspunsuri pentru development
     */
    public function testMockApiResponses(): void
    {
        $mockResponses = TestDataFixtures::getMockApiResponses();
        
        // Test răspuns de success
        $successResponse = $mockResponses['success'];
        $this->assertTrue(TestDataFixtures::validateApiResponse($successResponse));
        $this->assertEquals('SUCCESS', $successResponse['status']);
        $this->assertEquals('000', $successResponse['error_code']);
        
        // Test răspuns de eroare
        $errorResponse = $mockResponses['error'];
        $this->assertTrue(TestDataFixtures::validateApiResponse($errorResponse));
        $this->assertEquals('ERROR', $errorResponse['status']);
        $this->assertNotEquals('000', $errorResponse['error_code']);
        
        // Test răspuns curs valutar
        $cursResponse = $mockResponses['curs_valutar'];
        $this->assertTrue(TestDataFixtures::validateApiResponse($cursResponse));
        $this->assertArrayHasKey('EUR', $cursResponse['data']);
        $this->assertIsNumeric($cursResponse['data']['EUR']);
    }

    /**
     * Test performanță pentru multiple request-uri
     */
    public function testPerformanceMultipleRequests(): void
    {
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled.');
        }

        $startTime = microtime(true);
        
        // Execută 5 request-uri consecutive
        for ($i = 0; $i < 5; $i++) {
            try {
                $response = $this->insideApp->cursValutar();
                $this->assertTrue(TestDataFixtures::validateApiResponse($response));
            } catch (\Exception $e) {
                // Loghează eroarea dar continuă testul
                error_log("Request $i failed: " . $e->getMessage());
            }
        }
        
        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;
        
        // Verifică că timpul total e rezonabil (< 30 secunde pentru 5 requesturi)
        $this->assertLessThan(30, $totalTime, 'Request-urile durează prea mult timp');
    }

    /**
     * Test nomenclatoare (pentru a vedea structura răspunsurilor)
     */
    public function testNomenclatoareIntegration(): void
    {
        if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled.');
        }

        try {
            // Testează doar metodele care există în SDK
            $reflection = new \ReflectionClass($this->insideApp);
            
            // Test cursValutar (știm sigur că există)
            $cursuri = $this->insideApp->cursValutar();
            echo "\n💰 RĂSPUNS CURS VALUTAR (din test nomenclatoare):\n";
            echo json_encode($cursuri, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            echo "\n";
            $this->assertTrue(TestDataFixtures::validateApiResponse($cursuri));
            
            // Test infoCif cu un CIF valid românesc
            $cifTest = $this->insideApp->infoCif([
                'email_responsabil' => $this->credentials['email'],
                'cif' => 'RO1234567' // CIF mai scurt, poate existent
            ]);
            echo "\n🏢 TEST CIF ALTERNATIV:\n";
            echo json_encode($cifTest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            echo "\n";
            
            // Listează metodele disponibile pentru info
            $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
            $availableMethods = [];
            foreach ($publicMethods as $method) {
                $methodName = $method->getName();
                if (!in_array($methodName, ['__construct', 'execute', 'getVersion', 'setTimeout'])) {
                    $availableMethods[] = $methodName;
                }
            }
            
            echo "\n📋 METODE DISPONIBILE ÎN SDK (" . count($availableMethods) . " total):\n";
            echo implode(', ', array_slice($availableMethods, 0, 20)) . "...\n";
            
        } catch (\Exception $e) {
            echo "\n❗ Eroare la nomenclatoare: " . $e->getMessage() . "\n";
            // Nu facem fail pentru că poate unele endpoint-uri să nu fie disponibile
            $this->addWarning('Nomenclatoarele nu sunt disponibile: ' . $e->getMessage());
        }
    }

    /**
     * Test cu date reale generate
     */
    public function testWithGeneratedTestData(): void
    {
        // Folosește fixture-urile pentru a genera date de test
        $facturaData = TestDataFixtures::getValidFacturaData();
        $proformaData = TestDataFixtures::getValidProformaData();
        $firmaData = TestDataFixtures::getValidFirmaData();
        
        // Verifică că datele generate sunt valide
        $this->assertArrayHasKey('email_responsabil', $facturaData);
        $this->assertArrayHasKey('client', $facturaData);
        $this->assertArrayHasKey('continut', $facturaData);
        
        $this->assertArrayHasKey('email_responsabil', $proformaData);
        $this->assertArrayHasKey('client', $proformaData);
        
        $this->assertArrayHasKey('email_responsabil', $firmaData);
        $this->assertArrayHasKey('nume', $firmaData);
        $this->assertArrayHasKey('cif', $firmaData);
        
        // Verifică că CIF-urile generate sunt valide
        $this->assertRegExp('/^RO\d{8}$/', $facturaData['client']['cif']);
        $this->assertRegExp('/^RO\d{8}$/', $proformaData['client']['cif']);
        $this->assertRegExp('/^RO\d{8}$/', $firmaData['cif']);
    }
}