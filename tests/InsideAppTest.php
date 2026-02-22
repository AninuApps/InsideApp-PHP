<?php

namespace AninuApps\InsideApp\Tests;

use PHPUnit\Framework\TestCase;
use AninuApps\InsideApp\InsideApp;

/**
 * Teste pentru clasa principală InsideApp
 */
class InsideAppTest extends TestCase
{
    private InsideApp $insideApp;
    private string $testUsername = 'test_user';
    private string $testPassword = 'test_password';

    protected function setUp(): void
    {
        $this->insideApp = new InsideApp($this->testUsername, $this->testPassword);
    }

    /**
     * Test că SDK-ul se inițializează corect
     */
    public function testSdkInitialization(): void
    {
        $sdk = new InsideApp($this->testUsername, $this->testPassword);
        $this->assertInstanceOf(InsideApp::class, $sdk);
    }

    /**
     * Test pentru metoda getVersion()
     */
    public function testGetVersion(): void
    {
        $version = $this->insideApp->getVersion();
        $this->assertIsString($version);
        $this->assertNotEmpty($version);
        $this->assertEquals('1.0.0', $version);
    }

    /**
     * Test pentru setTimeout()
     */
    public function testSetTimeout(): void
    {
        $result = $this->insideApp->setTimeout(600);
        $this->assertInstanceOf(InsideApp::class, $result);
        
        // Testează că timeout-ul invalid aruncă excepție
        $this->expectException(\InvalidArgumentException::class);
        $this->insideApp->setTimeout(-1);
    }

    /**
     * Test că credențialele goale aruncă excepție
     */
    public function testEmptyCredentialsThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new InsideApp('', '');
    }

    /**
     * Test că username-ul gol aruncă excepție
     */
    public function testEmptyUsernameThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new InsideApp('', 'password');
    }

    /**
     * Test că parola goală aruncă excepție
     */
    public function testEmptyPasswordThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new InsideApp('username', '');
    }

    /**
     * Test că hash-ul Basic Auth se generează corect
     */
    public function testBasicAuthHashGeneration(): void
    {
        $expectedHash = base64_encode($this->testUsername . ':' . $this->testPassword);
        
        // Folosim reflection pentru a accesa proprietatea privată
        $reflection = new \ReflectionClass($this->insideApp);
        $hashProperty = $reflection->getProperty('hash');
        $hashProperty->setAccessible(true);
        $actualHash = $hashProperty->getValue($this->insideApp);
        
        $this->assertEquals($expectedHash, $actualHash);
    }

    /**
     * Test pentru validarea că toate metodele publice returnează array
     */
    public function testPublicMethodsReturnArray(): void
    {
        $reflection = new \ReflectionClass($this->insideApp);
        $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        
        $methodsToSkip = ['__construct', 'getVersion', 'setTimeout', 'execute', 'unaccent'];
        
        foreach ($publicMethods as $method) {
            if (in_array($method->getName(), $methodsToSkip)) {
                continue;
            }
            
            $returnType = $method->getReturnType();
            $this->assertNotNull($returnType, "Metoda {$method->getName()} trebuie să aibă return type");
            $this->assertEquals('array', $returnType->getName(), "Metoda {$method->getName()} trebuie să returneze array");
        }
    }

    /**
     * Test că API URL-ul este corect
     */
    public function testApiUrlIsCorrect(): void
    {
        $reflection = new \ReflectionClass($this->insideApp);
        $apiUrlProperty = $reflection->getProperty('apiUrl');
        $apiUrlProperty->setAccessible(true);
        $apiUrl = $apiUrlProperty->getValue($this->insideApp);
        
        $this->assertEquals('https://api.my.iapp.ro/', $apiUrl);
        
        // Verifică că nu conține slash-uri duble în părțile importante (nu în https://)
        $urlParts = parse_url($apiUrl);
        $path = $urlParts['path'] ?? '/';
        $this->assertStringNotContainsString('//', $path, 'Path-ul nu trebuie să conțină slash-uri duble');
    }

    /**
     * Test timeout default
     */
    public function testDefaultTimeout(): void
    {
        $reflection = new \ReflectionClass($this->insideApp);
        $timeoutProperty = $reflection->getProperty('timeout');
        $timeoutProperty->setAccessible(true);
        $timeout = $timeoutProperty->getValue($this->insideApp);
        
        $this->assertEquals(300, $timeout);
    }
}