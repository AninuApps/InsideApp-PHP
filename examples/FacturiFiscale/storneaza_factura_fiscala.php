<?php

/**
 * Exemplu pentru stornarea unei facturi fiscale
 * Echivalentul metodei storneaza_factura() din API-ul original
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
    
    // Datele pentru stornarea facturii fiscale
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'serie' => 'BY',          // obligatoriu
        'numar' => '7',     // obligatoriu
    );
    
    // Apel API pentru stornarea facturii fiscale
    $response = $insideApp->storneazaFactura($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";

    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Factura a fost stornată cu succes.",
     *   "request": "storneaza/factura",
     *   "data": {
     *     "serie": "FV",
     *     "numar": 125,
     *     "document": {
     *       "seria": "FV",
     *       "numar": 126,
     *       "total": -5950,
     *       "status": "STORNO",
     *       "pdf": "https://my.iapp.ro/share/factura/42b3ad37a37d3ac37a37d37b37a37c3ab37a37d37d37c37a37c3ac375"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la stornarea facturii fiscale: " . $e->getMessage() . "\n";
}