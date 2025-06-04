<?php
require_once 'conectare.php';

try {
    // Dezactivăm temporar foreign key checks
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Ștergem tabela veche
    $conn->exec("DROP TABLE IF EXISTS adaposturi");
    
    // Creăm tabela cu noua structură
    $conn->exec("CREATE TABLE adaposturi (
        id INT NOT NULL AUTO_INCREMENT,
        nume VARCHAR(100) NOT NULL,
        judet VARCHAR(100) NOT NULL,
        oras VARCHAR(100) NOT NULL,
        adresa VARCHAR(255) NOT NULL,
        telefon VARCHAR(20) NOT NULL,
        email VARCHAR(100),
        website VARCHAR(255),
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
    
    // Reactivăm foreign key checks
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "Structura tabelei a fost actualizată cu succes!\n";
    
} catch(PDOException $e) {
    echo "Eroare la actualizarea structurii: " . $e->getMessage() . "\n";
} 