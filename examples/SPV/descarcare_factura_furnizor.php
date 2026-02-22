<?php

/**
 * Exemplu pentru descărcarea facturilor de la furnizori din SPV
 * Echivalentul metodei eFactura_descarca_furnizori() din API-ul original
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
    
    // Datele pentru descărcarea facturilor de la furnizori
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id_descarcare' => '3283015416',             // obligatoriu
        'output' => '3283015416.zip',             // obligatoriu

    );
    
    // Apel API pentru descărcarea facturilor de la furnizori
    $response = $insideApp->eFacturaDescarcaFurnizori($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la descărcarea facturilor de la furnizori: " . $e->getMessage() . "\n";
}