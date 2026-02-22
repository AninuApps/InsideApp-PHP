<?php

/**
 * Exemplu pentru vizualizarea tuturor facturilor fiscale dintr-o perioadă
 * Echivalentul metodei view_facturi() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru vizualizarea tuturor facturilor fiscale
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'start' => '2026-01-01',                    // obligatoriu (Y-m-d)
        'end' => date("Y-m-d"),                     // obligatoriu (Y-m-d) - până azi

    );
    
    // Apel API pentru vizualizarea listei de facturi fiscale
    $response = $insideApp->viewFacturi($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "vizualizare/facturi",
     *   "data": {
     *     "perioada": {
     *       "tStart": 1704067200,
     *       "tEnd": 1706745600,
     *       "dStart": "2026-01-01",
     *       "dEnd": "2026-02-22"
     *     },
     *     "raport": [
     *       {
     *         "serie": "FF",
     *         "numar": "2026014",
     *         "client": "DIGITAL SOLUTIONS SRL",
     *         "data_emitere": "2026-01-15",
     *         "data_scadenta": "2026-02-14",
     *         "total": 8925,
     *         "moneda": "RON",
     *         "curs_valutar": 0,
     *         "observatii": "Servicii dezvoltare web și consultanță",
     *         "status": "WAIT",
     *         "spv_status": "Transmis catre ANAF",
     *         "pdf": "https://my.iapp.ro/share/factura/tech2024ff014secure123abc"
     *       },
     *       {
     *         "serie": "FF",
     *         "numar": "2026015",
     *         "client": "SC TECH SOLUTIONS SRL",
     *         "data_emitere": "2026-02-22",
     *         "data_scadenta": "2026-03-09",
     *         "total": 12994,
     *         "moneda": "RON",
     *         "curs_valutar": 0,
     *         "observatii": "Dezvoltare aplicație mobilă și hosting",
     *         "status": "PLATIT",
     *         "spv_status": "Preluat de ANAF",
     *         "pdf": "https://my.iapp.ro/share/factura/tech2024ff015secure456ghi"
     *       }
     *     ],
     *     "totaluri": {
     *       "numar_documente": 2,
     *       "total_ron": 21919,
     *       "detalii_monede": [
     *         {
     *           "moneda": "RON",
     *           "total": 21919
     *         }
     *       ]
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturilor fiscale: " . $e->getMessage() . "\n";
}
