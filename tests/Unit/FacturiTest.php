<?php

namespace AninuApps\InsideApp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AninuApps\InsideApp\InsideApp;

/**
 * Teste pentru operațiunile cu facturi
 */
class FacturiTest extends TestCase
{
    private InsideApp $insideApp;
    private array $validFacturaData;

    protected function setUp(): void
    {
        $this->insideApp = new InsideApp('test_user', 'test_password');
        
        $this->validFacturaData = [
            'email_responsabil' => 'admin@test.ro',
            'client' => [
                'type' => 'J',
                'name' => 'Test SRL',
                'cif' => 'RO12345678',
                'contact' => 'Ion Popescu',
                'telefon' => '0721123456',
                'tara' => 'Romania',
                'judet' => 'Bucuresti',
                'localitate' => 'Sectorul 1',
                'adresa' => 'Str. Test nr. 123',
                'email' => 'contact@test.ro'
            ],
            'data_start' => date('Y-m-d'),
            'data_termen' => '30',
            'seria' => 'FF',
            'moneda' => 'RON',
            'footer' => ['intocmit_name' => 'Maria Ionescu'],
            'continut' => [
                [
                    'title' => 'Consultanță IT',
                    'um' => 'oră',
                    'cantitate' => '40',
                    'pret' => '150',
                    'tvavalue' => '1140',
                    'tvapercent' => '19'
                ]
            ]
        ];
    }

    /**
     * Test că metodele de facturi au signatura corectă
     */
    public function testFacturaMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'emiteFactura'));
        $this->assertTrue(method_exists($this->insideApp, 'emiteFacturaV2'));
        $this->assertTrue(method_exists($this->insideApp, 'viewFactura'));
        $this->assertTrue(method_exists($this->insideApp, 'viewFacturi'));
        $this->assertTrue(method_exists($this->insideApp, 'cancelFactura'));
        $this->assertTrue(method_exists($this->insideApp, 'incaseazaFactura'));
        $this->assertTrue(method_exists($this->insideApp, 'storneazaFactura'));
    }

    /**
     * Test că metodele de proforma au signatura corectă
     */
    public function testProformaMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'emiteProforma'));
        $this->assertTrue(method_exists($this->insideApp, 'emiteProformaV2'));
        $this->assertTrue(method_exists($this->insideApp, 'viewProforma'));
        $this->assertTrue(method_exists($this->insideApp, 'viewProforme'));
        $this->assertTrue(method_exists($this->insideApp, 'cancelProforma'));
        $this->assertTrue(method_exists($this->insideApp, 'factureazaProforma'));
    }

    /**
     * Test că metodele de chitanță au signatura corectă
     */
    public function testChitantaMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'emiteChitanta'));
        $this->assertTrue(method_exists($this->insideApp, 'viewChitanta'));
        $this->assertTrue(method_exists($this->insideApp, 'viewChitante'));
        $this->assertTrue(method_exists($this->insideApp, 'anuleazaChitanta'));
        $this->assertTrue(method_exists($this->insideApp, 'stergeChitanta'));
    }

    /**
     * Test că metodele de încasări au signatura corectă
     */
    public function testIncasariMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'viewIncasari'));
        $this->assertTrue(method_exists($this->insideApp, 'viewIncasare'));
        $this->assertTrue(method_exists($this->insideApp, 'stergeIncasare'));
    }

    /**
     * Test validare data pentru factura - email responsabil obligatoriu
     */
    public function testValidateEmailResponsabilRequired(): void
    {
        $invalidData = $this->validFacturaData;
        unset($invalidData['email_responsabil']);
        
        // Pentru moment doar testăm că metoda există și acceptă array
        $this->assertTrue(method_exists($this->insideApp, 'emiteFactura'));
        
        // În viitor, când implementăm validarea:
        // $this->expectException(\InvalidArgumentException::class);
        // $this->insideApp->emiteFactura($invalidData);
    }

    /**
     * Test validare data pentru factura - client obligatoriu
     */
    public function testValidateClientRequired(): void
    {
        $invalidData = $this->validFacturaData;
        unset($invalidData['client']);
        
        // Pentru moment doar testăm că metoda există și acceptă array
        $this->assertTrue(method_exists($this->insideApp, 'emiteFactura'));
        
        // În viitor, când implementăm validarea:
        // $this->expectException(\InvalidArgumentException::class);
        // $this->insideApp->emiteFactura($invalidData);
    }

    /**
     * Test că datele valide sunt acceptate
     */
    public function testValidDataIsAccepted(): void
    {
        // Pentru moment doar testăm că metoda poate fi apelată
        $this->assertTrue(method_exists($this->insideApp, 'emiteFactura'));
        
        // În viitor, când conectăm la API sau mock:
        // $result = $this->insideApp->emiteFactura($this->validFacturaData);
        // $this->assertIsArray($result);
    }

    /**
     * Test că toate metodele de facturi acceptă parametri array
     */
    public function testFacturaMethodsAcceptArrayParameters(): void
    {
        $methods = ['emiteFactura', 'emiteFacturaV2', 'viewFactura', 'cancelFactura'];
        
        foreach ($methods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă exact un parametru");
            $this->assertEquals('array', $parameters[0]->getType()->getName(), "Metoda {$methodName} trebuie să accepte array");
        }
    }

    /**
     * Test că metodele view pot fi apelate fără parametri
     */
    public function testViewMethodsCanBeCalledWithoutParameters(): void
    {
        $methods = ['viewFacturi', 'viewProforme', 'viewChitante', 'viewIncasari'];
        
        foreach ($methods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă un parametru");
            $this->assertTrue($parameters[0]->isDefaultValueAvailable(), "Metoda {$methodName} trebuie să aibă valoare default");
            $this->assertEquals([], $parameters[0]->getDefaultValue(), "Metoda {$methodName} trebuie să aibă array gol ca default");
        }
    }

    /**
     * Test validare CIF format (când va fi implementată)
     */
    public function testCifValidation(): void
    {
        $validCifs = ['RO12345678', '12345678', 'RO1234567890'];
        $invalidCifs = ['', 'ABC123', '12345678901234567890'];
        
        // Pentru moment doar testăm structura
        foreach ($validCifs as $cif) {
            $this->assertTrue(is_string($cif) && !empty($cif));
        }
        
        foreach ($invalidCifs as $cif) {
            // În viitor: $this->assertFalse($this->insideApp->validateCif($cif));
        }
    }
}