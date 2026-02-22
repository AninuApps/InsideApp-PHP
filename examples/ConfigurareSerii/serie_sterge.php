<?php

/**
 * Exemplu pentru ștergerea unei serii de facturi
 * Echivalentul metodei serie_sterge() din API-ul original
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
    
    // Datele pentru ștergerea unei serii de facturi
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'id'  => "36038935438935b362361389354389",
    );
    
    // Apel API pentru ștergerea seriei de facturi
    $response = $insideApp->serieSterge($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Configurarea a fost ștearsă cu succes.",
     *   "request": "serie/sterge"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la ștergerea seriei de facturi: " . $e->getMessage() . "\n";
}