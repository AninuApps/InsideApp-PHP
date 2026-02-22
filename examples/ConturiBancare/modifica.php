<?php

/**
 * Exemplu pentru modificarea unui cont bancar din nomenclator
 * Echivalentul metodei conturibancare_modifica() din API-ul original
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
    
    // Datele pentru modificarea contului bancar
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id' => '35938835338835d35c388353388',

        'nume' => "Contul Bancar Tes",
        'iban' => "RRRRXXAAAA1B31007593840000",
        'moneda' => "RON",
        'swift' => "",
        'descriere' => "aceasta este o descriere a contului bancar test",
    );
    
    // Apel API pentru modificarea contului bancar
    $response = $insideApp->conturiBancareModifica($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Contul bancar a fost modificat cu succes.",
     *   "request": "conturibancare/modifica"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la modificarea contului bancar: " . $e->getMessage() . "\n";
}
