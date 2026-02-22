<?php

namespace InsideApp\Tests;

use InsideApp\InsideAppAPIClient;
use PHPUnit\Framework\TestCase;

class InsideAppAPIClientTest extends TestCase
{
    public function testConstructorSetsDefaultApiUrl(): void
    {
        $client = new InsideAppAPIClient('user', 'pass');

        $ref = new \ReflectionClass($client);
        $prop = $ref->getProperty('api_url');
        $prop->setAccessible(true);

        $this->assertSame('https://api-facturare.inap.ro/', $prop->getValue($client));
    }

    public function testConstructorSetsCustomApiUrl(): void
    {
        $client = new InsideAppAPIClient('user', 'pass', 'https://custom.example.com/v1');

        $ref = new \ReflectionClass($client);
        $prop = $ref->getProperty('api_url');
        $prop->setAccessible(true);

        $this->assertSame('https://custom.example.com/v1/', $prop->getValue($client));
    }

    public function testConstructorTrailingSlashNormalized(): void
    {
        $client = new InsideAppAPIClient('user', 'pass', 'https://custom.example.com/v1///');

        $ref = new \ReflectionClass($client);
        $prop = $ref->getProperty('api_url');
        $prop->setAccessible(true);

        $this->assertSame('https://custom.example.com/v1/', $prop->getValue($client));
    }

    public function testConstructorEncodesHash(): void
    {
        $client = new InsideAppAPIClient('myuser', 'mypass');

        $ref = new \ReflectionClass($client);
        $prop = $ref->getProperty('hash');
        $prop->setAccessible(true);

        $this->assertSame(base64_encode('myuser:mypass'), $prop->getValue($client));
    }

    public function testPingOutputsMessage(): void
    {
        $client = new InsideAppAPIClient('user', 'pass');

        $this->expectOutputString('InsideApp SDK is working');
        $client->ping();
    }
}
