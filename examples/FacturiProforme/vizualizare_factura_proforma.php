<?php

/**
 * Exemplu pentru vizualizarea unei facturi proforma
 * Echivalentul metodei view_proforma() din API-ul original
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
    
    // Datele pentru vizualizarea facturii proforma
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'PF',          // obligatoriu
        'numar' => '2026001',     // obligatoriu

    );
    
    // Apel API pentru vizualizarea facturii proforma
    $response = $insideApp->facturiProformaVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturii proforma: " . $e->getMessage() . "\n";
}
