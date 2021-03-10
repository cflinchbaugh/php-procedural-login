<?php
    if (isset($_POST['submit'])) {
        $file = $_FILES['file-data'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];
        $tmpFileExtension = explode('.', $fileName); // Split the string
        $fileExtension = end($tmpFileExtension); //Grab the last index to get the extension; two lines because https://stackoverflow.com/questions/4636166/only-variables-should-be-passed-by-reference

        $allowedExtensions = array(
            'jpg',
            'jpeg',
            'pdf',
            'png'
        );
        $maxFileSizeKb = 100000000;

        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            if ($fileError === 0) {
                if ($fileSize < $maxFileSizeKb) {
                    $fileNameUnique = uniqid('', true).".".$fileExtension; //Server name used to avoid conflicts with other user-uplaoded content since this is all stored in the same folder

                    $fileDestination = "uploads/" . $fileNameUnique;
                    move_uploaded_file($fileTmpName, $fileDestination); //Actually upload

                    header('Location: index.php?upload=success');
                } else {
                    echo "File must not exceed " . $maxFileSizeKb/1000 . "MB";
                }
            } else {
                echo "Error uploading file";
            }
        } else {
            echo "Invalid File Extension: " . $fileExtension . ";";
        }

    } else {
        header('Location: index.php?error=noSubmission');
    }