<?php
require_once 'conectare.php';

try {
    // Creăm tabelul pentru adăposturi
    $sql = "CREATE TABLE IF NOT EXISTS adaposturi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nume VARCHAR(255) NOT NULL,
        judet VARCHAR(50) NOT NULL,
        oras VARCHAR(100) NOT NULL,
        adresa TEXT,
        telefon VARCHAR(50),
        email VARCHAR(100),
        website VARCHAR(255),
        capacitate INT,
        data_adaugare TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $conn->exec($sql);
    echo "Tabelul adaposturi a fost creat cu succes!\n";

} catch(PDOException $e) {
    echo "Eroare la crearea tabelului: " . $e->getMessage() . "\n";
} 