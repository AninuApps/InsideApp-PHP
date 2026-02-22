<?php

/**
 * Exemplu pentru dezactivarea unei firme din contul reseller
 * Echivalentul metodei firma_dezactiveaza() din API-ul original
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
    
    // Datele pentru dezactivarea firmei
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '36038935438935c35e35c389354389',
    );
    
    // Apel API pentru dezactivarea firmei
    $response = $insideApp->resellerFirmaDezactiveaza($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Firma a fost dezactivată cu succes.",
     *   "request": "firma/dezactiveaza"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la dezactivarea firmei: " . $e->getMessage() . "\n";
}