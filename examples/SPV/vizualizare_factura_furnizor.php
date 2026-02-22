<?php

/**
 * Exemplu pentru vizualizarea unei facturi de la furnizor din SPV
 * Echivalentul metodei eFactura_view_furnizori() din API-ul original
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
    
    // Datele pentru vizualizarea unei facturi de la furnizor
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id_incarcare' => '5497449364',             // obligatoriu

    );
    
    // Apel API pentru vizualizarea facturii de la furnizor
    $response = $insideApp->eFacturaViewFurnizori($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea facturii de la furnizor: " . $e->getMessage() . "\n";
}