<?php
session_start();
include('../domenia_db3.php');
include('../functions.php');
$prod=new Production;
$domenia3=new Domenia3;

$page_title="Books";

include('../header2.php');
include('../menu.php');
?>
 <!-- </div> end main menu container -->
<div class="container-fluid">
<section class="top_section">	
		<article>
		
		<?php
		if(isset($_COOKIE['client_id']))
		{
			include('submenu.php');
			?>			
            <div class="row">
			<div class="col-md-3">
                <div class="border p-2 text-center shadow">
                    <form id="show_invoices_form" name="show_invoices_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
                    <select name="selected_trader" class="form-control form-control-sm mb-3">
                        <option value="0">--Choose Trader--</option>
                        <?php 
                        $selected_trader=$prod->xss_fix($_GET['selected_trader']);
                        $traders=$prod->show_all_licence_takers();

                        for($i=0;$i<count($traders);$i++)
                        {
                            $all_licences=$prod->get_licences($traders[$i]['lt_id']);

                        if(!empty($all_licences))
                        {
                        ?>
                        <option value="<?php echo $traders[$i]['lt_id']; ?>" <?php echo ($traders[$i]['lt_id']==$selected_trader)?"selected":""; ?>><?php 
                        
                            echo $traders[$i]['mailnick']." - "; 
                            
                            for($l=0;$l<count($all_licences);$l++)
                            {
                                echo $all_licences[$l]['lic_id'].";";
                            }?></option>
                        <?php
                        }
                        }
                        ?>
                    </select>
                    <br>
                    <select class="form-control form-control-sm" id="mc_id" name="mc_id">
                        <option value="0">--All main clients--</option>
                        <?php
                        $main_clients=$prod->get_all_main_clients();
                        for($i=0;$i<count($main_clients);$i++)
                        {
                        ?>
                        <option value="<?php echo $main_clients[$i]['mc_id'];?>" <?php echo ($main_clients[$i]['mc_id']==$_GET['mc_id'])?"selected":"";?>><?php echo $main_clients[$i]['clientname'];?></option>	
                        <?php
                        }
                        ?>
                    </select>
                    <br>
                    <p class="mb-0 text-left">Start date:</p>
                    <input class="form-control form-control-sm mb-3" id="invoice_start_date" name="invoice_start_date" type="text" value="<?php echo (isset($_GET['invoice_start_date']))?($_GET['invoice_start_date']):date("Y-m-01"); ?>" autocomplete="off">
                    <p class="text-left mb-0">End date:</p>
                    <input class="form-control form-control-sm mb-3" id="invoice_end_date" name="invoice_end_date" type="text" value="<?php echo (isset($_GET['invoice_end_date']))?($_GET['invoice_end_date']):date("Y-m-t"); ?>" autocomplete="off">
                    <button class="btn btn-sm btn-primary" id="show_btn" name="show_btn" type="submit">Show</button>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                        <?php
            if(isset($_GET['mc_id']))
            {
                $mc_id=$prod->xss_fix($_GET['mc_id']);
                if($mc_id==0)
                {
                    $main_clients=$prod->get_all_main_clients();

                    $invoice_start_date=$prod->xss_fix($_GET['invoice_start_date']);
                    $invoice_end_date=$prod->xss_fix($_GET['invoice_end_date']);

                    $selected_trader=$prod->xss_fix($_GET['selected_trader']);
                    
                    if($selected_trader!=0)
                    {
                    $trader=$prod->get_company($selected_trader);
                    $all_licences=$prod->get_licences($trader['lt_id']);
                    }

                    $counter=0;

                    for($i=0;$i<count($main_clients);$i++)
                    {

                        $cumulative_order=$prod->get_all_cumulative_orders($main_clients[$i]['mc_id'],$invoice_start_date,$invoice_end_date);

                        $total=0;

                        for($j=0;$j<count($cumulative_order);$j++)
                        {
                            if($selected_trader!=0)
                            {
                            for($l=0;$l<count($all_licences);$l++)
                            {
                                if($all_licences[$l]['lic_id']==$cumulative_order[$j]['lic_ID'])
                                {
                                    $total+=$cumulative_order[$j]['o_special_agreement_price'];
                                }
                            }
                            }
                            else
                            {
                                $total+=$cumulative_order[$j]['o_special_agreement_price'];
                            }
                            
                        }
                        $total_general[$counter]['sum']=$total;

                        $licence=$prod->get_licence($cumulative_order[0]['lic_ID']);
                        $total_general[$counter]['currency']=$prod->get_currency($licence['currencies'])['cur_short'];
                        $counter++;
                    }
                    ?>
                    <b>Total: <?php 
                    $sumsByCurrency=array();                   

                    for($t=0;$t<count($total_general);$t++)
                    {
                        if($total_general[$t]['currency']=="EUR")
                        {
                            $sumsByCurrency['EUR']+=$total_general[$t]['sum'];
                        }
                        elseif($total_general[$t]['currency']=="MDL")
                        {
                            $sumsByCurrency['MDL']+=$total_general[$t]['sum'];
                        }
                    }
                    foreach($sumsByCurrency as $key=>$value)
                    {
                        echo $value." ".$key.", ";
                    }
                    ?></b>
                    <?php
                }
                else
                {
                    $invoice_start_date=$prod->xss_fix($_GET['invoice_start_date']);
                    $invoice_end_date=$prod->xss_fix($_GET['invoice_end_date']);

                    $selected_trader=$prod->xss_fix($_GET['selected_trader']);
                    
                    if($selected_trader!=0)
                    {
                    $trader=$prod->get_company($selected_trader);
                    $all_licences=$prod->get_licences($trader['lt_id']);
                    }

                    $cumulative_order=$prod->get_all_cumulative_orders($mc_id,$invoice_start_date,$invoice_end_date);

                    $total=0;

                    for($j=0;$j<count($cumulative_order);$j++)
                    {
                        if($selected_trader!=0)
                        {
                        for($l=0;$l<count($all_licences);$l++)
                        {
                            if($all_licences[$l]['lic_id']==$cumulative_order[$j]['lic_ID'])
                            {
                                $total+=$cumulative_order[$j]['o_special_agreement_price'];
                            }
                        }
                        }
                        else
                        {
                            $total+=$cumulative_order[$j]['o_special_agreement_price'];
                        }                        
                    }
                    $total_general[0]['sum']=$total;
                    $licence=$prod->get_licence($cumulative_order[0]['lic_ID']);
                    $total_general[0]['currency']=$prod->get_currency($licence['currencies'])['cur_short'];
                    
                    ?>
                    <b>Total: <?php 
                    $sumsByCurrency=array();                   

                    for($t=0;$t<count($total_general);$t++)
                    {
                        if($total_general[$t]['currency']=="EUR")
                        {
                            $sumsByCurrency['EUR']+=$total_general[$t]['sum'];
                        }
                        elseif($total_general[$t]['currency']=="MDL")
                        {
                            $sumsByCurrency['MDL']+=$total_general[$t]['sum'];
                        }
                    }
                    foreach($sumsByCurrency as $key=>$value)
                    {
                        echo $value." ".$key.", ";
                    }?></b>
                    <?php
                }
            }
            ?>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $('#invoice_start_date').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "yy-mm-dd"
                                
                            });

                        $('#invoice_end_date').datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "yy-mm-dd"
                                
                            });
                    </script>
                </div><!-- end border -->
            </div><!-- end col-md-3 -->
            <div class="col-md-8">
            <?php
            if(isset($_GET['mc_id']))
            {
                $mc_id=$prod->xss_fix($_GET['mc_id']);
                ?>
                <table class="table table-sm table-bordered table-striped" id="all_mc_invoices">
                    <thead>
                        <tr>
                            <th>Main Client</th>
                            <th>Total</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($mc_id==0)
                    {
                        $main_clients=$prod->get_all_main_clients();

                        $invoice_start_date=$prod->xss_fix($_GET['invoice_start_date']);
                        $invoice_end_date=$prod->xss_fix($_GET['invoice_end_date']);

                        $selected_trader=$prod->xss_fix($_GET['selected_trader']);

                        if($selected_trader!=0)
                        {
                        $trader=$prod->get_company($selected_trader);
                        $all_licences=$prod->get_licences($trader['lt_id']);
                        }

                        for($i=0;$i<count($main_clients);$i++)
                        {

                            $cumulative_order=$prod->get_all_cumulative_orders($main_clients[$i]['mc_id'],$invoice_start_date,$invoice_end_date);

                            $total=0;

                            for($j=0;$j<count($cumulative_order);$j++)
                            {
                                if($selected_trader!=0)
                                {
                                for($l=0;$l<count($all_licences);$l++)
                                {
                                    if($all_licences[$l]['lic_id']==$cumulative_order[$j]['lic_ID'])
                                    {
                                        $total+=$cumulative_order[$j]['o_special_agreement_price'];
                                    }
                                }
                                }
                                else
                                {
                                    $total+=$cumulative_order[$j]['o_special_agreement_price'];
                                }
                                
                            }
                            ?>
                            <tr>
                                <td><?php echo $main_clients[$i]['clientname'];?></td>
                                <td><?php echo $total;
                                
                                $licence=$prod->get_licence($cumulative_order[0]['lic_ID']);
                                echo " ".$currency=$prod->get_currency($licence['currencies'])['cur_short'];
                                ?></td>                            
                                <td><a href="invoice_template.php?option=create&type=cumulative_invoice&main_client=<?php 
                                echo $main_clients[$i]['mc_id'];
                                ?>&invoice_start_date=<?php 
                                echo $invoice_start_date;?>&invoice_end_date=<?php 
                                echo $invoice_end_date;?>&licenceid=<?php 
                                echo $cumulative_order[0]['lic_ID'];
                                ?>&language[]=49&preview_invoice_btn=" class="btn btn-sm btn-primary" target="_blank">Preview invoice</a></td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        $invoice_start_date=$prod->xss_fix($_GET['invoice_start_date']);
                        $invoice_end_date=$prod->xss_fix($_GET['invoice_end_date']);

                        $cumulative_order=$prod->get_all_cumulative_orders($mc_id,$invoice_start_date,$invoice_end_date);

                        $selected_trader=$prod->xss_fix($_GET['selected_trader']);

                        if($selected_trader!=0)
                        {
                        $trader=$prod->get_company($selected_trader);
                        $all_licences=$prod->get_licences($trader['lt_id']);
                        }

                        $total=0;

                        for($j=0;$j<count($cumulative_order);$j++)
                        {
                            if($selected_trader!=0)
                            {
                            for($l=0;$l<count($all_licences);$l++)
                            {
                                if($all_licences[$l]['lic_id']==$cumulative_order[$j]['lic_ID'])
                                {
                                    $total+=$cumulative_order[$j]['o_special_agreement_price'];
                                }
                            }
                            }
                            else
                            {
                                $total+=$cumulative_order[$j]['o_special_agreement_price'];
                            }
                            
                        }
                        ?>
                        <tr>
                            <td><?php 
                            $main_clients=$prod->get_main_client($mc_id);

                            echo $main_clients['clientname'];?></td>
                            <td><?php echo $total;
                            $licence=$prod->get_licence($cumulative_order[0]['lic_ID']);
                            echo " ".$currency=$prod->get_currency($licence['currencies'])['cur_short'];
                            ?></td>                            
                            <td><a href="invoice_template.php?option=create&type=cumulative_invoice&main_client=<?php 
                                echo $mc_id;
                                ?>&invoice_start_date=<?php 
                                echo $invoice_start_date;?>&invoice_end_date=<?php 
                                echo $invoice_end_date;?>&licenceid=<?php 
                                echo $cumulative_order[0]['lic_ID'];
                                ?>&language[]=49&preview_invoice_btn=" class="btn btn-sm btn-primary" target="_blank">Preview invoice</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#all_mc_invoices').DataTable({
                        "lengthMenu": [[50, -1], [50, "All"]],
                        "order": [[ 1, "desc" ]]
                    });
                });
                </script>
                <?php
            }
            ?>
            </div><!-- end col-md-8 -->	
            </div> <!-- end row -->
			<?php
		}
		else
		{
			?>
			<div class="text-center">
				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
			<?php
		}
		?>
		</article>
		
</section>
</div> <!-- end container fluid -->

<?php include('../footer.php'); ?>