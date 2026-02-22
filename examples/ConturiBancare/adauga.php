<?php

/**
 * Exemplu pentru adăugarea unui cont bancar în nomenclator
 * Echivalentul metodei conturibancare_adauga() din API-ul original
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
    
    // Datele pentru adăugarea contului bancar
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'nume' => "Contul Bancar Test",
        'iban' => "RO49AAAA1B31007593840000",
        'moneda' => "RON",
        'swift' => "AAAA",
        'descriere' => "aceasta este o descriere a contului bancar test",
    );
    
    // Apel API pentru adăugarea contului bancar
    $response = $insideApp->conturiBancareAdauga($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Contul bancar a fost adăugat cu succes.",
     *   "request": "conturibancare/adauga"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la adăugarea contului bancar: " . $e->getMessage() . "\n";
}
