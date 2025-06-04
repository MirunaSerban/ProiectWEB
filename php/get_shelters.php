<?php
header('Content-Type: application/json');
require_once 'conectare.php';

// Pentru debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obținem județul din parametrul GET
$judet = isset($_GET['judet']) ? $_GET['judet'] : '';

// Debug: afișăm județul primit
error_log("Județ primit: " . $judet);

// Mapare între codurile de județe și numele complete
$coduri_judete = [
    'AB' => 'Alba',
    'AR' => 'Arad',
    'AG' => 'Argeș',
    'BC' => 'Bacău',
    'BH' => 'Bihor',
    'BN' => 'Bistrița-Năsăud',
    'BT' => 'Botoșani',
    'BV' => 'Brașov',
    'BR' => 'Brăila',
    'B' => 'București',
    'BZ' => 'Buzău',
    'CS' => 'Caraș-Severin',
    'CL' => 'Călărași',
    'CJ' => 'Cluj',
    'CT' => 'Constanța',
    'CV' => 'Covasna',
    'DB' => 'Dâmbovița',
    'DJ' => 'Dolj',
    'GL' => 'Galați',
    'GR' => 'Giurgiu',
    'GJ' => 'Gorj',
    'HR' => 'Harghita',
    'HD' => 'Hunedoara',
    'IL' => 'Ialomița',
    'IS' => 'Iași',
    'IF' => 'Ilfov',
    'MM' => 'Maramureș',
    'MH' => 'Mehedinți',
    'MS' => 'Mureș',
    'NT' => 'Neamț',
    'OT' => 'Olt',
    'PH' => 'Prahova',
    'SM' => 'Satu Mare',
    'SJ' => 'Sălaj',
    'SB' => 'Sibiu',
    'SV' => 'Suceava',
    'TR' => 'Teleorman',
    'TM' => 'Timiș',
    'TL' => 'Tulcea',
    'VS' => 'Vaslui',
    'VL' => 'Vâlcea',
    'VN' => 'Vrancea'
];

try {
    if (!empty($judet)) {
        // Debug: afișăm numele județului după mapare
        error_log("Județ căutat în DB: " . ($coduri_judete[$judet] ?? 'Negăsit'));
        
        // Căutăm adăposturile pentru județul specificat
        $stmt = $conn->prepare("SELECT * FROM adaposturi WHERE judet = :judet ORDER BY nume");
        $stmt->execute([':judet' => $coduri_judete[$judet] ?? $judet]);
        $adaposturi = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Debug: afișăm numărul de adăposturi găsite
        error_log("Număr adăposturi găsite: " . count($adaposturi));
        
        echo json_encode($adaposturi, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([]);
    }
} catch(PDOException $e) {
    error_log("Eroare SQL: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Eroare la obținerea adăposturilor']);
}
?> 