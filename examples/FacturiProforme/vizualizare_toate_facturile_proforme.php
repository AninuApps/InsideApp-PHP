<?php

/**
 * Exemplu pentru vizualizarea tuturor facturilor proforma dintr-o perioadă
 * Echivalentul metodei view_proforme() din API-ul original
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
    
    // Datele pentru vizualizarea tuturor facturilor proforma
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'start' => '2026-01-01',                    // obligatoriu (Y-m-d)
        'end' => date("Y-m-d"),                     // obligatoriu (Y-m-d) - până azi

    );
    
    // Apel API pentru vizualizarea listei de facturi proforma
    $response = $insideApp->facturiProformaLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "vizualizare/proforme",
     *   "data": {
     *     "perioada": {
     *       "tStart": 1704067200,
     *       "tEnd": 1706745600,
     *       "dStart": "2026-01-01",
     *       "dEnd": "2026-02-22"
     *     },
     *     "raport": [
     *       {
     *         "serie": "PF",
     *         "numar": "2026001",
     *         "client": "DIGITAL SOLUTIONS SRL",
     *         "data_emitere": "2026-01-15",
     *         "data_scadenta": "2026-02-14",
     *         "total": 7615,
     *         "moneda": "RON",
     *         "curs_valuta": 0,
     *         "observatii": "Consultanță IT și licențe software",
     *         "status": "WAIT",
     *         "pdf": "https://my.iapp.ro/share/proforma/tech2024pf001secure789xyz"
     *       },
     *       {
     *         "serie": "PF",
     *         "numar": "2026002",
     *         "client": "INNOVATE SYSTEMS SRL",
     *         "data_emitere": "2026-02-10",
     *         "data_scadenta": "2026-03-12",
     *         "total": 4635,
     *         "moneda": "RON",
     *         "curs_valutar": 0,
     *         "observatii": "Dezvoltare aplicație mobilă",
     *         "status": "EMIS",
     *         "pdf": "https://my.iapp.ro/share/proforma/tech2024pf002secure456abc"
     *       }
     *     ],
     *     "totaluri": {
     *       "numar_documente": 2,
     *       "total_ron": 12250,
     *       "detalii_monede": [
     *         {
     *           "moneda": "RON",
     *           "total": 12250
     *         }
     *       ]
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturilor proforma: " . $e->getMessage() . "\n";
}
