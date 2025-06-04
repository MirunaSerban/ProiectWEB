<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare - Adopții Animale</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="main-nav">
            <div class="nav-brand">
                <h1>Adopții Animale</h1>
            </div>
            <div class="nav-links">
                <a href="index.php">Acasă</a>
                <a href="adopta.php">Adoptă</a>
                <a href="login.php">Autentificare</a>
                <a href="contact.php">Contact</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h2>Înregistrare</h2>
            
            <?php if (isset($_SESSION['erori'])): ?>
                <div class="erori">
                    <?php 
                    foreach($_SESSION['erori'] as $eroare) {
                        echo "<p>$eroare</p>";
                    }
                    unset($_SESSION['erori']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['succes'])): ?>
                <div class="success-message">
                    <?php 
                    echo $_SESSION['succes'];
                    unset($_SESSION['succes']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="php/register.php" method="POST">
                <div class="form-group">
                    <label for="nume">Nume complet:</label>
                    <input type="text" id="nume" name="nume" value="<?php echo isset($_SESSION['date_formular']['nume']) ? htmlspecialchars($_SESSION['date_formular']['nume']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['date_formular']['email']) ? htmlspecialchars($_SESSION['date_formular']['email']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="parola">Parolă:</label>
                    <input type="password" id="parola" name="parola" required>
                </div>

                <div class="form-group">
                    <label for="confirma_parola">Confirmă parola:</label>
                    <input type="password" id="confirma_parola" name="confirma_parola" required>
                </div>

                <button type="submit">Înregistrare</button>
            </form>

            <p class="form-footer">
                Ai deja cont? <a href="login.php">Autentifică-te aici</a>
            </p>
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
<?php
// Curățăm datele formularului după ce le-am folosit
unset($_SESSION['date_formular']);
?> 