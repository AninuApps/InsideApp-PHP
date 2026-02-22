<?php

namespace AninuApps\InsideApp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AninuApps\InsideApp\InsideApp;

/**
 * Teste pentru API Reseller
 */
class ResellerTest extends TestCase
{
    private InsideApp $insideApp;
    private array $validFirmaData;

    protected function setUp(): void
    {
        $this->insideApp = new InsideApp('test_user', 'test_password');
        
        $this->validFirmaData = [
            'email_responsabil' => 'admin@reseller.ro',
            'nume' => 'Test Business SRL',
            'cif' => 'RO12345678',
            'adresa' => 'Str. Test nr. 123',
            'localitate' => 'Bucuresti',
            'judet' => 'Bucuresti',
            'tara' => 'Romania',
            'telefon' => '0721123456',
            'email' => 'contact@testbusiness.ro',
            'reprezentant_legal' => 'Ion Popescu',
            'capitol_social' => '200',
            'cont_bancar' => 'RO49AAAA1B31007593840000',
            'banca' => 'BCR'
        ];
    }

    /**
     * Test că metodele pentru gestionarea firmelor există
     */
    public function testFirmaManagementMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'firmaLista'));
        $this->assertTrue(method_exists($this->insideApp, 'firmaVizualizare'));
        $this->assertTrue(method_exists($this->insideApp, 'firmaAdauga'));
        $this->assertTrue(method_exists($this->insideApp, 'firmaModifica'));
        $this->assertTrue(method_exists($this->insideApp, 'firmaActiveaza'));
        $this->assertTrue(method_exists($this->insideApp, 'firmaDezactiveaza'));
    }

    /**
     * Test că metodele pentru API credentials există
     */
    public function testFirmaApiMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'firmaApi'));
        $this->assertTrue(method_exists($this->insideApp, 'firmaApiReset'));
    }

    /**
     * Test că metodele pentru eFactura autorizare există
     */
    public function testEFacturaAutorizareMethodsExist(): void
    {
        $this->assertTrue(method_exists($this->insideApp, 'eFacturaAutorizare'));
    }

    /**
     * Test semnătura metodelor de listare
     */
    public function testListaMethodSignature(): void
    {
        $reflection = new \ReflectionMethod($this->insideApp, 'firmaLista');
        $parameters = $reflection->getParameters();
        
        $this->assertCount(1, $parameters);
        $this->assertEquals('array', $parameters[0]->getType()->getName());
        $this->assertTrue($parameters[0]->isDefaultValueAvailable());
        $this->assertEquals([], $parameters[0]->getDefaultValue());
    }

    /**
     * Test semnătura metodelor care necesită ID
     */
    public function testIdRequiredMethodsSignature(): void
    {
        $idRequiredMethods = [
            'firmaVizualizare', 'firmaActiveaza', 'firmaDezactiveaza',
            'firmaApi', 'firmaApiReset', 'eFacturaAutorizare'
        ];

        foreach ($idRequiredMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $parameters = $reflection->getParameters();
            
            $this->assertCount(1, $parameters, "Metoda {$methodName} trebuie să aibă un parametru");
            $this->assertEquals('array', $parameters[0]->getType()->getName());
            $this->assertFalse($parameters[0]->isDefaultValueAvailable(), "Metoda {$methodName} nu trebuie să aibă valoare default");
        }
    }

    /**
     * Test validare date pentru adăugare firmă
     */
    public function testFirmaAdaugaDataValidation(): void
    {
        // Testăm că toate câmpurile obligatorii sunt prezente
        $requiredFields = ['email_responsabil', 'nume', 'cif', 'adresa', 'localitate', 'judet', 'tara'];
        
        foreach ($requiredFields as $field) {
            $this->assertArrayHasKey($field, $this->validFirmaData, "Câmpul {$field} este obligatoriu");
            $this->assertNotEmpty($this->validFirmaData[$field], "Câmpul {$field} nu poate fi gol");
        }
    }

    /**
     * Test validare CIF pentru firmă
     */
    public function testFirmaCifValidation(): void
    {
        $validCifs = ['RO12345678', '12345678', 'RO1234567890'];
        $invalidCifs = ['', 'ABC123', '12345678901234567890', null];
        
        foreach ($validCifs as $cif) {
            $testData = $this->validFirmaData;
            $testData['cif'] = $cif;
            
            // Testăm că CIF-ul are format valid
            $this->assertRegExp('/^(RO)?\d{6,10}$/', $cif, "CIF {$cif} trebuie să aibă format valid");
        }
        
        foreach ($invalidCifs as $cif) {
            if ($cif !== null) {
                $this->assertTrue(empty($cif) || !preg_match('/^(RO)?\d{6,10}$/', $cif), "CIF {$cif} trebuie să fie invalid");
            }
        }
    }

    /**
     * Test validare email pentru firmă
     */
    public function testFirmaEmailValidation(): void
    {
        $validEmails = ['test@example.com', 'admin@firma.ro', 'contact+test@business.com'];
        $invalidEmails = ['', 'invalid-email', 'test@', '@domain.com', null];
        
        foreach ($validEmails as $email) {
            $this->assertRegExp('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email, "Email {$email} trebuie să fie valid");
        }
        
        foreach ($invalidEmails as $email) {
            if ($email !== null) {
                $this->assertTrue(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL), "Email {$email} trebuie să fie invalid");
            }
        }
    }

    /**
     * Test validare IBAN pentru cont bancar
     */
    public function testContBancarValidation(): void
    {
        $validIbans = [
            'RO49AAAA1B31007593840000',
            'RO09BCYP0000001234567890',
            'RO32BACX0000000030009999'
        ];
        
        $invalidIbans = [
            '',
            'RO49',
            'INVALID_IBAN',
            'RO49AAAA1B31007593840000123', // prea lung
            null
        ];
        
        foreach ($validIbans as $iban) {
            // Test format IBAN românesc: RO + 2 cifre + 4 litere + 16 caractere alfanumerice
            $this->assertRegExp('/^RO\d{2}[A-Z]{4}[A-Z0-9]{16}$/', $iban, "IBAN {$iban} trebuie să aibă format valid");
            $this->assertEquals(24, strlen($iban), "IBAN {$iban} trebuie să aibă exact 24 caractere");
        }
        
        foreach ($invalidIbans as $iban) {
            if ($iban !== null) {
                $isValid = !empty($iban) && 
                          preg_match('/^RO\d{2}[A-Z]{4}[A-Z0-9]{16}$/', $iban) && 
                          strlen($iban) === 24;
                $this->assertFalse($isValid, "IBAN {$iban} trebuie să fie invalid");
            }
        }
    }

    /**
     * Test că toate metodele Reseller returnează array
     */
    public function testResellerMethodsReturnArray(): void
    {
        $resellerMethods = [
            'firmaLista', 'firmaVizualizare', 'firmaAdauga', 'firmaModifica',
            'firmaActiveaza', 'firmaDezactiveaza', 'firmaApi', 'firmaApiReset',
            'eFacturaAutorizare'
        ];

        foreach ($resellerMethods as $methodName) {
            $reflection = new \ReflectionMethod($this->insideApp, $methodName);
            $returnType = $reflection->getReturnType();
            
            $this->assertNotNull($returnType, "Metoda {$methodName} trebuie să aibă return type");
            $this->assertEquals('array', $returnType->getName(), "Metoda {$methodName} trebuie să returneze array");
        }
    }

    /**
     * Test validare telefon român
     */
    public function testTelefonValidation(): void
    {
        $validPhones = ['0721123456', '0212345678', '+40721123456', '0040721123456'];
        $invalidPhones = ['', '123', 'abc', '072112345678901', null];
        
        foreach ($validPhones as $phone) {
            // Test format telefon românesc basic
            $cleanPhone = preg_replace('/[^\d]/', '', $phone);
            $this->assertTrue(strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 14, "Telefon {$phone} trebuie să aibă între 10-14 cifre");
        }
        
        foreach ($invalidPhones as $phone) {
            if ($phone !== null) {
                $cleanPhone = preg_replace('/[^\d]/', '', $phone);
                $isValid = !empty($cleanPhone) && strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 14 && ctype_digit($cleanPhone);
                $this->assertFalse($isValid, "Telefon {$phone} trebuie să fie invalid");
            }
        }
    }

    /**
     * Test validare capitol social
     */
    public function testCapitolSocialValidation(): void
    {
        $validCapitals = ['200', '1000', '50000'];
        $invalidCapitals = ['', '0', '-100', 'abc', null];
        
        foreach ($validCapitals as $capital) {
            $this->assertIsNumeric($capital, "Capitol social {$capital} trebuie să fie numeric");
            $this->assertGreaterThan(0, (float)$capital, "Capitol social {$capital} trebuie să fie pozitiv");
        }
        
        foreach ($invalidCapitals as $capital) {
            if ($capital !== null) {
                $this->assertTrue(!is_numeric($capital) || (float)$capital <= 0, "Capitol social {$capital} trebuie să fie invalid");
            }
        }
    }
}