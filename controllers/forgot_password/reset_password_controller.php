<?php
header('Content-Type: application/json');
require_once __DIR__ ."/../../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['new_password'])) {
    $conn = Database::connect();
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];

    // $token = "0d0287e8d46c0bd0088ce2d51747b988b0786f70483b8a30baa9b1d326151bcf";
    // $new_password = "87654321";

    $stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($user_id);

    if ($stmt->fetch()) {
        $stmt->close();

        $hashed = md5($new_password); // Hash the new password
        $stmt = $conn->prepare("UPDATE users SET password_ = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['status' => 'success', 'message' => 'Password has been reset.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or expired token.']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
?>