<?php

namespace AninuApps\InsideApp;

/**
 * SDK oficial InsideApp PHP - Gestiune facturi și integrare completă cu SPV
 * 
 * Tot ce ai nevoie pentru facturarea în România:
 * - Emitere facturi proformă, fiscale, chitanțe
 * - Integrare completă ANAF SPV/eFactura automată
 * - Arhivă digitală cu toate facturile din SPV
 * - Gestionare clienți, produse, servicii, conturi bancare
 * - API Reseller: poți gestiona tot procesul de facturare pentru mai multe 
 *   firme direct din aplicația ta
 * 
 * Pentru suport și documentație:
 * - Email: support@iapp.ro
 * - Documentație: https://doc.iapp.ro  
 * - Portal Suport: https://developer.iapp.ro
 * - Referințe API: https://doc.iapp.ro/swagger
 */
class InsideApp
{
    /**
     * Dummy print function that echoes "test"
     *
     * @return void
     */
    public function dummyPrint(): void
    {
        echo "test";
    }

    /**
     * Get SDK version
     *
     * @return string
     */
    public function getVersion(): string
    {
        return "1.0.0";
    }

    /**
     * Print a custom message
     *
     * @param string $message
     * @return void
     */
    public function printMessage(string $message): void
    {
        echo $message;
    }
}