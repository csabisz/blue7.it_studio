<html>
    <title>Test video</title>
<body>
<?php
if(isset($_POST['save_btn']))
{
    $output_dir = "../testimage/";
    $original_file_name = $_FILES["video_file"]["name"];
    $tempfile = explode(".", $original_file_name);
    $file_extension = strtolower(end($tempfile));
    $internal_file_name = sha1(uniqid(mt_rand(), true)) . '.' . $file_extension;

    move_uploaded_file($_FILES["video_file"]["tmp_name"], $output_dir . "/" . $internal_file_name);

    $convert_video_command="ffmpeg -i ".$output_dir . "/" . $internal_file_name." -vf scale=-1:".$_POST['video_height']." -c:v libx264 -crf 18 -preset veryslow -c:a copy output_720p.mp4 > /dev/null 2>&1 &";
    $video_thumbnail="ffmpeg -ss 00:00:02.00 -i ".$output_dir . "/" . $internal_file_name." -vframes 1 thumbnail.jpg > /dev/null 2>&1 &";
    exec($convert_video_command);
    exec($video_thumbnail);
}
?>
    <form name="upload_video_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <input type="file" name="video_file"><br>
    <input type="text" name="video_height" placeholder="height"><br>
    <button type="submit" name="save_btn">Upload</button>
    </form>

</body>
</html>