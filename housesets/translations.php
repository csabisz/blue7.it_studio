<?php
session_start();
include('../functions.php');

$prod=new Production;

include('../header2.php');
include('../menu.php');
$lang_id = 1;
if(isset($_GET['lang_id'])){
    $lang_id = $prod ->xss_fix($_GET['lang_id']);      
}
$rights=$prod->get_client_rights($_COOKIE['client_id']);
?>
<section class="top_section">
<article>
<div class="container pagecontent bg-white px-0">
<?php
if(isset($_COOKIE['client_id']))
{	
    if(isset($_POST['delete_but'])){
        $trans_id = $prod->xss_fix($_POST['trans_idd']);
        $lang_id = $prod->xss_fix($_POST['lang_id']);

        $prod->delete_translation_superplan($trans_id,$lang_id);
      ?>
    <div class="alert alert-success" role="alert">
    <p class="text-center">Translation Deleted ! <?php echo $lang_id; echo " "; echo $trans_id; ?> </p>
    </div>
    <br>
    <meta http-equiv="refresh" content="2; url=translations.php?lang_id=<?php echo $lang_id; ?>">    
    <?php
    }
    $option = $_GET['option'];
    if($option=="modify"){
        if(isset($_GET['trans_id'])&&(isset($_GET['lang_id']))){
            if(isset($_POST['update_btn'])){
                $trans_id = $prod->xss_fix($_POST['trans_id']);
                $lang_id = $prod->xss_fix($_POST['lang_id']);

                if($lang_id==1)
                {
                    $lang_name="English-US";
                }
                if($lang_id==49)
                {
                    $lang_name="German";
                }
                if($lang_id==40)
                {
                    $lang_name="Romanian";
                }
                if($lang_id==7)
                {
                    $lang_name="Russian";
                }
                if($lang_id==34)
                {
                    $lang_name="Spanish";
                }
                if($lang_id==36)
                {
                    $lang_name="Hungarian";
                }
                if($lang_id==90)
                {
                    $lang_name="Turkish";
                }
                $lang_description=$_POST['eng_description'];
                // $translation=$_POST['translation'];

                $translation = trim($_POST['translation']);

                // $translation = preg_replace("/\<p\>\&nbsp\;\<\/p\>/", "", $translation);
                // $translation = preg_replace("/\&nbsp\;+/", " ", $translation);
                // $translation = preg_replace("/\s+/", " ", $translation);
              
                // $translation = htmlentities($translation);

                $prod->update_translation_superplan($trans_id,$lang_id,$lang_name,$lang_description,$translation);
                ?>
                <div class="alert alert-success" role="alert">
                <p class="text-center">Translation Updated ! </p>
                </div>
                <br>
                <meta http-equiv="refresh" content="2; url=translations.php?lang_id=<?php echo $lang_id; ?>">
                <?php
            }
            if($lang_id==1)
                {
                    $lang_name="English-US";
                }
                if($lang_id==49)
                {
                    $lang_name="German";
                }
                if($lang_id==40)
                {
                    $lang_name="Romanian";
                }
                if($lang_id==7)
                {
                    $lang_name="Russian";
                }
                if($lang_id==34)
                {
                    $lang_name="Spanish";
                }
                if($lang_id==36)
                {
                    $lang_name="Hungarian";
                }
                if($lang_id==90)
                {
                    $lang_name="Turkish";
                }
            $trans_id=$prod->xss_fix($_GET['trans_id']);
            $lang_id=$prod->xss_fix($_GET['lang_id']);
            $translation = $prod->get_translation_text_superplan($lang_id,$trans_id);
            $eng_version = $prod->get_translation_text_superplan(1,$trans_id);
        }        
        ?>
        <p class="w-100 text-center display-4 pt-4">Edit Translation  </p>
        <hr class="mb-4" width="450px">
        <form action="translations.php?option=modify&trans_id=<?php echo $trans_id; ?>&lang_id=<?php echo $lang_id; ?>" method="POST" >
        <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
            <div class="col-12 text-center">
                <a href="index.php" class="btn btn-sm bg-dark text-white mx-3 border">Go to Plansets</a>
                <a href="translations.php" class="btn btn-sm bg-dark text-white mx-3 border">Go to Translations</a>
            </div>       
            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">Translation ID </h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text text-muted to build on the card title and make up the bulk of the card's content.</p>
                <input type="text"  name="trans_id" value="<?php echo $trans_id; ?>"  class="form-control">
                <input type="hidden" name="lang_id" value="<?php echo $lang_id; ?>"> 
            </div>
            </div>
            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">English Description</h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <textarea id="editor1" name="eng_description" class="form-control"  id="" cols="30" rows="10">
                    <?php 
                        echo $eng_version['description_engl'];
                    ?>
                </textarea>
                <script>
                    CKEDITOR.config.autoParagraph = false;
                    CKEDITOR.replace('editor1');
                </script>
            </div>
            </div>

            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">English Version</h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <textarea id="editor2" name="eng_version" class="form-control" id="" cols="30" rows="10">
                <?php 
                    echo $eng_version['text'];
                ?>
                </textarea>
                <script>
                    CKEDITOR.config.autoParagraph = false;
                    CKEDITOR.replace('editor2');
                </script>
            </div>
            </div>
            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">Translated Text in <div class="text-danger" style="font-size: 1.25rem!important;display: inline;"><?php echo $lang_name; ?></div></h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <textarea id="editor3"  name="translation" class="form-control" id="" cols="30" rows="10">
                    <?php echo $translation['text']; ?>
                </textarea>
                <script>
                    CKEDITOR.config.autoParagraph = false;
                    CKEDITOR.replace('editor3');
                </script>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 offset-md-5 mb-4">
            <button name="update_btn" class="btn btn-primary btn-sm">Update this translation</button>
            </div>
        </div>
        </form>
        <?php
    }
    elseif($option == "create"){
        if(isset($_POST['add_btn'])){
            $data['trans_id'] = $prod->xss_fix($_POST['id_translation']);
            $data['lang_id'] = $prod->xss_fix($_POST['lang_id']);

            if($lang_id==1){
                $data['lang_name'] = "English-US";
            }
            if($lang_id==49){
                $data['lang_name'] = "German";
            }
            if($lang_id==40){
                $data['lang_name'] = "Romanian";
            }
            if($lang_id==7){
                $data['lang_name'] = "Russian";
            }
            if($lang_id==34){
                $data['lang_name'] = "Spanish";
            }
            if($lang_id==36){
                $data['lang_name'] = "Hungarian";
            }
            if($lang_id==90){
                $data['lang_name'] = "Turkish";
            }
            $data['lang_description'] = $prod->xss_fix($_POST['eng_description']); 
            $data['translation'] = $prod->xss_fix($_POST['translation']);
            $prod->add_translation_superplan(json_encode($data));
            ?>
            <div class="alert alert-success" role="alert">
            <p class="text-center">Translation saved !</p>
            </div>
            <br>
            <meta http-equiv="refresh" content="2; url=translations.php?lang_id=<?php echo $lang_id; ?>">
        <?php
        }
        if(isset($_GET['lang_id']))
        {
            $lang_id=$prod->xss_fix($_GET['lang_id']);
        }
        else
        {
            $lang_id=1;
        }
        
                    
        if($lang_id==1)
        {
            $lang_name="English-US";
        }
        if($lang_id==49)
        {
            $lang_name="German";
        }
        if($lang_id==40)
        {
            $lang_name="Romanian";
        }
        if($lang_id==7)
        {
            $lang_name="Russian";
        }
        if($lang_id==34)
        {
            $lang_name="Spanish";
        }
        if($lang_id==36)
        {
            $lang_name="Hungarian";
        }
        
        $trans_id=$prod->xss_fix($_GET['trans_id']);
        $translation = $prod->get_translation_text_superplan($lang_id,$trans_id);
        $english_vers = $prod->get_translation_text_superplan(1,$trans_id);
    ?>
        <p class="w-100 text-center display-4 pt-4">Add Translation</p>
        <hr class="mb-4" width="450px">
        <form action="translations.php?option=create&lang_id=<?php echo $lang_id; ?>" method="POST" >
        <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
            <div class="col-12 text-center">
                <a href="index.php" class="btn btn-sm bg-dark text-white mx-3 border">Go to Plansets</a>
                <a href="translations.php" class="btn btn-sm bg-dark text-white mx-3 border">Go to Translations</a>
            </div>       
            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">Translation ID </h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text text-muted to build on the card title and make up the bulk of the card's content.</p>
                <input type="text" id="trans_id" name="id_translation" value="<?php echo $trans_id;?>" required  class="form-control">
                <input type="hidden" name="lang_id" value="<?php echo $lang_id; ?>">
            </div>
            </div>
            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">English Description</h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <textarea id="editor4" name="eng_description" class="form-control" id="" cols="30" rows="10">
                    <?php if(isset($_GET['trans_id'])){
                        
                        if($lang_id!=1){
                            if($english_vers){
                                echo $english_vers['description_engl'];
                            }
                            else{
                                echo "english version not made yet!";
                            }
                        }
                    } ?>
                </textarea>
                <script>
                    CKEDITOR.config.autoParagraph = false;
                    CKEDITOR.replace('editor4');
                </script>
            </div>
            </div>

            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">English Version</h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <textarea id="editor5" name="eng_version" class="form-control" id="" cols="30" rows="10">
                    <?php echo $english_vers['text']; ?>
                </textarea>
                <script>
                    CKEDITOR.config.autoParagraph = false;
                    CKEDITOR.replace('editor5');
                </script>
            </div>
            </div>
            <div class="card col-5 ml-2 mt-4" >
            <div class="card-body text-center">
                <h5 class="card-title ">Translated Text in <div class="text-danger" style="font-size: 1.25rem!important;display: inline;"><?php echo $lang_name; ?></div></h5>
                <hr class="mb-4" width="250px">
                <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <textarea id="editor6"  name="translation" class="form-control" id="" cols="30" rows="10"></textarea>
                <script>
                    CKEDITOR.config.autoParagraph = false;
                    CKEDITOR.replace('editor6');
                </script>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 offset-md-5 mb-4">
            <button name="add_btn" class="btn btn-primary btn-sm">Save this translation</button>
            </div>
        </div>
        </form>
        	
    </div>
    <?php
    }	
    else{
    ?>
    <p class="w-100 text-center display-4 pt-4">Translations</p>
    <hr class="mb-4" width="450px">
    <div class="row mx-0 w-100 d-flex justify-content-center py-3 mb-3">
        <a href="index.php" class="btn btn-sm bg-dark text-white mx-3 border">Go To Plansets</a>
        <a href="translations.php?option=create&lang_id=<?php echo $lang_id; ?>" class="btn btn-sm btn-primary mx-3 border">Add Translation</a> 
        <div class="col-2">
        <select id="lang_id" onchange="if (this.value) window.location.href=this.value" class="custom-select custom-select-sm">
        <option value="">Select Language</option> 
        <?php if(strpos($rights['trans_languages'],'1;')!==false){ ?>
        <option value="translations.php?lang_id=1" <?php echo ($lang_id=="1")?"selected":""?>>English-US</option>
        <?php } 
        if(strpos($rights['trans_languages'],'49;')!==false){
        ?>
        <option value="translations.php?lang_id=49" <?php echo ($lang_id=="49")?"selected":""?>>German</option>
        <?php } 
        if(strpos($rights['trans_languages'],'7;')!==false){
        ?>
        <option value="translations.php?lang_id=7" <?php echo ($lang_id=="7")?"selected":""?>>Russian</option>
        <?php }
        if(strpos($rights['trans_languages'],'34;')!==false){
        ?>
        <option value="translations.php?lang_id=34" <?php echo ($lang_id=="34")?"selected":""?>>Spanish</option>
        <?php }
        if(strpos($rights['trans_languages'],'40;')!==false){
        ?>
        <option value="translations.php?lang_id=40" <?php echo ($lang_id=="40")?"selected":""?>>Romanian</option>
        <?php } 
        if(strpos($rights['trans_languages'],'36;')!==false){
        ?>
        <option value="translations.php?lang_id=36" <?php echo ($lang_id=="36")?"selected":""?>>Hungarian</option>
        <?php } 
        if(strpos($rights['trans_languages'],'90;')!==false){
        ?>
        <option value="translations.php?lang_id=90" <?php echo ($lang_id=="90")?"selected":""?>>Turkish</option>
        <?php } ?>
        </select>
        </div>
    </div>

	
    <h5 class="w-100 mx-0 text-center display-5 py-2 mb-3">Translations</h5>
    <div class="jumbotron mb-0 bg-white pt-0">
        <div class="row w-100 mx-0">
        <table class="table table-hover" id="myTable">
            <thead>
                <th>Translation ID</th>
                <th>English description</th>
                <th>English version</th>
                <th>Translation</th>
                <th style="width: 90px!important;">Action</th>
            </thead>
            <tbody>
                <?php 
                $nr=0;
                $translations = $prod->get_all_translations_by_lang(1);
                ?>
                <?php
                for($i=0;$i<count($translations);$i++){
                    $nr++;
                ?>
                <tr>
                    
                    <td><?php echo $translations[$i]['id_translation']; ?></td>
                    <td><?php echo $translations[$i]['description_engl']; ?></td>
                    <td>
                    <?php 
                    $short_english_translation = substr($translations[$i]['text'],0,150);
                    echo $short_english_translation;
                    if(strlen($short_english_translation)>149){
                        echo '...';
                    }
                    ?>
                    </td>
                    <td>
                        <?php 
                            $translated_version = $prod->get_translation_text_superplan($lang_id,$translations[$i]['id_translation']);   
                            echo  $translated_version['text'];
                            $short_translation = substr($translated_version[$i]['text'],0,150); 
                            echo $short_translation;
                            if(strlen($short_translation)>149){
                                echo '...';
                            }                                    
                        ?>
                    </td>
                    <td>
                        <?php 
                        if(!empty($translated_version)){
                        ?>
                        <a href="translations.php?option=modify&trans_id=<?php echo $translations[$i]['id_translation'] ?>&lang_id=<?php echo $lang_id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <?php 
                        } else{?>
                        <a href="translations.php?option=create&trans_id=<?php echo $translations[$i]['id_translation'] ?>&lang_id=<?php echo $lang_id; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <?php } ?>
                        <form class="d-inline" action="translations.php?trans_id=<?php echo $translations[$i]['id_translation']; ?>&lang_id=<?php echo $lang_id; ?>" method="post">
                            <input type="hidden" name="trans_idd" value="<?php echo $translations[$i]['id_translation']; ?>">
                            <input type="hidden" name="lang_id" value="<?php echo $translations[$i]['lang_id']; ?>">
                            <button class="btn btn-danger" name="delete_but" onclick="return confirm('Are you sure want do delete ?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>                              
                <?php } ?>
                
            </tbody>                          
                
        </table>
        <?php if($nr==0){?>
            <div class="col-12">
                <div class="container">
                    <div class="text-center">
                        <div class="alert alert-warning">No results found!</div>
                    </div>
                </div>
            </div>
        <?php
        } ?>
                    
        </div>
    </div>
    <?php
    }							
    ?>
    
<br>

	<?php		
	}
	else
	{
	?>
    <script type="text/javascript">
        Cookies.remove("session_id");
        Cookies.remove("start");
        Cookies.remove("client_id");
        Cookies.remove("client");
        Cookies.remove("own_tasks");
        Cookies.remove("cdesign");
        Cookies.remove("change_vat");
        Cookies.remove("l_first_name");
        Cookies.remove("l_last_name");
        Cookies.remove("c_first_name");
        Cookies.remove("c_last_name");
        Cookies.remove("email");
        Cookies.remove("useradmin");
        Cookies.remove("programs_of_employees");
        Cookies.remove("contracting");
        Cookies.remove("bookkeeping");
        Cookies.remove("coordination");
        Cookies.remove("plansets");
        Cookies.remove("housesets");
        Cookies.remove("plots");
        Cookies.remove("view_all_orders");
        Cookies.remove("activity_view");
        Cookies.remove("apu_lists");
        Cookies.remove("examples_db");
        Cookies.remove("translations");
        Cookies.remove("company");
        Cookies.remove("lt_id");
        Cookies.remove("ip_address");
        Cookies.remove("user_agent");
        Cookies.remove("expire");
    </script>
	<div class="center_message">				
	<div class="error">You must be logged in to view this page !</div>
	<a href="../index.php" class="btn btn-danger btn-sm">Login</a>
	<br><br>
	</div>
	<meta http-equiv="refresh" content="2; url=../index.php">
	<?php
	}
	?>
	</div>
	</article>
</section>
<?php
include('../footer.php');
?>