<?php 
require_once 'config.php';

/**
 * Save an uploaded file to a specific directory.
 *
 * @param array $file The uploaded file from $_FILES['key'].
 * @param string $directory The directory to save the file.
 * @return string|bool The file path if successful, false otherwise.
 */
function saveFile(array $file, string $fileName, string $directory)
{
    $allowedMimeTypes = [
        'image/png' => 'png',
        'image/jpeg' => 'jpeg',
        'image/jpg' => 'jpg'
    ];

    // Ensure the directory exists, create it if it doesn't
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Validate the upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false; // File upload error
    }

    // Get the MIME type and validate it
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
 *
 * @param string $filePath The path to the file to delete.
 * @return bool True if deleted successfully, false otherwise.
 */
function deleteFile(string $filePath)
{
    // Check if the file exists before deleting
    if (file_exists($filePath)) {
        return unlink(filename: $filePath); // Delete the file
    }

    return false; // File does not exist
}