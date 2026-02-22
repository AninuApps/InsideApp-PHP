<?php

/**
 * Exemplu pentru vizualizarea unei facturi fiscale
 * Echivalentul metodei view_factura() din API-ul original
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
    
    // Datele pentru vizualizarea facturii fiscale
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'FF',          // obligatoriu
        'numar' => '2026001',     // obligatoriu

    );
    
    // Apel API pentru vizualizarea facturii fiscale
    $response = $insideApp->facturiVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "vizualizare/factura",
     *   "data": {
     *     "serie": "FF",
     *     "numar": 2026015,
     *     "client": {
     *       "juridic": "J",
     *       "banca": "BCR",
     *       "iban": "RO76RNCB0082123456789012",
     *       "web": "www.tech-solutions.ro",
     *       "adresa": "Romania, CLUJ, Cluj-Napoca, Str. Tehnologiei, Nr. 45",
     *       "email": "facturare@tech-solutions.ro",
     *       "telefon": "0742987654",
     *       "denumire": "SC TECH SOLUTIONS SRL",
     *       "cui": "RO98765432",
     *       "regcom": "J40/5678/2022",
     *       "contact": "Andrei Georgescu"
     *     },
     *     "emitere": "2026-02-22",
     *     "scadenta": "2026-03-09",
     *     "tva": "Y",
     *     "status": "WAIT",
     *     "spv_status": "Trimisă în SPV, Se așteaptă răspuns de la ANAF",
     *     "moneda": "RON",
     *     "total": 12994,
     *     "cursvalutarron": 0,
     *     "cursvalutardata": "",
     *     "footer": {
     *       "intocmit": "Elena Popescu",
     *       "cnp": "",
     *       "delegat": "",
     *       "buletin": "",
     *       "auto": "",
     *       "mentiuni": "Factura fiscală pentru servicii IT",
     *       "aviz": ""
     *     },
     *     "logo": "",
     *     "pdf": "https://my.iapp.ro/share/factura/tech2024ff015secure456ghi",
     *     "continut": [
     *       {
     *         "denumire": "Dezvoltare aplicație mobilă",
     *         "descriere": "Servicii profesionale dezvoltare mobile app Android și iOS",
     *         "um": "oră",
     *         "cantitate": 80,
     *         "pretunitar_no_tva": "120.00",
     *         "valoare_no_tva": "9600.00",
     *         "valoare_tva": "1824.00",
     *         "cota_tva": 19,
     *         "total": "11424.00"
     *       },
     *       {
     *         "denumire": "Servicii de hosting cloud",
     *         "descriere": "Hosting dedicat cu backup automat zilnic și monitoring 24/7",
     *         "um": "lună",
     *         "cantitate": 12,
     *         "pretunitar_no_tva": "250.00",
     *         "valoare_no_tva": "3000.00",
     *         "valoare_tva": "570.00",
     *         "cota_tva": 19,
     *         "total": "3570.00"
     *       }
     *     ],
     *     "plata": {
     *       "link": "",
     *       "qr": "",
     *       "procesator": ""
     *     },
     *     "storno": {
     *       "status": "N"
     *     },
     *     "xml": {
     *       "bt_10": "REF-CLIENT-2026-001",
     *       "bt_11": "PROJ-MOBILE-APP-2026",
     *       "bt_12": "CONTRACT-DEV-2026-001",
     *       "bt_13": "PO-TECH-20260222-001",
     *       "bt_14": "SO-SOLUTIONS-20260222-001",
     *       "bt_15": "AVIZ-RECEPTIE-001",
     *       "bt_16": "AVIZ-EXPEDITIE-001",
     *       "bt_17": "LOT-DEV-2026-Q1",
     *       "bt_19": "CONT-CLIENT-2026-001",
     *       "bt_20": "Plata la 15 zile de la emitere",
     *       "bt_23": "Dezvoltare software",
     *       "bt_25": "FF-2026-100",
     *       "bt_26": "2026-01-15",
     *       "bt_29": "RO47852369",
     *       "bt_46": "RO98765432",
     *       "bt_73": "2026-02-01",
     *       "bt_74": "2026-02-28",
     *       "bt_122": "DOC-JUSTIF-2026-001",
     *       "bt_123": "Contract de dezvoltare aplicație mobilă"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturii fiscale: " . $e->getMessage() . "\n";
}
