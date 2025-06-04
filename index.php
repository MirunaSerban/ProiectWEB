<?php
// Începem sesiunea pentru a putea accesa variabilele de sesiune
session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopții Animale</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-images.css">
    <!-- Adăugăm un font modern de la Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <!-- Adăugăm SVG.js pentru manipularea hărții -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/3.1.1/svg.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Adopții Animale</h1>
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

    <main>
        <!-- Secțiunea hero cu imagine de fundal și text -->
        <section class="hero">
            <div class="hero-content">
                <h2>Oferă o șansă la fericire</h2>
                <p class="hero-quote">„Haideți să nu mai așteptăm ca lucrurile să se întâmple,<br>haideți să le facem să se întâmple."</p>
                <a href="adopta.php" class="cta-button">Adoptă Acum</a>
            </div>
        </section>

        <!-- Secțiunea de caracteristici/servicii -->
        <section class="features">
            <div class="container">
                <div class="feature-grid">
                    <div class="feature-card">
                        <img src="images/adopt-icon.svg" alt="Adoptă" class="feature-icon">
                        <h3>Adoptă un Prieten</h3>
                        <p>Descoperă companionul perfect și oferă-i o casă plină de iubire.</p>
                        <a href="adopta.php" class="feature-link">Vezi Animalele</a>
                    </div>
                    <div class="feature-card">
                        <img src="images/shelter-icon.svg" alt="Adăposturi" class="feature-icon">
                        <h3>Adăposturi Partenere</h3>
                        <p>Colaborăm cu adăposturi autorizate din toată țara.</p>
                        <a href="#harta-adaposturi" class="feature-link">Vezi Adăposturile</a>
                    </div>
                    <div class="feature-card">
                        <img src="images/info-icon.svg" alt="Despre Adopție" class="feature-icon">
                        <h3>Despre Adopție</h3>
                        <p>Află tot ce trebuie să știi despre procesul de adopție și regula 3-3-3.</p>
                        <a href="despre_adoptie.php" class="feature-link">Citește Ghidul</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Secțiunea cu harta României -->
        <section class="map-section" id="harta-adaposturi">
            <div class="container">
                <h2>Adăposturi din România</h2>
                <p class="map-intro">Selectează județul pentru a vedea adăposturile disponibile</p>
                
                <div class="map-container">
                    <div class="map-controls">
                        <button class="zoom-in">+</button>
                        <button class="zoom-out">-</button>
                    </div>
                    <div class="romania-map" id="romania-map"></div>
                    <div class="shelters-list">
                        <h3>Adăposturi în județul selectat</h3>
                        <div id="shelters-container">
                            <!-- Lista adăposturilor va fi încărcată aici -->
                            <p class="select-county">Te rugăm să selectezi un județ din hartă</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                <h4>Contact</h4>
                <p>Email: contact@adoptii-animale.ro</p>
                <p>Telefon: (+40) 123 456 789</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Adopții Animale. Toate drepturile rezervate.</p>
        </div>
    </footer>

    <!-- Script pentru harta interactivă -->
    <script src="js/romania-counties.js"></script>
    <script src="js/romania-map.js"></script>
</body>
</html>
