-- Crearea tabelului pentru utilizatori
CREATE TABLE IF NOT EXISTS utilizatori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    parola VARCHAR(255) NOT NULL,
    data_inregistrare TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crearea tabelului pentru animale
CREATE TABLE IF NOT EXISTS animale (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(100) NOT NULL,
    tip VARCHAR(50) NOT NULL,
    varsta VARCHAR(50) NOT NULL,
    descriere TEXT,
    imagine_url VARCHAR(255),
    adoptat BOOLEAN DEFAULT FALSE,
    data_adaugare TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crearea tabelului pentru adopții
CREATE TABLE IF NOT EXISTS adoptii (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilizator_id INT NOT NULL,
    animal_id INT NOT NULL,
    data_adoptie TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilizator_id) REFERENCES utilizatori(id),
    FOREIGN KEY (animal_id) REFERENCES animale(id)
); 