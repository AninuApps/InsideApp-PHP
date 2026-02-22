<?php

/**
 * Exemplu pentru activarea unei firme din contul reseller
 * Echivalentul metodei firma_activeaza() din API-ul original
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
    
    // Datele pentru activarea firmei
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '36038935438935c35e35c389354389',
    );
    
    // Apel API pentru activarea firmei
    $response = $insideApp->firmaActiveaza($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Firma a fost activată cu succes.",
     *   "request": "firma/activeaza"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la activarea firmei: " . $e->getMessage() . "\n";
}