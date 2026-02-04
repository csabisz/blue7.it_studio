<?php
session_start();

include("../functions.php");

$prod=new Production;
$_COOKIE['start']=gmdate("Y-m-d H:i:s");

$page_title="Coordination";

include("../headerCoordination3.php");
include('../menu.php');

$client=$prod->get_client($_COOKIE['client_id']);

$licence_sites=explode(";",$client['ls_ids']);

$licences=$prod->get_licences($_COOKIE['lt_id']);

if(isset($_GET['on_stock']))
{
    $on_stock=$prod->xss_fix($_GET['on_stock']);
}
else
{
    $on_stock=0;
}

if(isset($_GET['materials_orders']))
{
    $materials_orders=$prod->xss_fix($_GET['materials_orders']);
}
else
{
    $materials_orders=0;
}

?>

<div id="coordination" class="page-content top_section">
    <div class="container-fluid px-0" style="background: #000000;">
       <?php
        if(isset($_COOKIE['client_id'])&&($_COOKIE['start']<$_COOKIE['expire']))
        {
            if ($_COOKIE['coordination'] > 0) 
            {
       ?>
    <div class="row w-100 mx-0 py-2">
        <div class="col-md-2 d-flex align-items-center justify-content-center">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?on_stock=0" class="btn btn-sm btn-primary">Orders in progress (<?php 
        if($_COOKIE['view_all_orders']==1)
        {
            $orders_in_progress=$prod->show_unfinished_orders_by_on_stock(0);
            echo count($orders_in_progress);
        }
        else
        {
            //$orders_in_progress=$prod->show_unfinished_orders_by_ls_id_on_stock($licence_sites[0],$on_stock=0);
            $lic_ids_array=array();

            for($l=0;$l<count($licences);$l++)
            {
                $lic_ids_array[]=$licences[$l]['lic_id'];
            }
            //print_r($lic_ids_array);
            $orders_in_progress=$prod->show_unfinished_orders_by_lic_ids_on_stock($lic_ids_array,$on_stock=0);
            echo count($orders_in_progress);
        }
        ?>)</a>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="row w-100 mx-0">
            <div class="col-4 d-flex align-items-center">
                <h4 class="text-center w-100 mb-0 text-white">Coordination</h4>
            </div>
            <div class="col-6 px-0">
                <form name="search_from" id="search_from" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-inline w-100">
                    <div class="col-xl-8 col-12 col-md-4 d-flex justify-content-center align-items-center flex-row pr-2 py-1">
                        <p class="mx-2 text-dark mb-0 text-left w-75">
                            <strong class="text-white">Search for</strong>      
                        </p>
                        <select name="search_option" class="form-control form-control-sm">
                            <option value="o_id">Order ID:</option> 
                            <option value="c_last_name">Client Last Name:</option>
                            <option value="order_name">Order Name:</option>
                            <option value="plot_id">Plot ID:</option> 
                        </select>
                    </div>
                    <div class="col-xl-4 col-8 col-md-4 d-flex align-items-center px-0">
                        <div class="input-group">
                            <input type="text" class="form-control-sm form-control" name="search" value="">
                            <div class="input-group-append" onclick="document.getElementById('search_from').submit();">
                                <span class="input-group-text"><i class="fas fa-search" ></i></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <div class="col-md-1 d-flex justify-content-center align-items-center px-0">
            <?php
                if(isset($_GET['page']))
                {
                    $page=$prod->xss_fix($_GET['page']);
                }
                else
                {
                    $page=1;
                }

                $limit=10;
                $startpoint=($page*$limit)-$limit;

                $allstatus=$prod->showallstatus();

                //getting finished orders to make pagination on top

                if($_COOKIE['view_all_orders']==1)
                {
                    $fin_orders=$prod->show_finished_orders_by_on_stock($on_stock,$startpoint,$limit);
                }
                else
                {

                $lic_ids_array=array();

                for($l=0;$l<count($licences);$l++)
                {
                    $lic_ids_array[]=$licences[$l]['lic_id'];
                }

                $fin_orders=$prod->show_finished_orders_by_lic_ids_on_stock($lic_ids_array,$startpoint,$limit,$on_stock);
                }

                $pages=count($fin_orders);

            ?>
            <ul class="pagination mb-0">
                <?php
                if($page>1)
                {
                ?>
                <li class="page-item"><a class="page-link text-secondary" href="<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo $page-1;?>"><<</a></li>
                <?php
                }
                ?>
                <li class="page-item"><a class="page-link text-white bg-dark" href="#"><?php echo $page;?></a></li>
                <!--<li class="page-item"><a class="page-link text-secondary" href="#">2</a></li>
                <li class="page-item"><a class="page-link text-secondary" href="#">3</a></li> -->
                <?php
                if($pages>0)
                {
                ?>
                <li class="page-item"><a class="page-link text-secondary" href="<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo $page+1;?>">>></a></li>
                <?php
                }
                ?>
            </ul>
        </div>

        <div class="col-md-1 d-flex align-items-center justify-content-center">
            <a href="<?php echo $_SERVER['PHP_SELF'];?>?on_stock=1" class="btn btn-sm btn-primary">Orders on stock (<?php 
            if($_COOKIE['view_all_orders']==1)
            {
                $orders_in_progress=$prod->show_unfinished_orders_by_on_stock(1);
                echo count($orders_in_progress);
            }
            else
            {
                //$orders_in_progress=$prod->show_unfinished_orders_by_ls_id_on_stock($licence_sites[0],$on_stock=1);
                $lic_ids_array=array();

                for($l=0;$l<count($licences);$l++)
                {
                    $lic_ids_array[]=$licences[$l]['lic_id'];
                }
                //print_r($lic_ids_array);
                $orders_in_progress=$prod->show_unfinished_orders_by_lic_ids_on_stock($lic_ids_array,1);
                echo count($orders_in_progress);
            }
            ?>)</a>
        </div>
        <div class="col-md-1 d-flex align-items-center justify-content-center">
            <a href="<?php echo $_SERVER['PHP_SELF'];?>?materials_orders=1" class="btn btn-sm btn-primary">Materials orders (<?php 
            $materials_orders_in_progress=$prod->show_unfinished_materials_orders(1);
            echo count($materials_orders_in_progress);
            ?>)</a>
        </div>
    </div>
        
        
        <div class="projects">
            
            <!-- <div class="row mx-0 w-100 d-flex justify-content-center mb-4 pb-4 mt-=2"> -->
            <?php
if(isset($_GET['page']))
{
    $page=$prod->xss_fix($_GET['page']);
}
else
{
    $page=1;
}

if(isset($_GET['on_stock']))
{
    $on_stock=$prod->xss_fix($_GET['on_stock']);
}
else
{
    $on_stock=0;
}

$limit=10;
if($page>1)
{
    $startpoint=(($page-1)*$limit)-$limit;
}
else
{
    $startpoint=($page*$limit)-$limit;
}

$allstatus=$prod->showallstatus();

//getting finished orders to make pagination on top

if($_COOKIE['view_all_orders']==1)
{
    $fin_orders=$prod->show_finished_orders_by_on_stock($on_stock,$startpoint,$limit);
}
else
{

$lic_ids_array=array();

for($l=0;$l<count($licences);$l++)
{
    $lic_ids_array[]=$licences[$l]['lic_id'];
}

$fin_orders=$prod->show_finished_orders_by_lic_ids_on_stock($lic_ids_array,$startpoint,$limit,$on_stock);
}

$pages=count($fin_orders);

?>          <div class="row w-100 mx-0 px-0">
                <hr class="mt-0" style="border: 2px solid #fff; width: 100%;">
            </div>
            <!-- </div>-->
            <?php
            if(isset($_GET['search']))
            {
                include('coordination_search_orders.php');
            }
            else
            {
                if($page<2)
                {
                    ?>
                    <div id="unfinished_orders">
                    </div>
                    <div id="loading_spinner" class="d-none">
                        <img src="https://blue7.it/studio/img/loading.gif" style="width:100px;height:100px;" alt="Loading...">
                    </div>
                    <script type="text/javascript">
                        let start = 0;
                        let limit = 5;
                        let loading = false;

                        function loadPosts() {
                            if (loading) return;

                            loading = true;
                            $('#loading_spinner').removeClass('d-none');

                            $.ajax({
                                url: 'unfinished_new.php',
                                method: 'GET',
                                data: {
                                    start: start,
                                    limit: limit
                                },
                                success: function (data) 
                                {
                                    
                                }
                            }).done(function(data) {

                                if (data.trim() === '') 
                                {
                                    $(window).off('scroll'); // no more records
                                    $('#loading_spinner').text('No more posts');
                                    return;
                                }

                                $('#unfinished_orders').append(data);
                                start += limit;
                                loading = false;
                                $('#loading_spinner').addClass('d-none');
                            });
                        }

                        // initial load
                        loadPosts();

                        // detect scroll
                        $(window).scroll(function () {
                            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                                loadPosts();
                            }
                        });
                        </script>
                    <?php
                }
                if($page>1)
                {
                    include('finished.php');
                }
            }
           
            ?>
           
        
        <a id="back2Top" title="Back to top" href="#home">&#10148;</a>
        </div>
        <div class="row mx-0 w-100 d-flex justify-content-center mb-4 pb-4 mt-=2">
            <ul class="pagination">
                <?php
                if($page>1)
                {
                ?>
                <li class="page-item"><a class="page-link text-secondary" href="<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo $page-1;?>"><<</a></li>
                <?php
                }
                ?>
                <li class="page-item"><a class="page-link text-white bg-dark" href="#"><?php echo $page;?></a></li>
                <!--<li class="page-item"><a class="page-link text-secondary" href="#">2</a></li>
                <li class="page-item"><a class="page-link text-secondary" href="#">3</a></li> -->
                <?php
                if($pages>0)
                {
                ?>
                <li class="page-item"><a class="page-link text-secondary" href="<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo $page+1;?>">>></a></li>
                <?php
                }
                ?>
            </ul>
        </div>
        <?php
        }
		else
		{
			?>
			<div class="text-center">				
			<div class="alert alert-danger">Access denied !</div>
			<a href="<?php echo $base_url;?>own_tasks.php" class="btn btn-danger btn-sm">Go to Own tasks</a>
			<br><br>
			</div>
		<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>own_tasks.php">
		<?php
		}

        }
        else
        {
            session_unset();
            session_destroy();
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
        <div class="text-center">				
				<div class="alert alert-danger">You must be logged in to view this page !</div>
				<a href="<?php echo $base_url;?>index.php" class="btn btn-danger btn-sm">Login</a>
				<br><br>
			</div>
			<meta http-equiv="refresh" content="3; url=<?php echo $base_url;?>index.php">
        <?php
        }
?>
    </div>
</div>

<?php include("../footer.php");?>