<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload and Watermark</title>
</head>
<body>
    <h2>Upload JPG Image</h2>
    <form action="watermark.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/jpeg" required>
        <button type="submit">Upload & Watermark</button>
    </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $uploadDir = "uploads_test/";
            $watermarkPath = "img/watermark.png";  // Path to your watermark

            // Ensure the upload directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $what=getimagesize($_FILES['image']['tmp_name']);
            
            echo $width = $what[0];
            echo $height = $what[1];
            // Handle file upload
            $uploadedFile = $uploadDir . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile);

            // Apply watermark
            addFullWatermark($uploadedFile, $watermarkPath);
        }

        function addFullWatermark($imagePath, $watermarkPath)
        {
            // Load the base image (JPG)
            $image = imagecreatefromjpeg($imagePath);
            if (!$image) {
                die("Failed to load image.");
            }

            // Load the watermark (PNG)
            $watermark = imagecreatefrompng($watermarkPath);
            if (!$watermark) {
                die("Failed to load watermark.");
            }

            // Get dimensions
            $imgWidth = imagesx($image);
            $imgHeight = imagesy($image);

            // Resize watermark to match image size
            $resizedWatermark = imagecreatetruecolor($imgWidth, $imgHeight);
            imagesavealpha($resizedWatermark, true);
            $transparent = imagecolorallocatealpha($resizedWatermark, 0, 0, 0, 127);
            imagefill($resizedWatermark, 0, 0, $transparent);
            
            imagecopyresampled($resizedWatermark, $watermark, 0, 0, 0, 0, $imgWidth, $imgHeight, imagesx($watermark), imagesy($watermark));

            // Merge watermark onto the image (full size)
            imagecopy($image, $resizedWatermark, 0, 0, 0, 0, $imgWidth, $imgHeight);

            // Save the final image
            $outputFile = str_replace(".jpg", "_watermarked.jpg", $imagePath);
            imagejpeg($image, $outputFile, 90);

            // Free memory
            imagedestroy($image);
            imagedestroy($watermark);
            imagedestroy($resizedWatermark);

            echo "Watermarked image saved: <a href='$outputFile'>View Image</a>";
        }
    ?>

</body>
</html>