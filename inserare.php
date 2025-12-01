<?php
include("Conectare.php");
$error = '';

if (isset($_POST['submit'])) {
    // preluam datele din formular (doar coloanele care exista in DB)
    $nume    = trim($_POST['nume'] ?? '');
    $code    = trim($_POST['code'] ?? '');
    $imagine = trim($_POST['imagine'] ?? '');
    $price   = trim($_POST['price'] ?? '');

    // verificam daca sunt completate
    if ($nume === '' || $code === '' || $imagine === '' || $price === '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO tbl_product (name, code, image, price) 
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$nume, $code, $imagine, $price]);

            // optional: dupa inserare mergem la lista
            header("Location: Vizualizare.php");
            exit;
        } catch (PDOException $e) {
            echo "ERROR: Nu se poate executa insert. " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Inserare inregistrare</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <h1>Inserare inregistrare</h1>

    <?php
    if ($error !== '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>{$error}</div>";
    }
    ?>

    <form action="" method="post">
        <div>
            <strong>Nume: </strong>
            <input type="text" name="nume" value="" /><br />

            <strong>Code: </strong>
            <input type="text" name="code" value="" /><br />

            <strong>Imagine: </strong>
            <input type="text" name="imagine" value="" /><br />

            <strong>Pret: </strong>
            <input type="text" name="price" value="" /><br />

            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="Vizualizare.php">Index</a>
        </div>
    </form>
</body>

</html>