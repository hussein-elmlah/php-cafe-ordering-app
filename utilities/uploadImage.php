<?php

$errors = [];
$old_data = [];

function uploadImage($files, $old_data)
{
    global $errors; 
    global $old_data; 

    if (!empty($files['image']['tmp_name'])) {
        $filename = $files['image']['name'];
        $tmp_name = $files['image']['tmp_name'];
        // Extract extension
        $lastDotPos = strrpos($filename, '.');
        if ($lastDotPos !== false) {
            $extension = strtolower(substr($filename, $lastDotPos + 1));
        } else {
            $extension = '';
        }

        // var_dump($extension);

        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'enc'])) {
            $errors["image"] = "Sorry, only JPG, JPEG, PNG, GIF, and ENC files are allowed.";
            $old_data['image'] = $old_data['lastImage'];
        } else {
            $imagesDirectory = 'public/images' . DIRECTORY_SEPARATOR;
            if (!file_exists($imagesDirectory)) {
                mkdir($imagesDirectory, 0777, true); // Recursive directory creation
                // Adjust permissions for Windows
                chmod($imagesDirectory, 0777);
            }

            // Generate new filename with timestamp before extension
            $timestamp = floor(microtime(true) * 1000);
            $newFilename = pathinfo($filename, PATHINFO_FILENAME) . '-' . $timestamp . '.' . $extension;
            $imagePath = $imagesDirectory . $newFilename;

            $saved = move_uploaded_file($tmp_name, $imagePath);
            if ($saved) {
                $old_data['image'] = $imagePath;
            } else {
                $errors["image"] = "Failed to upload image.";
            }
        }
    } else {
        $old_data['image'] = $old_data['lastImage'];
    }

    return [
        'errors' => $errors,
        'data' => $old_data
    ];
}

// Usage example:
// $files = $_FILES;
// $data = ['lastImage' => '/path/to/last/image.jpg'];
// $result = uploadImage($files, $old_data);
// $errors = $result["errors"];
// $data = $result["data"];
// $image_path = $data['image'];

// print_r($result);


// Function to handle image upload
function handleImageUpload($file) {
    // Check if an image was uploaded
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ['error' => 'No image uploaded.'];
    }

    
    $uploadDir = 'public/images/';
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];


    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    
    if (!in_array($fileExt, $allowedTypes)) {
        return ['error' => 'Invalid file type. Allowed types: jpg, jpeg, png, gif'];
    }

    
    if ($fileError !== 0) {
        return ['error' => 'Error uploading file. Please try again.'];
    }

    $uniqueFileName = uniqid('', true) . '.' . $fileExt;

    
    if (!move_uploaded_file($fileTmpName, $uploadDir . $uniqueFileName)) {
        return ['error' => 'Error moving file to upload directory. Please check permissions.'];
    }

    return ['success' => 'Image uploaded successfully.', 'image' => $uploadDir . $uniqueFileName];
}

?>
