<?php

/**
 * Exemplu pentru vizualizarea unei facturi proforma
 * Echivalentul metodei view_proforma() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru vizualizarea facturii proforma
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'PF',          // obligatoriu
        'numar' => '2026001',     // obligatoriu

    );
    
    // Apel API pentru vizualizarea facturii proforma
    $response = $insideApp->facturiProformaVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "vizualizare/proforma",
     *   "data": {
     *     "serie": "PF",
     *     "numar": 2026001,
     *     "client": {
     *       "juridic": "J",
     *       "banca": "Banca Transilvania",
     *       "iban": "RO49BTRLRONCRT0237923501",
     *       "web": "www.digitalsolutions.ro",
     *       "adresa": "Romania, CLUJ, Cluj-Napoca, Str. MEMORANDUMULUI, Nr. 28",
     *       "email": "contact@digitalsolutions.ro",
     *       "telefon": "0264123456",
     *       "denumire": "DIGITAL SOLUTIONS SRL",
     *       "cui": "RO35678124",
     *       "regcom": "J12/1234/2020",
     *       "contact": "Ana Popescu"
     *     },
     *     "emitere": "2026-02-22",
     *     "scadenta": "2026-03-24",
     *     "tva": "Y",
     *     "status": "WAIT",
     *     "moneda": "RON",
     *     "total": 12250,
     *     "cursvalutarron": 0,
     *     "cursvalutardata": "",
     *     "footer": {
     *       "intocmit": "Maria Ionescu",
     *       "cnp": "",
     *       "delegat": "",
     *       "buletin": "",
     *       "auto": "",
     *       "mentiuni": "Factura proforma valabila 30 zile",
     *       "aviz": ""
     *     },
     *     "logo": "",
     *     "pdf": "https://my.iapp.ro/share/proforma/tech2024pf001secure789xyz",
     *     "continut": [
     *       {
     *         "denumire": "Laptop Dell Inspiron 15",
     *         "descriere": "Laptop profesional cu procesor Intel i7, 16GB RAM, SSD 512GB",
     *         "um": "buc",
     *         "cantitate": 2,
     *         "pretunitar_no_tva": "2500.00",
     *         "valoare_no_tva": "5000.00",
     *         "valoare_tva": "950.00",
     *         "cota_tva": 19,
     *         "total": "5950.00"
     *       },
     *       {
     *         "denumire": "Servicii consultanta IT",
     *         "descriere": "Analiza si optimizare infrastructura IT existenta, implementare solutii de securitate",
     *         "um": "ore",
     *         "cantitate": 40,
     *         "pretunitar_no_tva": "150.00",
     *         "valoare_no_tva": "6000.00",
     *         "valoare_tva": "300.00",
     *         "cota_tva": 5,
     *         "total": "6300.00"
     *       }
     *     ],
     *     "plata": {
     *       "link": "",
     *       "qr": "",
     *       "procesator": ""
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturii proforma: " . $e->getMessage() . "\n";
}
