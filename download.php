<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = 'uploads/' . $file;

    if (file_exists($filepath)) {
        // Set headers
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $file);
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Read the file and output it
        readfile($filepath);
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid request.';
}
?>
