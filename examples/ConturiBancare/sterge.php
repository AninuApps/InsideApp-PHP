<?php

/**
 * Exemplu pentru ștergerea unui cont bancar din nomenclator
 * Echivalentul metodei conturibancare_sterge() din API-ul original
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
    
    // Datele pentru ștergerea contului bancar
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'id'  => "35938835338835d35e388353388",
    );
    
    // Apel API pentru ștergerea contului bancar
    $response = $insideApp->conturiBancareSterge($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Contul bancar a fost șters cu succes.",
     *   "request": "conturibancare/sterge"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la ștergerea contului bancar: " . $e->getMessage() . "\n";
}
