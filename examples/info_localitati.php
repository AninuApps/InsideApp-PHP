<?php

/**
 * Exemplu pentru obținerea informațiilor despre localități dintr-un județ
 * Echivalentul metodei info_localitati() din API-ul original
 */

require_once '../vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru obținerea localităților
    $data_iApp = array(
        'email_responsabil' => $email,      
        'cod' => '40'    // cod județ (40 = București, 36 = Timiș, 1 = Alba, etc.)      
    );
    
    // Apel API pentru informații localități
    $response = $insideApp->infoLocalitati($data_iApp);
    
    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000", 
     *   "message": "",
     *   "request": "info/localitati",
     *   "data": {
     *     "cod": 36,
     *     "output": [
     *       {
     *         "cod": 1,
     *         "cod_parinte": 175,
     *         "tip": "Sat",
     *         "name": "Agighiol",
     *         "postal": 827236
     *       },
     *       {
     *         "cod": 2,
     *         "cod_parinte": 80,
     *         "tip": "Sat",
     *         "name": "Alba",
     *         "postal": 827106
     *       },
     *       {
     *         "cod": 3,
     *         "cod_parinte": 48,
     *         "tip": "Sat",
     *         "name": "Ardealu",
     *         "postal": 827071
     *       },
     *       ...
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la obținerea informațiilor localități: " . $e->getMessage() . "\n";
}