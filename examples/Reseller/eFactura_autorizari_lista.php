<?php

/**
 * Exemplu pentru listarea autorizărilor eFactura ale unei firme din contul reseller
 * Echivalentul metodei eFactura_autorizare_lista() din API-ul original
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
    
    // Datele pentru listarea autorizărilor eFactura
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '36038935438935c36135e389354389', // id_firma
    );
    
    // Apel API pentru listarea autorizărilor eFactura
    $response = $insideApp->eFacturaAutorizariLista($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Lista încercărilor de autorizare SPV a fost încărcată cu succes.",
     *   "request": "e-factura/autorizare-lista",
     *   "data": {
     *     "output": [
     *       {
     *         "index": 1,
     *         "autorizat_de": "Nume Delegat",
     *         "data_adaugare": "2024-01-15 14:30:45",
     *         "data_expirare": "2024-07-15 14:30:45",
     *         "status_cod": "A",
     *         "status_text": "Activ",
     *         "mesaj": "Autorizare SPV completată cu succes"
     *       },
     *       {
     *         "index": 2,
     *         "autorizat_de": "Link extern",
     *         "data_adaugare": "2024-02-20 10:15:30",
     *         "data_expirare": "2024-08-20 10:15:30",
     *         "status_cod": "E",
     *         "status_text": "Expirat",
     *         "mesaj": "Autorizarea a expirat și necesită reînnoirea"
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea autorizărilor eFactura: " . $e->getMessage() . "\n";
}