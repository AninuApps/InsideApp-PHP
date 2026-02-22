<?php

/**
 * Exemplu pentru adăugarea unui client în nomenclator
 * Echivalentul metodei clienti_adauga() din API-ul original
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
    
    // Datele pentru adăugarea clientului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        "nume" => "Denumire client",
        "cifcnp" => "9",
        "regcom" => "8",
        "tip" => "F",
        "contact" => "1",
        "email" => "dev@aninu.ro",
        "telefon" => "3",
        "web" => "4",
        "extra" => "5",
        "banca" => "6",
        "iban" => "7",
        "adresa" => array(
            "tara" => "Romania",
            "judet" => "Bucuresti",
            "oras" => "Sector1",
            "adresa" => "Strada Exemplu, Nr. 1"
        ),
    );
    
    // Apel API pentru adăugarea clientului
    $response = $insideApp->clientiAdauga($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "clienti/adauga"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la adăugarea clientului: " . $e->getMessage() . "\n";
}
