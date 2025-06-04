<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despre Adopție - Adoptă un Prieten</title>
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
        <div class="adoption-process">
            <h2>Procesul de Adopție</h2>
            <p class="adoption-intro">
                Schimbarea căminului unui animal este o ocazie minunată de a întâmpina un nou membru al familiei și, 
                în același timp, de a oferi unui animal o nouă șansă la o viață liniștită.
            </p>

            <div class="process-grid">
                <div class="process-card">
                    <h3>Lucruri de luat în considerare</h3>
                    <ul>
                        <li>Evaluează dimensiunea locuinței tale – ai loc pentru un animal?</li>
                        <li>Asigură-te că ai timp pentru nevoile comportamentale, sociale și fizice ale animalului</li>
                        <li>Gândește-te la costurile de îngrijire (tratamente veterinare, hrană, cosmetice)</li>
                        <li>Verifică dacă toți membrii familiei sunt de acord cu adopția</li>
                        <li>Asigură-te că poți oferi un mediu stabil și îngrijire pe termen lung</li>
                    </ul>
                </div>

                <div class="process-card">
                    <h3>Procesul de adopție</h3>
                    <ul>
                        <li>Vizitează adăpostul și discută cu personalul despre animalul potrivit pentru tine</li>
                        <li>Petrece timp cu animalul pentru a vă cunoaște reciproc</li>
                        <li>Completează formularele necesare și oferă informații despre mediul în care va locui animalul</li>
                        <li>Pregătește-ți casa pentru noul membru al familiei</li>
                        <li>Programează o vizită la veterinar pentru un control complet</li>
                    </ul>
                </div>

                <div class="process-card">
                    <h3>Beneficiile adopției</h3>
                    <ul>
                        <li>Oferi o șansă la viață unui animal care are nevoie de ajutor</li>
                        <li>Animalele adoptate sunt deseori deja vaccinate și sterilizate</li>
                        <li>Primești sprijin și sfaturi din partea adăpostului</li>
                        <li>Personalitatea animalului este deja formată (în cazul adulților)</li>
                        <li>Satisfacția de a oferi un cămin unui animal care are nevoie</li>
                    </ul>
                </div>
            </div>

            <div class="adoption-benefits">
                <h3>Regula 3-3-3 în Adopție</h3>
                <div class="benefits-grid">
                    <div class="benefit-item">
                        <h4>Primele 3 ZILE</h4>
                        <p>Animalul se va simți copleșit și stresat în noul mediu. Poate refuza să mănânce sau să se ascundă. 
                           Oferă-i spațiu și timp să se acomodeze în ritmul său.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Primele 3 SĂPTĂMÂNI</h4>
                        <p>Animalul începe să se simtă mai confortabil, își arată personalitatea și începe să înțeleagă rutina casei. 
                           Este momentul perfect pentru a începe stabilirea regulilor de bază.</p>
                    </div>
                    <div class="benefit-item">
                        <h4>Primele 3 LUNI</h4>
                        <p>Animalul se simte acasă, are încredere în familia sa și și-a stabilit rutina. 
                           Personalitatea sa este complet dezvoltată și se simte în siguranță în noul cămin.</p>
                    </div>
                </div>
            </div>

            <div class="adoption-note">
                <p><strong>Important:</strong> Adopția unui animal este o decizie pe termen lung care necesită dedicare, 
                răbdare și dragoste. Asigură-te că ești pregătit pentru această responsabilitate înainte de a face acest pas important.</p>
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