<?php
include("../functions.php");
$prod=new Production;

$o_id=$prod->xss_fix($_GET['o_id']);
$osub_id=$prod->xss_fix($_GET['osub_id']);
$prod_id=$prod->xss_fix($_GET['prod_id']);

$order=$prod->get_order($o_id);

//variables to check creators next day

$month=date("m");
$year=date("Y");
$day=date("d");
$today=$prod->get_day_name($year,$month,$day);

$nr_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$nextday=$day+1;

if($nextday>$nr_days_in_month)
{
    $nextday=1;$month++;
}
?>
<option value="">-- Choose creator --</option>
<?php
$all_creators=$prod->show_creators($order['u_prod_id']);
$all_other_creators=$prod->show_creators_other_companies($order['u_prod_id']);

//showing first producer creators

for($i=0;$i<count($all_creators);$i++)
{
    $creator_qualification=$prod->get_client_qualifications($all_creators[$i]['client_ID']);
    $creator_right=$prod->get_client_rights($all_creators[$i]['client_ID']);
    
    //checking if user is active

    if($creator_right['u_status']=="active")
    {
        //creators end time
        $endtime=$prod->get_creator_end_time($all_creators[$i]['client_ID']);

        if($prod_id=="p1800")
        {
            if($creator_qualification['b8_walls']>0)
            {
    ?>
        <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_creators[$i]['client_ID'],$month,$year);                   
            
            // 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                
            }
            else
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
            }
            ?>"><?php 
        if(!empty($all_creators[$i]['c_last_name']))
        {
            echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b8_walls'].")";
        }
        else
        {
            echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b8_walls'].")";
        }?> </option>
    <?php
            }
        }	

        if($prod_id=="p1801")
        {
            if(($creator_qualification['b8_walls']>0)&&($creator_qualification['b8_windows_doors']>0))
            {
    ?>
        <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_creators[$i]['client_ID'],$month,$year);                   
            
            // 00:00 and 22:00 (UTC time) default for No shift
           
            if($today=="Saturday")
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                
            }
            else
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
            }
            ?>"><?php 
        if(!empty($all_creators[$i]['c_last_name']))
        {
            echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b8_walls'].")(".$creator_qualification['b8_windows_doors'].")";
        }
        else
        {
            echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b8_walls'].")(".$creator_qualification['b8_windows_doors'].")";
        }?> </option>
    <?php
            }
        }		
        
        


        if($creator_right['u_status']=="active")
        {
            if(($prod_id=="p1821")||($prod_id=="p1841"))
            {
                if($creator_qualification['b8_furniture']>0)
                {
        ?>
            <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_creators[$i]['client_ID'],$month,$year);                   
            
            // 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                
            }
            else
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
            }
            ?>"><?php
            if(!empty($all_creators[$i]['c_last_name'])) 
            {
                echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b8_furniture'].")";
            }
            else
            {
                echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b8_furniture'].")";
            }?> </option>
        <?php
                }
            }												
        }

        if(((substr($prod_id,1)>1801)&&(substr($prod_id,1)<1806))||((substr($prod_id,1)>1821)&&(substr($prod_id,1)<1826))||((substr($prod_id,1)>1841)&&(substr($prod_id,1)<1846)))
        {
            if($creator_qualification['b8_render_stills']>0)
            {
    ?>
        <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_creators[$i]['client_ID'],$month,$year);                   
            
            // 00:00 and 22:00 (UTC time) default for No shift
           
            if($today=="Saturday")
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                
            }
            else
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
            }
            ?>"><?php 
        if(!empty($all_creators[$i]['c_last_name']))
        {
            echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b8_render_stills'].")";
        }
        else
        {
            echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b8_render_stills'].")";
        }?> <?php 
        
        ?></option>
    <?php
            }
        }


        if(($prod_id=="p1806")||($prod_id=="p1826")||($prod_id=="p1846"))
        {
            if($creator_qualification['b8_render_360']>0)
            {
    ?>
        <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_creators[$i]['client_ID'],$month,$year);                   
            
            // 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                
            }
            else
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
            }
            ?>"><?php 
        if(!empty($all_creators[$i]['c_last_name']))
        {
            echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b8_render_360'].")";
        }
        else
        {
            echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b8_render_360'].")";
        }?> <?php 
        
        ?></option>
    <?php
            }
        }

        if(($prod_id=="p1807")||($prod_id=="p1827")||($prod_id=="p1847"))
        {
            if($creator_qualification['b8_render_slideshow']>0)
            {
    ?>
        <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_creators[$i]['client_ID'],$month,$year);                   
            
            // 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                
            }
            else
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
            }
            ?>"><?php 
        if(!empty($all_creators[$i]['c_last_name']))
        {
            echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b8_render_slideshow'].")";
        }
        else
        {
            echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b8_render_slideshow'].")";
        }?> </option>
    <?php
            }
        }


        if(($prod_id=="p1808")||($prod_id=="p1828")||($prod_id=="p1848"))
        {
            if($creator_qualification['b8_render_movie']>0)
            {
    ?>
        <option id="creator_<?php echo $all_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_creators[$i]['client_ID'],$month,$year);                   
            
            // 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
                    {
                        echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                
            }
            else
            {
                if($nextday<10)
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
                else
                {
                    if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
                    {
                        echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
                    }
                    else
                    {
                        echo "No shift";
                    }
                }
            }
            ?>"><?php 
        if(!empty($all_creators[$i]['c_last_name']))
        {
            echo $all_creators[$i]['c_first_name']." ".$all_creators[$i]['c_last_name']." (".$creator_qualification['b8_render_movie'].")";
        }
        else
        {
            echo $all_creators[$i]['l_first_name']." ".$all_creators[$i]['l_last_name']." (".$creator_qualification['b8_render_movie'].")";
        }?> </option>
    <?php
            }
        }

    }
}

$other_resources_counter=0;

//showing other company creators

for($i=0;$i<count($all_other_creators);$i++)
{
    $creator_qualification=$prod->get_client_qualifications($all_other_creators[$i]['client_ID']);
    $creator_right=$prod->get_client_rights($all_other_creators[$i]['client_ID']);
    
    //checking if user is active

    if($creator_right['u_status']=="active")
    {
        //creators end time
        $endtime=$prod->get_creator_end_time($all_other_creators[$i]['client_ID']);

        if($prod_id=="p1800")
        {														
            if($creator_qualification['b8_walls']>0)
            {	
                if($other_resources_counter==0)
                {
                    ?>
                    <option style="color:red;">Resources from other companies</option>
                    <?php
                    $other_resources_counter++;
                }
    ?>
        <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_other_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_other_creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
            ?>"><?php 
        if(!empty($all_other_creators[$i]['c_last_name']))
        {
            echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_walls'].")";
        }
        else
        {
            echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_walls'].")";
        }?> </option>
    <?php
            }
        }	

        if($prod_id=="p1801")
        {														
            if(($creator_qualification['b8_walls']>0)&&($creator_qualification['b8_windows_doors']>0))
            {	
                if($other_resources_counter==0)
                {
                    ?>
                    <option style="color:red;">Resources from other companies</option>
                    <?php
                    $other_resources_counter++;
                }
    ?>
        <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_other_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_other_creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
            ?>"><?php 
        if(!empty($all_other_creators[$i]['c_last_name']))
        {
            echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_walls'].")(".$creator_qualification['b8_windows_doors'].")";
        }
        else
        {
            echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_walls'].")(".$creator_qualification['b8_windows_doors'].")";
        }?> <?php 
        
        ?></option>
    <?php
            }
        }	
        
        
        if(($prod_id=="p1821")||($prod_id=="p1841"))
        {														
            if($creator_qualification['b8_furniture']>0)
            {	
                if($other_resources_counter==0)
                {
                    ?>
                    <option style="color:red;">Resources from other companies</option>
                    <?php
                    $other_resources_counter++;
                }
    ?>
        <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_other_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_other_creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
            ?>"><?php 
        if(!empty($all_other_creators[$i]['c_last_name']))
        {
            echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_furniture'].")";
        }
        else
        {
            echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_furniture'].")";
        }?> </option>
    <?php
            }
        }

        if(((substr($prod_id,1)>1801)&&(substr($prod_id,1)<1806))||((substr($prod_id,1)>1821)&&(substr($prod_id,1)<1826))||((substr($prod_id,1)>1841)&&(substr($prod_id,1)<1846)))
        {														
            if($creator_qualification['b8_render_stills']>0)
            {	
                if($other_resources_counter==0)
                {
                    ?>
                    <option style="color:red;">Resources from other companies</option>
                    <?php
                    $other_resources_counter++;
                }
    ?>
        <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_other_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_other_creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
            ?>"><?php 
        if(!empty($all_other_creators[$i]['c_last_name']))
        {
            echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_stills'].")";
        }
        else
        {
            echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_stills'].")";
        }?> </option>
    <?php
            }
        }

        if(($prod_id=="p1806")||($prod_id=="p1826")||($prod_id=="p1846"))
        {														
            if($creator_qualification['b8_render_360']>0)
            {	
                if($other_resources_counter==0)
                {
                    ?>
                    <option style="color:red;">Resources from other companies</option>
                    <?php
                    $other_resources_counter++;
                }
    ?>
        <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_other_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_other_creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
            ?>"><?php 
        if(!empty($all_other_creators[$i]['c_last_name']))
        {
            echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_360'].")";
        }
        else
        {
            echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_360'].")";
        }?> </option>
    <?php
            }
        }

        if(($prod_id=="p1807")||($prod_id=="p1827")||($b5_in_prods[$k]['prod_id']=="p1847"))
        {														
            if($creator_qualification['b8_render_slideshow']>0)
            {	
                if($other_resources_counter==0)
                {
                    ?>
                    <option style="color:red;">Resources from other companies</option>
                    <?php
                    $other_resources_counter++;
                }
    ?>
        <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_other_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_other_creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
            ?>"><?php 
        if(!empty($all_other_creators[$i]['c_last_name']))
        {
            echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_slideshow'].")";
        }
        else
        {
            echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_slideshow'].")";
        }?> <?php 
        
        ?></option>
    <?php
            }
        }

        if(($prod_id=="p1808")||($prod_id=="p1828")||($b5_in_prods[$k]['prod_id']=="p1848"))
        {														
            if($creator_qualification['b8_render_movie']>0)
            {	
                if($other_resources_counter==0)
                {
                    ?>
                    <option style="color:red;">Resources from other companies</option>
                    <?php
                    $other_resources_counter++;
                }
    ?>
        <option id="creator_<?php echo $all_other_creators[$i]['client_ID']; ?>" class="offline" value="<?php echo $all_other_creators[$i]['client_ID'];?>" data-creator_end_time="<?php echo $endtime['end_time'];?>" data-creator_start_time="<?php 
            
            //showing creator's next day 
            $nextday_start=$prod->get_uca_program($all_other_creators[$i]['client_ID'],$month,$year);
			
			// 00:00 and 22:00 (UTC time) default for No shift
            
            if($today=="Saturday")
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-0".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.($nextday+1)]!="00:00")&&($nextday_start['work_start_time'.($nextday+1)]!="22:00")&&(!empty($nextday_start['work_start_time'.($nextday+1)])))
					{
						echo $year."-".$month."-".($nextday+1)." ".$nextday_start['work_start_time'.($nextday+1)];
					}
					else
					{
						echo "No shift";
					}
				}
				
			}
			else
			{
				if($nextday<10)
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-0".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
				else
				{
					if(($nextday_start['work_start_time'.$nextday]!="00:00")&&($nextday_start['work_start_time'.$nextday]!="22:00")&&(!empty($nextday_start['work_start_time'.$nextday])))
					{
						echo $year."-".$month."-".$nextday." ".$nextday_start['work_start_time'.$nextday];
					}
					else
					{
						echo "No shift";
					}
				}
			}
            ?>"><?php 
        if(!empty($all_other_creators[$i]['c_last_name']))
        {
            echo $all_other_creators[$i]['c_first_name']." ".$all_other_creators[$i]['c_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_movie'].")";
        }
        else
        {
            echo $all_other_creators[$i]['l_first_name']." ".$all_other_creators[$i]['l_last_name']." - ".$prod->get_company($all_other_creators[$i]['lt_id'])['mailnick']." (".$creator_qualification['b8_render_movie'].")";
        }?> <?php 
        
        ?></option>
    <?php
            }
        }
    }
}
?>