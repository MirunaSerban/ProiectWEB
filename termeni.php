<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termeni și Condiții - Adoptă un Prieten</title>
    <link rel="stylesheet" href="style.css">
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

    <main class="terms-page">
        <div class="terms-container">
            <section class="terms-intro">
                <h2>Termeni și Condiții</h2>
                <p>Vă rugăm să citiți cu atenție acești termeni și condiții înainte de a utiliza platforma noastră.</p>
            </section>

            <div class="terms-content">
                <section class="terms-section">
                    <h3>1. Acceptarea Termenilor</h3>
                    <p>Prin accesarea și utilizarea platformei Adopții Animale, acceptați să respectați acești termeni și condiții de utilizare. Dacă nu sunteți de acord cu acești termeni, vă rugăm să nu utilizați platforma.</p>
                </section>

                <section class="terms-section">
                    <h3>2. Eligibilitate</h3>
                    <p>Pentru a utiliza serviciile noastre, trebuie:</p>
                    <ul>
                        <li>Să aveți vârsta minimă de 18 ani</li>
                        <li>Să furnizați informații reale și actualizate</li>
                        <li>Să aveți capacitatea legală de a încheia contracte</li>
                    </ul>
                </section>

                <section class="terms-section">
                    <h3>3. Procesul de Adopție</h3>
                    <p>Platforma noastră facilitează procesul de adopție, dar:</p>
                    <ul>
                        <li>Nu suntem responsabili pentru deciziile finale ale adăposturilor</li>
                        <li>Nu garantăm disponibilitatea animalelor afișate</li>
                        <li>Rezervăm dreptul de a refuza accesul utilizatorilor care nu respectă politicile noastre</li>
                    </ul>
                </section>

                <section class="terms-section">
                    <h3>4. Responsabilitățile Utilizatorilor</h3>
                    <p>Ca utilizator al platformei, sunteți de acord să:</p>
                    <ul>
                        <li>Furnizați informații corecte și complete</li>
                        <li>Nu utilizați platforma în scopuri ilegale sau neautorizate</li>
                        <li>Respectați drepturile celorlalți utilizatori</li>
                        <li>Nu încărcați conținut dăunător sau inadecvat</li>
                    </ul>
                </section>

                <section class="terms-section">
                    <h3>5. Confidențialitate și Date Personale</h3>
                    <p>Ne angajăm să protejăm datele dumneavoastră personale conform:</p>
                    <ul>
                        <li>Regulamentului General privind Protecția Datelor (GDPR)</li>
                        <li>Politicii noastre de confidențialitate</li>
                        <li>Legislației în vigoare din România</li>
                    </ul>
                </section>

                <section class="terms-section">
                    <h3>6. Modificări ale Termenilor</h3>
                    <p>Ne rezervăm dreptul de a modifica acești termeni în orice moment. Modificările vor intra în vigoare imediat după publicarea lor pe platformă. Continuarea utilizării platformei după publicarea modificărilor constituie acceptarea acestora.</p>
                </section>

                <section class="terms-section">
                    <h3>7. Contact</h3>
                    <p>Pentru orice întrebări sau clarificări privind acești termeni și condiții, ne puteți contacta la:</p>
                    <ul>
                        <li>Email: contact@adoptii-animale.ro</li>
                        <li>Telefon: (+40) 123 456 789</li>
                        <li>Adresă: Strada Exemplu nr. 123, București, România</li>
                    </ul>
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