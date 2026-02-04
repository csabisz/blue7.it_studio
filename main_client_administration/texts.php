<?php

session_start();

include('../functions.php');



$prod=new Production;

$_SESSION['start']=gmdate("Y-m-d H:i:s");

$page_title="Main Client Administration - Texts";

include('../header2.php');

include('../menu.php');



$mc_id=$prod->xss_fix($_GET['mc_id']);

$main_client=$prod->get_main_client($mc_id);

$main_client_color=$prod->get_main_client_colors($mc_id);

?>
<script src="<?php echo $base_url;?>js/tinymce/tinymce.min.js"></script>
<section class="top_section">
	<article>
	<div class="container pagecontent bg-white">
<?php

if(isset($_SESSION['client_id'])&&($_SESSION['start']<$_SESSION['expire']))
{
	?>

    <p class="w-100 text-center display-4 pt-4">

        Texts for main client ID <?php echo $mc_id; ?>

        <br>
        <?php
        if($client['mc_id']>0)
        {       
            echo $main_client['clientname'];
        }
        ?>

    </p>
    <p class="w-100 text-center"><a href="<?php echo $base_url;?>main_client_administration/index.php"><- Back to Main Clients</a></p>
    <hr class="mb-4" width="450px">
    <?php   
    //start page
	?>
    <div class="row">
        <div class="col-md-12 p-0" style="background-color:#d3d3d3;">
    <form id="main_client_texts_form" name="main_client_texts_form" method="post" action="<?php $_SERVER['PHP_SELF'];?>?clientid=<?php echo $clientid;?>" enctype="multipart/form-data"></form>
    <input type="hidden" name="mc_id" value="<?php echo $mc_id; ?>" form="main_client_texts_form">
    <br>
    <div class="row" style="padding-bottom: 0 !important;">
        <div class="col-md-2">
            <label for="text_1_name"><b>Text 1 name</b></label>
        </div>
        <div class="col-md-6">
            <input id="text_1_name" name="text_1_name" type="text" class="form-control rounded-0" value="<?php echo $main_client_color['text_1_name'];?>" form="main_client_texts_form">
        </div>
    </div>
    <div class="form-group mt-0">
        <label for="text_1_long"><b>Text 1 - Long</b></label>
        <div class="d-flex">
            <textarea id="text_1_long" name="text_1_long" type="text" class="form-control rounded-0" form="main_client_texts_form"><?php echo $main_client_color['text_1_long'];?></textarea>
        </div>
        <script type="text/javascript">

            $(document).ready(function(){

                tinymce.init({
                    selector:'textarea#text_1_long',
                    plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',

                    imagetools_cors_hosts: ['picsum.photos'],

                    menubar: 'file edit view insert format tools table help',

                    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',

                    toolbar_sticky: false,

                    autosave_ask_before_unload: false,

                    autosave_interval: "30s",

                    autosave_prefix: "{path}{query}-{id}-",

                    autosave_restore_when_empty: false,

                    autosave_retention: "2m",

                    image_advtab: true,

                    content_css: '//www.tiny.cloud/css/codepen.min.css',

                    link_list: [

                        { title: 'My page 1', value: 'http://www.tinymce.com' },

                        { title: 'My page 2', value: 'http://www.moxiecode.com' }

                    ],

                    image_list: [

                        { title: 'My page 1', value: 'http://www.tinymce.com' },

                        { title: 'My page 2', value: 'http://www.moxiecode.com' }

                    ],

                    image_class_list: [

                        { title: 'None', value: '' },

                        { title: 'Some class', value: 'class-name' }

                    ],

                    importcss_append: true,

                    height: 200,

                    file_picker_callback: function (callback, value, meta) {

                        /* Provide file and text for the link dialog */

                        if (meta.filetype === 'file') {

                            callback('https://www.google.com/logos/google.jpg', { text: 'My text' });

                        }



                        /* Provide image and alt text for the image dialog */

                        if (meta.filetype === 'image') {

                            callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });

                        }



                        /* Provide alternative source and posted for the media dialog */

                        if (meta.filetype === 'media') {

                            callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });

                        }

                    },

                    templates: [

                        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },

                        { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },

                        { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }

                    ],

                    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',

                    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',

                    //height: 600,

                    image_caption: true,

                    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',

                    noneditable_noneditable_class: "mceNonEditable",

                    toolbar_mode: 'sliding',

                    contextmenu: "link image imagetools table"

                });

            });

        </script>
    </div>
    <div class="row" style="padding-bottom: 0 !important;">
        <div class="col-md-2">
            <label for="text_2_name"><b>Text 2 name</b></label>
        </div>
        <div class="col-md-6">
            <input id="text_2_name" name="text_2_name" type="text" class="form-control rounded-0" form="main_client_texts_form" value="<?php echo $main_client_color['text_2_name'];?>">
        </div>
    </div>
    <div class="form-group mt-0">
        <label for="text_2_long"><b>Text 2 - Long</b></label>
        <div class="d-flex">
            <textarea id="text_2_long" name="text_2_long" type="text" class="form-control rounded-0" form="main_client_texts_form"><?php echo $main_client_color['text_2_long'];?></textarea>
        </div>
        <script type="text/javascript">

            $(document).ready(function(){

                tinymce.init({
                    selector:'textarea#text_2_long',
                    plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',

                    imagetools_cors_hosts: ['picsum.photos'],

                    menubar: 'file edit view insert format tools table help',

                    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',

                    toolbar_sticky: false,

                    autosave_ask_before_unload: false,

                    autosave_interval: "30s",

                    autosave_prefix: "{path}{query}-{id}-",

                    autosave_restore_when_empty: false,

                    autosave_retention: "2m",

                    image_advtab: true,

                    content_css: '//www.tiny.cloud/css/codepen.min.css',

                    link_list: [

                        { title: 'My page 1', value: 'http://www.tinymce.com' },

                        { title: 'My page 2', value: 'http://www.moxiecode.com' }

                    ],

                    image_list: [

                        { title: 'My page 1', value: 'http://www.tinymce.com' },

                        { title: 'My page 2', value: 'http://www.moxiecode.com' }

                    ],

                    image_class_list: [

                        { title: 'None', value: '' },

                        { title: 'Some class', value: 'class-name' }

                    ],

                    importcss_append: true,

                    height: 200,

                    file_picker_callback: function (callback, value, meta) {

                        /* Provide file and text for the link dialog */

                        if (meta.filetype === 'file') {

                            callback('https://www.google.com/logos/google.jpg', { text: 'My text' });

                        }



                        /* Provide image and alt text for the image dialog */

                        if (meta.filetype === 'image') {

                            callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });

                        }



                        /* Provide alternative source and posted for the media dialog */

                        if (meta.filetype === 'media') {

                            callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });

                        }

                    },

                    templates: [

                        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },

                        { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },

                        { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }

                    ],

                    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',

                    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',

                    //height: 600,

                    image_caption: true,

                    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',

                    noneditable_noneditable_class: "mceNonEditable",

                    toolbar_mode: 'sliding',

                    contextmenu: "link image imagetools table"

                });

            });

        </script>
    </div>
    
    
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-12 text-center">                
            <button id="texts_save_btn" name="texts_save_btn" type="button" class="btn btn-sm btn-primary">Save</button>                        
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <div id="save_texts_message">
            </div>
            <script type="text/javascript">
                $('#texts_save_btn').click(function(){
                    
                    let message = tinymce.get('text_1_long').getContent();
                    $('#text_1_long').text(message);
                    message = tinymce.get('text_2_long').getContent();
                    $('#text_2_long').text(message);

                    formData= new FormData($('#main_client_texts_form')[0]);

                    $.ajax({
                        url: "<?php echo $base_url;?>ajax/save_main_client_texts.php",
                        type: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType:"html",
                        success:function(data) {
                            console.log(data);
                        }
                    }).done(function(data){

                        html = "<div class=\"alert alert-success\">";
                        html += data;
                        html += "</div>";

                        $('#save_texts_message').html(html);
                        //setTimeout(function(){window.location = "<?php echo $base_url;?>admin/texts"},2000);
                    });

                });
            </script>    
        </div>
    </div>
        </div><!-- end col-md-12 -->
        </div><!-- end row -->
	<?php

}
else
{

    session_unset();
    session_destroy();

?>

	<div class="text-center">				
        <div class="alert alert-danger">You must be logged in to view this page !</div>
        <a href="<?php echo $base_url;?>login.php" class="btn btn-danger btn-sm">Login</a>
        <br><br>
	</div>
	<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
	<?php
}
?>
</div> <!-- end container -->
</article>
</section>
<?php
include('../footer.php');
?>