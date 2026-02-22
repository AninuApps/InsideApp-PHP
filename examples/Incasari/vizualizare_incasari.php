<?php

/**
 * Exemplu pentru vizualizarea incasărilor
 * Echivalentul metodei view_incasari() din API-ul original
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
    
    // Datele pentru vizualizarea incasărilor
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'start' => '2025-09-01',                    // obligatoriu (Y-m-d)
        'end' => date("Y-m-d", time()+24*60*60),    // obligatoriu (Y-m-d)

    );
    
    // Apel API pentru vizualizarea incasărilor
    $response = $insideApp->viewIncasari($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "vizualizare/incasari",
     *   "data": {
     *     "perioada": {
     *       "tStart": 1704067200,
     *       "tEnd": 1706745600,
     *       "dStart": "2025-01-01",
     *       "dEnd": "2025-02-01"
     *     },
     *     "raport": [
     *       {
     *         "id": "36e38b35638b35d36436135f35d38b35638b",
     *         "tip_cod": 1,
     *         "tip_incasare": "Chitanță",
     *         "data_incasare": "2026-01-02",
     *         "suma": "2,300.00",
     *         "moneda": "RON",
     *         "status_cod": "OK",
     *         "status": "încasat",
     *         "descriere": "contravaloarea facturii seria APS nr 0187 din data de 02/01/2026",
     *         "factura": {
     *           "pdf": "https://my.iapp.ro/share/factura/4403b037d38137f37d37f3af37d37d38037a378",
     *           "serie": "APS",
     *           "numar": "0187"
     *         },
     *         "chitanta": {
     *           "pdf": "https://my.iapp.ro/share/chitanta/42b3aa37a37d3ac37a37d377337c3aa37a37c3ad376",
     *           "serie": "APS",
     *           "numar": "0001"
     *         }
     *       },
     *       {
     *         "id": "36e38b35638b35d36436235e35e38b35638b",
     *         "tip_cod": 0,
     *         "tip_incasare": "Extras de cont",
     *         "data_incasare": "05/01/2026",
     *         "suma": "17,495.00",
     *         "moneda": "RON",
     *         "status_cod": "OK",
     *         "status": "încasat",
     *         "descriere": "contravaloarea facturii seria APS nr 0188 din data de 05/01/2026",
     *         "factura": {
     *           "pdf": "https://my.iapp.ro/share/factura/4403b037d38137f37d37f3aa37d38037f37d38037e378",
     *           "serie": "APS",
     *           "numar": "0188"
     *         },
     *         "chitanta": {
     *           "pdf": "",
     *           "serie": "",
     *           "numar": ""
     *         }
     *       },
     *       {
     *         "id": "36e38b35638b35d36436335f35f38b35638b",
     *         "tip_cod": 10,
     *         "tip_incasare": "Plata online - EuPlătesc",
     *         "data_incasare": "10/01/2026",
     *         "suma": "5,600.00",
     *         "moneda": "RON",
     *         "status_cod": "OK",
     *         "status": "încasat",
     *         "descriere": "Plata online pentru factura APS nr 0190",
     *         "factura": {
     *           "pdf": "https://my.iapp.ro/share/factura/4403b037d38137f37d377d38037f37d38037e379",
     *           "serie": "APS",
     *           "numar": "0190"
     *         },
     *         "chitanta": {
     *           "pdf": "",
     *           "serie": "",
     *           "numar": ""
     *         }
     *       }
     *     ],
     *     "totaluri": {
     *       "numar_documente": 53,
     *       "total_ron": 169438.72,
     *       "detalii_monede": [
     *         {
     *           "moneda": "RON",
     *           "total": 169438.72
     *         }
     *       ]
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea incasărilor: " . $e->getMessage() . "\n";
}