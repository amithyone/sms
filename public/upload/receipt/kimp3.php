<?php
// Simple PHP File Manager

$password = "yourpassword"; // Change this!

session_start();
if (!isset($_SESSION['auth'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['pass'] === $password) {
        $_SESSION['auth'] = true;
    } else {
        echo '<form method="POST"><input type="password" name="pass"><input type="submit" value="Login"></form>';
        exit;
    }
}

$dir = isset($_GET['dir']) ? realpath($_GET['dir']) : __DIR__;
$files = scandir($dir);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadPath = $dir . DIRECTORY_SEPARATOR . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath);
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $fileToDelete = realpath($_GET['delete']);
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete);
    }
    header("Location: ?dir=" . urlencode($dir));
    exit;
}

// Handle file download
if (isset($_GET['download'])) {
    $file = realpath($_GET['download']);
    if (file_exists($file) && is_file($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

// Display directory contents
echo "<h3>Directory: $dir</h3>";
echo "<a href='?dir=" . urlencode(dirname($dir)) . "'>[Up]</a><br><br>";

// Upload form
echo "<form method='POST' enctype='multipart/form-data'>";
echo "<input type='file' name='file'>";
echo "<input type='submit' value='Upload'>";
echo "</form><br>";

echo "<ul>";
foreach ($files as $file) {
    if ($file === ".") continue;
    $path = $dir . DIRECTORY_SEPARATOR . $file;
    if (is_dir($path)) {
        echo "<li>[DIR] <a href='?dir=" . urlencode($path) . "'>$file</a></li>";
    } else {
        echo "<li><a href='?download=" . urlencode($path) . "'>$file</a> 
              | <a href='?delete=" . urlencode($path) . "' onclick='return confirm(\"Delete $file?\");'>[X]</a></li>";
    }
}
echo "</ul>";
?>
