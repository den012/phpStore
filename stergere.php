<?php
// conectare la baza de date database
include("Conectare.php");
// se verifica daca id a fost primit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    if ($stmt = $pdo->prepare("DELETE FROM tbl_product WHERE id = ? LIMIT 1")) {
        $stmt->bindParam(1, $id);
        $stmt->execute();
    } else {
        echo "ERROR: Nu se poate executa delete.";
    }
    echo "Inregistrarea a fost stearsa!!!!";
}
echo "<p><a href=\"Vizualizare.php\">Index</a></p>";
