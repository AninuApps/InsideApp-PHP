<?php

/**
 * Exemplu pentru vizualizarea unui produs/serviciu din nomenclator
 * Echivalentul metodei produse_vizualizare() din API-ul original
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
    
    // Datele pentru vizualizarea produsului/serviciului
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'id' => '35938835338835b35e388353388',
    );
    
    // Apel API pentru vizualizarea produsului/serviciului
    $response = $insideApp->produseVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "produse/vizualizare",
     *   "data": {
     *     "output": {
     *       "id": "35938835338835b35e388353388",
     *       "nume": "Servicii online",
     *       "descriere": "/",
     *       "um": "buc",
     *       "pret": 0,
     *       "moneda": "RON"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea produsului/serviciului: " . $e->getMessage() . "\n";
}
