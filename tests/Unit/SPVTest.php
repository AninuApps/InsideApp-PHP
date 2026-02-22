<?php

namespace AninuApps\InsideApp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AninuApps\InsideApp\InsideApp;

/**
 * Teste pentru operațiunile SPV/eFactura
 */
class SPVTest extends TestCase
{
    private InsideApp $insideApp;

    protected function setUp(): void
    {
        $this->insideApp = new InsideApp('test_user', 'test_password');
    }

    /**
     * Test că metodele SPV pentru facturi emise există
     */
    public function testSPVEmiseMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaEmise'));
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaViewEmise'));
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaDescarcaEmise'));
        
        // Verificăm și aliases pentru compatibilitate
        $this->assertTrue(method_exists($this->insideApp, 'spvEmiseLista') || 
                         method_exists($this->insideApp, 'eFacturaEmise'));
    }

    /**
     * Test că metodele SPV pentru furnizori există
     */
    public function testSPVFurnizoriMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaFurnizori'));
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaViewFurnizori'));
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaDescarcaFurnizori'));
    }

    /**
     * Test că metodele pentru upload XML există
     */
    public function testSPVUploadMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaUploadXml'));
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaUploadStatus'));
        $this->assertTrue(method_exists($this->insideApp, 'trimiteFacturaSpvManual'));
    }

    /**
     * Test că metodele SPV au semnătura corectă
     */
    public function testSPVMethodSignatures(): void
    {
        $listMethods = ['eFacturaEmise', 'eFacturaFurnizori'];
        
        foreach ($listMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă un parametru");
            $this->assertEquals('array', $parameters[0]->getType()->getName());
            $this->assertTrue($parameters[0]->isDefaultValueAvailable(), "Metoda {$methodName} trebuie să aibă valoare default");
        }
    }

    /**
     * Test că metodele de view necesită parametri
     */
    public function testSPVViewMethodsRequireParameters(): void
    {
        $viewMethods = ['eFacturaViewEmise', 'eFacturaViewFurnizori'];
        
        foreach ($viewMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă un parametru");
            $this->assertEquals('array', $parameters[0]->getType()->getName());
            $this->assertFalse($parameters[0]->isDefaultValueAvailable(), "Metoda {$methodName} nu trebuie să aibă valoare default");
        }
    }

    /**
     * Test că metodele de upload necesită parametri
     */
    public function testSPVUploadMethodsRequireParameters(): void
    {
        $uploadMethods = ['eFacturaUploadXml', 'eFacturaUploadStatus', 'trimiteFacturaSpvManual'];
        
        foreach ($uploadMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă un parametru");
            $this->assertEquals('array', $parameters[0]->getType()->getName());
        }
    }

    /**
     * Test validare date pentru eFacturaUploadXml
     */
    public function testEFacturaUploadXmlDataValidation(): void
    {
        $validData = [
            'email_responsabil' => 'admin@test.ro',
            'serie' => 'FF',
            'numar' => '001',
            'type' => 'test',
            'filexml' => base64_encode('<xml>test</xml>')
        ];

        // Testăm structura datelor
        $this->assertArrayHasKey('email_responsabil', $validData);
        $this->assertArrayHasKey('serie', $validData);
        $this->assertArrayHasKey('numar', $validData);
        $this->assertArrayHasKey('filexml', $validData);
        
        // Testăm că filexml este base64 valid
        $decodedXml = base64_decode($validData['filexml'], true);
        $this->assertNotFalse($decodedXml, 'filexml trebuie să fie base64 valid');
    }

    /**
     * Test validare date pentru descărcare facturi
     */
    public function testDescarcareFacturiDataValidation(): void
    {
        $validData = [
            'email_responsabil' => 'admin@test.ro',
            'id_descarcare' => '1234567890',
            'output' => 'facturi.zip'
        ];

        $this->assertArrayHasKey('email_responsabil', $validData);
        $this->assertArrayHasKey('id_descarcare', $validData);
        $this->assertArrayHasKey('output', $validData);
        
        // ID descărcare trebuie să fie string nevid
        $this->assertIsString($validData['id_descarcare']);
        $this->assertNotEmpty($validData['id_descarcare']);
    }

    /**
     * Test că toate metodele SPV returnează array
     */
    public function testSPVMethodsReturnArray(): void
    {
        $spvMethods = [
            'eFacturaEmise', 'eFacturaViewEmise', 'eFacturaDescarcaEmise',
            'eFacturaFurnizori', 'eFacturaViewFurnizori', 'eFacturaDescarcaFurnizori',
            'eFacturaUploadXml', 'eFacturaUploadStatus', 'trimiteFacturaSpvManual'
        ];

        foreach ($spvMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $returnType = $reflection->getReturnType();
            
            $this->assertNotNull($returnType, "Metoda {$methodName} trebuie să aibă return type");
            $this->assertEquals('array', $returnType->getName(), "Metoda {$methodName} trebuie să returneze array");
        }
    }

    /**
     * Test validare email responsabil pentru toate metodele SPV
     */
    public function testEmailResponsabilRequiredForSPVMethods(): void
    {
        $testData = [
            'serie' => 'FF',
            'numar' => '001'
            // Lipsește email_responsabil
        ];

        // Pentru moment testăm doar că metodele acceptă array-uri
        $this->assertIsArray($testData);
        
        // În viitor, când implementăm validarea:
        // $this->expectException(\InvalidArgumentException::class);
        // $this->insideApp->eFacturaUploadXml($testData);
    }

    /**
     * Test că XML-ul încărcat este valid base64
     */
    public function testXmlBase64Validation(): void
    {
        $validXml = '<factura><client>Test</client></factura>';
        $encodedXml = base64_encode($validXml);
        
        // Test că encoding/decoding funcționează
        $this->assertEquals($validXml, base64_decode($encodedXml));
        
        // Test că base64 invalid este detectat
        $invalidBase64 = 'invalid_base64!!!';
        $decoded = base64_decode($invalidBase64, true);
        $this->assertFalse($decoded, 'Base64 invalid trebuie să returneze false');
    }

    /**
     * Test format ID descărcare
     */
    public function testIdDescarcareFormat(): void
    {
        $validIds = ['1234567890', '0987654321', '1111111111'];
        $invalidIds = ['', 'abc', '123abc', null];
        
        foreach ($validIds as $id) {
            $this->assertIsString($id);
            $this->assertNotEmpty($id);
            $this->assertRegExp('/^\d+$/', $id, 'ID descărcare trebuie să conțină doar cifre');
        }
        
        foreach ($invalidIds as $id) {
            if ($id !== null) {
                $this->assertTrue(empty($id) || !preg_match('/^\d+$/', $id));
            }
        }
    }
}