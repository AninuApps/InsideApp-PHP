<?php

namespace AninuApps\InsideApp\Tests\Fixtures;

/**
 * Date de test pentru SDK InsideApp
 */
class TestDataFixtures
{
    /**
     * Date valide pentru testarea facturilor
     */
    public static function getValidFacturaData(): array
    {
        return [
            'email_responsabil' => 'test@example.com',
            'client' => [
                'type' => 'J',
                'name' => 'SC Test Business SRL',
                'cif' => 'RO12345678',
                'contact' => 'Ion Popescu',
                'telefon' => '0721123456',
                'tara' => 'Romania',
                'judet' => 'Bucuresti',
                'localitate' => 'Sectorul 1',
                'adresa' => 'Str. Test nr. 123',
                'email' => 'contact@testbusiness.ro'
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
                    'pret' => '150.00',
                    'tvavalue' => '1140.00',
                    'tvapercent' => '19'
                ],
                [
                    'title' => 'Dezvoltare software',
                    'um' => 'oră',
                    'cantitate' => '20',
                    'pret' => '200.00',
                    'tvavalue' => '760.00',
                    'tvapercent' => '19'
                ]
            ]
        ];
    }

    /**
     * Date valide pentru testarea proformelor
     */
    public static function getValidProformaData(): array
    {
        return [
            'email_responsabil' => 'test@example.com',
            'client' => [
                'type' => 'J',
                'name' => 'SC Proforma Test SRL',
                'cif' => 'RO87654321',
                'contact' => 'Ana Popescu',
                'telefon' => '0722234567',
                'tara' => 'Romania',
                'judet' => 'Cluj',
                'localitate' => 'Cluj-Napoca',
                'adresa' => 'Str. Proforma nr. 456',
                'email' => 'contact@proformatest.ro'
            ],
            'data_start' => date('Y-m-d'),
            'data_termen' => '15',
            'seria' => 'PF',
            'moneda' => 'RON',
            'footer' => ['intocmit_name' => 'Vasile Ionescu'],
            'continut' => [
                [
                    'title' => 'Servicii marketing',
                    'um' => 'pachet',
                    'cantitate' => '1',
                    'pret' => '2500.00',
                    'tvavalue' => '475.00',
                    'tvapercent' => '19'
                ]
            ]
        ];
    }

    /**
     * Date valide pentru testarea firmelor (Reseller API)
     */
    public static function getValidFirmaData(): array
    {
        return [
            'email_responsabil' => 'admin@reseller.com',
            'nume' => 'Test Reseller Business SRL',
            'cif' => 'RO98765432',
            'adresa' => 'Str. Reseller nr. 789',
            'localitate' => 'Timisoara',
            'judet' => 'Timis',
            'tara' => 'Romania',
            'telefon' => '0723345678',
            'email' => 'contact@resellertest.ro',
            'reprezentant_legal' => 'Mihai Georgescu',
            'capitol_social' => '500',
            'cont_bancar' => 'RO49AAAA1B31007593840000',
            'banca' => 'Banca Transilvania'
        ];
    }

    /**
     * Date valide pentru testarea seriilor
     */
    public static function getValidSerieData(): array
    {
        return [
            'email_responsabil' => 'admin@test.ro',
            'logo' => base64_encode('fake_logo_binary_data_for_testing'),
            'proforma' => [
                'serie' => 'TEST_PF',
                'nr_inceput' => '1',
                'nr_curent' => '10',
                'design' => '1'
            ],
            'factura' => [
                'serie' => 'TEST_FF',
                'nr_inceput' => '1',
                'nr_curent' => '25',
                'design' => '2'
            ],
            'chitanta' => [
                'serie' => 'TEST_CH',
                'nr_inceput' => '1',
                'nr_curent' => '5'
            ]
        ];
    }

    /**
     * Date pentru testarea SPV upload XML
     */
    public static function getValidSPVUploadData(): array
    {
        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>
        <factura>
            <client>Test Client SRL</client>
            <suma>1000.00</suma>
            <moneda>RON</moneda>
        </factura>';

        return [
            'email_responsabil' => 'spv@test.ro',
            'serie' => 'SPV',
            'numar' => '001',
            'type' => 'test',
            'filexml' => base64_encode($xmlContent)
        ];
    }

    /**
     * Răspunsuri mock pentru API
     */
    public static function getMockApiResponses(): array
    {
        return [
            'success' => [
                'status' => 'SUCCESS',
                'error_code' => '000',
                'message' => '',
                'request' => 'test/endpoint',
                'data' => [
                    'id' => '12345',
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ],
            'error' => [
                'status' => 'ERROR',
                'error_code' => '001',
                'message' => 'Test error message',
                'request' => 'test/endpoint'
            ],
            'curs_valutar' => [
                'status' => 'SUCCESS',
                'error_code' => '000',
                'message' => '',
                'request' => 'nomenclator/curs-valutar',
                'data' => [
                    'EUR' => '4.9758',
                    'USD' => '4.5621',
                    'GBP' => '5.7832'
                ]
            ],
            'factura_lista' => [
                'status' => 'SUCCESS',
                'error_code' => '000',
                'message' => '',
                'request' => 'vizualizare/facturi',
                'data' => [
                    'output' => [
                        [
                            'serie' => 'FF',
                            'numar' => '001',
                            'client' => 'Test Client SRL',
                            'total' => '1190.00',
                            'moneda' => 'RON',
                            'status' => 'EMIS'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Credențiale de test
     */
    public static function getTestCredentials(): array
    {
        return [
            'username' => getenv('INSIDEAPP_TEST_USERNAME') ?: 'test_user',
            'password' => getenv('INSIDEAPP_TEST_PASSWORD') ?: 'test_password',
            'email' => getenv('INSIDEAPP_TEST_EMAIL') ?: 'test@example.com'
        ];
    }

    /**
     * Validatori pentru răspunsuri API
     */
    public static function validateApiResponse(array $response): bool
    {
        // Verifică că răspunsul are structura de bază
        if (!isset($response['status']) || !isset($response['error_code'])) {
            return false;
        }

        // Verifică că status-ul este valid
        if (!in_array($response['status'], ['SUCCESS', 'ERROR'])) {
            return false;
        }

        // Pentru răspunsuri de success, verifică că există data
        if ($response['status'] === 'SUCCESS' && !isset($response['data'])) {
            return false;
        }

        // Pentru răspunsuri de eroare, verifică că există mesaj
        if ($response['status'] === 'ERROR' && empty($response['message'])) {
            return false;
        }

        return true;
    }

    /**
     * Generează date fake pentru testare
     */
    public static function generateFakeClient(): array
    {
        return [
            'type' => 'J',
            'name' => 'SC Fake Business ' . rand(1000, 9999) . ' SRL',
            'cif' => 'RO' . rand(10000000, 99999999),
            'contact' => 'Test Contact ' . rand(1, 100),
            'telefon' => '072' . rand(1000000, 9999999),
            'tara' => 'Romania',
            'judet' => 'Bucuresti',
            'localitate' => 'Sectorul ' . rand(1, 6),
            'adresa' => 'Str. Fake nr. ' . rand(1, 999),
            'email' => 'fake' . rand(1000, 9999) . '@example.com'
        ];
    }
}