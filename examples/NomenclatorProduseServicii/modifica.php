<?php

/**
 * Exemplu pentru modificarea unui produs/serviciu din nomenclator
 * Echivalentul metodei produse_modifica() din API-ul original
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
    
    // Datele pentru modificarea produsului/serviciului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id' => '36038935438935b360363389354389',

        'nume' => "Wow nice",
        'descriere' => "O descriere oarecare",
        'um' => "buc.",
        'pret' => "15.21",
        'moneda' => "RON",
    );
    
    // Apel API pentru modificarea produsului/serviciului
    $response = $insideApp->produseModifica($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "produse/modifica"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la modificarea produsului/serviciului: " . $e->getMessage() . "\n";
}
