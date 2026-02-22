<?php

/**
 * Exemplu pentru ștergerea unui produs/serviciu din nomenclator
 * Echivalentul metodei produse_sterge() din API-ul original
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
    
    // Datele pentru ștergerea produsului/serviciului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'id'  => "36038935438935b36235e389354389",
    );
    
    // Apel API pentru ștergerea produsului/serviciului
    $response = $insideApp->produseSterge($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Produsul / Serviciul a fost șters cu succes.",
     *   "request": "produse/sterge"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la ștergerea produsului/serviciului: " . $e->getMessage() . "\n";
}
