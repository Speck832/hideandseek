<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chasse à l'Homme</title>
    <link rel="icon" href="http://liam.sarinoty.com/html/20250928_114532.png" type="image/x-icon" sizes="16x16">
    <link rel="stylesheet" href="./hideandseek.css">
    <link rel="stylesheet" href="./mediaqueries.css">
</head>
<body bgcolor="#28252b">
    <header>
        <section class="flexbox">
                    <img src="http://liam.sarinoty.com/html/20250928_114532.png" alt="logo" height="100" width="100">
        </section>
        <section class="flexbox">
            <h1 class="titreheader" align="center">Chasse à l'Homme -  par Spectral</h1>
        </section>
        <section  class="flexbox">
            <h4 class="titreheader" align="center">4ème édition - 2025</h4>
        </section>
    </header>
    <nav class="ctr" id="nav" align="center">
        <a class="titrenav" href="./carte.html">Cartes</a>
        |
        <a class="titrenav" href="./Règlement.html">Règlement</a>
        |
        <a class="titrenav" href="./bonus.html">Bonus</a>
    </nav>
    <section class="flex">
        <p class="txt">Cache-cache géant organisé dans Mouriès</p>
        <img id="image" src="./Mouriès-2-PV.jpg" alt="Photo de Mouriès">
    </section>
    <section>
        <?php
// === CONFIGURATION ===
$dataFile = 'data.json';
$password = 'Guinness7';

// === NOMS DES QR-CODES ===
$qrNames = [
    "1" => "Gilet jaune (chasseur)",
    "2" => "Géolocalisation précise (chasseur)",
    "3" => "Freeze 1 (chassé)",
    "4" => "Freeze 2 (chassé)",
    "5" => "Campement pendant 10 minutes (chassé)"
];

// === CHARGER LES DONNÉES ===
if (!file_exists($dataFile)) {
    $init = [];
    foreach ($qrNames as $id => $name) {
        $init[$id] = false;
    }
    file_put_contents($dataFile, json_encode($init));
}
$data = json_decode(file_get_contents($dataFile), true);

// === MARQUER UN QR TROUVÉ ===
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($data[$id])) {
        $data[$id] = true;
        file_put_contents($dataFile, json_encode($data));
        echo "<div class='qr-message success'>🎉 <strong>{$qrNames[$id]}</strong> trouvé !</div>";
    } else {
        echo "<div class='qr-message error'>❌ QR-code inconnu (#$id)</div>";
    }
}

// === RÉINITIALISATION ===
if (isset($_POST['reset'])) {
    if ($_POST['password'] === $password) {
        foreach ($data as $key => $val) $data[$key] = false;
        file_put_contents($dataFile, json_encode($data));
        echo "<div class='qr-message success'>✅ Réinitialisation effectuée !</div>";
    } else {
        echo "<div class='qr-message error'>❌ Mot de passe incorrect.</div>";
    }
}

// === AFFICHAGE DE L'ÉTAT GÉNÉRAL ===
echo "<div class='qr-list'>";
foreach ($data as $key => $found) {
    $name = $qrNames[$key];
    $status = $found ? "✅ Trouvé" : "❌ Non trouvé";
    $class = $found ? "found" : "not-found";
    echo "<div class='qr-item $class'><strong>$name</strong><br>$status</div>";
}
echo "</div>";

// === FORMULAIRE DE RÉINITIALISATION ===
echo "
<form class='qr-reset' method='POST'>
    <input type='password' name='password' placeholder='Mot de passe'>
    <button type='submit' name='reset'>🔁 Réinitialiser</button>
</form>
";
?>
    </section>
    <footer id="footer">
        <p class="txt">Crédits :</p>
        <ul class="txt">
        <li>Estéban</li>
        <li><a id="evan" href="https://www.youtube.com/@EvaixZ">Evan</a></li>
        <li>Logan</li>
        <li>Maxime</li>
        <li>Liam</li>
        </ul>
    </footer>
    <footer id="foote">
        © - 
        <a id="lien" href="https://www.youtube.com/@Spectral2212">Spectral</a>
    </footer>
</body>
</html>
