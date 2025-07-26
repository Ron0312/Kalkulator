<?php
// Sicherer E-Mail-Versand aus WordPress per AJAX

add_action('wp_ajax_send_calculator_email', 'handle_calculator_form');
add_action('wp_ajax_nopriv_send_calculator_email', 'handle_calculator_form');

function handle_calculator_form() {
    if (!empty($_POST['website'])) {
        wp_send_json_error(['message' => 'Spam erkannt (Honeypot).']);
        return;
    }

    $name  = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $menge = sanitize_text_field($_POST['menge'] ?? '');

    if (empty($name) || empty($phone)) {
        wp_send_json_error(['message' => 'Pflichtfelder fehlen.']);
        return;
    }

    $to = 'vertrieb@gasmoeller.de';
    $subject = 'Neue Anfrage über den Preisrechner';
    $message = "Name: $name\nTelefon: $phone\nE-Mail: $email\nMenge: $menge\n\n---\n";
    foreach ($_POST as $key => $val) {
        if (!in_array($key, ['action', 'website'])) {
            $message .= "$key: " . sanitize_text_field($val) . "\n";
        }
    }

    $headers = ['Content-Type: text/plain; charset=UTF-8'];
    $sent = wp_mail($to, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Nachricht erfolgreich versendet.']);
    } else {
        wp_send_json_error(['message' => 'Versand fehlgeschlagen.']);
    }
}
