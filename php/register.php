<?php
session_start();
require_once 'conectare.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = trim($_POST['nume']);
    $email = trim($_POST['email']);
    $parola = $_POST['parola'];
    $confirma_parola = $_POST['confirma_parola'];
    $erori = [];
    
    // Validare nume
    if (empty($nume)) {
        $erori[] = "Numele este obligatoriu!";
    } elseif (strlen($nume) < 3) {
        $erori[] = "Numele trebuie să aibă cel puțin 3 caractere!";
    }
    
    // Validare email
    if (empty($email)) {
        $erori[] = "Email-ul este obligatoriu!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erori[] = "Adresa de email nu este validă!";
    } else {
        // Verificăm dacă email-ul există deja
        $stmt = $conn->prepare("SELECT id FROM utilizatori WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erori[] = "Această adresă de email este deja înregistrată!";
        }
    }
    
    // Validare parolă
    if (empty($parola)) {
        $erori[] = "Parola este obligatorie!";
    } elseif (strlen($parola) < 6) {
        $erori[] = "Parola trebuie să aibă cel puțin 6 caractere!";
    }
    
    // Validare confirmare parolă
    if ($parola !== $confirma_parola) {
        $erori[] = "Parolele nu coincid!";
    }
    
    // Dacă nu sunt erori, înregistrăm utilizatorul
    if (empty($erori)) {
        try {
            $parola_hash = password_hash($parola, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO utilizatori (nume, email, parola) VALUES (?, ?, ?)");
            $stmt->execute([$nume, $email, $parola_hash]);
            
            // Autentificăm utilizatorul imediat după înregistrare
            $_SESSION['utilizator_id'] = $conn->lastInsertId();
            $_SESSION['utilizator_nume'] = $nume;
            $_SESSION['utilizator_email'] = $email;
            $_SESSION['logat'] = true;
            
            // Redirecționăm către pagina principală
            header("Location: ../index.php");
            exit();
        } catch(PDOException $e) {
            $erori[] = "Eroare la înregistrare. Te rugăm să încerci din nou.";
        }
    }
    
    // Dacă sunt erori, le stocăm în sesiune și redirecționăm înapoi
    if (!empty($erori)) {
        $_SESSION['erori'] = $erori;
        $_SESSION['form_data'] = [
            'nume' => $nume,
            'email' => $email
        ];
        header("Location: ../register.php");
        exit();
    }
}
?>
