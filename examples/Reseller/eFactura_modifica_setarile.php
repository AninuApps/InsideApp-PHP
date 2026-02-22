<?php

/**
 * Exemplu pentru modificarea setărilor eFactura ale unei firme din contul reseller
 * Echivalentul metodei eFactura_setari_update() din API-ul original
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
    
    // Datele pentru modificarea setărilor eFactura
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '35938835338835d361388353388', // id_firma
        
        // Setări trimitere automată
        'auto_send_b' => 'Y',               // (Y/N) Trimite automat facturile în SPV (B2B / B2G)
        'auto_send_c' => 'Y',               // (Y/N) Trimite automat facturile în SPV (B2C)
        'auto_send_days' => 2,              // Zile întârziere pentru trimiterea automată în SPV (0-4)
        'auto_renew' => 'Y',                // (Y/N) Reînnoire automată a certificatelor digitale la 90 de zile
        
        // Notificări email
        'notify_facturi_primite' => 'Y',    // (Y/N) Notificare email la primirea facturilor
        'notify_facturi_trimise' => 'Y',    // (Y/N) Notificare email la trimiterea facturilor
        'user_email' => 'test@firma.ro', // Email-ul pentru notificări (max 75 caractere)
        'user_name' => 'Nume Delegat',         // Numele utilizatorului pentru notificări (max 75 caractere)
        
        // Notificări SMS
        'notify_sms_facturi_primite' => 'Y', // (Y/N) Notificare SMS la primirea facturilor
        'notify_sms_facturi_trimise' => 'Y', // (Y/N) Notificare SMS la trimiterea facturilor
        'user_phone' => '+40...',     // Telefonul pentru notificări SMS (+40..., max 15 caractere)
        'notify_sms_facturi_eroare' => 'Y', // (Y/N) Notificare SMS la apariția erorilor la trimiterea facturilor
        
        // Webhook
        'webhook_url' => '', // URL-ul pentru notificări Webhook (https:// sau gol)
    );
    
    // Apel API pentru modificarea setărilor eFactura
    $response = $insideApp->eFacturaModificaSetarile($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Setările e-Factura SPV au fost actualizate cu succes în InsideApp.",
     *   "request": "e-factura/setari-update"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la modificarea setărilor eFactura: " . $e->getMessage() . "\n";
}