<?php

/**
 * Exemplu pentru ștergerea logo-ului unei serii de facturi
 * Echivalentul metodei serie_sterge_logo() din API-ul original
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
    
    // Datele pentru ștergerea logo-ului unei serii de facturi
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'id'  => "36038935438935b362362389354389",
    );
    
    // Apel API pentru ștergerea logo-ului seriei de facturi
    $response = $insideApp->serieStergeLogo($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Logo-ul a fost șters cu succes.",
     *   "request": "serie/sterge-logo"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la ștergerea logo-ului seriei de facturi: " . $e->getMessage() . "\n";
}