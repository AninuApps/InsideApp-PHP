<?php

/**
 * Exemplu pentru marcarea unei facturi fiscale ca fiind încasată
 * Echivalentul metodei incaseaza_factura() din API-ul original
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
    
    // Datele pentru marcarea facturii ca încasată
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'FF',          // obligatoriu - seria facturii fiscale
        'numar' => '2026001',     // obligatoriu - numărul facturii fiscale

    );
    
    // Apel API pentru marcarea facturii ca încasată
    $response = $insideApp->facturiIncaseaza($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Factura a fost incasata cu succes.",
     *   "request": "incaseaza/factura",
     *   "data": {
     *     "serie": "FF",
     *     "numar": 2026015
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la marcarea facturii ca încasată: " . $e->getMessage() . "\n";
}
