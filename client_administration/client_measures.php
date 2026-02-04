<?php
//session_set_cookie_params(14400,"/");
session_start();
include('../functions.php');

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

include('../header2.php');

include('../menu.php');

?>
<section class="top_section">
	<article>
    <?php
    if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
    {
        ?>
	<div class="container py-3 my-4">	
    <h3 class="text-center mb-2">Change Main client/Simple client measures</h3>
	<br>
		
    <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="main_client-tab" data-toggle="tab" href="#main_client" role="tab" aria-controls="main_client" aria-selected="true">Main client</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="simple_client-tab" data-toggle="tab" href="#simple_client" role="tab" aria-controls="simple_client" aria-selected="false">Simple client</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="default_client-tab" data-toggle="tab" href="#default_client" role="tab" aria-controls="default_client" aria-selected="false">Default client</a>
    </li>
    </ul>

    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="main_client" role="tabpanel" aria-labelledby="main_client-tab">
        
    <table id="main_client_measures" class="table table-striped border">
        <thead>
        <tr>
            <th>Main client name</th>
            <th>Wall height (mm)</th>
            <th>Wall out thickness (mm)</th>
            <th>Wall in thickness (mm)</th>
            <th>Wall middle thickness (mm)</th>
            <th>Windows top (mm)</th>
            <th>Exterior doors top (mm)</th>
            <th>Interior doors top (mm)</th>
            <th>Foundation (mm)</th>
            <th>Ceiling (mm)</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        
		$measures=$prod->get_all_main_client_measures();

        for($i=0;$i<count($measures);$i++)
        {
            ?>
            <tr>
                <td class="pl-3">
                <?php
                $main_client=$prod->get_main_client($measures[$i]['mc_id']);
                echo $main_client['clientname'];
                ?>
                </td>
                <td>
                <?php
                    echo $measures[$i]['wall_height'];
                ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['wall_out_thickness'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['wall_in_thickness'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['wall_middle_thickness'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['windows_top'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['ex_doors_top'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['in_doors_top'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['foundation'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $measures[$i]['ceiling'];
                    ?>
                </td>
                <td>
                    <button id="modify_btn<?php echo $measures[$i]['ucm_id']; ?>" name="modify_btn<?php echo $measures[$i]['ucm_id']; ?>" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modifyModal<?php echo $measures[$i]['ucm_id']; ?>">Modify</button>
                </td>
                <!-- Modal -->
                <div class="modal fade" id="modifyModal<?php echo $measures[$i]['ucm_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel<?php echo $measures[$i]['ucm_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modifyModalLabel<?php echo $measures[$i]['ucm_id']; ?>">Modify measures for ucm_id <?php echo $measures[$i]['ucm_id']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        $measure=$prod->get_client_measure($measures[$i]['ucm_id']);
                        ?>
                        <div class="modal-body text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Main client name</b>
                                </div>
                                <div class="col-md-6">
                                    <select id="mc_id<?php echo $measures[$i]['ucm_id']; ?>" name="mc_id" class="form-control form-control-sm">
                                        <option value="">--Select--</option>
                                        <?php
                                        $main_clients=$prod->get_all_main_clients();

                                        for($m=0;$m<count($main_clients);$m++)
                                        {
                                            ?>
                                            <option value="<?php echo $main_clients[$m]['mc_id'];?>" <?php echo ($main_clients[$m]['mc_id']==$measure['mc_id'])?"selected":"";?>><?php echo $main_clients[$m]['clientname'];?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall height (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_height<?php echo $measures[$i]['ucm_id']; ?>" name="wall_height" value="<?php echo $measure['wall_height'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall out thickness (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_out_thickness<?php echo $measures[$i]['ucm_id']; ?>" name="wall_out_thickness" value="<?php echo $measure['wall_out_thickness'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall in thickness (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_in_thickness<?php echo $measures[$i]['ucm_id']; ?>" name="wall_in_thickness" value="<?php echo $measure['wall_in_thickness'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall middle thickness (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_middle_thickness<?php echo $measures[$i]['ucm_id']; ?>" name="wall_middle_thickness" value="<?php echo $measure['wall_middle_thickness'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Windows top (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="windows_top<?php echo $measures[$i]['ucm_id']; ?>" name="windows_top" value="<?php echo $measure['windows_top'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Exterior doors top (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="ex_doors_top<?php echo $measures[$i]['ucm_id']; ?>" name="ex_doors_top" value="<?php echo $measure['ex_doors_top'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Interior doors top (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="in_doors_top<?php echo $measures[$i]['ucm_id']; ?>" name="in_doors_top" value="<?php echo $measure['in_doors_top'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Foundation (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="foundation<?php echo $measures[$i]['ucm_id']; ?>" name="foundation" value="<?php echo $measure['foundation'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Ceiling (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="ceiling<?php echo $measures[$i]['ucm_id']; ?>" name="ceiling" value="<?php echo $measure['ceiling'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div id="client_measures_response<?php echo $measures[$i]['ucm_id']; ?>">
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="save_btn<?php echo $measures[$i]['ucm_id']; ?>" name="save_btn<?php echo $measures[$i]['ucm_id']; ?>" class="btn btn-sm btn-primary">Save</button>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('#save_btn<?php echo $measures[$i]['ucm_id']; ?>').click(function(){

                                    let ucm_id=<?php echo $measures[$i]['ucm_id']; ?>;
                                    let mc_id=$('#mc_id<?php echo $measures[$i]['ucm_id']; ?> option:selected').val();
                                    let wall_height=$('#wall_height<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let wall_out_thickness=$('#wall_out_thickness<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let wall_in_thickness=$('#wall_in_thickness<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let wall_middle_thickness=$('#wall_middle_thickness<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let windows_top=$('#windows_top<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let in_doors_top=$('#in_doors_top<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let ex_doors_top=$('#ex_doors_top<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let foundation=$('#foundation<?php echo $measures[$i]['ucm_id']; ?>').val();
                                    let ceiling=$('#ceiling<?php echo $measures[$i]['ucm_id']; ?>').val();

                                    $.ajax({
                                        url: "../ajax/update_client_measures.php",
                                        method: "post",
                                        data: {ucm_id:ucm_id,
                                        mc_id:mc_id,
                                        wall_height:wall_height,
                                        wall_out_thickness:wall_out_thickness,
                                        wall_in_thickness:wall_in_thickness,
                                        wall_middle_thickness:wall_middle_thickness,
                                        windows_top:windows_top,
                                        in_doors_top:in_doors_top,
                                        ex_doors_top:ex_doors_top,
                                        foundation:foundation,
                                        ceiling:ceiling
                                        },
                                        dataType:"html",
                                        success:function(data) {
                                            	
                                            $('#client_measures_response<?php echo $measures[$i]['ucm_id']; ?>').html(data);

                                            setTimeout(function(){$('#modifyModal<?php echo $measures[$i]['ucm_id']; ?>').modal('hide')},2000);
                                        }
                                    });

                                });
                            });
                        </script>
                        </div>
                    </div>
                </div>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <script type="text/javascript">
        $(document).ready(function(){
                    $('#main_client_measures').DataTable({
                        "lengthMenu": [[50, -1], [50, "All"]],
                        "order": [[ 0, "asc" ]]
                    });
                });
    </script>
    </div>
    <div class="tab-pane fade" id="simple_client" role="tabpanel" aria-labelledby="simple_client-tab">Simple client</div>
    
    
    <div class="tab-pane fade" id="default_client" role="tabpanel" aria-labelledby="default_client-tab">
    <table class="table table-striped border">
        <thead>
        <tr>
            <th>Main client name</th>
            <th>Wall height</th>
            <th>Wall out thickness</th>
            <th>Wall in thickness</th>
            <th>Wall middle thickness</th>
            <th>Windows top</th>
            <th>Foundation</th>
            <th>Ceiling</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <?php
        $default_measures=$prod->get_all_default_client_measures();
        
        for($j=0;$j<count($default_measures);$j++)
        {
            ?>
            <tr>
                <td class="pl-3">
                <?php
                echo "Default client";
                ?>
                </td>
                <td>
                <?php
                    echo $default_measures[$j]['wall_height'];
                ?>
                </td>
                <td>
                    <?php
                    echo $default_measures[$j]['wall_out_thickness'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $default_measures[$j]['wall_in_thickness'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $default_measures[$j]['wall_middle_thickness'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $default_measures[$j]['windows_top'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $default_measures[$j]['foundation'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $default_measures[$j]['ceiling'];
                    ?>
                </td>
                <td>
                    <button id="modify_btn<?php echo $default_measures[$j]['ucm_id']; ?>" name="modify_btn<?php echo $default_measures[$j]['ucm_id']; ?>" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modifyModal<?php echo $default_measures[$j]['ucm_id']; ?>">Modify</button>
                </td>
                <!-- Modal -->
                <div class="modal fade" id="modifyModal<?php echo $default_measures[$j]['ucm_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel<?php echo $default_measures[$j]['ucm_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modifyModalLabel<?php echo $default_measures[$j]['ucm_id']; ?>">Modify measures for ucm_id <?php echo $default_measures[$j]['ucm_id']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        $measure=$prod->get_client_measure($default_measures[$j]['ucm_id']);
                        ?>
                        <div class="modal-body text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Default client</b>
                                </div>
                                <div class="col-md-6">

                                    <input type="hidden" id="mc_id<?php echo $default_measures[$j]['ucm_id']; ?>" name="mc_id<?php echo $default_measures[$j]['ucm_id']; ?>" value="0" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall height (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_height<?php echo $default_measures[$j]['ucm_id']; ?>" name="wall_height" value="<?php echo $measure['wall_height'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall out thickness (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_out_thickness<?php echo $default_measures[$j]['ucm_id']; ?>" name="wall_out_thickness" value="<?php echo $measure['wall_out_thickness'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall in thickness (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_in_thickness<?php echo $default_measures[$j]['ucm_id']; ?>" name="wall_in_thickness" value="<?php echo $measure['wall_in_thickness'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Wall middle thickness (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="wall_middle_thickness<?php echo $default_measures[$j]['ucm_id']; ?>" name="wall_middle_thickness" value="<?php echo $measure['wall_middle_thickness'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Windows top (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="windows_top<?php echo $default_measures[$j]['ucm_id']; ?>" name="windows_top" value="<?php echo $measure['windows_top'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Exterior doors top (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="ex_doors_top<?php echo $default_measures[$j]['ucm_id']; ?>" name="ex_doors_top" value="<?php echo $measure['ex_doors_top'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Interior doors top (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="in_doors_top<?php echo $default_measures[$j]['ucm_id']; ?>" name="in_doors_top" value="<?php echo $measure['in_doors_top'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Foundation (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="foundation<?php echo $default_measures[$j]['ucm_id']; ?>" name="foundation" value="<?php echo $measure['foundation'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <b>Ceiling (mm)</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="ceiling<?php echo $default_measures[$j]['ucm_id']; ?>" name="ceiling" value="<?php echo $measure['ceiling'];?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div id="client_measures_response<?php echo $default_measures[$j]['ucm_id']; ?>">
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="save_btn<?php echo $default_measures[$j]['ucm_id']; ?>" name="save_btn<?php echo $default_measures[$j]['ucm_id']; ?>" class="btn btn-sm btn-primary">Save</button>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('#save_btn<?php echo $default_measures[$j]['ucm_id']; ?>').click(function(){

                                    let ucm_id=<?php echo $default_measures[$j]['ucm_id']; ?>;
                                    let mc_id=$('#mc_id<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let wall_height=$('#wall_height<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let wall_out_thickness=$('#wall_out_thickness<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let wall_in_thickness=$('#wall_in_thickness<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let wall_middle_thickness=$('#wall_middle_thickness<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let windows_top=$('#windows_top<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let ex_doors_top=$('#ex_doors_top<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let in_doors_top=$('#in_doors_top<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let foundation=$('#foundation<?php echo $default_measures[$j]['ucm_id']; ?>').val();
                                    let ceiling=$('#ceiling<?php echo $default_measures[$j]['ucm_id']; ?>').val();

                                    $.ajax({
                                        url: "../ajax/update_client_measures.php",
                                        method: "post",
                                        data: {ucm_id:ucm_id,
                                        mc_id:mc_id,
                                        wall_height:wall_height,
                                        wall_out_thickness:wall_out_thickness,
                                        wall_in_thickness:wall_in_thickness,
                                        wall_middle_thickness:wall_middle_thickness,
                                        windows_top:windows_top,
                                        ex_doors_top:ex_doors_top,
                                        in_doors_top:in_doors_top,
                                        foundation:foundation,
                                        ceiling:ceiling
                                        },
                                        dataType:"html",
                                        success:function(data) {
                                            	
                                            $('#client_measures_response<?php echo $default_measures[$j]['ucm_id']; ?>').html(data);

                                            setTimeout(function(){$('#modifyModal<?php echo $default_measures[$j]['ucm_id']; ?>').modal('hide')},2000);
                                            
                                            
                                        }
                                    }).done(function () {
                                        setTimeout(function () {
                                            window.location = "client_administration/client_measures.php";
                                        }, 4000);
                                    });
                                    //setTimeout(function(){window.location = "client_administration/client_measures.php"},4000);

                                });
                            });
                        </script>
                        </div>
                    </div>
                </div>
            </tr>
            <?php
        }
        ?>
    </div>

    </div> <!-- end mytabcontent -->
    <?php
        
		} //end session
		else
		{
            session_unset();
            session_destroy();
			?>
			<div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				    <a href="<?php echo $base_url;?>login.php" class="btn btn-danger px-4 btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>login.php">
			<?php
		}
		?>
	</article>
</section>
<?php
include('footer.php');
?>