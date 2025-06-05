<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despre Noi - Adoptă un Prieten</title>
    <link rel="stylesheet" href="style.css">
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

    <main class="about-page">
        <div class="about-container">
            <section class="about-intro">
                <h2>Despre Noi</h2>
                <p>Suntem o platformă dedicată conectării animalelor care au nevoie de un cămin cu oameni care pot oferi dragoste și grijă.</p>
            </section>

            <div class="about-content">
                <section class="mission-section">
                    <h3>Misiunea Noastră</h3>
                    <p>Ne-am propus să facilităm procesul de adopție a animalelor și să creăm o comunitate care să sprijine bunăstarea animalelor fără adăpost din România. Prin intermediul platformei noastre, dorim să:</p>
                    <ul>
                        <li>Conectăm adăposturile cu potențiali adoptatori</li>
                        <li>Educăm publicul despre beneficiile adopției</li>
                        <li>Promovăm adopția responsabilă</li>
                        <li>Reducem numărul animalelor fără adăpost</li>
                    </ul>
                </section>

                <section class="values-section">
                    <h3>Valorile Noastre</h3>
                    <div class="values-grid">
                        <div class="value-card">
                            <i class="fas fa-heart"></i>
                            <h4>Compasiune</h4>
                            <p>Punem bunăstarea animalelor pe primul loc în tot ceea ce facem.</p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-hands-helping"></i>
                            <h4>Responsabilitate</h4>
                            <p>Promovăm adopția responsabilă și îngrijirea pe termen lung.</p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-users"></i>
                            <h4>Comunitate</h4>
                            <p>Construim o rețea puternică de susținători ai adopției de animale.</p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Transparență</h4>
                            <p>Oferim informații clare și corecte despre procesul de adopție.</p>
                        </div>
                    </div>
                </section>

                <section class="impact-section">
                    <h3>Impactul Nostru</h3>
                    <div class="impact-stats">
                        <div class="stat-card">
                            <span class="stat-number">1000+</span>
                            <p>Animale Adoptate</p>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">50+</span>
                            <p>Adăposturi Partenere</p>
                        </div>
                        <div class="stat-card">
                            <span class="stat-number">5000+</span>
                            <p>Utilizatori Activi</p>
                        </div>
                    </div>
                </section>

                <section class="team-section">
                    <h3>Echipa Noastră</h3>
                    <p>Suntem o echipă dedicată de profesioniști și iubitori de animale care lucrează neîncetat pentru a face adopția de animale mai accesibilă și mai sigură pentru toți cei implicați.</p>
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