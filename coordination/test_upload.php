<?php
//session_set_cookie_params(14400,"/");
session_start();

include('../functions.php');
include('../../../../domenia7.com/public_html/domenia_db2.php');
include('../notifications.php');
include('../../../../blue7.it/public_html/domenia/domenia.php');

//$domenia=new Domenia;
$domenia2 = new Domenia2;
$prod = new Production;
$notification = new Notifications;
$_SESSION['start'] = gmdate("Y-m-d H:i:s");

$picture_website = "https://domenia.blue7.it/";

include('../header2.php');
include('../menu.php');
//5192.x01.p1563
?>
    <section class="acceptance pt-5">
        <article>
            <div class="row">
        <div class="col-md-6">
            <div id="fileuploader_5192_x01_p1724"></div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#fileuploader_5192_x01_p1724").uploadFile({
                        url: "../upload_files_beta2.php?filecategory=creatorfiles&o_id=5192&osub_id=n01&prod_id=p1724&uca_id=<?php echo $_SESSION['client_id']; ?>",
                        fileName: "myfile",
                        showAbort: true,
                        showStatusAfterSuccess: true,
                        showStatusAfterError: true,
                        statusBarWidth: 350,
                        dragdropWidth: 350,
                        uploadStr: "Upload result files",
                        afterUploadAll: function () {
                            setTimeout(function () {
                                window.location = "test_upload.php?o_id=5192&osub_id=x01&prod_id=p1724"
                            }, 2000);
                        }
                    });
                });
            </script>
        </div>
            </div>
        </article>
    </section>
<?php
include('../footer.php');
?>