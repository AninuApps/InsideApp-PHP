<?php

/**
 * Exemplu pentru trimiterea manua facturii în SPV
 * Echivalentul metodei trimite_factura_manual_in_spv() din API-ul original
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
    
    // Datele pentru trimiterea facturii în SPV
    $data_iApp = array(
        'email' => $email,
        'serie' => 'A',
        'numar' => 123456,
        'type' => 'test'
    );
    
    // Apel API pentru trimiterea facturii în SPV
    $response = $insideApp->trimiteFacturaSpvManual($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Factura a fost trimisă la ANAF pentru procesare (test).",
     *   "request": "e-factura/trimite-factura-spv",
     *   "data": {
     *     "serie": "A",
     *     "numar": 123456,
     *     "type": "test",
     *     "spv": {
     *       "index_incarcare": "12345678"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la trimiterea facturii în SPV: " . $e->getMessage() . "\n";
}