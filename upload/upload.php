<?php
// upload.php

$uploadDir = '../../uploadPrivate/';
$maxTotalSize = 300 * 1024 * 1024; // 300MB in bytes

// Define allowed file types (you can expand this list if needed)
$allowed_types = ['mp3'];

// Function to show messages
function showMessage($message, $type = 'info') {
    echo "<div style='
        font-family: Arial, sans-serif;
        font-size: 18px;
        margin: 40px auto;
        padding: 15px 25px;
        max-width: 500px;
        border-radius: 10px;
        background-color: " . ($type === 'success' ? '#d4edda' : ($type === 'error' ? '#f8d7da' : '#fff3cd')) . ";
        color: " . ($type === 'success' ? '#155724' : ($type === 'error' ? '#721c24' : '#856404')) . ";
        border: 1px solid " . ($type === 'success' ? '#c3e6cb' : ($type === 'error' ? '#f5c6cb' : '#ffeeba')) . ";
        text-align: center;
    '>$message</div>";
}

// Check if file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileUpload'])) {
        $file = $_FILES['fileUpload'];

        // Get the file extension
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Check if the file type is allowed
        if (!in_array(strtolower($fileExtension), $allowed_types)) {
            showMessage('❌ Invalid file type. Please upload an MP3 file.', 'error');
        } else {
            // Check the size of the uploaded file
            $fileSize = $file['size'];

            // Get total size of all files in the upload directory
            $totalSize = 0;
            $files = glob($uploadDir . '*'); // Get all files in the upload directory
            foreach ($files as $filePath) {
                if (is_file($filePath)) {
                    $totalSize += filesize($filePath); // Add the file size to the total
                }
            }

            // Check if the total file size exceeds the limit (300MB)
            if (($totalSize + $fileSize) > $maxTotalSize) {
                showMessage('⚠️ Total upload limit of 300MB reached. No more files can be uploaded.', 'error');
            } else {
                // Check if the file size is under 5MB
                if ($fileSize > 5 * 1024 * 1024) {
                    showMessage('⚠️ File size exceeds 5MB. Please select a smaller file.', 'error');
                } else {
                    // Make sure the upload directory exists
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    // Define the target file path
                    $targetFile = $uploadDir . basename($file['name']);

                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                        showMessage('✅ File uploaded successfully: ' . htmlspecialchars($targetFile), 'success');
                    } else {
                        showMessage('❌ Sorry, there was an error uploading your file.', 'error');
                    }
                }
            }
        }
    }
}
?>