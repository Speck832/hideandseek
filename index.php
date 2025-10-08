<?php
// === CONFIGURATION ===
$dataFile = 'data.json';           // Fichier où on stocke les états
$adminPassword = 'secret123';      // 🔒 Mot de passe de réinitialisation

// === CHARGEMENT DES DONNÉES ===
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}
$data = json_decode(file_get_contents($dataFile), true);

// === RÉINITIALISATION ===
if (isset($_POST['reset'])) {
    $password = $_POST['password'] ?? '';
    if ($password === $adminPassword) {
        foreach ($data as $key => $value) {
            $data[$key] = false;
        }
        file_put_contents($dataFile, json_encode($data));
        echo "<h2>✅ Réinitialisation effectuée.</h2><a href='index.php'>Retour</a>";
        exit;
    } else {
        echo "<h2>❌ Mot de passe incorrect.</h2><a href='index.php'>Retour</a>";
        exit;
    }
}

// === SCAN D’UN QR CODE ===
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($data[$id])) {
        if (!$data[$id]) {
            $data[$id] = true;
            file_put_contents($dataFile, json_encode($data));
            echo "<h1>🎉 Bravo ! Le QR-code #$id a été trouvé !</h1>";
        } else {
            echo "<h1>⚠️ Le QR-code #$id a déjà été trouvé.</h1>";
        }
    } else {
        echo "<h1>❌ QR-code inconnu (#$id)</h1>";
    }
    echo "<p><a href='index.php'>Voir le tableau des QR</a></p>";
    exit;
}

// === AFFICHAGE PRINCIPAL ===
echo "<h1>📋 État des QR-codes</h1><ul>";
foreach ($data as $key => $value) {
    echo "<li>QR #$key : " . ($value ? "✅ Trouvé" : "❌ Pas encore") . "</li>";
}
echo "</ul>";

// === FORMULAIRE ADMIN ===
?>
<hr>
<h2>🔐 Réinitialiser les QR-codes</h2>
<form method="POST">
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit" name="reset">Réinitialiser</button>
</form>