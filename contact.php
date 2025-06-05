<?php
session_start();

// Procesare formular
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume = $_POST['nume'] ?? '';
    $email = $_POST['email'] ?? '';
    $subiect = $_POST['subiect'] ?? '';
    $mesaj = $_POST['mesaj'] ?? '';
    
    $erori = [];
    
    // Validări
    if (empty($nume)) {
        $erori[] = "Numele este obligatoriu";
    }
    
    if (empty($email)) {
        $erori[] = "Email-ul este obligatoriu";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erori[] = "Adresa de email nu este validă";
    }
    
    if (empty($subiect)) {
        $erori[] = "Subiectul este obligatoriu";
    }
    
    if (empty($mesaj)) {
        $erori[] = "Mesajul este obligatoriu";
    }
    
    if (empty($erori)) {
        // Aici se poate adăuga logica pentru trimiterea email-ului
        $_SESSION['mesaj_succes'] = "Mesajul tău a fost trimis cu succes! Vom reveni cu un răspuns în cel mai scurt timp posibil.";
        header("Location: contact.php");
        exit();
    } else {
        $_SESSION['erori'] = $erori;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Adoptă un Prieten</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome pentru iconițe -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Adoptă un Prieten</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Acasă</a></li>
                <li><a href="adopta.php">Adoptă</a></li>
                <li><a href="despre_adoptie.php">Despre Adopție</a></li>
                <li><a href="adaposturi.php">Adăposturi</a></li>
                <?php if (isset($_SESSION['logat']) && $_SESSION['logat'] === true): ?>
                    <li><a href="panou_utilizator.php">Panou Utilizator</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php if (isset($_SESSION['logat']) && $_SESSION['logat'] === true): ?>
            <a href="php/logout.php" class="logout-button">Deconectare</a>
        <?php else: ?>
            <div class="auth-buttons">
                <a href="login.php" class="login-button">Autentificare</a>
                <a href="register.php" class="register-button">Înregistrare</a>
            </div>
        <?php endif; ?>
    </header>

    <main class="contact-page">
        <div class="contact-container">
            <section class="contact-intro">
                <h2>Contactează-ne</h2>
                <p>Ai întrebări despre procesul de adopție sau dorești să ne împărtășești experiența ta? Suntem aici să te ajutăm!</p>
            </section>

            <div class="contact-content">
                <section class="contact-info">
                    <h3>Informații de Contact</h3>
                    <div class="info-items">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Adresă</h4>
                                <p>Strada Exemplu nr. 123<br>București, România</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h4>Telefon</h4>
                                <p>(+40) 123 456 789</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email</h4>
                                <p>contact@adoptii-animale.ro</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>Program</h4>
                                <p>Luni - Vineri: 09:00 - 18:00<br>
                                   Sâmbătă: 10:00 - 14:00<br>
                                   Duminică: Închis</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="contact-form-section">
                    <h3>Trimite-ne un Mesaj</h3>
                    
                    <?php if (isset($_SESSION['erori'])): ?>
                        <div class="alert error">
                            <?php 
                            foreach($_SESSION['erori'] as $eroare) {
                                echo "<p>$eroare</p>";
                            }
                            unset($_SESSION['erori']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['mesaj_succes'])): ?>
                        <div class="alert success">
                            <?php 
                            echo $_SESSION['mesaj_succes'];
                            unset($_SESSION['mesaj_succes']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" class="contact-form">
                        <div class="form-group">
                            <label for="nume">Nume complet</label>
                            <input type="text" id="nume" name="nume" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subiect">Subiect</label>
                            <input type="text" id="subiect" name="subiect" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="mesaj">Mesaj</label>
                            <textarea id="mesaj" name="mesaj" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-button">Trimite Mesajul</button>
                    </form>
                </section>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Adopții Animale</h3>
                <p>Împreună putem face o diferență în viața animalelor fără adăpost.</p>
            </div>
            <div class="footer-section">
                <h4>Link-uri Utile</h4>
                <ul>
                    <li><a href="despre.php">Despre Noi</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="termeni.php">Termeni și Condiții</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Parteneri</h4>
                <ul>
                    <li><a href="https://scanstart.ro" target="_blank">ScanStart</a></li>
                    <li><a href="https://csac.ro" target="_blank">CSAC</a></li>
                    <li><a href="https://www.instagram.com/cie.engineering_ulbs/?hl=en" target="_blank">CIE Engineering ULBS</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: contact@adoptii-animale.ro</p>
                <p>Telefon: (+40) 123 456 789</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Adopții Animale. Toate drepturile rezervate.</p>
        </div>
    </footer>
</body>
</html> 