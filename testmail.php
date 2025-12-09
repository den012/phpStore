<?php
    $to = "dd2341093@gmail.com";
    $subject = "Confirmare comanda - Plata a fost procesata cu succes";

    $from = "denisdenis668@yahoo.com";

    // Headers
    $headers  = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "
    <html>
    <body>
        <h1>Multumim pentru comanda!</h1>
        <p>Plata dumneavoastra a fost procesata cu succes.</p>
        <p>Acesta este un email de confirmare. Veti primi detaliile comenzii in curand.</p>
    </body>
    </html>";

    // Trimite email-ul
    $sent = mail($to, $subject, $body, $headers);

    if($sent) {
        echo "email trimis!";
    } else {
        echo "eroare la trimitere";
    }

?>