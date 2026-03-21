<?php

include('/home/adminhdd/domains/cseven.eu/public_html/studio/functions.php');

$prod=new Production;





$creators=array();

$other_creators=array();



$selected_producer=3;



$creators=$prod->show_creators($selected_producer);

$other_creators=$prod->show_creators_other_companies($selected_producer);



// $users_start_date=date("Y-m-d",strtotime('first day of last month'));

// $users_end_date=date("Y-m-d",strtotime('last day of last month'));

$today=date("Y-m-d");



$start_d = new DateTime($today);

$start_d->modify( 'first day of - 1 month' );

$users_start_date = $start_d->format( 'Y-m-d' );



$end_d = new DateTime($today);

$end_d->modify( 'last day of - 1 month' );

$users_end_date = $end_d->format( 'Y-m-d' );



$html="";



$html .="<div style=\"text-align:center\">";

$html .="<h2>Total labcs/APUS for all creators between ".$users_start_date." and ".$users_end_date." generated on ".$today."</h2>";

$html .="</div>";



$html .="<table border=\"1\">";

$html .="<tr>";

$html .="<th>Creator name</th>";

$html .="<th>Total labc</th>";

$html .="<th>Total APUs</th>";

$html .="</tr>";



for($i=0;$i<count($creators);$i++)

{

    $licence_taker=$prod->get_company($creators[$i]['lt_id']);



    



    $html .="<tr>";

    $html .="<td>";



    if(!empty($creators[$i]['c_last_name']))

    {

        $html .=$creators[$i]['c_first_name']." ".$creators[$i]['c_last_name']." - ".$licence_taker['mailnick'];

    }

    else

    {

        $html .=$creators[$i]['l_first_name']." ".$creators[$i]['l_last_name']." - ".$licence_taker['mailnick'];

    }



    $html .="</td>";

    $html .="<td>";



        $user_products=$prod->get_user_products_by_date($creators[$i]['client_ID'],$users_start_date,$users_end_date);



        $total_apus=array();

        $total_labc=array();

    

        $general_total_labcs[]=array();

        $general_total_apus[]=array();



        for($j=0;$j<count($user_products);$j++)

        {



            $order=$prod->get_order($user_products[$j]['o_id']);

    

            if((substr($user_products[$j]['prod_id'],1)>1300)&&(substr($user_products[$j]['prod_id'],1)<1360))

            {

                //calculating b3 interior labc



                $o_desc_in_b3=$prod->get_o_desc_in_b3($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                if($user_products[$j]['prod_id']=="p1301")

                {

                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductlabc,1,2);

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1302")

                {

                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductlabc,1,2);

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1321")

                {

                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductlabc,1,2);

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1322")

                {

                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductlabc,1,2);

                    $total_labc[]=$labc;

                }

                else

                {

                    $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $thisproductlabc,1,2);    

                    $total_labc[]=$labc;

                }

            }

    

            if((substr($user_products[$j]['prod_id'],1)>1499)&&(substr($user_products[$j]['prod_id'],1)<1560))

            {

                //calculating b5 interior labc



                $o_desc_in_b5=$prod->get_o_desc_in_b5($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

    

                if($user_products[$j]['prod_id']=="p1501")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1504")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1521")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1524")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1541")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1544")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1506")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;        

                }

                elseif($user_products[$j]['prod_id']=="p1526")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;   

                }

                elseif($user_products[$j]['prod_id']=="p1546")

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;            

                }

                else

                {

                    $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;                        

                }

                

            }

            

            if((substr($user_products[$j]['prod_id'],1)>1599)&&(substr($user_products[$j]['prod_id'],1)<1660))

            {

                //calculating b6 interior labc



                $o_desc_in_b6=$prod->get_o_desc_in_b6($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

                

                if($user_products[$j]['prod_id']=="p1600")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1601")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1604")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1621")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1624")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1641")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1644")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1606")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;        

                }

                elseif($user_products[$j]['prod_id']=="p1626")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;   

                }

                elseif($user_products[$j]['prod_id']=="p1646")

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;            

                }

                else

                {

                    $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;                        

                }

            }

    

            if((substr($user_products[$j]['prod_id'],1)>1699)&&(substr($user_products[$j]['prod_id'],1)<1760))

            {

                //calculating b7 interior labc



                $o_desc_in_b7=$prod->get_o_desc_in_b7($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

    

                if($user_products[$j]['prod_id']=="p1700")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1701")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1704")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1721")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1724")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1741")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1744")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1706")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;        

                }

                elseif($user_products[$j]['prod_id']=="p1726")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;   

                }

                elseif($user_products[$j]['prod_id']=="p1746")

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;            

                }

                else

                {

                    $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;                        

                }

                

            }

    

            if((substr($user_products[$j]['prod_id'],1)>1799)&&(substr($user_products[$j]['prod_id'],1)<1860))

            {

                //calculating b8 interior labc



                $o_desc_in_b8=$prod->get_o_desc_in_b8($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

    

                if($user_products[$j]['prod_id']=="p1800")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1801")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1804")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;

                }

                elseif($user_products[$j]['prod_id']=="p1821")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1824")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductlabc,1,2);  

    

                    $total_labc[]=$labc; 

                }

                elseif($user_products[$j]['prod_id']=="p1841")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1844")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductlabc,1,2); 

    

                    $total_labc[]=$labc;    

                }

                elseif($user_products[$j]['prod_id']=="p1806")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;        

                }

                elseif($user_products[$j]['prod_id']=="p1826")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;   

                }

                elseif($user_products[$j]['prod_id']=="p1846")

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;            

                }

                else

                {

                    $labc=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;                        

                }

                

            }



            if((substr($user_products[$j]['prod_id'],1)>1559)&&(substr($user_products[$j]['prod_id'],1)<1590))

            {

                //calculating b5 exterior labc



                $o_desc_ex_b5=$prod->get_o_desc_ex_b5($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

    

                if($user_products[$j]['prod_id']=="p1561")

                {

                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1563")

                {

                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1566")

                {

                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

                else

                {

                    $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

            }

    

            if((substr($user_products[$j]['prod_id'],1)>1659)&&(substr($user_products[$j]['prod_id'],1)<1690))

            {

                //calculating b6 exterior labc



                $o_desc_ex_b6=$prod->get_o_desc_ex_b6($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

    

                if($user_products[$j]['prod_id']=="p1661")

                {

                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1663")

                {

                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1666")

                {

                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

                else

                {

                    $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

            }

    

            if((substr($user_products[$j]['prod_id'],1)>1759)&&(substr($user_products[$j]['prod_id'],1)<1790))

            {

                //calculating b7 exterior labcs



                $o_desc_ex_b7=$prod->get_o_desc_ex_b7($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

    

                if($user_products[$j]['prod_id']=="p1761")

                {

                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1763")

                {

                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1766")

                {

                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

                else

                {

                    $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

            }

    

            if((substr($user_products[$j]['prod_id'],1)>1859)&&(substr($user_products[$j]['prod_id'],1)<1890))

            {

                //calculating b8 exterior labcs



                $o_desc_ex_b8=$prod->get_o_desc_ex_b8($user_products[$j]['o_id']);

    

                $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

    

                if($user_products[$j]['prod_id']=="p1861")

                {

                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1863")

                {

                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductlabc,1,2);

                    

                    $total_labc[]=$labc;

                

                }

                elseif($user_products[$j]['prod_id']=="p1866")

                {

                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

                else

                {

                    $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductlabc,1,2);

    

                    $total_labc[]=$labc;

                    

                }

            }

        }



        $tot_labc=0;

        

        for($j=0;$j<count($total_labc);$j++)

        {

            $tot_labc = $tot_labc + $total_labc[$j];

        }



        $general_total_labcs[]=$tot_labc;



        $html .=$tot_labc;

        $html .="</td>";

        $html .="<td>";



        $tot_apus=0;



    for($j=0;$j<count($user_products);$j++)

    {

        if((substr($user_products[$j]['prod_id'],1)>1300)&&(substr($user_products[$j]['prod_id'],1)<1360))

        {

            //calclualting b3 interior apus



            $o_desc_in_b3=$prod->get_o_desc_in_b3($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1301")

            {

                $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1302")

            {

                $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1321")

            {

                $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1322")

            {

                $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            else

            {

                $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

            }

        }



        if((substr($user_products[$j]['prod_id'],1)>1499)&&(substr($user_products[$j]['prod_id'],1)<1560))

        {

            //calculating b5 interior apus



            $o_desc_in_b5=$prod->get_o_desc_in_b5($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1501")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1504")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1521")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1524")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1541")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1544")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1506")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;        

            }

            elseif($user_products[$j]['prod_id']=="p1526")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;   

            }

            elseif($user_products[$j]['prod_id']=="p1546")

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;            

            }

            else

            {

                $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;                        

            }

            

        }

        

        if((substr($user_products[$j]['prod_id'],1)>1599)&&(substr($user_products[$j]['prod_id'],1)<1660))

        {

            //calculating b6 interior apus



            $o_desc_in_b6=$prod->get_o_desc_in_b6($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1600")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1601")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1604")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1621")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1624")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1641")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1644")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1606")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;        

            }

            elseif($user_products[$j]['prod_id']=="p1626")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;   

            }

            elseif($user_products[$j]['prod_id']=="p1646")

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;            

            }

            else

            {

                $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;                        

            }

        }



        if((substr($user_products[$j]['prod_id'],1)>1699)&&(substr($user_products[$j]['prod_id'],1)<1760))

        {

            //calclualting b7 interior apus



            $o_desc_in_b7=$prod->get_o_desc_in_b7($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1700")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1701")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1704")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1721")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1724")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1741")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1744")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1706")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;        

            }

            elseif($user_products[$j]['prod_id']=="p1726")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;   

            }

            elseif($user_products[$j]['prod_id']=="p1746")

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;            

            }

            else

            {

                $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;                        

            }

            

        }



        if((substr($user_products[$j]['prod_id'],1)>1799)&&(substr($user_products[$j]['prod_id'],1)<1860))

        {

            //calclualting b8 interior apus



            $o_desc_in_b8=$prod->get_o_desc_in_b8($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1800")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1800_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1801")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1801_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1804")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1804_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;

            }

            elseif($user_products[$j]['prod_id']=="p1821")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1821_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1824")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1824_fac'] * $thisproductAPU,1,2);  



                $total_apus[]=$apu; 

            }

            elseif($user_products[$j]['prod_id']=="p1841")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1841_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1844")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1844_fac'] * $thisproductAPU,1,2); 



                $total_apus[]=$apu;    

            }

            elseif($user_products[$j]['prod_id']=="p1806")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1806_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;        

            }

            elseif($user_products[$j]['prod_id']=="p1826")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1826_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;   

            }

            elseif($user_products[$j]['prod_id']=="p1846")

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $o_desc_in_b8['p1846_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;            

            }

            else

            {

                $apu=bcdiv($o_desc_in_b8['fac_labc_in_b8'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;                        

            }

            

        }



        if((substr($user_products[$j]['prod_id'],1)>1559)&&(substr($user_products[$j]['prod_id'],1)<1590))

        {

            //calcluating b5 exterior apus



            $o_desc_ex_b5=$prod->get_o_desc_ex_b5($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1561")

            {

                $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);

                

                $total_apus[]=$apu;

            

            }

            elseif($user_products[$j]['prod_id']=="p1563")

            {

                $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);

                

                $total_apus[]=$apu;

            

            }

            elseif($user_products[$j]['prod_id']=="p1566")

            {

                $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

            else

            {

                $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

        }



        if((substr($user_products[$j]['prod_id'],1)>1659)&&(substr($user_products[$j]['prod_id'],1)<1690))

        {

            //calculating b6 exterior apus



            $o_desc_ex_b6=$prod->get_o_desc_ex_b6($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1661")

            {

                $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);

             

                $total_apus[]=$apu;

            

            }

            elseif($user_products[$j]['prod_id']=="p1663")

            {

                $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

            elseif($user_products[$j]['prod_id']=="p1666")

            {

                $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

            else

            {

                $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

    

            }

        }



        if((substr($user_products[$j]['prod_id'],1)>1759)&&(substr($user_products[$j]['prod_id'],1)<1790))

        {

            //calclualting b7 exterior apus



            $o_desc_ex_b7=$prod->get_o_desc_ex_b7($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1761")

            {

                $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);

                

                $total_apus[]=$apu;

            

            }

            elseif($user_products[$j]['prod_id']=="p1763")

            {

                $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);

                

                $total_apus[]=$apu;

            

            }

            elseif($user_products[$j]['prod_id']=="p1766")

            {

                $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

            else

            {

                $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

        }



        if((substr($user_products[$j]['prod_id'],1)>1859)&&(substr($user_products[$j]['prod_id'],1)<1890))

        {

            //calcluating b8 exterior apus



            $o_desc_ex_b8=$prod->get_o_desc_ex_b8($user_products[$j]['o_id']);



            $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



            if($user_products[$j]['prod_id']=="p1861")

            {

                $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);

                

                $total_apus[]=$apu;

            

            }

            elseif($user_products[$j]['prod_id']=="p1863")

            {

                $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);

                

                $total_apus[]=$apu;

            

            }

            elseif($user_products[$j]['prod_id']=="p1866")

            {

                $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

            else

            {

                $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);



                $total_apus[]=$apu;

                

            }

        }

    }



    for($j=0;$j<count($total_apus);$j++)

    {

        $tot_apus = $tot_apus + $total_apus[$j];

    }

    $general_total_apus[]=$tot_apus;



    $html .=$tot_apus;

    $html .="</td>";

    $html .="</tr>";





}



if(!empty($other_creators))

{

    for($i=0;$i<count($other_creators);$i++)

    {

        $licence_taker=$prod->get_company($other_creators[$i]['lt_id']);

    

        $html .="<tr>";

        $html .="<td>";



                if(!empty($other_creators[$i]['c_last_name']))

                {

                    $html .=$other_creators[$i]['c_first_name']." ".$other_creators[$i]['c_last_name']." - ".$licence_taker['mailnick'];

                }

                else

                {

                    $html .=$other_creators[$i]['l_first_name']." ".$other_creators[$i]['l_last_name']." - ".$licence_taker['mailnick'];

                }



            $html .="</td>";

            $html .="<td>";



            $user_products=$prod->get_user_products_by_date($other_creators[$i]['client_ID'],$users_start_date,$users_end_date);



            $total_apus=array();

            $total_labc=array();



            for($j=0;$j<count($user_products);$j++)

            {

                $order=$prod->get_order($user_products[$j]['o_id']);



                if((substr($user_products[$j]['prod_id'],1)>1300)&&(substr($user_products[$j]['prod_id'],1)<1360))

                {

                    //calculating b3 interior labc



                    $o_desc_in_b3=$prod->get_o_desc_in_b3($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1301")

                    {

                        $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1302")

                    {

                        $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1321")

                    {

                        $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1322")

                    {

                        $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1322_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                    }

                }



                if((substr($user_products[$j]['prod_id'],1)>1499)&&(substr($user_products[$j]['prod_id'],1)<1560))

                {

                    //calculating b5 interior labc



                    $o_desc_in_b5=$prod->get_o_desc_in_b5($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1501")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1504")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1521")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductlabc,1,2);  



                        $total_labc[]=$labc; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1524")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductlabc,1,2);  



                        $total_labc[]=$labc; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1541")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1544")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1506")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;        

                    }

                    elseif($user_products[$j]['prod_id']=="p1526")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;   

                    }

                    elseif($user_products[$j]['prod_id']=="p1546")

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;            

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;                        

                    }

                    

                }

                

                if((substr($user_products[$j]['prod_id'],1)>1599)&&(substr($user_products[$j]['prod_id'],1)<1660))

                {

                    //calculating b6 interior labc



                    $o_desc_in_b6=$prod->get_o_desc_in_b6($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);

                    

                    if($user_products[$j]['prod_id']=="p1600")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1601")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1604")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1621")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductlabc,1,2);  



                        $total_labc[]=$labc; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1624")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductlabc,1,2);  



                        $total_labc[]=$labc; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1641")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1644")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1606")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;        

                    }

                    elseif($user_products[$j]['prod_id']=="p1626")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;   

                    }

                    elseif($user_products[$j]['prod_id']=="p1646")

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;            

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;                        

                    }

                }



                if((substr($user_products[$j]['prod_id'],1)>1699)&&(substr($user_products[$j]['prod_id'],1)<1760))

                {

                    //calculating b7 interior labc



                    $o_desc_in_b7=$prod->get_o_desc_in_b7($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1700")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1701")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1704")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;

                    }

                    elseif($user_products[$j]['prod_id']=="p1721")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductlabc,1,2);  



                        $total_labc[]=$labc; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1724")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductlabc,1,2);  



                        $total_labc[]=$labc; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1741")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1744")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductlabc,1,2); 



                        $total_labc[]=$labc;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1706")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;        

                    }

                    elseif($user_products[$j]['prod_id']=="p1726")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;   

                    }

                    elseif($user_products[$j]['prod_id']=="p1746")

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;            

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;                        

                    }

                    

                }



                if((substr($user_products[$j]['prod_id'],1)>1559)&&(substr($user_products[$j]['prod_id'],1)<1590))

                {

                    //calculating b5 exterior labc



                    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1561")

                    {

                        $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductlabc,1,2);

                        

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1563")

                    {

                        $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductlabc,1,2);

                        

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1566")

                    {

                        $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                }



                if((substr($user_products[$j]['prod_id'],1)>1659)&&(substr($user_products[$j]['prod_id'],1)<1690))

                {

                    //calculating b6 exterior labc



                    $o_desc_ex_b6=$prod->get_o_desc_ex_b6($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1661")

                    {

                        $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductlabc,1,2);

                       

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1663")

                    {

                        $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductlabc,1,2);

                       

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1666")

                    {

                        $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                }



                if((substr($user_products[$j]['prod_id'],1)>1759)&&(substr($user_products[$j]['prod_id'],1)<1790))

                {

                    //calculating b7 exterior labcs



                    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1761")

                    {

                        $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductlabc,1,2);

                        

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1763")

                    {

                        $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductlabc,1,2);

                        

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1766")

                    {

                        $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                }



                if((substr($user_products[$j]['prod_id'],1)>1859)&&(substr($user_products[$j]['prod_id'],1)<1890))

                {

                    //calculating b8 exterior labcs



                    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($user_products[$j]['o_id']);



                    $thisproductlabc=$prod->calculateProductlabc($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1861")

                    {

                        $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductlabc,1,2);

                        

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1863")

                    {

                        $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductlabc,1,2);

                        

                        $total_labc[]=$labc;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1866")

                    {

                        $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                    else

                    {

                        $labc=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductlabc,1,2);



                        $total_labc[]=$labc;

                        

                    }

                }

            }



            $tot_labc=0;



            for($j=0;$j<count($total_labc);$j++)

            {

                $tot_labc = $tot_labc + $total_labc[$j];

            }



            $general_total_labcs[]=$tot_labc;



            $html .=$tot_labc;

            

            $html .="</td>";

            $html .="<td>";

            

            $tot_apus=0;

    

            for($j=0;$j<count($user_products);$j++)

            {

                if((substr($user_products[$j]['prod_id'],1)>1300)&&(substr($user_products[$j]['prod_id'],1)<1360))

                {

                    //calclualting b3 interior apus

        

                    $o_desc_in_b3=$prod->get_o_desc_in_b3($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);



                    if($user_products[$j]['prod_id']=="p1301")

                    {

                        $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1301_fac'] * $thisproductAPU,1,2);



                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1302")

                    {

                        $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1302_fac'] * $thisproductAPU,1,2);



                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1321")

                    {

                        $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);



                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1321")

                    {

                        $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $o_desc_in_b3['p1321_fac'] * $thisproductAPU,1,2);



                        $total_apus[]=$apu;

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_in_b3['fac_labc_in_b3'] * $thisproductAPU,1,2);

            

                        $total_apus[]=$apu;

                    }

                }

        

                if((substr($user_products[$j]['prod_id'],1)>1499)&&(substr($user_products[$j]['prod_id'],1)<1560))

                {

                    //calculating b5 interior apus

        

                    $o_desc_in_b5=$prod->get_o_desc_in_b5($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);

        

                    if($user_products[$j]['prod_id']=="p1501")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1501_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1504")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1504_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1521")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1521_fac'] * $thisproductAPU,1,2);  

        

                        $total_apus[]=$apu; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1524")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1524_fac'] * $thisproductAPU,1,2);  

        

                        $total_apus[]=$apu; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1541")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1541_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1544")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1544_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1506")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1506_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;        

                    }

                    elseif($user_products[$j]['prod_id']=="p1526")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1526_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;   

                    }

                    elseif($user_products[$j]['prod_id']=="p1546")

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $o_desc_in_b5['p1546_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;            

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_in_b5['fac_labc_in_b5'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;                        

                    }

                    

                }

                

                if((substr($user_products[$j]['prod_id'],1)>1599)&&(substr($user_products[$j]['prod_id'],1)<1660))

                {

                    //calculating b6 interior apus

        

                    $o_desc_in_b6=$prod->get_o_desc_in_b6($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);

        

                    if($user_products[$j]['prod_id']=="p1600")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1600_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1601")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1601_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1604")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1604_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1621")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1621_fac'] * $thisproductAPU,1,2);  

        

                        $total_apus[]=$apu; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1624")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1624_fac'] * $thisproductAPU,1,2);  

        

                        $total_apus[]=$apu; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1641")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1641_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1644")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1644_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1606")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1606_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;        

                    }

                    elseif($user_products[$j]['prod_id']=="p1626")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1626_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;   

                    }

                    elseif($user_products[$j]['prod_id']=="p1646")

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $o_desc_in_b6['p1646_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;            

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_in_b6['fac_labc_in_b6'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;                        

                    }

                }

        

                if((substr($user_products[$j]['prod_id'],1)>1699)&&(substr($user_products[$j]['prod_id'],1)<1760))

                {

                    //calclualting b7 interior apus

        

                    $o_desc_in_b7=$prod->get_o_desc_in_b7($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);

        

                    if($user_products[$j]['prod_id']=="p1700")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1700_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1701")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1701_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1704")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1704_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;

                    }

                    elseif($user_products[$j]['prod_id']=="p1721")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1721_fac'] * $thisproductAPU,1,2);  

        

                        $total_apus[]=$apu; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1724")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1724_fac'] * $thisproductAPU,1,2);  

        

                        $total_apus[]=$apu; 

                    }

                    elseif($user_products[$j]['prod_id']=="p1741")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1741_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1744")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1744_fac'] * $thisproductAPU,1,2); 

        

                        $total_apus[]=$apu;    

                    }

                    elseif($user_products[$j]['prod_id']=="p1706")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1706_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;        

                    }

                    elseif($user_products[$j]['prod_id']=="p1726")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1726_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;   

                    }

                    elseif($user_products[$j]['prod_id']=="p1746")

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $o_desc_in_b7['p1746_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;            

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_in_b7['fac_labc_in_b7'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;                        

                    }

                    

                }

        

                if((substr($user_products[$j]['prod_id'],1)>1559)&&(substr($user_products[$j]['prod_id'],1)<1590))

                {

                    //calcluating b5 exterior apus

        

                    $o_desc_ex_b5=$prod->get_o_desc_ex_b5($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);

        

                    if($user_products[$j]['prod_id']=="p1561")

                    {

                        $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1561_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1563")

                    {

                        $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1563_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1566")

                    {

                        $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $o_desc_ex_b5['p1566_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_ex_b5['fac_prod_ex_b5'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                }

        

                if((substr($user_products[$j]['prod_id'],1)>1659)&&(substr($user_products[$j]['prod_id'],1)<1690))

                {

                    //calculating b6 exterior apus

        

                    $o_desc_ex_b6=$prod->get_o_desc_ex_b6($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);

        

                    if($user_products[$j]['prod_id']=="p1661")

                    {

                        $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1661_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1663")

                    {

                        $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1663_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1666")

                    {

                        $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $o_desc_ex_b6['p1666_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_ex_b6['fac_prod_ex_b6'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                }

        

                if((substr($user_products[$j]['prod_id'],1)>1759)&&(substr($user_products[$j]['prod_id'],1)<1790))

                {

                    //calclualting b7 exterior apus

        

                    $o_desc_ex_b7=$prod->get_o_desc_ex_b7($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);

        

                    if($user_products[$j]['prod_id']=="p1761")

                    {

                        $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1761_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1763")

                    {

                        $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1763_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1766")

                    {

                        $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $o_desc_ex_b7['p1766_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_ex_b7['fac_prod_ex_b7'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                }

        

                if((substr($user_products[$j]['prod_id'],1)>1859)&&(substr($user_products[$j]['prod_id'],1)<1890))

                {

                    //calcluating b8 exterior apus

        

                    $o_desc_ex_b8=$prod->get_o_desc_ex_b8($user_products[$j]['o_id']);

        

                    $thisproductAPU=$prod->calculateProductAPU($user_products[$j]['prod_id']);

        

                    if($user_products[$j]['prod_id']=="p1861")

                    {

                        $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1861_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1863")

                    {

                        $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1863_fac'] * $thisproductAPU,1,2);

                        

                        $total_apus[]=$apu;

                    

                    }

                    elseif($user_products[$j]['prod_id']=="p1866")

                    {

                        $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $o_desc_ex_b8['p1866_fac'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                    else

                    {

                        $apu=bcdiv($o_desc_ex_b8['fac_prod_ex_b8'] * $thisproductAPU,1,2);

        

                        $total_apus[]=$apu;

                        

                    }

                }

            }

        

            for($j=0;$j<count($total_apus);$j++)

            {

                $tot_apus = $tot_apus + $total_apus[$j];

            }



            $general_total_apus[]=$tot_apus;

            $html .=$tot_apus;



            $html .="</td>";

            $html .="</tr>";

    

    }

}



$html .="</table>";





$gen_tot_labcs=0;

$gen_tot_apus=0;



for($j=0;$j<count($general_total_labcs);$j++)

{

    if(!empty($general_total_labcs[$j]))

    {

        $gen_tot_labcs = $gen_tot_labcs + $general_total_labcs[$j];

    }

}



for($j=0;$j<count($general_total_apus);$j++)

{

    if(!empty($general_total_apus[$j]))

    {

        $gen_tot_apus = $gen_tot_apus + $general_total_apus[$j];

    }

}



$html .="<br><b>";

$html .="Total labcs = ".$gen_tot_labcs;

$html .=" -- Total APUs = ".$gen_tot_apus;

$html .= "</b>";



require('/home/adminhdd/domains/cseven.eu/public_html/studio/mpdf/mpdf.php');

$pdf=new mPDF();

$pdf->setAutoBottomMargin = 'stretch';

//$pdf->SetHTMLFooter($signature);

$pdf->WriteHTML($html);



$pdf_file_name="/home/adminhdd/domains/cseven.eu/public_html/studio/users/pdf/all_creators_labcs_apus".$users_start_date."_".$users_end_date.".pdf";



$pdf->Output($pdf_file_name,'F');



?>