<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "diak_adatok";

// Kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolat sikertelen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oktatasi_azonosito = $_POST['oktatasi_azonosito'];
    $diak_neve = $_POST['diak_neve'];
    $szulo_neve = $_POST['szulo_neve'];
    $szulo_telefonszama = $_POST['szulo_telefonszama'];
    $kepzes_tipus = $_POST['kepzes_tipus'];
    $datum = $_POST['datum'];

    // Ellenőrzés, hogy minden mező ki van-e töltve
    if (empty($oktatasi_azonosito) || empty($diak_neve) || empty($szulo_neve) || empty($szulo_telefonszama) || empty($kepzes_tipus) || empty($datum)) {
        echo "Kérjük, töltse ki az összes mezőt.";
    } else {
        $stmt = $conn->prepare("INSERT INTO diak (oktatasi_azonosito, diak_neve, szulo_neve, szulo_telefonszama, kepzes_tipus, datum) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $oktatasi_azonosito, $diak_neve, $szulo_neve, $szulo_telefonszama, $kepzes_tipus, $datum);

        if ($stmt->execute()) {
            // Új rekord sikeresen hozzáadva, visszairányítás a főoldalra
            $stmt->close();
            $conn->close();
            header("Location: index.html");
            exit();
        } else {
            echo "Hiba: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
