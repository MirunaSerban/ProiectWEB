<?php
session_start();

// Dacă utilizatorul este deja autentificat, redirecționăm către pagina principală
if (isset($_SESSION['logat']) && $_SESSION['logat'] === true) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare - Adopții Animale</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="main-nav">
            <div class="nav-brand">
                <img src="images/info-icon.svg" alt="Adopții Animale Logo" class="logo">
                <div class="brand-text">
                    <h1>Adopții Animale</h1>
                    <p class="tagline">"Rescued is our favorite breed"</p>
                </div>
            </div>
            <div class="nav-links">
                <a href="index.php">Acasă</a>
                <a href="adopta.php">Adoptă un prieten</a>
                <a href="adaposturi.php">Adăposturi partenere</a>
                <a href="despre_adoptie.php">Despre adopție</a>
                <a href="login.php" class="active">Autentificare</a>
                <a href="register.php">Înregistrare</a>
            </div>
        </nav>
    </header>

    <main class="auth-main">
        <div class="auth-container">
            <div class="auth-box">
                <h2>Autentificare</h2>
                <p class="auth-intro">Bine ai revenit! Te rugăm să te autentifici pentru a continua.</p>

                <?php if (isset($_SESSION['eroare'])): ?>
                    <div class="alert error">
                        <?php 
                        echo $_SESSION['eroare'];
                        unset($_SESSION['eroare']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="php/proceseaza_login.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required 
                               placeholder="Introdu adresa ta de email">
                    </div>

                    <div class="form-group">
                        <label for="parola">Parolă</label>
                        <input type="password" id="parola" name="parola" required 
                               placeholder="Introdu parola ta">
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" id="remember">
                            <span>Ține-mă minte</span>
                        </label>
                        <a href="recuperare_parola.php" class="forgot-password">Ai uitat parola?</a>
                    </div>

                    <button type="submit" class="auth-button">Autentificare</button>
                </form>

                <div class="auth-footer">
                    <p>Nu ai cont încă? <a href="register.php">Înregistrează-te aici</a></p>
                </div>
            </div>

            <div class="auth-image">
                <img src="images/auth-pets.svg" alt="Animale fericite">
                <div class="auth-quote">
                    <p>"Fiecare animal salvat este o poveste de succes"</p>
                </div>
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