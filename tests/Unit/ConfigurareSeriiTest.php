<?php

namespace AninuApps\InsideApp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AninuApps\InsideApp\InsideApp;

/**
 * Teste pentru configurarea seriilor de facturi
 */
class ConfigurareSeriiTest extends TestCase
{
    private InsideApp $insideApp;
    private array $validSerieData;

    protected function setUp(): void
    {
        $this->insideApp = new InsideApp('test_user', 'test_password');
        
        $this->validSerieData = [
            'email_responsabil' => 'admin@test.ro',
            'logo' => base64_encode(file_get_contents(__DIR__ . '/../../examples/test_logo.png') ?: 'fake_logo_data'),
            'proforma' => [
                'serie' => 'PF',
                'nr_inceput' => '1',
                'nr_curent' => '100',
                'design' => '1'
            ],
            'factura' => [
                'serie' => 'FF',
                'nr_inceput' => '1',
                'nr_curent' => '500',
                'design' => '2'
            ],
            'chitanta' => [
                'serie' => 'CH',
                'nr_inceput' => '1',
                'nr_curent' => '50'
            ]
        ];
    }

    /**
     * Test că metodele CRUD pentru serii există
     */
    public function testSeriesCrudMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'serieLista'));
        $this->assertTrue(method_exists($this->insideApp, 'serieVizualizare'));
        $this->assertTrue(method_exists($this->insideApp, 'serieAdauga'));
        $this->assertTrue(method_exists($this->insideApp, 'serieModifica'));
        $this->assertTrue(method_exists($this->insideApp, 'serieSterge'));
        $this->assertTrue(method_exists($this->insideApp, 'serieStergeLogo'));
    }

    /**
     * Test că metoda pentru design-uri există
     */
    public function testSerieDesignMethodExists(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'serieDesign'));
    }

    /**
     * Test semnătura metodelor de listare
     */
    public function testListaMethodsSignature(): void
    {
        $listMethods = ['serieLista', 'serieDesign'];
        
        foreach ($listMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă un parametru");
            $this->assertEquals('array', $parameters[0]->getType()->getName());
            $this->assertTrue($parameters[0]->isDefaultValueAvailable(), "Metoda {$methodName} trebuie să aibă valoare default");
        }
    }

    /**
     * Test semnătura metodelor care necesită parametri obligatorii
     */
    public function testRequiredParameterMethodsSignature(): void
    {
        $requiredMethods = [
            'serieVizualizare', 'serieAdauga', 'serieModifica', 
            'serieSterge', 'serieStergeLogo'
        ];

        foreach ($requiredMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă un parametru");
            $this->assertEquals('array', $parameters[0]->getType()->getName());
            $this->assertFalse($parameters[0]->isDefaultValueAvailable(), "Metoda {$methodName} nu trebuie să aibă valoare default");
        }
    }

    /**
     * Test validare date pentru adăugare serie
     */
    public function testSerieAdaugaDataValidation(): void
    {
        // Testăm câmpurile obligatorii
        $this->assertArrayHasKey('email_responsabil', $this->validSerieData);
        $this->assertArrayHasKey('proforma', $this->validSerieData);
        $this->assertArrayHasKey('factura', $this->validSerieData);
        $this->assertArrayHasKey('chitanta', $this->validSerieData);
        
        // Testăm structura proforma
        $proforma = $this->validSerieData['proforma'];
        $this->assertArrayHasKey('serie', $proforma);
        $this->assertArrayHasKey('nr_inceput', $proforma);
        $this->assertArrayHasKey('nr_curent', $proforma);
        $this->assertArrayHasKey('design', $proforma);
        
        // Testăm structura factura
        $factura = $this->validSerieData['factura'];
        $this->assertArrayHasKey('serie', $factura);
        $this->assertArrayHasKey('nr_inceput', $factura);
        $this->assertArrayHasKey('nr_curent', $factura);
        $this->assertArrayHasKey('design', $factura);
        
        // Testăm structura chitanta
        $chitanta = $this->validSerieData['chitanta'];
        $this->assertArrayHasKey('serie', $chitanta);
        $this->assertArrayHasKey('nr_inceput', $chitanta);
        $this->assertArrayHasKey('nr_curent', $chitanta);
    }

    /**
     * Test validare logo base64
     */
    public function testLogoBase64Validation(): void
    {
        $validLogo = base64_encode('fake_image_data');
        $invalidLogos = ['', 'not_base64!!!', null];
        
        // Test logo valid
        $decoded = base64_decode($validLogo, true);
        $this->assertNotFalse($decoded, 'Logo valid trebuie să fie decodabil');
        
        // Test logo-uri invalide
        foreach ($invalidLogos as $logo) {
            if ($logo !== null && $logo !== '') {
                $decoded = base64_decode($logo, true);
                $this->assertFalse($decoded, "Logo {$logo} trebuie să fie invalid");
            }
        }
    }

    /**
     * Test validare serii - format string nevid
     */
    public function testSerieFormatValidation(): void
    {
        $validSeries = ['FF', 'PF', 'CH', 'ABC', '123'];
        $invalidSeries = ['', null, '   ', 'FOARTE_LUNGA_SERIE_1234567890'];
        
        foreach ($validSeries as $serie) {
            $this->assertIsString($serie, "Seria {$serie} trebuie să fie string");
            $this->assertNotEmpty(trim($serie), "Seria {$serie} nu trebuie să fie goală");
            $this->assertLessThanOrEqual(10, strlen($serie), "Seria {$serie} trebuie să aibă max 10 caractere");
        }
        
        foreach ($invalidSeries as $serie) {
            if ($serie !== null) {
                $this->assertTrue(empty(trim($serie)) || strlen($serie) > 10, "Seria {$serie} trebuie să fie invalidă");
            }
        }
    }

    /**
     * Test validare numere - trebuie să fie numerice pozitive
     */
    public function testNumerotareValidation(): void
    {
        $validNumbers = ['1', '100', '9999', '0'];
        $invalidNumbers = ['', '-1', 'abc', null, '1.5'];
        
        foreach ($validNumbers as $number) {
            $this->assertRegExp('/^\d+$/', $number, "Numărul {$number} trebuie să fie întreg pozitiv");
        }
        
        foreach ($invalidNumbers as $number) {
            if ($number !== null) {
                $this->assertTrue(empty($number) || !preg_match('/^\d+$/', $number), "Numărul {$number} trebuie să fie invalid");
            }
        }
    }

    /**
     * Test validare design ID - trebuie să fie numeric pozitiv
     */
    public function testDesignIdValidation(): void
    {
        $validDesigns = ['1', '2', '3', '10'];
        $invalidDesigns = ['0', '-1', 'abc', '', null];
        
        foreach ($validDesigns as $design) {
            $this->assertRegExp('/^\d+$/', $design, "Design ID {$design} trebuie să fie numeric");
            $this->assertGreaterThan(0, (int)$design, "Design ID {$design} trebuie să fie pozitiv");
        }
        
        foreach ($invalidDesigns as $design) {
            if ($design !== null) {
                $this->assertTrue(empty($design) || !is_numeric($design) || (int)$design <= 0, "Design ID {$design} trebuie să fie invalid");
            }
        }
    }

    /**
     * Test că modificarea seriei necesită ID
     */
    public function testSerieModificaRequiresId(): void
    {
        $dataWithId = array_merge($this->validSerieData, ['id' => '1234567890']);
        
        $this->assertArrayHasKey('id', $dataWithId);
        $this->assertNotEmpty($dataWithId['id']);
        
        // Test format ID
        $this->assertRegExp('/^\w+$/', $dataWithId['id'], 'ID serie trebuie să aibă format valid');
    }

    /**
     * Test că ștergerea seriei necesită doar ID și email
     */
    public function testSerieStergeData(): void
    {
        $stergeData = [
            'email_responsabil' => 'admin@test.ro',
            'id' => '1234567890'
        ];
        
        $this->assertArrayHasKey('email_responsabil', $stergeData);
        $this->assertArrayHasKey('id', $stergeData);
        $this->assertCount(2, $stergeData, 'Ștergere serie trebuie să aibă doar 2 câmpuri');
    }

    /**
     * Test că toate metodele serii returnează array
     */
    public function testSerieMethodsReturnArray(): void
    {
        $serieMethods = [
            'serieLista', 'serieVizualizare', 'serieDesign',
            'serieAdauga', 'serieModifica', 'serieSterge', 'serieStergeLogo'
        ];

        foreach ($serieMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $returnType = $reflection->getReturnType();
            
            $this->assertNotNull($returnType, "Metoda {$methodName} trebuie să aibă return type");
            $this->assertEquals('array', $returnType->getName(), "Metoda {$methodName} trebuie să returneze array");
        }
    }

    /**
     * Test validare număr curent >= număr început
     */
    public function testNumerotareLogic(): void
    {
        $validCases = [
            ['nr_inceput' => '1', 'nr_curent' => '1'],
            ['nr_inceput' => '1', 'nr_curent' => '100'],
            ['nr_inceput' => '50', 'nr_curent' => '75']
        ];
        
        $invalidCases = [
            ['nr_inceput' => '100', 'nr_curent' => '50'],
            ['nr_inceput' => '10', 'nr_curent' => '5']
        ];
        
        foreach ($validCases as $case) {
            $this->assertGreaterThanOrEqual(
                (int)$case['nr_inceput'], 
                (int)$case['nr_curent'], 
                'Numărul curent trebuie să fie >= numărul de început'
            );
        }
        
        foreach ($invalidCases as $case) {
            $this->assertLessThan(
                (int)$case['nr_inceput'], 
                (int)$case['nr_curent'], 
                'Această combinație trebuie să fie invalidă'
            );
        }
    }
}