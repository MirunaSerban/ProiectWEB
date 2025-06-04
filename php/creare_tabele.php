<?php
require_once 'conectare.php';

try {
    // Creăm tabela utilizatori dacă nu există
    $sql = "CREATE TABLE IF NOT EXISTS utilizatori (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nume VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        parola VARCHAR(255) NOT NULL,
        data_inregistrare TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        ultima_autentificare TIMESTAMP NULL,
        activ BOOLEAN DEFAULT TRUE,
        rol ENUM('utilizator', 'admin') DEFAULT 'utilizator'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $conn->exec($sql);
    echo "Tabela 'utilizatori' a fost creată cu succes sau există deja.\n";

    // Creăm tabela pentru adăposturi
    $sql = "CREATE TABLE IF NOT EXISTS adaposturi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nume VARCHAR(200) NOT NULL,
        judet VARCHAR(50) NOT NULL,
        oras VARCHAR(100) NOT NULL,
        adresa TEXT,
        telefon VARCHAR(20),
        email VARCHAR(100),
        website VARCHAR(200),
        descriere TEXT,
        latitudine DECIMAL(10, 8),
        longitudine DECIMAL(11, 8),
        program_functionare TEXT,
        capacitate INT,
        data_adaugare TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $conn->exec($sql);
    echo "Tabela 'adaposturi' a fost creată cu succes sau există deja.\n";

    // Verificăm dacă există un cont de admin
    $stmt = $conn->query("SELECT COUNT(*) FROM utilizatori WHERE rol = 'admin'");
    if ($stmt->fetchColumn() == 0) {
        // Creăm un cont de admin implicit
        $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilizatori (nume, email, parola, rol) 
                VALUES ('Administrator', 'admin@adoptii-animale.ro', :parola, 'admin')";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['parola' => $admin_password]);
        echo "Contul de administrator a fost creat cu succes.\n";
    }

} catch(PDOException $e) {
    echo "Eroare la crearea tabelelor: " . $e->getMessage() . "\n";
}
?> 