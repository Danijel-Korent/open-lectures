<?php 
require_once 'config.php';

/**
 * Save an uploaded file to a specific directory.
 * Validates file type (PNG, JPEG, JPG only) and creates directory if it doesn't exist.
 * 
 * @param array $file The uploaded file array from $_FILES['key'] with keys: 'tmp_name', 'error', etc.
 * @param string $fileName Base filename without extension (extension will be determined from MIME type)
 * @param string $directory Target directory path where the file should be saved
 * @return string|false The saved filename with extension on success, false on failure
 *                      (returns false if upload error, invalid MIME type, or file move fails)
 */
function saveFile(array $file, string $fileName, string $directory)
{
    $allowedMimeTypes = [
        'image/png' => 'png',
        'image/jpeg' => 'jpeg',
        'image/jpg' => 'jpg'
    ];

    // Ensure the directory exists, create it if it doesn't
    // SECURITY ISSUE: INSECURE FILE PERMISSIONS
    // 0777 gives full read/write/execute permissions to everyone
    // FIX: Use 0755 for directories (owner: rwx, group: rx, others: rx)
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Validate the upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false; // File upload error
    }

    // Get the MIME type and validate it
    // SECURITY ISSUE: INSUFFICIENT FILE UPLOAD VALIDATION
    // Only checking MIME type, not file extension or content validation
    // FIX: Add file extension validation, content scanning, and size limits
    $mimeType = mime_content_type($file['tmp_name']);
    if (!isset($allowedMimeTypes[$mimeType])) {
        return false; // Unsupported file type
    }

    // Determine the file extension
    $extension = $allowedMimeTypes[$mimeType];

    // Append the correct file extension to the file name
    $fileNameWithExtension = $fileName . '.' . $extension;

    // Generate the full file path
    $filePath = rtrim($directory, '/') . '/' . $fileNameWithExtension;

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        return $fileNameWithExtension; // Return the full path to the saved file
    }

    return false; // File move failed
}


/**
 * Delete a file from the filesystem.
 * Checks if file exists before attempting deletion.
 * 
 * @param string $filePath The full path to the file to delete
 * @return bool True if file was deleted successfully, false if file doesn't exist or deletion fails
 */
function deleteFile(string $filePath)
{
    // Check if the file exists before deleting
    if (file_exists($filePath)) {
        return unlink(filename: $filePath); // Delete the file
    }
    return false; // File does not exist
}