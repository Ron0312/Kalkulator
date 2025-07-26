<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"] ?? "");
    $phone = htmlspecialchars($_POST["phone"] ?? "");
    $email = htmlspecialchars($_POST["email"] ?? "");
    $website = $_POST["website"] ?? "";
    $privacy = $_POST["privacy"] ?? "";

    if (!empty($website)) {
        http_response_code(400);
        echo "Spam erkannt.";
        exit;
    }

    if (empty($name) || empty($phone) || !$privacy) {
        http_response_code(400);
        echo "Pflichtfelder fehlen.";
        exit;
    }

    $to = "info@gasmoeller.de";
    $subject = "Neue Anfrage über den Preisrechner";
    $message = "Name: $name\nTelefon: $phone\nE-Mail: $email";
    $headers = "From: webmaster@gasmoeller.de\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "Vielen Dank! Wir melden uns schnellstmöglich.";
    } else {
        http_response_code(500);
        echo "Es gab ein Problem beim Versenden.";
    }
}
?>