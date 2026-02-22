<?php

/**
 * Exemplu pentru descărcarea unei facturi emise prin SPV
 * Echivalentul metodei eFactura_descarca_emise() din API-ul original
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
    
    // Datele pentru descărcarea unei facturi emise
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id_descarcare' => '3298051889',             // obligatoriu
        'output' => 'fisier_output.zip',             // obligatoriu

    );
    
    // Apel API pentru descărcarea facturii emise
    $response = $insideApp->eFacturaDescarcaEmise($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la descărcarea facturii emise: " . $e->getMessage() . "\n";
}