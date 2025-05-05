<?php
header('Content-Type: application/json');
require_once __DIR__ ."/../../config.php";
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Manila');
$conn = Database::connect();

function sendResetEmail($to, $resetLink) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = "your_email@gmail.com";         // 🔐 your email
        $mail->Password   = 'abcdefghijklmnop';            // 🔐 Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('your_email@gmail.com', 'Sentimo');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body    = "Click to reset: <a href='$resetLink'>$resetLink</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Only POST allowed']);
    exit;
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($user_id);

if ($stmt->fetch()) {
    $stmt->close();

    // Check if token already sent
    $stmt = $conn->prepare("SELECT token FROM password_resets WHERE user_id = ? AND expires_at > NOW()");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($existing_token);

    if ($stmt->fetch()) {
        $stmt->close();
        $resetLink = "http://localhost/project-sentiment-analysis/reset_password.php?token=$existing_token";
        sendResetEmail($email, $resetLink);
        echo json_encode(['status' => 'info', 'message' => 'Reset link already sent. Check your email.']);
        exit;
    }
    $stmt->close();

    // Generate and save new token
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
    $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $token, $expires);
    $stmt->execute();
    $stmt->close();

    $resetLink = "http://localhost/project-sentiment-analysis/reset_password.php?token=$token";
    if (!sendResetEmail($email, $resetLink)) {
        // $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        // $stmt->bind_param("s", $token);
        // $stmt->execute();
        // $stmt->close();

        echo json_encode(['status' => 'error', 'message' => 'Email could not be sent.']);
        exit;
    }
}

echo json_encode(['status' => 'success', 'message' => 'If your email exists, a reset link has been sent.']);
?>