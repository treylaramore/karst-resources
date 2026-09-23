<?php
declare(strict_types=1);

$to = "inquiries@karstresources.com";
$from = "inquiries@karstresources.com";

function fail(string $msg): void {
    http_response_code(400);
    echo "<!DOCTYPE html><html lang=\"en\"><meta charset=\"utf-8\"><title>Karst Resources</title><p>"
        . htmlspecialchars($msg, ENT_QUOTES, "UTF-8")
        . " <a href=\"start.html#contact\">Back</a></p></html>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: start.html#contact");
    exit;
}

if (trim((string)($_POST["website"] ?? "")) !== "") {
    header("Location: start.html?sent=1#contact");
    exit;
}

$name = trim((string)($_POST["name"] ?? ""));
$email = trim((string)($_POST["email"] ?? ""));
$company = trim((string)($_POST["company"] ?? ""));
$sector = trim((string)($_POST["sector"] ?? ""));
$message = trim((string)($_POST["message"] ?? ""));

if ($name === "" || $company === "" || $message === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail("Name, a real email, the company, and a short note are required.");
}

if (strlen($name) > 120 || strlen($email) > 160 || strlen($company) > 160 || strlen($sector) > 80 || strlen($message) > 2000) {
    fail("That note is too long.");
}

$sector = str_replace(["\r", "\n"], " ", $sector);
$body = "Name: {$name}\nEmail: {$email}\nCompany: {$company}\nSector: {$sector}\n\n{$message}\n";
$subject = "Karst audit inquiry — " . str_replace(["\r", "\n"], " ", $company);
$headers = "From: {$from}\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";

if (!mail($to, $subject, $body, $headers)) {
    fail("The message did not send. Email inquiries@karstresources.com directly.");
}

header("Location: start.html?sent=1#contact");
exit;
