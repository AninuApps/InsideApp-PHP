<?php

/**
 * Exemplu pentru adăugarea unui produs/serviciu în nomenclator
 * Echivalentul metodei produse_adauga() din API-ul original
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
    
    // Datele pentru adăugarea produsului/serviciului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'nume' => "Produs X x1234",
        'descriere' => "O descriere oarecare",
        'um' => "buc.",
        'pret' => "15",
        'moneda' => "RON",
    );
    
    // Apel API pentru adăugarea produsului/serviciului
    $response = $insideApp->produseAdauga($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Produsul / serviciul a fost adăugat cu succes.",
     *   "request": "produse/adauga"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la adăugarea produsului/serviciului: " . $e->getMessage() . "\n";
}
