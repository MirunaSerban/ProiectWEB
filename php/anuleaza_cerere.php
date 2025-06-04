<?php
session_start();

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    header('Location: ../login.php');
    exit();
}

require_once 'conectare.php';

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

header("Location: ../panou_utilizator.php");
exit(); 