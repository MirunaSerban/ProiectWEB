<?php
session_start();
require_once 'php/conectare.php';

try {
    $stmt = $conn->query("SELECT * FROM adaposturi ORDER BY nume");
    $adaposturi = $stmt->fetchAll();
} catch(PDOException $e) {
    error_log("Eroare la preluarea adăposturilor: " . $e->getMessage());
    $_SESSION['mesaj'] = "A apărut o eroare la încărcarea adăposturilor.";
    $_SESSION['mesaj_tip'] = "error";
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adăposturi - Adoptă un Prieten</title>
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

    <main>
        <div class="container">
            <section class="shelters-section">
                <h2>Adăposturi Partenere</h2>
                
                <?php if (isset($_SESSION['mesaj'])): ?>
                    <div class="alert <?php echo $_SESSION['mesaj_tip'] ?? 'info'; ?>">
                        <?php 
                        echo $_SESSION['mesaj'];
                        unset($_SESSION['mesaj']);
                        unset($_SESSION['mesaj_tip']);
                        ?>
                    </div>
                <?php endif; ?>

                <div class="shelters-grid">
                    <?php if (empty($adaposturi)): ?>
                        <p class="no-shelters">Nu există adăposturi înregistrate momentan.</p>
                    <?php else: ?>
                        <?php foreach($adaposturi as $adapost): ?>
                            <div class="shelter-card">
                                <h3><?php echo htmlspecialchars($adapost['nume']); ?></h3>
                                <div class="shelter-info">
                                    <p><strong>Oraș:</strong> <?php echo htmlspecialchars($adapost['oras']); ?></p>
                                    <p><strong>Județ:</strong> <?php echo htmlspecialchars($adapost['judet']); ?></p>
                                    <a href="php/detalii_adapost.php?id=<?php echo $adapost['id']; ?>" 
                                       class="btn-detalii">Vezi Detalii</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
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