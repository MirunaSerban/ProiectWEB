<?php
session_start();

// Distrugem toate datele sesiunii
$_SESSION = array();

// Distrugem cookie-ul sesiunii dacă există
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Distrugem sesiunea
session_destroy();

// Redirecționăm către pagina principală
header('Location: ../index.php');
exit();
?>
