<?php

/**
 * Exemplu pentru vizualizarea setărilor eFactura ale unei firme din contul reseller
 * Echivalentul metodei eFactura_setari_view() din API-ul original
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
    
    // Datele pentru vizualizarea setărilor eFactura
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '35938835338835d361388353388',  // id_firma
    );
    
    // Apel API pentru vizualizarea setărilor eFactura
    $response = $insideApp->resellerEFacturaSetariView($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Vizualizare setări e-Factura SPV în InsideApp.",
     *   "request": "e-factura/setari-view",
     *   "data": {
     *     "output": {
     *       "auto_send_b": "Y",
     *       "auto_send_c": "Y",
     *       "auto_send_days": 2,
     *       "auto_renew": "Y",
     *       "notify_facturi_primite": "Y",
     *       "notify_facturi_trimise": "Y",
     *       "user_email": "office@technosolutions.ro",
     *       "user_name": "Maria Ionescu",
     *       "notify_sms_facturi_primite": "N",
     *       "notify_sms_facturi_trimise": "Y",
     *       "user_phone": "+40731456789",
     *       "notify_sms_facturi_eroare": "Y",
     *       "webhook_url": "https://api.technosolutions.ro/webhook/efactura"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea setărilor eFactura: " . $e->getMessage() . "\n";
}