<?php

/**
 * Exemplu pentru vizualizarea tuturor facturilor proforma dintr-o perioadă
 * Echivalentul metodei view_proforme() din API-ul original
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
    
    // Datele pentru vizualizarea tuturor facturilor proforma
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'start' => '2026-01-01',                    // obligatoriu (Y-m-d)
        'end' => date("Y-m-d"),                     // obligatoriu (Y-m-d) - până azi

    );
    
    // Apel API pentru vizualizarea listei de facturi proforma
    $response = $insideApp->facturiProformaLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturilor proforma: " . $e->getMessage() . "\n";
}
