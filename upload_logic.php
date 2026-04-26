<?php
// 1. Database connection path-ai sariyaaga include pannuvom
// Unga structure-padi 'config' folder root-la irundhaal idhu dhaan correct path
include 'config/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_file'])) {
    
    // 2. Upload panna vaendiya folder
    $target_dir = "uploads/";
    
    // 3. File name-la unique ID sethukkuvom (ore name-la files vandhaal replace aagaama irukka)
    $file_name = time() . "_" . basename($_FILES["pdf_file"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 4. PDF-ai mattum allow pannuvom
    if ($file_type != "pdf") {
        die("Error: PDF files mattum dhaan upload panna mudiyum!");
    }

    // 5. File-ai 'uploads' folder-kku move pannuvom
    if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
        
        // 6. Database-la file path-ai save pannuvom (optional)
        // $sql = "INSERT INTO uploads (file_name, path) VALUES ('$file_name', '$target_file')";
        // mysqli_query($conn, $sql);

        header("Location: app/views/index.php?status=success");
        exit();
    } else {
        echo "Upload failed! Unga project folder kulla 'uploads' folder irukkudhaa nu check pannunga.";
    }
} else {
    echo "No file selected!";
}
?>