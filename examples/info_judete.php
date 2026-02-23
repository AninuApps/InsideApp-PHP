<?php

/**
 * Exemplu pentru obținerea informațiilor despre județe
 * Echivalentul metodei info_judete() din API-ul original
 */

require_once '../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru obținerea județelor (opțional - toate pot fi goale)
    $data_iApp = array(
        'email_responsabil' => $email,
    );
    
    // Apel API pentru informații județe
    $response = $insideApp->infoJudente($data_iApp);
    
    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000", 
     *   "message": "",
     *   "request": "info/judete",
     *   "data": {
     *     "output": [
     *       {
     *         "cod": 1,
     *         "auto": "AB",
     *         "name": "ALBA",
     *         "sort": 1
     *       },
     *       {
     *         "cod": 2,
     *         "auto": "AR", 
     *         "name": "ARAD",
     *         "sort": 2
     *       },
     *       {
     *         "cod": 3,
     *         "auto": "AG",
     *         "name": "ARGEŞ",
     *         "sort": 3
     *       },
     *       ...
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la obținerea informațiilor județe: " . $e->getMessage() . "\n";
}