<?php

/**
 * Exemplu pentru crearea unei noi autorizări eFactura pentru o firmă din contul reseller
 * Echivalentul metodei eFactura_autorizare() din API-ul original
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
    
    // Datele pentru crearea unei noi autorizări eFactura
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '352387352387359387352387', // id_firma
        'design' => 1, // la cerere se poate realiza un design personalizat 
        'return' => ''  // optional url return pentru redirect
    );
    
    // Apel API pentru crearea unei noi autorizări eFactura
    $response = $insideApp->resellerEFacturaAutorizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Link-ul pentru autorizare SPV a fost generat cu succes.",
     *   "request": "e-factura/autorizare",
     *   "data": {
     *     "output": {
     *       "id": "352387352387359387352387",
     *       "nume": "TECHNO SOLUTIONS SRL",
     *       "cif": "RO47852369",
     *       "link": "https://my.iapp.ro/auth/anafspv/tech2024secure789xyz"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la crearea autorizării eFactura: " . $e->getMessage() . "\n";
}