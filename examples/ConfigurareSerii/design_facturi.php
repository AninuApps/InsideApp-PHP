<?php

/**
 * Exemplu pentru vizualizarea design-urilor de facturi
 * Echivalentul metodei serie_design() din API-ul original
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
    
    // Datele pentru vizualizarea design-urilor de facturi
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
    );
    
    // Apel API pentru vizualizarea design-urilor de facturi
    $response = $insideApp->serieDesign($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "serie/design",
     *   "data": {
     *     "output": [
     *       {
     *         "id": 1,
     *         "nume": "Standard",
     *         "imagine": "https://my.iapp.ro/public/design_invoices/design_1.png"
     *       },
     *       {
     *         "id": 2,
     *         "nume": "Green 1",
     *         "imagine": "https://my.iapp.ro/public/design_invoices/design_2.png"
     *       },
     *       {
     *         "id": 3,
     *         "nume": "Black 1",
     *         "imagine": "https://my.iapp.ro/public/design_invoices/design_3.png"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea design-urilor de facturi: " . $e->getMessage() . "\n";
}