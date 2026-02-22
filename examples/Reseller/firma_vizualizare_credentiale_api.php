<?php

/**
 * Exemplu pentru vizualizarea credențialelor API ale unei firme din contul reseller
 * Echivalentul metodei firma_api() din API-ul original
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
    
    // Datele pentru vizualizarea credențialelor API ale firmei
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '352387352387359387352387',
    );
    
    // Apel API pentru vizualizarea credențialelor API
    $response = $insideApp->resellerFirmaApi($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "firma/api",
     *   "data": {
     *     "output": {
     *       "id": "352387352387359387352387",
     *       "cod_firma": "TECH-2024-3845-9201",
     *       "parola": "TechnoApi#2024$Secure",
     *       "email_responsabil": "admin@technosolutions.ro",
     *       "nume": "TECHNO SOLUTIONS SRL",
     *       "cif": "RO47852369"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea credențialelor API: " . $e->getMessage() . "\n";
}