<?php
session_start();
require_once 'conectare.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? '';
    
    // Validare de bază
    if (empty($email) || empty($parola)) {
        $_SESSION['eroare'] = "Te rugăm să completezi toate câmpurile.";
        header('Location: ../login.php');
        exit();
    }

    try {
        // Căutăm utilizatorul după email
        $stmt = $conn->prepare("SELECT id, nume, email, parola FROM utilizatori WHERE email = ?");
        $stmt->execute([$email]);
        $utilizator = $stmt->fetch();

        if ($utilizator && password_verify($parola, $utilizator['parola'])) {
            // Autentificare reușită
            $_SESSION['logat'] = true;
            $_SESSION['utilizator_id'] = $utilizator['id'];
            $_SESSION['utilizator_nume'] = $utilizator['nume'];
            $_SESSION['utilizator_email'] = $utilizator['email'];

            // Verificăm dacă utilizatorul a selectat "Ține-mă minte"
            if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                // Setăm cookie-uri pentru 30 de zile
                setcookie('user_email', $email, time() + (86400 * 30), "/");
                // Nu stocăm niciodată parola în cookie!
            }

            header('Location: ../index.php');
            exit();
        } else {
            // Autentificare eșuată
            $_SESSION['eroare'] = "Email sau parolă incorectă.";
            header('Location: ../login.php');
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['eroare'] = "A apărut o eroare la autentificare. Te rugăm să încerci din nou.";
        error_log("Eroare la autentificare: " . $e->getMessage());
        header('Location: ../login.php');
        exit();
    }
} else {
    // Dacă cineva încearcă să acceseze direct acest fișier
    header('Location: ../login.php');
    exit();
}
?> 