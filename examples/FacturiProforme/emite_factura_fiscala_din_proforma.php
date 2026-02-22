<?php

/**
 * Exemplu pentru transformarea unei facturi proforma în factură fiscală
 * Echivalentul metodei factureaza_proforma() din API-ul original
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
    
    // Datele pentru transformarea proformei în factură fiscală
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'PF',          // obligatoriu - seria proformei
        'numar' => '2026001',     // obligatoriu - numărul proformei

    );
    
    // Apel API pentru transformarea proformei în factură fiscală
    $response = $insideApp->facturiProformaConvertesteFactura($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Factura fiscala a fost inregistrata cu succes.",
     *   "request": "factureaza/proforma",
     *   "data": {
     *     "serie": "PF",
     *     "numar": 2026001,
     *     "document": {
     *       "seria": "FV",
     *       "numar": 2026003,
     *       "status": "WAIT",
     *       "pdf": "https://my.iapp.ro/share/factura/tech2024fv003secure123def"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la transformarea proformei în factură fiscală: " . $e->getMessage() . "\n";
}
