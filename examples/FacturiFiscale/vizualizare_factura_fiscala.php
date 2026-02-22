<?php

/**
 * Exemplu pentru vizualizarea unei facturi fiscale
 * Echivalentul metodei view_factura() din API-ul original
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
    
    // Datele pentru vizualizarea facturii fiscale
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'FF',          // obligatoriu
        'numar' => '2026001',     // obligatoriu

    );
    
    // Apel API pentru vizualizarea facturii fiscale
    $response = $insideApp->facturiVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturii fiscale: " . $e->getMessage() . "\n";
}
