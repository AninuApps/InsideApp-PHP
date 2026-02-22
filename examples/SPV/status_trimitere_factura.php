<?php

/**
 * Exemplu pentru verificarea statusului trimiterii unei facturi în SPV
 * Echivalentul metodei eFactura_upload_status() din API-ul original
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
    
    // Datele pentru verificarea statusului trimiterii facturii
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'ABC',          // obligatoriu
        'numar' => '15746',     // obligatoriu

    );
    
    // Apel API pentru verificarea statusului trimiterii în SPV
    $response = $insideApp->spvUploadStatus($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la verificarea statusului trimiterii facturii: " . $e->getMessage() . "\n";
}