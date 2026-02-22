<?php

/**
 * Exemplu pentru încărcarea unui fișier XML în SPV
 * Echivalentul metodei eFactura_upload_xml() din API-ul original
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
    
    /** Read file and encode to base64 */
    $filexml = file_get_contents("ABC-015676.xml");
    $filexml = base64_encode($filexml);
    
    // Datele pentru încărcarea fișierului XML
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'serie' => 'ABC',          // obligatoriu
        'numar' => '015676',     // obligatoriu
        'type' => 'test',     // obligatoriu
        'filexml' => $filexml,     // obligatoriu

    );
    
    // Apel API pentru încărcarea fișierului XML în SPV
    $response = $insideApp->eFacturaUploadXml($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
} catch (Exception $e) {
    echo "Eroare la încărcarea fișierului XML: " . $e->getMessage() . "\n";
}