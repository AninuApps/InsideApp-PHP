<?php

/**
 * Exemplu pentru obținerea informațiilor despre CIF
 * Echivalentul metodei info_cif() din API-ul original
 */

require_once '../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru verificarea CIF-ului
    $data_iApp = array(
        'email_responsabil' => $email,              // obligatoriu
        'cif' => '49235450',                        // obligatoriu
    );
    
    // Apel API pentru informații CIF
    $response = $insideApp->infoCif($data_iApp);
    
    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la obținerea informațiilor CIF: " . $e->getMessage() . "\n";
}