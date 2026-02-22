<?php

/**
 * Exemplu pentru verificarea statusului trimiterii unei facturi în SPV
 * Echivalentul metodei eFactura_upload_status() din API-ul original
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
    
    // Datele pentru verificarea statusului trimiterii facturii
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'ABC',          // obligatoriu
        'numar' => '15746',     // obligatoriu

    );
    
    // Apel API pentru verificarea statusului trimiterii în SPV
    $response = $insideApp->spvUploadStatus($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "e-factura/upload-status",
     *   "data": {
     *     "serie": "ABC",
     *     "numar": 15746,
     *     "raport": [
     *       {
     *         "time_sent": 1754256451,
     *         "time_response": 1754256604,
     *         "stare": "OK",
     *         "index_incarcare": "5284730720",
     *         "index_descarcare": "5319613124",
     *         "message": "Factura procesată cu succes în SPV ANAF",
     *         "type": "live"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la verificarea statusului trimiterii facturii: " . $e->getMessage() . "\n";
}