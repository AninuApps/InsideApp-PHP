<?php

/**
 * Exemplu pentru adăugarea unei noi serii de facturi
 * Echivalentul metodei serie_adauga() din API-ul original
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
    
    /** Logo - Rezoluția trebuie să fie cuprinsă între: 382W x 100H px și 382W x 170H px. */
    $fileContentLogo = file_get_contents("test_logo.png");
    // Convert the image to base64
    $fileContentLogo = base64_encode($fileContentLogo);

    /** Prepare data */
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'logo'  => $fileContentLogo,
        'proforma' => array(
            'serie'  => "1",
            'nr_inceput'  => "2",
            'nr_curent'  => "3",
            'design'  => "1",
        ),
        'factura' => array(
            'serie'  => "5",
            'nr_inceput'  => "6",
            'nr_curent'  => "7",
            'design'  => "1",
        ),
        'chitanta' => array(
            'serie'  => "9",
            'nr_inceput'  => "10",
            'nr_curent'  => "11",
        ),
    );
    
    // Apel API pentru adăugarea unei noi serii de facturi
    $response = $insideApp->serieAdauga($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Configurarea a fost adăugată cu succes.",
     *   "request": "serie/adauga"
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la adăugarea seriei de facturi: " . $e->getMessage() . "\n";
}