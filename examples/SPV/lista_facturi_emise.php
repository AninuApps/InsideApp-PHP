<?php

/**
 * Exemplu pentru listarea facturilor emise prin SPV/eFactura
 * Echivalentul metodei eFactura_emise() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru listarea facturilor emise prin SPV
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'start' => '2026-01-01',                    // obligatoriu (Y-m-d)
        'end' => date("Y-m-d"),                     // obligatoriu (Y-m-d)

    );
    
    // Apel API pentru listarea facturilor emise prin SPV
    $response = $insideApp->spvEmiseLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la listarea facturilor emise prin SPV: " . $e->getMessage() . "\n";
}