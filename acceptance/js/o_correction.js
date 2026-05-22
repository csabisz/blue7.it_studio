$(document).ready(function() {

calculatePricesAPUslabcs_with_multiplicator_in_b3();
calculatePricesAPUslabcs_with_multiplicator_in_b5();
calculatePricesAPUslabcs_with_multiplicator_in_b6();
calculatePricesAPUslabcs_with_multiplicator_in_b7();
calculatePricesAPUslabcs_with_multiplicator_in_b8();

calculatePricesAPUslabcs_with_multiplicator_ex_b5();
calculatePricesAPUslabcs_with_multiplicator_ex_b6();
calculatePricesAPUslabcs_with_multiplicator_ex_b7();
calculatePricesAPUslabcs_with_multiplicator_ex_b8();

calculatePricesAPUslabcs_ex_b5();
calculate_ex_b5();
calculatePricesAPUslabcs_ex_b6();
calculate_ex_b6();
calculatePricesAPUslabcs_ex_b7();
calculate_ex_b7();
calculatePricesAPUslabcs_ex_b8();
calculate_ex_b8();

calculatePricesAPUslabcs_in_b3();
calculate_in_b3();
calculatePricesAPUslabcs_in_b5();
calculate_in_b5();
calculatePricesAPUslabcs_in_b6();
calculate_in_b6();
calculatePricesAPUslabcs_in_b7();
calculate_in_b7();
calculatePricesAPUslabcs_in_b8();
calculate_in_b8();

calculatetotalPriceAPU();

$('.b3_in_multiplicator').on('change keyup paste mouseup', function() {
    $('.b3_in_multiplicator').val($(this).val());
    calculatePricesAPUslabcs_with_multiplicator_in_b3();
    calculatePricesAPUslabcs_in_b3();
    calculate_in_b3();
    calculatetotalPriceAPU();
});

$('.b5_in_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());
    
    calculatePricesAPUslabcs_with_multiplicator_in_b5();
    calculatePricesAPUslabcs_in_b5();
    calculate_in_b5();
    calculatetotalPriceAPU();
});

$('.b6_in_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());
    calculatePricesAPUslabcs_with_multiplicator_in_b6();
    calculatePricesAPUslabcs_in_b6();
    calculate_in_b6();
    calculatetotalPriceAPU();
});

$('.b7_in_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());

    calculatePricesAPUslabcs_with_multiplicator_in_b7();
    calculatePricesAPUslabcs_in_b7();
    calculate_in_b7();
    calculatetotalPriceAPU();
});

$('.b8_in_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());

    calculatePricesAPUslabcs_with_multiplicator_in_b8();
    calculatePricesAPUslabcs_in_b8();
    calculate_in_b8();
    calculatetotalPriceAPU();
});

$('.b5_ex_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());
    
    calculatePricesAPUslabcs_with_multiplicator_ex_b5();
    calculatePricesAPUslabcs_ex_b5();
    calculate_ex_b5();
    calculatetotalPriceAPU();
});

$('.b6_ex_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());
    calculatePricesAPUslabcs_with_multiplicator_ex_b6();
    calculatePricesAPUslabcs_ex_b6();
    calculate_ex_b6();
    calculatetotalPriceAPU();
});

$('.b7_ex_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());

    calculatePricesAPUslabcs_with_multiplicator_ex_b7();
    calculatePricesAPUslabcs_ex_b7();
    calculate_ex_b7();
    calculatetotalPriceAPU();
});

$('.b8_ex_multiplicator').on('change keyup paste mouseup', function() {
    var current_id=$(this).attr('id');
    $('.'+current_id).val($(this).val());
    
    calculatePricesAPUslabcs_with_multiplicator_ex_b8();
    calculatePricesAPUslabcs_ex_b8();
    calculate_ex_b8();
    calculatetotalPriceAPU();
});

$('.product_ex_b5').click(function(){	

var value=($(this).val()).split(".");
var	product=value[4];	
//console.log(product);

if($(this).is(":checked"))
{
	
	$('#product_'+product+'_price').addClass('prices_ex_b5');
	$('#product_'+product+'_apu').addClass('apus_ex_b5');
	$('#product_'+product+'_labc').addClass('labcs_ex_b5');
	calculatePricesAPUslabcs_ex_b5();
	calculate_ex_b5();
	calculatetotalPriceAPU();
	
}
else
{
	
	$('#product_'+product+'_price').removeClass('prices_ex_b5');
	$('#product_'+product+'_apu').removeClass('apus_ex_b5');
	$('#product_'+product+'_labc').removeClass('labcs_ex_b5');
	calculatePricesAPUslabcs_ex_b5();
	calculate_ex_b5();
	calculatetotalPriceAPU();
}		

});

$('.product_ex_b6').click(function(){	

    var value=($(this).val()).split(".");
    var	product=value[4];	
    //console.log(product);
    
    if($(this).is(":checked"))
    {
        
        $('#product_'+product+'_price').addClass('prices_ex_b6');
        $('#product_'+product+'_apu').addClass('apus_ex_b6');
        $('#product_'+product+'_labc').addClass('labcs_ex_b6');
        calculatePricesAPUslabcs_ex_b6();
        calculate_ex_b6();
        calculatetotalPriceAPU();
        
    }
    else
    {
        
        $('#product_'+product+'_price').removeClass('prices_ex_b6');
        $('#product_'+product+'_apu').removeClass('apus_ex_b6');
        $('#product_'+product+'_labc').removeClass('labcs_ex_b6');
        calculatePricesAPUslabcs_ex_b6();
        calculate_ex_b6();
        calculatetotalPriceAPU();
    }		
    
    });

$('.product_ex_b7').click(function(){	

var value=($(this).val()).split(".");
var	product=value[4];	
//console.log(product);

if($(this).is(":checked"))
{
	
	$('#product_'+product+'_price').addClass('prices_ex_b7');
	$('#product_'+product+'_apu').addClass('apus_ex_b7');
	$('#product_'+product+'_labc').addClass('labcs_ex_b7');
	calculatePricesAPUslabcs_ex_b7();
	calculate_ex_b7();
	calculatetotalPriceAPU();
}
else
{
	
	$('#product_'+product+'_price').removeClass('prices_ex_b7');
	$('#product_'+product+'_apu').removeClass('apus_ex_b7');
	$('#product_'+product+'_labc').removeClass('labcs_ex_b7');
	calculatePricesAPUslabcs_ex_b7();
	calculate_ex_b7();
	calculatetotalPriceAPU();
}		

});

$('.product_in_b3').click(function(){	

var value=($(this).val()).split(".");
var	product=value[4];	
//console.log(product);

if($(this).is(":checked"))
{
	
	$('#product_'+product+'_price').addClass('prices_in_b3');
	$('#product_'+product+'_apu').addClass('apus_in_b3');
	$('#product_'+product+'_labc').addClass('labcs_in_b3');
	calculatePricesAPUslabcs_in_b3();
	calculate_in_b3();
	calculatetotalPriceAPU();
	
}
else
{
	
	$('#product_'+product+'_price').removeClass('prices_in_b3');
	$('#product_'+product+'_apu').removeClass('apus_in_b3');
	$('#product_'+product+'_labc').removeClass('labcs_in_b3');
	calculatePricesAPUslabcs_in_b3();
	calculate_in_b3();
	calculatetotalPriceAPU();
}		

});

$('.product_in_b5').click(function(){	

var value=($(this).val()).split(".");
var	product=value[4];	
//console.log(product);

if($(this).is(":checked"))
{
	
	$('#product_'+product+'_price').addClass('prices_in_b5');
	$('#product_'+product+'_apu').addClass('apus_in_b5');
	$('#product_'+product+'_labc').addClass('labcs_in_b5');
	calculatePricesAPUslabcs_in_b5();
	calculate_in_b5();
	calculatetotalPriceAPU();
	
}
else
{
	
	$('#product_'+product+'_price').removeClass('prices_in_b5');
	$('#product_'+product+'_apu').removeClass('apus_in_b5');
	$('#product_'+product+'_labc').removeClass('labcs_in_b5');
	calculatePricesAPUslabcs_in_b5();
	calculate_in_b5();
	calculatetotalPriceAPU();
}		

});

$('.product_in_b7').click(function(){	

var value=($(this).val()).split(".");
var	product=value[4];	
console.log(product);

if($(this).is(":checked"))
{
	
	$('#product_'+product+'_price').addClass('prices_in_b7');
	$('#product_'+product+'_apu').addClass('apus_in_b7');
	$('#product_'+product+'_labc').addClass('labcs_in_b7');
	calculatePricesAPUslabcs_in_b7();
	calculate_in_b7();
	calculatetotalPriceAPU();
}
else
{
	
	$('#product_'+product+'_price').removeClass('prices_in_b7');
	$('#product_'+product+'_apu').removeClass('apus_in_b7');
	$('#product_'+product+'_labc').removeClass('labcs_in_b7');
	calculatePricesAPUslabcs_in_b7();
	calculate_in_b7();
	calculatetotalPriceAPU();
}		

});
	
$('#fac_cl_ex_b7').on('change keyup paste mouseup', function() {
	calculatePricesAPUslabcs_ex_b7();
	calculate_ex_b7();
	calculatetotalPriceAPU();
});

$('#fac_prod_ex_b7').on('change keyup paste mouseup', function() {
	calculatePricesAPUslabcs_ex_b7();
	calculate_ex_b7();
	calculatetotalPriceAPU();
});

$('#fac_labc_ex_b7').on('change keyup paste mouseup', function() {
	calculatePricesAPUslabcs_ex_b7();
	calculate_ex_b7();
	calculatetotalPriceAPU();
});	


$('#fac_cl_in_b7').on('change keyup paste mouseup', function() {
	calculatePricesAPUslabcs_in_b7();
	calculate_in_b7();
	calculatetotalPriceAPU();
});

$('#fac_prod_in_b7').on('change keyup paste mouseup', function() {
	calculatePricesAPUslabcs_in_b7();
	calculate_in_b7();
	calculatetotalPriceAPU();
});

$('#fac_labc_in_b7').on('change keyup paste mouseup', function() {
	calculatePricesAPUslabcs_in_b7();
	calculate_in_b7();
	calculatetotalPriceAPU();
});	
	
});



function calculatePricesAPUslabcs_in_b3()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_in_b3').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_in_b3').val(price.toFixed(2));
	
	$('.apus_in_b3').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_in_b3').val(apus.toFixed(2));
	
	$('.labcs_in_b3').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_in_b3').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_with_multiplicator_in_b3()
{
    var p1301_fac=$('#p1301_fac').val();
    var p1302_fac=$('#p1302_fac').val();
    var p1321_fac=$('#p1321_fac').val();
    var p1322_fac=$('#p1322_fac').val();

    if((p1301_fac!=0)&&(p1301_fac != undefined))
    {
        
        $('#product_p1301_price').val(($('#product_p1301_price_original').val() * p1301_fac).toFixed(2));
        $('#product_p1301_apu').val(($('#product_p1301_apu_original').val() * p1301_fac).toFixed(2));
        $('#product_p1301_labc').val(($('#product_p1301_labc_original').val() * p1301_fac).toFixed(2));
    }

    if((p1302_fac!=0)&&(p1302_fac != undefined))
    {
        
        $('#product_p1302_price').val(($('#product_p1302_price_original').val() * p1302_fac).toFixed(2));
        $('#product_p1302_apu').val(($('#product_p1302_apu_original').val() * p1302_fac).toFixed(2));
        $('#product_p1302_labc').val(($('#product_p1302_labc_original').val() * p1302_fac).toFixed(2));
    }

    if((p1321_fac!=0)&&(p1321_fac != undefined))
    {
        
        $('#product_p1321_price').val(($('#product_p1321_price_original').val() * p1321_fac).toFixed(2));
        $('#product_p1321_apu').val(($('#product_p1321_apu_original').val() * p1321_fac).toFixed(2));
        $('#product_p1321_labc').val(($('#product_p1321_labc_original').val() * p1321_fac).toFixed(2));
    }

    if((p1322_fac!=0)&&(p1322_fac != undefined))
    {
        
        $('#product_p1322_price').val(($('#product_p1322_price_original').val() * p1322_fac).toFixed(2));
        $('#product_p1322_apu').val(($('#product_p1322_apu_original').val() * p1322_fac).toFixed(2));
        $('#product_p1322_labc').val(($('#product_p1322_labc_original').val() * p1322_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_in_b5()
{
    var p1501_fac=$('#p1501_fac').val();
    var p1504_fac=$('#p1504_fac').val();
    var p1521_fac=$('#p1521_fac').val();
    var p1524_fac=$('#p1524_fac').val();
    var p1541_fac=$('#p1541_fac').val();
    var p1544_fac=$('#p1544_fac').val();

    var p1506_fac=$('#p1506_fac').val();
    var p1526_fac=$('#p1526_fac').val();
    var p1546_fac=$('#p1546_fac').val();

    if((p1501_fac!=0)&&(p1501_fac != undefined))
    {
        
        $('#product_p1501_price').val(($('#product_p1501_price_original').val() * p1501_fac).toFixed(2));
        $('#product_p1501_apu').val(($('#product_p1501_apu_original').val() * p1501_fac).toFixed(2));
        $('#product_p1501_labc').val(($('#product_p1501_labc_original').val() * p1501_fac).toFixed(2));
    }

    if((p1504_fac!=0)&&(p1504_fac != undefined))
    {
        
        $('#product_p1504_price').val(($('#product_p1504_price_original').val() * p1504_fac).toFixed(2));
        $('#product_p1504_apu').val(($('#product_p1504_apu_original').val() * p1504_fac).toFixed(2));
        $('#product_p1504_labc').val(($('#product_p1504_labc_original').val() * p1504_fac).toFixed(2));
    }

    if((p1521_fac!=0)&&(p1521_fac != undefined))
    {
        
        $('#product_p1521_price').val(($('#product_p1521_price_original').val() * p1521_fac).toFixed(2));
        $('#product_p1521_apu').val(($('#product_p1521_apu_original').val() * p1521_fac).toFixed(2));
        $('#product_p1521_labc').val(($('#product_p1521_labc_original').val() * p1521_fac).toFixed(2));
    }

    if((p1524_fac!=0)&&(p1524_fac != undefined))
    {
        
        $('#product_p1524_price').val(($('#product_p1524_price_original').val() * p1524_fac).toFixed(2));
        $('#product_p1524_apu').val(($('#product_p1524_apu_original').val() * p1524_fac).toFixed(2));
        $('#product_p1524_labc').val(($('#product_p1524_labc_original').val() * p1524_fac).toFixed(2));
    }

    if((p1541_fac!=0)&&(p1541_fac != undefined))
    {
        
        $('#product_p1541_price').val(($('#product_p1541_price_original').val() * p1541_fac).toFixed(2));
        $('#product_p1541_apu').val(($('#product_p1541_apu_original').val() * p1541_fac).toFixed(2));
        $('#product_p1541_labc').val(($('#product_p1541_labc_original').val() * p1541_fac).toFixed(2));
    }

    if((p1544_fac!=0)&&(p1544_fac != undefined))
    {
       
        $('#product_p1544_price').val(($('#product_p1544_price_original').val() * p1544_fac).toFixed(2));
        $('#product_p1544_apu').val(($('#product_p1544_apu_original').val() * p1544_fac).toFixed(2));
        $('#product_p1544_labc').val(($('#product_p1544_labc_original').val() * p1544_fac).toFixed(2));
    }



    if((p1506_fac!=0)&&(p1506_fac != undefined)) 
    {
        // alert("p1506_fac = "+p1506_fac);
        $('#product_p1506_price').val(($('#product_p1506_price_original').val() * p1506_fac).toFixed(2));
        $('#product_p1506_apu').val(($('#product_p1506_apu_original').val() * p1506_fac).toFixed(2));
        $('#product_p1506_labc').val(($('#product_p1506_labc_original').val() * p1506_fac).toFixed(2));
    }

    if((p1526_fac!=0)&&(p1526_fac != undefined))
    {
        // alert("p1526_fac = "+p1526_fac);
        $('#product_p1526_price').val(($('#product_p1526_price_original').val() * p1526_fac).toFixed(2));
        $('#product_p1526_apu').val(($('#product_p1526_apu_original').val() * p1526_fac).toFixed(2));
        $('#product_p1526_labc').val(($('#product_p1526_labc_original').val() * p1526_fac).toFixed(2));
    }

    if((p1546_fac!=0)&&(p1546_fac != undefined))
    {
        // alert("p1546_fac = "+p1546_fac);
        $('#product_p1546_price').val(($('#product_p1546_price_original').val() * p1546_fac).toFixed(2));
        $('#product_p1546_apu').val(($('#product_p1546_apu_original').val() * p1546_fac).toFixed(2));
        $('#product_p1546_labc').val(($('#product_p1546_labc_original').val() * p1546_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_ex_b5()
{
    var p1561_fac=$('#p1561_fac').val();
    var p1562_fac=$('#p1562_fac').val();
    var p1563_fac=$('#p1563_fac').val();
    var p1566_fac=$('#p1566_fac').val();

    if((p1561_fac!=0)&&(p1561_fac != undefined))
    {
        $('#product_p1561_price').val(($('#product_p1561_price_original').val() * p1561_fac).toFixed(2));
        $('#product_p1561_apu').val(($('#product_p1561_apu_original').val() * p1561_fac).toFixed(2));
        $('#product_p1561_labc').val(($('#product_p1561_labc_original').val() * p1561_fac).toFixed(2));
    }

    if((p1562_fac!=0)&&(p1562_fac != undefined))
    {
        $('#product_p1562_price').val(($('#product_p1562_price_original').val() * p1562_fac).toFixed(2));
        $('#product_p1562_apu').val(($('#product_p1562_apu_original').val() * p1562_fac).toFixed(2));
        $('#product_p1562_labc').val(($('#product_p1562_labc_original').val() * p1562_fac).toFixed(2));
    }

    if((p1563_fac!=0)&&(p1563_fac != undefined))
    {
        $('#product_p1563_price').val(($('#product_p1563_price_original').val() * p1563_fac).toFixed(2));
        $('#product_p1563_apu').val(($('#product_p1563_apu_original').val() * p1563_fac).toFixed(2));
        $('#product_p1563_labc').val(($('#product_p1563_labc_original').val() * p1563_fac).toFixed(2));
    }

    if((p1566_fac!=0)&&(p1566_fac != undefined))
    {
        $('#product_p1566_price').val(($('#product_p1566_price_original').val() * p1566_fac).toFixed(2));
        $('#product_p1566_apu').val(($('#product_p1566_apu_original').val() * p1566_fac).toFixed(2));
        $('#product_p1566_labc').val(($('#product_p1566_labc_original').val() * p1566_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_in_b6()
{
    var p1600_fac=$('#p1600_fac').val();
    var p1601_fac=$('#p1601_fac').val();
    var p1604_fac=$('#p1604_fac').val();
    var p1621_fac=$('#p1621_fac').val();
    var p1624_fac=$('#p1624_fac').val();
    var p1641_fac=$('#p1641_fac').val();
    var p1644_fac=$('#p1644_fac').val();

    var p1606_fac=$('#p1606_fac').val();
    var p1626_fac=$('#p1626_fac').val();
    var p1646_fac=$('#p1646_fac').val();

    if((p1600_fac!=0)&&(p1600_fac != undefined))
    {
        
        $('#product_p1600_price').val(($('#product_p1600_price_original').val() * p1600_fac).toFixed(2));
        $('#product_p1600_apu').val(($('#product_p1600_apu_original').val() * p1600_fac).toFixed(2));
        $('#product_p1600_labc').val(($('#product_p1600_labc_original').val() * p1600_fac).toFixed(2));
    }
    if((p1601_fac!=0)&&(p1601_fac != undefined))
    {
        
        $('#product_p1601_price').val(($('#product_p1601_price_original').val() * p1601_fac).toFixed(2));
        $('#product_p1601_apu').val(($('#product_p1601_apu_original').val() * p1601_fac).toFixed(2));
        $('#product_p1601_labc').val(($('#product_p1601_labc_original').val() * p1601_fac).toFixed(2));
    }

    if((p1604_fac!=0)&&(p1604_fac != undefined))
    {
        
        $('#product_p1604_price').val(($('#product_p1604_price_original').val() * p1604_fac).toFixed(2));
        $('#product_p1604_apu').val(($('#product_p1604_apu_original').val() * p1604_fac).toFixed(2));
        $('#product_p1604_labc').val(($('#product_p1604_labc_original').val() * p1604_fac).toFixed(2));
    }

    if((p1621_fac!=0)&&(p1621_fac != undefined))
    {
       
        $('#product_p1621_price').val(($('#product_p1621_price_original').val() * p1621_fac).toFixed(2));
        $('#product_p1621_apu').val(($('#product_p1621_apu_original').val() * p1621_fac).toFixed(2));
        $('#product_p1621_labc').val(($('#product_p1621_labc_original').val() * p1621_fac).toFixed(2));
    }

    if((p1624_fac!=0)&&(p1624_fac != undefined))
    {
        
        $('#product_p1624_price').val(($('#product_p1624_price_original').val() * p1624_fac).toFixed(2));
        $('#product_p1624_apu').val(($('#product_p1624_apu_original').val() * p1624_fac).toFixed(2));
        $('#product_p1624_labc').val(($('#product_p1624_labc_original').val() * p1624_fac).toFixed(2));
    }

    if((p1641_fac!=0)&&(p1641_fac != undefined))
    {
        
        $('#product_p1641_price').val(($('#product_p1641_price_original').val() * p1641_fac).toFixed(2));
        $('#product_p1641_apu').val(($('#product_p1641_apu_original').val() * p1641_fac).toFixed(2));
        $('#product_p1641_labc').val(($('#product_p1641_labc_original').val() * p1641_fac).toFixed(2));
    }

    if((p1644_fac!=0)&&(p1644_fac != undefined))
    {
        
        $('#product_p1644_price').val(($('#product_p1644_price_original').val() * p1644_fac).toFixed(2));
        $('#product_p1644_apu').val(($('#product_p1644_apu_original').val() * p1644_fac).toFixed(2));
        $('#product_p1644_labc').val(($('#product_p1644_labc_original').val() * p1644_fac).toFixed(2));
    }



    if((p1606_fac!=0)&&(p1606_fac != undefined)) 
    {
        // alert("p1506_fac = "+p1506_fac);
        $('#product_p1606_price').val(($('#product_p1606_price_original').val() * p1606_fac).toFixed(2));
        $('#product_p1606_apu').val(($('#product_p1606_apu_original').val() * p1606_fac).toFixed(2));
        $('#product_p1606_labc').val(($('#product_p1606_labc_original').val() * p1606_fac).toFixed(2));
    }

    if((p1626_fac!=0)&&(p1626_fac != undefined))
    {
        // alert("p1526_fac = "+p1526_fac);
        $('#product_p1626_price').val(($('#product_p1626_price_original').val() * p1626_fac).toFixed(2));
        $('#product_p1626_apu').val(($('#product_p1626_apu_original').val() * p1626_fac).toFixed(2));
        $('#product_p1626_labc').val(($('#product_p1626_labc_original').val() * p1626_fac).toFixed(2));
    }

    if((p1646_fac!=0)&&(p1646_fac != undefined))
    {
        // alert("p1546_fac = "+p1546_fac);
        $('#product_p1646_price').val(($('#product_p1646_price_original').val() * p1646_fac).toFixed(2));
        $('#product_p1646_apu').val(($('#product_p1646_apu_original').val() * p1646_fac).toFixed(2));
        $('#product_p1646_labc').val(($('#product_p1646_labc_original').val() * p1646_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_ex_b6()
{
    var p1661_fac=$('#p1661_fac').val();
    var p1663_fac=$('#p1663_fac').val();
    var p1666_fac=$('#p1666_fac').val();
    var p166p_fac=$('#p166p_fac').val();

    if((p1661_fac!=0)&&(p1661_fac != undefined))
    {
        $('#product_p1661_price').val(($('#product_p1661_price_original').val() * p1661_fac).toFixed(2));
        $('#product_p1661_apu').val(($('#product_p1661_apu_original').val() * p1661_fac).toFixed(2));
        $('#product_p1661_labc').val(($('#product_p1661_labc_original').val() * p1661_fac).toFixed(2));
    }

    if((p1663_fac!=0)&&(p1663_fac != undefined))
    {
        $('#product_p1663_price').val(($('#product_p1663_price_original').val() * p1663_fac).toFixed(2));
        $('#product_p1663_apu').val(($('#product_p1663_apu_original').val() * p1663_fac).toFixed(2));
        $('#product_p1663_labc').val(($('#product_p1663_labc_original').val() * p1663_fac).toFixed(2));
    }

    if((p1666_fac!=0)&&(p1666_fac != undefined))
    {
        $('#product_p1666_price').val(($('#product_p1666_price_original').val() * p1666_fac).toFixed(2));
        $('#product_p1666_apu').val(($('#product_p1666_apu_original').val() * p1666_fac).toFixed(2));
        $('#product_p1666_labc').val(($('#product_p1666_labc_original').val() * p1666_fac).toFixed(2));
    }

    if((p166p_fac!=0)&&(p166p_fac != undefined))
    {
        $('#product_p166p_price').val(($('#product_p166p_price_original').val() * p166p_fac).toFixed(2));
        $('#product_p166p_apu').val(($('#product_p166p_apu_original').val() * p166p_fac).toFixed(2));
        $('#product_p166p_labc').val(($('#product_p166p_labc_original').val() * p166p_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_in_b7()
{
    var p1700_fac=$('#p1700_fac').val();
    var p1701_fac=$('#p1701_fac').val();
    var p1704_fac=$('#p1704_fac').val();
    var p1721_fac=$('#p1721_fac').val();
    var p1723_fac=$('#p1723_fac').val();
    var p1724_fac=$('#p1724_fac').val();
    var p1741_fac=$('#p1741_fac').val();
    var p1744_fac=$('#p1744_fac').val();

    var p1706_fac=$('#p1706_fac').val();
    var p1726_fac=$('#p1726_fac').val();
    var p1746_fac=$('#p1746_fac').val();

    if((p1700_fac!=0)&&(p1700_fac != undefined))
    {
       
        $('#product_p1700_price').val(($('#product_p1700_price_original').val() * p1700_fac).toFixed(2));
        $('#product_p1700_apu').val(($('#product_p1700_apu_original').val() * p1700_fac).toFixed(2));
        $('#product_p1700_labc').val(($('#product_p1700_labc_original').val() * p1700_fac).toFixed(2));
    }
    if((p1701_fac!=0)&&(p1701_fac != undefined))
    {
       
        $('#product_p1701_price').val(($('#product_p1701_price_original').val() * p1701_fac).toFixed(2));
        $('#product_p1701_apu').val(($('#product_p1701_apu_original').val() * p1701_fac).toFixed(2));
        $('#product_p1701_labc').val(($('#product_p1701_labc_original').val() * p1701_fac).toFixed(2));
    }

    if((p1704_fac!=0)&&(p1704_fac != undefined))
    {
       
        $('#product_p1704_price').val(($('#product_p1704_price_original').val() * p1704_fac).toFixed(2));
        $('#product_p1704_apu').val(($('#product_p1704_apu_original').val() * p1704_fac).toFixed(2));
        $('#product_p1704_labc').val(($('#product_p1704_labc_original').val() * p1704_fac).toFixed(2));
    }

    if((p1721_fac!=0)&&(p1721_fac != undefined))
    {
        
        $('#product_p1721_price').val(($('#product_p1721_price_original').val() * p1721_fac).toFixed(2));
        $('#product_p1721_apu').val(($('#product_p1721_apu_original').val() * p1721_fac).toFixed(2));
        $('#product_p1721_labc').val(($('#product_p1721_labc_original').val() * p1721_fac).toFixed(2));
    }

    if((p1723_fac!=0)&&(p1723_fac != undefined))
    {
        
        $('#product_p1723_price').val(($('#product_p1723_price_original').val() * p1723_fac).toFixed(2));
        $('#product_p1723_apu').val(($('#product_p1723_apu_original').val() * p1723_fac).toFixed(2));
        $('#product_p1723_labc').val(($('#product_p1723_labc_original').val() * p1723_fac).toFixed(2));
    }

    if((p1724_fac!=0)&&(p1724_fac != undefined))
    {
        
        $('#product_p1724_price').val(($('#product_p1724_price_original').val() * p1724_fac).toFixed(2));
        $('#product_p1724_apu').val(($('#product_p1724_apu_original').val() * p1724_fac).toFixed(2));
        $('#product_p1724_labc').val(($('#product_p1724_labc_original').val() * p1724_fac).toFixed(2));
    }

    if((p1741_fac!=0)&&(p1741_fac != undefined))
    {
        
        $('#product_p1741_price').val(($('#product_p1741_price_original').val() * p1741_fac).toFixed(2));
        $('#product_p1741_apu').val(($('#product_p1741_apu_original').val() * p1741_fac).toFixed(2));
        $('#product_p1741_labc').val(($('#product_p1741_labc_original').val() * p1741_fac).toFixed(2));
    }

    if((p1744_fac!=0)&&(p1744_fac != undefined))
    {
        
        $('#product_p1744_price').val(($('#product_p1744_price_original').val() * p1744_fac).toFixed(2));
        $('#product_p1744_apu').val(($('#product_p1744_apu_original').val() * p1744_fac).toFixed(2));
        $('#product_p1744_labc').val(($('#product_p1744_labc_original').val() * p1744_fac).toFixed(2));
    }

    if((p1706_fac!=0)&&(p1706_fac != undefined)) 
    {
        // alert("p1506_fac = "+p1506_fac);
        $('#product_p1706_price').val(($('#product_p1706_price_original').val() * p1706_fac).toFixed(2));
        $('#product_p1706_apu').val(($('#product_p1706_apu_original').val() * p1706_fac).toFixed(2));
        $('#product_p1706_labc').val(($('#product_p1706_labc_original').val() * p1706_fac).toFixed(2));
    }

    if((p1726_fac!=0)&&(p1726_fac != undefined))
    {
        // alert("p1526_fac = "+p1526_fac);
        $('#product_p1726_price').val(($('#product_p1726_price_original').val() * p1726_fac).toFixed(2));
        $('#product_p1726_apu').val(($('#product_p1726_apu_original').val() * p1726_fac).toFixed(2));
        $('#product_p1726_labc').val(($('#product_p1726_labc_original').val() * p1726_fac).toFixed(2));
    }

    if((p1746_fac!=0)&&(p1746_fac != undefined))
    {
        // alert("p1546_fac = "+p1546_fac);
        $('#product_p1746_price').val(($('#product_p1746_price_original').val() * p1746_fac).toFixed(2));
        $('#product_p1746_apu').val(($('#product_p1746_apu_original').val() * p1746_fac).toFixed(2));
        $('#product_p1746_labc').val(($('#product_p1746_labc_original').val() * p1746_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_ex_b7()
{
    var p1761_fac=$('#p1761_fac').val();
    var p1763_fac=$('#p1763_fac').val();
    var p1766_fac=$('#p1766_fac').val();

    if((p1761_fac!=0)&&(p1761_fac != undefined))
    {
        $('#product_p1761_price').val(($('#product_p1761_price_original').val() * p1761_fac).toFixed(2));
        $('#product_p1761_apu').val(($('#product_p1761_apu_original').val() * p1761_fac).toFixed(2));
        $('#product_p1761_labc').val(($('#product_p1761_labc_original').val() * p1761_fac).toFixed(2));
    }
    if((p1763_fac!=0)&&(p1763_fac != undefined))
    {
        $('#product_p1763_price').val(($('#product_p1763_price_original').val() * p1763_fac).toFixed(2));
        $('#product_p1763_apu').val(($('#product_p1763_apu_original').val() * p1763_fac).toFixed(2));
        $('#product_p1763_labc').val(($('#product_p1763_labc_original').val() * p1763_fac).toFixed(2));
    }

    if((p1766_fac!=0)&&(p1766_fac != undefined))
    {
        $('#product_p1766_price').val(($('#product_p1766_price_original').val() * p1766_fac).toFixed(2));
        $('#product_p1766_apu').val(($('#product_p1766_apu_original').val() * p1766_fac).toFixed(2));
        $('#product_p1766_labc').val(($('#product_p1766_labc_original').val() * p1766_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_in_b8()
{
    var p1800_fac=$('#p1800_fac').val();
    var p1801_fac=$('#p1801_fac').val();
    var p1804_fac=$('#p1804_fac').val();
    var p1821_fac=$('#p1821_fac').val();
    var p1824_fac=$('#p1824_fac').val();
    var p1841_fac=$('#p1841_fac').val();
    var p1844_fac=$('#p1844_fac').val();

    var p1806_fac=$('#p1806_fac').val();
    var p1826_fac=$('#p1826_fac').val();
    var p1846_fac=$('#p1846_fac').val();

    if((p1800_fac!=0)&&(p1800_fac != undefined))
    {
        
        $('#product_p1800_price').val(($('#product_p1800_price_original').val() * p1800_fac).toFixed(2));
        $('#product_p1800_apu').val(($('#product_p1800_apu_original').val() * p1800_fac).toFixed(2));
        $('#product_p1800_labc').val(($('#product_p1800_labc_original').val() * p1800_fac).toFixed(2));
    }

    if((p1801_fac!=0)&&(p1801_fac != undefined))
    {
        
        $('#product_p1801_price').val(($('#product_p1801_price_original').val() * p1801_fac).toFixed(2));
        $('#product_p1801_apu').val(($('#product_p1801_apu_original').val() * p1801_fac).toFixed(2));
        $('#product_p1801_labc').val(($('#product_p1801_labc_original').val() * p1801_fac).toFixed(2));
    }

    if((p1804_fac!=0)&&(p1804_fac != undefined))
    {
        
        $('#product_p1804_price').val(($('#product_p1804_price_original').val() * p1804_fac).toFixed(2));
        $('#product_p1804_apu').val(($('#product_p1804_apu_original').val() * p1804_fac).toFixed(2));
        $('#product_p1804_labc').val(($('#product_p1804_labc_original').val() * p1804_fac).toFixed(2));
    }

    if((p1821_fac!=0)&&(p1821_fac != undefined))
    {
        
        $('#product_p1821_price').val(($('#product_p1821_price_original').val() * p1821_fac).toFixed(2));
        $('#product_p1821_apu').val(($('#product_p1821_apu_original').val() * p1821_fac).toFixed(2));
        $('#product_p1821_labc').val(($('#product_p1821_labc_original').val() * p1821_fac).toFixed(2));
    }
    if((p1824_fac!=0)&&(p1824_fac != undefined))
    {
        
        $('#product_p1824_price').val(($('#product_p1824_price_original').val() * p1824_fac).toFixed(2));
        $('#product_p1824_apu').val(($('#product_p1824_apu_original').val() * p1824_fac).toFixed(2));
        $('#product_p1824_labc').val(($('#product_p1824_labc_original').val() * p1824_fac).toFixed(2));
    }

    if((p1841_fac!=0)&&(p1841_fac != undefined))
    {
        
        $('#product_p1841_price').val(($('#product_p1841_price_original').val() * p1841_fac).toFixed(2));
        $('#product_p1841_apu').val(($('#product_p1841_apu_original').val() * p1841_fac).toFixed(2));
        $('#product_p1841_labc').val(($('#product_p1841_labc_original').val() * p1841_fac).toFixed(2));
    }

    if((p1844_fac!=0)&&(p1844_fac != undefined))
    {
        
        $('#product_p1844_price').val(($('#product_p1844_price_original').val() * p1844_fac).toFixed(2));
        $('#product_p1844_apu').val(($('#product_p1844_apu_original').val() * p1844_fac).toFixed(2));
        $('#product_p1844_labc').val(($('#product_p1844_labc_original').val() * p1844_fac).toFixed(2));
    }

    if((p1806_fac!=0)&&(p1806_fac != undefined)) 
    {
        // alert("p1506_fac = "+p1506_fac);
        $('#product_p1806_price').val(($('#product_p1806_price_original').val() * p1806_fac).toFixed(2));
        $('#product_p1806_apu').val(($('#product_p1806_apu_original').val() * p1806_fac).toFixed(2));
        $('#product_p1806_labc').val(($('#product_p1806_labc_original').val() * p1806_fac).toFixed(2));
    }

    if((p1826_fac!=0)&&(p1826_fac != undefined))
    {
        // alert("p1526_fac = "+p1526_fac);
        $('#product_p1826_price').val(($('#product_p1826_price_original').val() * p1826_fac).toFixed(2));
        $('#product_p1826_apu').val(($('#product_p1826_apu_original').val() * p1826_fac).toFixed(2));
        $('#product_p1826_labc').val(($('#product_p1826_labc_original').val() * p1826_fac).toFixed(2));
    }

    if((p1846_fac!=0)&&(p1846_fac != undefined))
    {
        // alert("p1546_fac = "+p1546_fac);
        $('#product_p1846_price').val(($('#product_p1846_price_original').val() * p1846_fac).toFixed(2));
        $('#product_p1846_apu').val(($('#product_p1846_apu_original').val() * p1846_fac).toFixed(2));
        $('#product_p1846_labc').val(($('#product_p1846_labc_original').val() * p1846_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_ex_b8()
{
    var p1861_fac=$('#p1861_fac').val();
    var p1863_fac=$('#p1863_fac').val();
    var p1866_fac=$('#p1866_fac').val();

    if((p1861_fac!=0)&&(p1861_fac != undefined))
    {
        $('#product_p1861_price').val(($('#product_p1861_price_original').val() * p1861_fac).toFixed(2));
        $('#product_p1861_apu').val(($('#product_p1861_apu_original').val() * p1861_fac).toFixed(2));
        $('#product_p1861_labc').val(($('#product_p1861_labc_original').val() * p1861_fac).toFixed(2));
    }

    if((p1863_fac!=0)&&(p1863_fac != undefined))
    {
        $('#product_p1863_price').val(($('#product_p1863_price_original').val() * p1863_fac).toFixed(2));
        $('#product_p1863_apu').val(($('#product_p1863_apu_original').val() * p1863_fac).toFixed(2));
        $('#product_p1863_labc').val(($('#product_p1863_labc_original').val() * p1863_fac).toFixed(2));
    }

    if((p1866_fac!=0)&&(p1866_fac != undefined))
    {
        $('#product_p1866_price').val(($('#product_p1866_price_original').val() * p1866_fac).toFixed(2));
        $('#product_p1866_apu').val(($('#product_p1866_apu_original').val() * p1866_fac).toFixed(2));
        $('#product_p1866_labc').val(($('#product_p1866_labc_original').val() * p1866_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_in_b5()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_in_b5').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_in_b5').val(price.toFixed(2));
	
	$('.apus_in_b5').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_in_b5').val(apus.toFixed(2));
	
	$('.labcs_in_b5').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_in_b5').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_in_b6()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_in_b6').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_in_b6').val(price.toFixed(2));
	
	$('.apus_in_b6').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_in_b6').val(apus.toFixed(2));
	
	$('.labcs_in_b6').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_in_b6').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_in_b7()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_in_b7').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_in_b7').val(price.toFixed(2));
	
	$('.apus_in_b7').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_in_b7').val(apus.toFixed(2));
	
	$('.labcs_in_b7').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_in_b7').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_in_b8()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_in_b8').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_in_b8').val(price.toFixed(2));
	
	$('.apus_in_b8').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_in_b8').val(apus.toFixed(2));
	
	$('.labcs_in_b8').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_in_b8').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_ex_b3()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	/*$('.product_ex_b3').each(function() {
		
		if($(this).is(":checked"))
		{
			product += $(this).val()+";";
		}
	});	
	$('#collection').val(product);
	*/
	$('.prices_ex_b3').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_ex_b3').val(price.toFixed(2));
	
	$('.apus_ex_b3').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_ex_b3').val(apus.toFixed(2));
	
	$('.labcs_ex_b3').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_ex_b3').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_ex_b5()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_ex_b5').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_ex_b5').val(price.toFixed(2));
	
	$('.apus_ex_b5').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_ex_b5').val(apus.toFixed(2));
	
	$('.labcs_ex_b5').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_ex_b5').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_ex_b6()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_ex_b6').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_ex_b6').val(price.toFixed(2));
	
	$('.apus_ex_b6').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_ex_b6').val(apus.toFixed(2));
	
	$('.labcs_ex_b6').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_ex_b6').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_ex_b7()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_ex_b7').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_ex_b7').val(price.toFixed(2));
	
	$('.apus_ex_b7').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_ex_b7').val(apus.toFixed(2));
	
	$('.labcs_ex_b7').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_ex_b7').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_ex_b8()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_ex_b8').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_ex_b8').val(price.toFixed(2));
	
	$('.apus_ex_b8').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_ex_b8').val(apus.toFixed(2));
	
	$('.labcs_ex_b8').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_ex_b8').val(labc.toFixed(2));
}

function calculate_ex_b5()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b5').val()) * parseFloat($('#fac_cl_ex_b5').val());
	
	$('#o_price_ex_b5').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b5').val())*parseFloat($('#fac_prod_ex_b5').val());
	
	$('#o_apus_ex_b5').val(producerPriceTotal.toFixed(2));
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b5').val())*parseFloat($('#fac_labc_ex_b5').val());
	
	$('#total_labcs_ex_b5').val(producerTotallabc.toFixed(2));
}

function calculate_ex_b6()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b6').val()) * parseFloat($('#fac_cl_ex_b6').val());
	
	$('#o_price_ex_b6').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b6').val())*parseFloat($('#fac_prod_ex_b6').val());
	
	$('#o_apus_ex_b6').val(producerPriceTotal.toFixed(2));
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b6').val())*parseFloat($('#fac_labc_ex_b6').val());
	
	$('#total_labcs_ex_b6').val(producerTotallabc.toFixed(2));
}

function calculate_ex_b7()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b7').val()) * parseFloat($('#fac_cl_ex_b7').val());
	
	$('#o_price_ex_b7').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b7').val())*parseFloat($('#fac_prod_ex_b7').val());
	
	$('#o_apus_ex_b7').val(producerPriceTotal.toFixed(2));
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b7').val())*parseFloat($('#fac_labc_ex_b7').val());
	
	$('#total_labcs_ex_b7').val(producerTotallabc.toFixed(2));
}

function calculate_ex_b8()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b8').val()) * parseFloat($('#fac_cl_ex_b8').val());
	
	$('#o_price_ex_b8').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b8').val())*parseFloat($('#fac_prod_ex_b8').val());
	
	$('#o_apus_ex_b8').val(producerPriceTotal.toFixed(2));
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b8').val())*parseFloat($('#fac_labc_ex_b8').val());
	
	$('#total_labcs_ex_b8').val(producerTotallabc.toFixed(2));
}

function calculate_in_b3()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b3').val()) * parseFloat($('#fac_cl_in_b3').val());
	
	$('#o_price_in_b3').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b3').val())*parseFloat($('#fac_prod_in_b3').val());
	
	$('#o_apus_in_b3').val(producerPriceTotal.toFixed(2));	
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b3').val())*parseFloat($('#fac_labc_in_b3').val());
	
	$('#total_labcs_in_b3').val(producerTotallabc.toFixed(2));
}

function calculate_in_b5()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b5').val()) * parseFloat($('#fac_cl_in_b5').val());
	
	$('#o_price_in_b5').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b5').val())*parseFloat($('#fac_prod_in_b5').val());
	
	$('#o_apus_in_b5').val(producerPriceTotal.toFixed(2));	
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b5').val())*parseFloat($('#fac_labc_in_b5').val());
	
	$('#total_labcs_in_b5').val(producerTotallabc.toFixed(2));
}

function calculate_in_b6()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b6').val()) * parseFloat($('#fac_cl_in_b6').val());
	
	$('#o_price_in_b6').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b6').val())*parseFloat($('#fac_prod_in_b6').val());
	
	$('#o_apus_in_b6').val(producerPriceTotal.toFixed(2));	
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b6').val())*parseFloat($('#fac_labc_in_b6').val());
	
	$('#total_labcs_in_b6').val(producerTotallabc.toFixed(2));
}

function calculate_in_b7()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b7').val()) * parseFloat($('#fac_cl_in_b7').val());
	
	$('#o_price_in_b7').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b7').val())*parseFloat($('#fac_prod_in_b7').val());
	
	$('#o_apus_in_b7').val(producerPriceTotal.toFixed(2));	
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b7').val())*parseFloat($('#fac_labc_in_b7').val());
	
	$('#total_labcs_in_b7').val(producerTotallabc.toFixed(2));
}

function calculate_in_b8()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b8').val()) * parseFloat($('#fac_cl_in_b8').val());
	
	$('#o_price_in_b8').val(purchaserPriceTotal.toFixed(2));
	
	
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b8').val())*parseFloat($('#fac_prod_in_b8').val());
	
	$('#o_apus_in_b8').val(producerPriceTotal.toFixed(2));	
	
	
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b8').val())*parseFloat($('#fac_labc_in_b8').val());
	
	$('#total_labcs_in_b8').val(producerTotallabc.toFixed(2));
}

function calculatetotalPriceAPU()
{
	if($('#budget').val()!=1)
	{
	var o_price_in_b3 = parseFloat($('#o_price_in_b3').val());
    var o_price_in_b5 = parseFloat($('#o_price_in_b5').val());
    var o_price_in_b6 = parseFloat($('#o_price_in_b6').val());
    var o_price_in_b7 = parseFloat($('#o_price_in_b7').val());
    var o_price_in_b8 = parseFloat($('#o_price_in_b8').val());

    var o_price_ex_b5 = parseFloat($('#o_price_ex_b5').val());
    var o_price_ex_b6 = parseFloat($('#o_price_ex_b6').val());
	var o_price_ex_b7 = parseFloat($('#o_price_ex_b7').val());
    var o_price_ex_b8 = parseFloat($('#o_price_ex_b8').val());
    
	var o_apus_in_b3 = parseFloat($('#o_apus_in_b3').val());
    var o_apus_in_b5 = parseFloat($('#o_apus_in_b5').val());
    var o_apus_in_b6 = parseFloat($('#o_apus_in_b6').val());
    var o_apus_in_b7 = parseFloat($('#o_apus_in_b7').val());
    var o_apus_in_b8 = parseFloat($('#o_apus_in_b8').val());

    var o_apus_ex_b5 = parseFloat($('#o_apus_ex_b5').val());
    var o_apus_ex_b6 = parseFloat($('#o_apus_ex_b6').val());
	var o_apus_ex_b7 = parseFloat($('#o_apus_ex_b7').val());
    var o_apus_ex_b8 = parseFloat($('#o_apus_ex_b8').val());
    
	if(isNaN(o_price_in_b3))
	{
		o_price_in_b3=0;
	}
	if(isNaN(o_price_in_b5))
	{
		o_price_in_b5=0;
    }
    if(isNaN(o_price_in_b6))
	{
		o_price_in_b6=0;
	}
	if(isNaN(o_price_ex_b5))
	{
		o_price_ex_b5=0;
	}
	if(isNaN(o_price_in_b7))
	{
		o_price_in_b7=0;
    }
    if(isNaN(o_price_in_b8))
	{
		o_price_in_b8=0;
    }
    if(isNaN(o_price_ex_b6))
	{
		o_price_ex_b6=0;
	}
	if(isNaN(o_price_ex_b7))
	{
		o_price_ex_b7=0;
    }
    if(isNaN(o_price_ex_b8))
	{
		o_price_ex_b8=0;
	}
	if(isNaN(o_apus_in_b3))
	{
		o_apus_in_b3=0;
	}
	if(isNaN(o_apus_in_b5))
	{
		o_apus_in_b5=0;
    }
    if(isNaN(o_apus_in_b6))
	{
		o_apus_in_b6=0;
	}
	if(isNaN(o_apus_ex_b5))
	{
		o_apus_ex_b5=0;
	}
	if(isNaN(o_apus_in_b7))
	{
		o_apus_in_b7=0;
    }
    if(isNaN(o_apus_in_b8))
	{
		o_apus_in_b8=0;
    }
    if(isNaN(o_apus_ex_b6))
	{
		o_apus_ex_b6=0;
	}
	if(isNaN(o_apus_ex_b7))
	{
		o_apus_ex_b7=0;
    }
    if(isNaN(o_apus_ex_b8))
	{
		o_apus_ex_b8=0;
	}
	var totalPrice =  o_price_in_b3 + o_price_in_b5 + o_price_in_b6 + o_price_in_b8 + o_price_ex_b5 + o_price_ex_b6 + o_price_in_b7 + o_price_ex_b7 + o_price_ex_b8;
	var totalAPU = o_apus_in_b3 + o_apus_in_b5 + o_apus_in_b6 + o_apus_in_b8 + o_apus_ex_b6 + o_apus_ex_b8 + o_apus_in_b7 + o_apus_ex_b7;
	
	$('#o_price').val(totalPrice.toFixed(2));
	//$('#total_apu').val(totalAPU.toFixed(2));
	}
}