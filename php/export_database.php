<?php
require_once 'conectare.php';

try {
    // Array cu toate tabelele din baza de date
    $tables = array(
        'utilizatori',
        'animale',
        'adaposturi',
        'cereri_adoptie'
    );
    
    $output = "-- Export baza de date Adoptii Animale\n\n";
    
    foreach ($tables as $table) {
        // Obține structura tabelului
        $stmt = $conn->prepare("SHOW CREATE TABLE $table");
        $stmt->execute();
        $row = $stmt->fetch();
        $output .= "\n\n" . $row['Create Table'] . ";\n\n";
        
        // Obține datele din tabel
        $stmt = $conn->prepare("SELECT * FROM $table");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        
        foreach ($rows as $row) {
            $fields = array_map(function($value) use ($conn) {
                if ($value === null) return 'NULL';
                return $conn->quote($value);
            }, $row);
            
            $output .= "INSERT INTO $table VALUES (" . implode(", ", $fields) . ");\n";
        }
    }
    
    // Salvează în fișier
    file_put_contents('database_export.sql', $output);
    echo "Exportul bazei de date a fost realizat cu succes!";
    
} catch(PDOException $e) {
    die("Eroare la exportul bazei de date: " . $e->getMessage());
}
?> 