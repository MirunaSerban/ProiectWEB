<?php
session_start();
require_once 'conectare.php';

// Verificăm dacă avem un ID valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mesaj'] = "ID adăpost invalid!";
    $_SESSION['mesaj_tip'] = "error";
    header('Location: ../adaposturi.php');
    exit();
}

try {
    // Preluăm detaliile adăpostului
    $stmt = $conn->prepare("SELECT * FROM adaposturi WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $adapost = $stmt->fetch();

    if (!$adapost) {
        $_SESSION['mesaj'] = "Adăpostul căutat nu a fost găsit.";
        $_SESSION['mesaj_tip'] = "error";
        header('Location: ../adaposturi.php');
        exit();
    }

    // Preluăm animalele din acest adăpost
    $stmt = $conn->prepare("SELECT * FROM animale WHERE adapost_id = ?");
    $stmt->execute([$_GET['id']]);
    $animale = $stmt->fetchAll();
} catch(PDOException $e) {
    error_log("Eroare la preluarea detaliilor adăpost: " . $e->getMessage());
    $_SESSION['mesaj'] = "A apărut o eroare la încărcarea detaliilor. Te rugăm să încerci din nou.";
    $_SESSION['mesaj_tip'] = "error";
    header('Location: ../adaposturi.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($adapost['nume']); ?> - Adopții Animale</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <nav class="main-nav">
            <div class="nav-brand">
                <h1>Adopții Animale</h1>
            </div>
            <div class="nav-links">
                <a href="../index.php">Acasă</a>
                <a href="../adopta.php">Adoptă</a>
                <?php if (isset($_SESSION['logat']) && $_SESSION['logat'] === true): ?>
                    <a href="../panou_utilizator.php">Panou Utilizator</a>
                    <a href="logout.php">Deconectare</a>
                <?php else: ?>
                    <a href="../login.php">Autentificare</a>
                    <a href="../register.php">Înregistrare</a>
                <?php endif; ?>
                <a href="../adaposturi.php" class="active">Adăposturi</a>
                <a href="../contact.php">Contact</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <section class="shelter-details">
                <h2><?php echo htmlspecialchars($adapost['nume']); ?></h2>
                
                <div class="shelter-info-detailed">
                    <div class="info-group">
                        <p><strong>Oraș:</strong> <?php echo htmlspecialchars($adapost['oras']); ?></p>
                        <p><strong>Județ:</strong> <?php echo htmlspecialchars($adapost['judet']); ?></p>
                        <p><strong>Adresă:</strong> <?php echo htmlspecialchars($adapost['adresa']); ?></p>
                        <p><strong>Program:</strong> <?php echo htmlspecialchars($adapost['program']); ?></p>
                    </div>

                    <div class="shelter-animals">
                        <h3>Animale disponibile în acest adăpost</h3>
                        <?php if (empty($animale)): ?>
                            <p>Nu există animale disponibile pentru adopție în acest moment.</p>
                        <?php else: ?>
                            <div class="animals-grid">
                                <?php foreach($animale as $animal): ?>
                                    <div class="animal-card">
                                        <div class="animal-image">
                                            <img src="<?php echo !empty($animal['poza']) ? '../' . htmlspecialchars($animal['poza']) : '../images/default-pet.svg'; ?>" 
                                                 alt="<?php echo htmlspecialchars($animal['nume']); ?>">
                                        </div>
                                        <div class="animal-info">
                                            <h4><?php echo htmlspecialchars($animal['nume']); ?></h4>
                                            <p><strong>Specie:</strong> <?php echo htmlspecialchars($animal['specie']); ?></p>
                                            <p><strong>Tip:</strong> <?php echo htmlspecialchars($animal['tip']); ?></p>
                                            <p><strong>Vârsta:</strong> <?php echo htmlspecialchars($animal['varsta']); ?></p>
                                            <a href="../detalii_animal.php?id=<?php echo $animal['id']; ?>" class="btn-detalii">Vezi Detalii</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
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