<?php
session_start();

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    $_SESSION['erori'] = ['Trebuie să fii autentificat pentru a accesa această pagină!'];
    header('Location: login.php');
    exit();
}

// Verificăm dacă avem un ID valid
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mesaj'] = "ID animal invalid!";
    $_SESSION['mesaj_tip'] = "error";
    header('Location: adopta.php');
    exit();
}

require_once 'php/conectare.php';

try {
    // Preluăm detaliile animalului
    $stmt = $conn->prepare("
        SELECT a.*, ad.nume as adapost_nume 
        FROM animale a 
        LEFT JOIN adaposturi ad ON a.adapost_id = ad.id 
        WHERE a.id = ?
    ");
    $stmt->execute([$_GET['id']]);
    $animal = $stmt->fetch();

    if (!$animal) {
        $_SESSION['mesaj'] = "Animalul căutat nu a fost găsit.";
        $_SESSION['mesaj_tip'] = "error";
        header('Location: adopta.php');
        exit();
    }

    // Verificăm dacă animalul are deja o cerere de adopție aprobată
    $stmt = $conn->prepare("
        SELECT * FROM cereri_adoptie 
        WHERE animal_id = ? AND status = 'aprobat'
    ");
    $stmt->execute([$_GET['id']]);
    $cerere_aprobata = $stmt->fetch();

    // Verificăm dacă utilizatorul curent are deja o cerere pentru acest animal
    $stmt = $conn->prepare("
        SELECT * FROM cereri_adoptie 
        WHERE animal_id = ? AND utilizator_id = ?
    ");
    $stmt->execute([$_GET['id'], $_SESSION['utilizator_id']]);
    $cerere_existenta = $stmt->fetch();
} catch(PDOException $e) {
    error_log("Eroare la preluarea detaliilor animal: " . $e->getMessage());
    $_SESSION['mesaj'] = "A apărut o eroare la încărcarea detaliilor. Te rugăm să încerci din nou.";
    $_SESSION['mesaj_tip'] = "error";
    header('Location: adopta.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($animal['nume']); ?> - Adopții Animale</title>
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
                <a href="panou_utilizator.php">Panou Utilizator</a>
                <a href="php/logout.php">Deconectare</a>
                <a href="contact.php">Contact</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <section class="animal-details">
                <h2><?php echo htmlspecialchars($animal['nume']); ?></h2>
                
                <?php if (isset($_SESSION['mesaj'])): ?>
                    <div class="alert <?php echo $_SESSION['mesaj_tip'] ?? 'success'; ?>">
                        <?php 
                        echo $_SESSION['mesaj'];
                        unset($_SESSION['mesaj']);
                        unset($_SESSION['mesaj_tip']);
                        ?>
                    </div>
                <?php endif; ?>

                <div class="animal-details-grid">
                    <div class="animal-image-large">
                        <img src="<?php echo !empty($animal['poza']) ? htmlspecialchars($animal['poza']) : 'images/default-pet.jpg'; ?>" 
                             alt="<?php echo htmlspecialchars($animal['nume']); ?>">
                    </div>

                    <div class="animal-info-detailed">
                        <div class="info-group">
                            <p><strong>Specie:</strong> <?php echo htmlspecialchars($animal['specie']); ?></p>
                            <p><strong>Tip:</strong> <?php echo htmlspecialchars($animal['tip']); ?></p>
                            <p><strong>Vârsta:</strong> <?php echo htmlspecialchars($animal['varsta']); ?></p>
                            <?php if (!empty($animal['adapost_nume'])): ?>
                                <p><strong>Adăpost:</strong> <?php echo htmlspecialchars($animal['adapost_nume']); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="animal-description">
                            <h3>Descriere</h3>
                            <p><?php echo nl2br(htmlspecialchars($animal['descriere'])); ?></p>
                        </div>

                        <?php if ($cerere_aprobata): ?>
                            <div class="alert warning">
                                <p>Acest animal a fost deja adoptat.</p>
                            </div>
                        <?php elseif ($cerere_existenta): ?>
                            <div class="alert info">
                                <p>Ai depus deja o cerere de adopție pentru acest animal.</p>
                                <p>Status cerere: <strong><?php echo htmlspecialchars($cerere_existenta['status']); ?></strong></p>
                            </div>
                        <?php else: ?>
                            <div class="adoption-form-container">
                                <h3>Formular de adopție</h3>
                                <form action="php/proceseaza_cerere.php" method="POST" class="adoption-form">
                                    <input type="hidden" name="animal_id" value="<?php echo $animal['id']; ?>">
                                    <div class="form-group">
                                        <label for="mesaj">Mesajul tău pentru adăpost:</label>
                                        <textarea id="mesaj" name="mesaj" rows="4" required 
                                            placeholder="Spune-ne de ce dorești să adopți acest animal și ce condiții îi poți oferi..."></textarea>
                                    </div>
                                    <button type="submit" class="btn-submit">Trimite cererea de adopție</button>
                                </form>
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