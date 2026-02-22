<?php

/**
 * Exemplu pentru modificarea unui client din nomenclator
 * Echivalentul metodei clienti_modifica() din API-ul original
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
    
    // Datele pentru modificarea clientului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id' => '36738a35538a35c35d36036038a35538a',

        "nume" => "Denumire client",
        "cifcnp" => "RO1234567890",
        "regcom" => "123",
        "tip" => "J",
        "contact" => "1",
        "email" => "dev@aninu.ax",
        "telefon" => "3",
        "web" => "4",
        "extra" => "5",
        "banca" => "6",
        "iban" => "7",
        "adresa" => array(
            "tara" => "8",
            "judet" => "9",
            "oras" => "10",
            "adresa" => "11"
        ),
    );
    
    // Apel API pentru modificarea clientului
    $response = $insideApp->clientiModifica($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "clienti/modifica"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la modificarea clientului: " . $e->getMessage() . "\n";
}
