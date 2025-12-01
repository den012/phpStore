<?php
// conectare baza de date
include("Conectare.php");

$error = '';

// daca s-a apasat butonul Submit (UPDATE)
if (isset($_POST['submit'])) {

    // verificam daca id este prezent si numeric (permit si 0)
    if (isset($_POST['id']) && $_POST['id'] !== '' && is_numeric($_POST['id'])) {

        $id      = (int)$_POST['id'];
        $nume    = trim($_POST['nume'] ?? '');
        $code    = trim($_POST['code'] ?? '');
        $imagine = trim($_POST['imagine'] ?? '');
        $price   = trim($_POST['price'] ?? '');

        // validare campuri obligatorii
        if ($nume === '' || $code === '' || $imagine === '' || $price === '') {
            $error = "ERROR: Completati campurile obligatorii!";
        } else {
            try {
                $stmt = $pdo->prepare(
                    "UPDATE tbl_product 
                     SET name = ?, code = ?, image = ?, price = ?
                     WHERE id = ?"
                );
                $stmt->execute([$nume, $code, $imagine, $price, $id]);

                // dupa update ne intoarcem la lista
                header("Location: Vizualizare.php");
                exit;
            } catch (PDOException $e) {
                $error = "ERROR: nu se poate executa update. " . htmlspecialchars($e->getMessage());
            }
        }
    } else {
        $error = "ID incorect!";
    }
}

// preluam inregistrarea pentru afisare in formular
$row = null;
if (isset($_GET['id']) && $_GET['id'] !== '' && is_numeric($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_product WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$row) {
        $error = "Nu s-a gasit inregistrarea ceruta.";
    }
} else {
    if ($error === '') {
        $error = "Lipseste parametrul id din URL.";
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Modificare inregistrare</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <h1>Modificare Inregistrare</h1>

    <?php
    if ($error !== '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    }
    ?>

    <?php if ($row) { ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row->id); ?>" />
            <p>ID: <?php echo htmlspecialchars($row->id); ?></p>

            <strong>Nume: </strong>
            <input type="text" name="nume" value="<?php echo htmlspecialchars($row->name); ?>" /><br />

            <strong>Code: </strong>
            <input type="text" name="code" value="<?php echo htmlspecialchars($row->code); ?>" /><br />

            <strong>Imagine: </strong>
            <input type="text" name="imagine" value="<?php echo htmlspecialchars($row->image); ?>" /><br />

            <strong>Pret: </strong>
            <input type="text" name="price" value="<?php echo htmlspecialchars($row->price); ?>" /><br />

            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="Vizualizare.php">Index</a>
        </form>
    <?php } else { ?>
        <p><a href="Vizualizare.php">Inapoi la lista</a></p>
    <?php } ?>

</body>

</html>