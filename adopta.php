<?php
session_start();

// Verificăm dacă utilizatorul este autentificat
if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    $_SESSION['erori'] = ['Trebuie să fii autentificat pentru a accesa această pagină!'];
    header('Location: login.php');
    exit();
}

require_once 'php/conectare.php';

// Preluăm filtrele
$tip = isset($_GET['tip']) ? $_GET['tip'] : '';
$specie = isset($_GET['specie']) ? $_GET['specie'] : '';

?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoptă un Animal</title>
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
        <section class="adoptions-section">
            <div class="container">
                <h2>Animale disponibile pentru adopție</h2>
                <div class="filters">
                    <form method="GET" action="" class="filter-form">
                        <select name="tip" id="tip" onchange="this.form.submit()">
                            <option value="">Toate tipurile</option>
                            <option value="caine" <?php echo $tip === 'caine' ? 'selected' : ''; ?>>Câini</option>
                            <option value="pisica" <?php echo $tip === 'pisica' ? 'selected' : ''; ?>>Pisici</option>
                            <option value="altele" <?php echo $tip === 'altele' ? 'selected' : ''; ?>>Alte animale</option>
                        </select>
                        <select name="specie" id="specie" onchange="this.form.submit()">
                            <option value="">Toate speciile</option>
                            <?php
                            $stmt = $conn->query("SELECT DISTINCT specie FROM animale ORDER BY specie");
                            while ($row = $stmt->fetch()) {
                                $selected = ($specie === $row['specie']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['specie']) . '" ' . $selected . '>' . 
                                     htmlspecialchars($row['specie']) . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                </div>
                
                <div class="animals-grid">
                    <?php
                    try {
                        // Construim query-ul în funcție de filtre
                        $sql = "SELECT a.*, ad.nume as adapost_nume 
                               FROM animale a
                               LEFT JOIN adaposturi ad ON a.adapost_id = ad.id";
                        $params = array();
                        $where = array();

                        // Adăugăm condițiile pentru filtre
                        if (!empty($tip)) {
                            $where[] = "a.tip = ?";
                            $params[] = $tip;
                        }
                        if (!empty($specie)) {
                            $where[] = "a.specie = ?";
                            $params[] = $specie;
                        }

                        // Adăugăm WHERE dacă avem condiții
                        if (!empty($where)) {
                            $sql .= " WHERE " . implode(" AND ", $where);
                        }

                        $sql .= " ORDER BY a.id DESC";
                        
                        $stmt = $conn->prepare($sql);
                        $stmt->execute($params);
                        $animale = $stmt->fetchAll();
                        
                        if (empty($animale)) {
                            echo '<p class="no-animals">Nu există animale disponibile pentru adopție în acest moment.</p>';
                        } else {
                            foreach($animale as $animal) {
                                echo '<div class="animal-card">';
                                echo '<div class="animal-image">';
                                $imagine = !empty($animal['poza']) ? $animal['poza'] : 'images/default-pet.jpg';
                                echo '<img src="' . htmlspecialchars($imagine) . '" alt="' . htmlspecialchars($animal['nume']) . '">';
                                echo '</div>';
                                echo '<div class="animal-info">';
                                echo '<h3>' . htmlspecialchars($animal['nume']) . '</h3>';
                                echo '<p><strong>Specie:</strong> ' . htmlspecialchars($animal['specie']) . '</p>';
                                echo '<p><strong>Tip:</strong> ' . htmlspecialchars($animal['tip']) . '</p>';
                                echo '<p><strong>Vârsta:</strong> ' . htmlspecialchars($animal['varsta']) . '</p>';
                                if (!empty($animal['adapost_nume'])) {
                                    echo '<p><strong>Adăpost:</strong> ' . htmlspecialchars($animal['adapost_nume']) . '</p>';
                                }
                                echo '<p class="animal-description">' . htmlspecialchars(substr($animal['descriere'], 0, 100)) . '...</p>';
                                echo '<a href="detalii_animal.php?id=' . $animal['id'] . '" class="btn-detalii">Vezi Detalii</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    } catch(PDOException $e) {
                        error_log("Eroare la încărcarea animalelor: " . $e->getMessage());
                        echo '<p class="error">Ne pare rău, a apărut o eroare la încărcarea animalelor. Vă rugăm să încercați din nou.</p>';
                    }
                    ?>
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
