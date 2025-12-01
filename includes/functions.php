<?php
/**
 * Helper Functions - Gitar Surabaya
 * Fungsi-fungsi reusable untuk seluruh aplikasi
 */

/**
 * Sanitize user input
 * @param string $data Input data
 * @return string Sanitized data
 */
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return mysqli_real_escape_string($conn, $data);
}

/**
 * Upload image dengan validation
 * @param array $file $_FILES array
 * @param string $directory Target directory (tanpa trailing slash)
 * @return array ['success' => bool, 'filename' => string, 'error' => string]
 */
function upload_image($file, $directory = 'images/products') {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    // Check if file exists
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ['success' => false, 'error' => 'No file uploaded'];
    }
    
    // Check file size
    if ($file['size'] > $max_size) {
        return ['success' => false, 'error' => 'File terlalu besar (max 5MB)'];
    }
    
    // Check MIME type
    $file_type = mime_content_type($file['tmp_name']);
    if (!in_array($file_type, $allowed_types)) {
        return ['success' => false, 'error' => 'Format file tidak valid'];
    }
    
    // Create directory if not exists
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    
    // Generate unique filename
    $filename = date('dmYHis') . basename($file['name']);
    $filepath = $directory . '/' . $filename;
    
    // Move file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['success' => false, 'error' => 'Gagal upload file'];
}

/**
 * Delete image file
 * @param string $filename Filename
 * @param string $directory Directory
 * @return bool Success status
 */
function delete_image($filename, $directory = 'images/products') {
    $filepath = $directory . '/' . $filename;
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}

/**
 * Log aktivitas admin
 * @param mysqli $conn Database connection
 * @param string $message Log message
 * @return bool Success status
 */
function log_activity($conn, $message) {
    $message = sanitize_input($message);
    $stmt = mysqli_prepare($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES (?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $message);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
    return false;
}

/**
 * Set notification session
 * @param string $type 'success' or 'error'
 * @param string $message Notification message
 */
function set_notification($type, $message) {
    $_SESSION['notif_type'] = $type;
    $_SESSION['notif_msg'] = $message;
}

/**
 * Clear notification session
 */
function clear_notification() {
    unset($_SESSION['notif_type']);
    unset($_SESSION['notif_msg']);
}

/**
 * Redirect dengan delay
 * @param string $url Target URL
 * @param int $delay Delay in seconds (default 0)
 */
function redirect($url, $delay = 0) {
    if ($delay > 0) {
        header("Refresh: $delay; URL=$url");
    } else {
        header("Location: $url");
    }
    exit;
}

/**
 * Check if user is logged in
 * @return bool Login status
 */
function is_logged_in() {
    return isset($_SESSION['status_login']) && $_SESSION['status_login'] === true;
}

/**
 * Require login (redirect if not logged in)
 * @param string $redirect_url URL to redirect if not logged in
 */
function require_login($redirect_url = 'login.php') {
    if (!is_logged_in()) {
        redirect($redirect_url);
    }
}

/**
 * Format rupiah
 * @param float $number Number to format
 * @return string Formatted rupiah string
 */
function format_rupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

/**
 * Clean price input (remove non-numeric characters)
 * @param string $price Price string
 * @return int Clean price
 */
function clean_price($price) {
    return (int) preg_replace('/[^0-9]/', '', $price);
}

/**
 * Generate CSRF token
 * @return string CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token Token to verify
 * @return bool Validation result
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
