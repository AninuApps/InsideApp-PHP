<?php

/**
 * Exemplu pentru ștergerea unui client din nomenclator
 * Echivalentul metodei clienti_sterge() din API-ul original
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
    
    // Datele pentru ștergerea clientului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'id'  => "36038935438936335c35a389354389",
    );
    
    // Apel API pentru ștergerea clientului
    $response = $insideApp->clientiSterge($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Clientul a fost șters cu succes.",
     *   "request": "clienti/sterge"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la ștergerea clientului: " . $e->getMessage() . "\n";
}
