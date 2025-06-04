<?php
session_start();

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    $_SESSION['erori'] = ['Trebuie să fii autentificat pentru a accesa această pagină!'];
    header('Location: login.php');
    exit();
}

require_once 'php/conectare.php';

// Preluăm informațiile utilizatorului
$user_id = $_SESSION['utilizator_id'];
$user = null;
$cereri_adoptie = array();

try {
    // Preluăm detaliile utilizatorului
    $stmt = $conn->prepare("SELECT * FROM utilizatori WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Eroare: Utilizatorul nu a fost găsit.");
    }

    // Preluăm cererile de adopție ale utilizatorului
    $stmt = $conn->prepare("
        SELECT ca.*, a.nume as nume_animal, a.specie, a.tip
        FROM cereri_adoptie ca
        JOIN animale a ON ca.animal_id = a.id
        WHERE ca.utilizator_id = ?
        ORDER BY ca.data_cerere DESC
    ");
    $stmt->execute([$user_id]);
    $cereri_adoptie = $stmt->fetchAll();
} catch(PDOException $e) {
    die("A apărut o eroare la încărcarea datelor.");
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panou Utilizator - Adopții Animale</title>
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
                <a href="panou_utilizator.php" class="active">Panou Utilizator</a>
                <a href="php/logout.php">Deconectare</a>
                <a href="contact.php">Contact</a>
            </div>
            <div class="user-welcome">
                <p>Bun venit, <strong><?php echo htmlspecialchars($_SESSION['utilizator_nume']); ?></strong></p>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <section class="user-dashboard">
                <h2>Panou de Control</h2>

                <div class="dashboard-grid">
                    <div class="dashboard-section">
                        <h3>Informații Personale</h3>
                        <div class="user-info">
                            <p><strong>Nume:</strong> <?php echo htmlspecialchars($user['nume']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>

                    <div class="dashboard-section">
                        <h3>Cererile Mele de Adopție</h3>
                        <?php if (empty($cereri_adoptie)): ?>
                            <p>Nu ai făcut încă nicio cerere de adopție.</p>
                            <a href="adopta.php" class="btn-primary">Vezi Animale Disponibile</a>
                        <?php else: ?>
                            <div class="adoptions-list">
                                <?php foreach ($cereri_adoptie as $cerere): ?>
                                    <div class="adoption-request">
                                        <h4><?php echo htmlspecialchars($cerere['nume_animal']); ?></h4>
                                        <p><strong>Specie:</strong> <?php echo htmlspecialchars($cerere['specie']); ?></p>
                                        <p><strong>Tip:</strong> <?php echo htmlspecialchars($cerere['tip']); ?></p>
                                        <p><strong>Status cerere:</strong> 
                                            <span class="status-<?php echo htmlspecialchars($cerere['status']); ?>">
                                                <?php echo htmlspecialchars($cerere['status']); ?>
                                            </span>
                                        </p>
                                        <p><strong>Data cererii:</strong> 
                                            <?php echo date('d.m.Y H:i', strtotime($cerere['data_cerere'])); ?>
                                        </p>
                                        <?php if ($cerere['status'] === 'in_asteptare'): ?>
                                            <form action="php/anuleaza_cerere.php" method="POST" class="inline-form">
                                                <input type="hidden" name="cerere_id" value="<?php echo $cerere['id']; ?>">
                                                <button type="submit" class="btn-cancel">Anulează Cererea</button>
                                            </form>
                                        <?php endif; ?>
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