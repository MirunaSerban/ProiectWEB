<?php
session_start();

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    header('Location: ../login.php');
    exit();
}

require_once 'conectare.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $animal_id = $_POST['animal_id'] ?? null;
    $mesaj = trim($_POST['mesaj'] ?? '');
    $utilizator_id = $_SESSION['utilizator_id'];
    
    $erori = [];
    
    // Validări
    if (!$animal_id || !is_numeric($animal_id)) {
        $erori[] = "ID animal invalid!";
    }
    
    if (empty($mesaj)) {
        $erori[] = "Mesajul este obligatoriu!";
    }
    
    if (empty($erori)) {
        try {
            // Verificăm dacă animalul există și nu are deja o cerere aprobată
            $stmt = $conn->prepare("
                SELECT a.id 
                FROM animale a 
                LEFT JOIN cereri_adoptie ca ON a.id = ca.animal_id AND ca.status = 'aprobat'
                WHERE a.id = ? AND ca.id IS NULL
            ");
            $stmt->execute([$animal_id]);
            
            if (!$stmt->fetch()) {
                $_SESSION['mesaj'] = "Acest animal nu mai este disponibil pentru adopție.";
                $_SESSION['mesaj_tip'] = "error";
                header("Location: ../detalii_animal.php?id=" . $animal_id);
                exit();
            }
            
            // Verificăm dacă utilizatorul are deja o cerere pentru acest animal
            $stmt = $conn->prepare("
                SELECT id FROM cereri_adoptie 
                WHERE animal_id = ? AND utilizator_id = ?
            ");
            $stmt->execute([$animal_id, $utilizator_id]);
            
            if ($stmt->fetch()) {
                $_SESSION['mesaj'] = "Ai depus deja o cerere pentru acest animal.";
                $_SESSION['mesaj_tip'] = "warning";
                header("Location: ../detalii_animal.php?id=" . $animal_id);
                exit();
            }
            
            // Inserăm cererea de adopție
            $stmt = $conn->prepare("
                INSERT INTO cereri_adoptie (utilizator_id, animal_id, mesaj, status, data_cerere) 
                VALUES (?, ?, ?, 'in_asteptare', NOW())
            ");
            $stmt->execute([$utilizator_id, $animal_id, $mesaj]);
            
            $_SESSION['mesaj'] = "Cererea ta de adopție a fost înregistrată cu succes!";
            $_SESSION['mesaj_tip'] = "success";
            
        } catch(PDOException $e) {
            $_SESSION['mesaj'] = "A apărut o eroare la procesarea cererii. Te rugăm să încerci din nou.";
            $_SESSION['mesaj_tip'] = "error";
        }
    } else {
        $_SESSION['mesaj'] = implode(" ", $erori);
        $_SESSION['mesaj_tip'] = "error";
    }
    
    header("Location: ../detalii_animal.php?id=" . $animal_id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cerere_id'])) {
    $cerere_id = $_POST['cerere_id'];
    $utilizator_id = $_SESSION['utilizator_id'];
    
    try {
        // Verificăm dacă cererea aparține utilizatorului și este în așteptare
        $stmt = $conn->prepare("
            SELECT id FROM cereri_adoptie 
            WHERE id = ? AND utilizator_id = ? AND status = 'in_asteptare'
        ");
        $stmt->execute([$cerere_id, $utilizator_id]);
        
        if ($stmt->fetch()) {
            // Ștergem cererea
            $stmt = $conn->prepare("DELETE FROM cereri_adoptie WHERE id = ?");
            $stmt->execute([$cerere_id]);
            
            $_SESSION['mesaj'] = "Cererea de adopție a fost anulată cu succes.";
            $_SESSION['mesaj_tip'] = "success";
        } else {
            $_SESSION['mesaj'] = "Nu ai permisiunea să anulezi această cerere sau cererea nu mai este în așteptare.";
            $_SESSION['mesaj_tip'] = "error";
        }
    } catch(PDOException $e) {
        $_SESSION['mesaj'] = "A apărut o eroare la anularea cererii.";
        $_SESSION['mesaj_tip'] = "error";
    }
}

// Dacă nu este POST, redirecționăm către pagina de adopție
header("Location: ../adopta.php");
exit();
