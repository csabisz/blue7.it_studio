$(document).ready(function() {
	
	var current_date = new Date();
	var minutes = 10;
	current_date.setTime(current_date.getTime() + (minutes * 60 * 1000));

	calculatePricesAPUslabcs_with_multiplicator_in_b1();
    calculatePricesAPUslabcs_with_multiplicator_in_b3();
    calculatePricesAPUslabcs_with_multiplicator_in_b5();
    calculatePricesAPUslabcs_with_multiplicator_in_b6();
    calculatePricesAPUslabcs_with_multiplicator_in_b7();
    calculatePricesAPUslabcs_with_multiplicator_in_b8();

	calculatePricesAPUslabcs_with_multiplicator_ex_b1();
    calculatePricesAPUslabcs_with_multiplicator_ex_b5();
    calculatePricesAPUslabcs_with_multiplicator_ex_b6();
    calculatePricesAPUslabcs_with_multiplicator_ex_b7();
    calculatePricesAPUslabcs_with_multiplicator_ex_b8();

	calculatePricesAPUslabcs_in_b1();
	calculatePricesAPUslabcs_g_b1();
	calculatePricesAPUslabcs_in_b3();
    calculatePricesAPUslabcs_in_b5();
    calculatePricesAPUslabcs_in_b6();
	calculatePricesAPUslabcs_in_b7();
    calculatePricesAPUslabcs_in_b8();

	calculatePricesAPUslabcs_ex_b1();
	calculatePricesAPUslabcs_ex_b3();
    calculatePricesAPUslabcs_ex_b5();
    calculatePricesAPUslabcs_ex_b6();
	calculatePricesAPUslabcs_ex_b7();
    calculatePricesAPUslabcs_ex_b8();
    
	calcPurchaserPrice_in_b1();
	calcPurchaserPrice_g_b1();
	calcPurchaserPrice_in_b3();
    calcPurchaserPrice_in_b5();
    calcPurchaserPrice_in_b6();
	calcPurchaserPrice_in_b7();
    calcPurchaserPrice_in_b8();
    
	calcPurchaserPrice_ex_b1();
	calcPurchaserPrice_ex_b3();
    calcPurchaserPrice_ex_b5();
    calcPurchaserPrice_ex_b6();
	calcPurchaserPrice_ex_b7();
    calcPurchaserPrice_ex_b8();
    
	calcProducerPrice_in_b1();
	calcProducerPrice_in_b3();
    calcProducerPrice_in_b5();
    calcProducerPrice_in_b6();
	calcProducerPrice_in_b7();
    calcProducerPrice_in_b8();
    
	calcProducerPrice_ex_b1();
	calcProducerPrice_ex_b3();
    calcProducerPrice_ex_b5();
    calcProducerPrice_ex_b6();
	calcProducerPrice_ex_b7();
    calcProducerPrice_ex_b8();
    
	calcEmployeeProducer_in_b1();
	calcEmployeeProducer_g_b1();
	calcEmployeeProducer_in_b3();
    calcEmployeeProducer_in_b5();
    calcEmployeeProducer_in_b6();
	calcEmployeeProducer_in_b7();
    calcEmployeeProducer_in_b8();
    
	calcEmployeeProducer_ex_b1();
	calcEmployeeProducer_ex_b3();
    calcEmployeeProducer_ex_b5();
    calcEmployeeProducer_ex_b6();
	calcEmployeeProducer_ex_b7();
    calcEmployeeProducer_ex_b8();
    
	calculatetotalPriceAPU();
	
	col_amount_in_calculations();
	col_amount_ex_calculations();

	//stairs

	$('#st_id0').click(function(){
		$('#st_id1').val($(this).val());
	});

	$('#st_id1').click(function(){
		$('#st_id0').val($(this).val());
	});
	
	$('#col_amount_general0').on('change keyup paste mouseup', function() 
	{

		$('#col_amount1_g_b1').val($('#col_amount_general0').val());
		$('#col_amount2_g_b1').val($('#col_amount_general0').val());
		$('#col_amount3_g_b1').val($('#col_amount_general0').val());

		calculatePricesAPUslabcs_with_multiplicator_g_b1();
        calculatePricesAPUslabcs_g_b1();
        calcPurchaserPrice_g_b1();
		calcProducerPrice_g_b1();
		calcEmployeeProducer_g_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount0').on('change keyup paste mouseup', function() 
	{

		$('#col_amount1_in_b1').val($('#col_amount0').val());
		$('#col_amount2_in_b1').val($('#col_amount0').val());
		$('#col_amount3_in_b1').val($('#col_amount0').val());

		$('#col_amount1_in_b3').val($('#col_amount0').val());
		$('#col_amount2_in_b3').val($('#col_amount0').val());
		$('#col_amount3_in_b3').val($('#col_amount0').val());
		
		$('#col_amount1_in_b5').val($('#col_amount0').val());
		$('#col_amount2_in_b5').val($('#col_amount0').val());
		$('#col_amount3_in_b5').val($('#col_amount0').val());
        
        $('#col_amount1_in_b6').val($('#col_amount0').val());
		$('#col_amount2_in_b6').val($('#col_amount0').val());
        $('#col_amount3_in_b6').val($('#col_amount0').val());

        $('#col_amount1_in_b7').val($('#col_amount0').val());
		$('#col_amount2_in_b7').val($('#col_amount0').val());
        $('#col_amount3_in_b7').val($('#col_amount0').val());
        
        $('#col_amount1_in_b8').val($('#col_amount0').val());
		$('#col_amount2_in_b8').val($('#col_amount0').val());
        $('#col_amount3_in_b8').val($('#col_amount0').val());

		// $.removeCookie("col_amount0", { path: '/' });
		// $.cookie("col_amount0", $(this).val(), {expires: current_date, path:'/'});
		
        calculatePricesAPUslabcs_in_b5();
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
        calcEmployeeProducer_in_b5();
        
        calculatePricesAPUslabcs_in_b6();
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
        calcEmployeeProducer_in_b6();
        
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
        calcEmployeeProducer_in_b7();
        
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
        calcEmployeeProducer_in_b8();
        
		calculatetotalPriceAPU();
	});
    
    $('#col_amount0_ex').on('change keyup paste mouseup', function() 
	{
		
		$('#col_amount1_ex_b1').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b1').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b1').val($('#col_amount0_ex').val());

		$('#col_amount1_ex_b5').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b5').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b5').val($('#col_amount0_ex').val());
        
        $('#col_amount1_ex_b6').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b6').val($('#col_amount0_ex').val());
        $('#col_amount3_ex_b6').val($('#col_amount0_ex').val());

        $('#col_amount1_ex_b7').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b7').val($('#col_amount0_ex').val());
        $('#col_amount3_ex_b7').val($('#col_amount0_ex').val());

        $('#col_amount1_ex_b8').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b8').val($('#col_amount0_ex').val());
        $('#col_amount3_ex_b8').val($('#col_amount0_ex').val());

        
		$.removeCookie("col_amount0_ex", { path: '/' });
		$.cookie("col_amount0_ex", $(this).val(), {expires: current_date, path:'/'});
        
		calculatePricesAPUslabcs_with_multiplicator_ex_b1();
        calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
        calcEmployeeProducer_ex_b1();

        calculatePricesAPUslabcs_with_multiplicator_ex_b5();
        calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
        calcEmployeeProducer_ex_b5();
        
        calculatePricesAPUslabcs_with_multiplicator_ex_b6();
        calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
        calcEmployeeProducer_ex_b6();

        calculatePricesAPUslabcs_with_multiplicator_ex_b7();
        calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
        calcEmployeeProducer_ex_b7();

        calculatePricesAPUslabcs_with_multiplicator_ex_b8();
        calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
        calcEmployeeProducer_ex_b8();

		calculatetotalPriceAPU();
    });
    
	$('#total_special_agreement_price').on('change keyup paste mouseup', function() {		
		$.removeCookie("total_special_agreement_price", { path: '/' });
		$.cookie("total_special_agreement_price", $(this).val(), {expires: current_date, path:'/'});		
	});
	
	$('#levels_over_ground').on('change keyup paste mouseup', function() {
		$.cookie("levels_over_ground", $(this).val(), {expires: current_date, path:'/'});
	});
	
	//b5 in
	
	$('#col_amount1_in_b5').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b5').val($('#col_amount1_in_b5').val());
		$('#col_amount3_in_b5').val($('#col_amount1_in_b5').val());
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_in_b5').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b5').val($('#col_amount2_in_b5').val());
		$('col_amount3_in_b5').val($('#col_amount2_in_b5').val());
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_in_b5').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b5').val($('#col_amount3_in_b5').val());
		$('#col_amount2_in_b5').val($('#col_amount3_in_b5').val());
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
    
    //b6 in
	
	$('#col_amount1_in_b6').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b6').val($('#col_amount1_in_b6').val());
		$('#col_amount3_in_b6').val($('#col_amount1_in_b6').val());
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_in_b6').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b6').val($('#col_amount2_in_b6').val());
		$('col_amount3_in_b6').val($('#col_amount2_in_b6').val());
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_in_b6').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b6').val($('#col_amount3_in_b6').val());
		$('#col_amount2_in_b6').val($('#col_amount3_in_b6').val());
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
    });
    
	//b7 in
	
	$('#col_amount1_in_b7').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b7').val($('#col_amount1_in_b7').val());
		$('#col_amount3_in_b7').val($('#col_amount1_in_b7').val());
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_in_b7').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b7').val($('#col_amount2_in_b7').val());
		$('col_amount3_in_b7').val($('#col_amount2_in_b7').val());
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_in_b7').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b7').val($('#col_amount3_in_b7').val());
		$('#col_amount2_in_b7').val($('#col_amount3_in_b7').val());
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
    
    //b8 in
	
	$('#col_amount1_in_b8').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b8').val($('#col_amount1_in_b8').val());
		$('#col_amount3_in_b8').val($('#col_amount1_in_b8').val());
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_in_b8').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b8').val($('#col_amount2_in_b8').val());
		$('col_amount3_in_b8').val($('#col_amount2_in_b8').val());
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_in_b8').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b8').val($('#col_amount3_in_b8').val());
		$('#col_amount2_in_b8').val($('#col_amount3_in_b8').val());
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
    });
    
	//b1 ex 
	
	$('#col_amount1_ex_b1').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b1').val($('#col_amount1_ex_b1').val());
        $('#col_amount3_ex_b1').val($('#col_amount1_ex_b1').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b1();
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_ex_b1').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b1').val($('#col_amount2_ex_b1').val());
        $('col_amount3_ex_b1').val($('#col_amount2_ex_b1').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b1();
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_ex_b1').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b1').val($('#col_amount3_ex_b1').val());
        $('#col_amount2_ex_b1').val($('#col_amount3_ex_b1').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b1();
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
	});

	//b5 ex 
	
	$('#col_amount1_ex_b5').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b5').val($('#col_amount1_ex_b5').val());
        $('#col_amount3_ex_b5').val($('#col_amount1_ex_b5').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b5();
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_ex_b5').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b5').val($('#col_amount2_ex_b5').val());
        $('col_amount3_ex_b5').val($('#col_amount2_ex_b5').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b5();
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_ex_b5').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b5').val($('#col_amount3_ex_b5').val());
        $('#col_amount2_ex_b5').val($('#col_amount3_ex_b5').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b5();
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
	});
    
    //b6 ex 
	
	$('#col_amount1_ex_b6').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b5').val($('#col_amount1_ex_b6').val());
        $('#col_amount3_ex_b5').val($('#col_amount1_ex_b6').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b6();
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_ex_b6').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b6').val($('#col_amount2_ex_b6').val());
        $('col_amount3_ex_b6').val($('#col_amount2_ex_b6').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b6();
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_ex_b6').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b6').val($('#col_amount3_ex_b6').val());
        $('#col_amount2_ex_b6').val($('#col_amount3_ex_b6').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b6();
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
    });
    
	//b7 ex 
	
	$('#col_amount1_ex_b7').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b7').val($('#col_amount1_ex_b7').val());
        $('#col_amount3_ex_b7').val($('#col_amount1_ex_b7').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b7();
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_ex_b7').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b7').val($('#col_amount2_ex_b7').val());
        $('col_amount3_ex_b7').val($('#col_amount2_ex_b7').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b7();
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_ex_b7').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b7').val($('#col_amount3_ex_b7').val());
        $('#col_amount2_ex_b7').val($('#col_amount3_ex_b7').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b7();
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
	});
    
    //b8 ex 
	
	$('#col_amount1_ex_b8').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b8').val($('#col_amount1_ex_b8').val());
        $('#col_amount3_ex_b8').val($('#col_amount1_ex_b8').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b8();
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_ex_b8').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b8').val($('#col_amount2_ex_b8').val());
        $('col_amount3_ex_b8').val($('#col_amount2_ex_b8').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b8();
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_ex_b8').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b8').val($('#col_amount3_ex_b8').val());
        $('#col_amount2_ex_b8').val($('#col_amount3_ex_b8').val());
        calculatePricesAPUslabcs_with_multiplicator_ex_b8();
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
    });
    
	//b3 in
	
	$('#b3_main_fac').on('change keyup paste mouseup', function() {
        $('.b3_in_multiplicator').val($(this).val());
        calculatePricesAPUslabcs_with_multiplicator_in_b3();
        calculatePricesAPUslabcs_in_b3();
        calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
    });
    
    $('.b5_in_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
        calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
    });

	$('.b1_in_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b1();
        calculatePricesAPUslabcs_in_b1();
        calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
    });

	$('.b1_ex_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_ex_b1();
        calculatePricesAPUslabcs_ex_b1();
        calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
    });

	$('.b1_g_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_g_b1();
        calculatePricesAPUslabcs_g_b1();
        calcPurchaserPrice_g_b1();
		calcProducerPrice_g_b1();
		calcEmployeeProducer_g_b1();
		calculatetotalPriceAPU();
    });

    $('.b5_ex_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_ex_b5();
        calculatePricesAPUslabcs_ex_b5();
        calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
    });

    $('.b6_in_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
        calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
    });

    $('.b6_ex_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_ex_b6();
        calculatePricesAPUslabcs_ex_b6();
        calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
    });

    $('.b7_in_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
        calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
    });

    $('.b7_ex_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_ex_b7();
        calculatePricesAPUslabcs_ex_b7();
        calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
    });

    $('.b8_in_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
        calculatePricesAPUslabcs_in_b8();
        calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
    });

    $('.b8_ex_multiplicator').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_ex_b8();
        calculatePricesAPUslabcs_ex_b8();
        calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
    });

	$('#col_amount1_g_b1').on('change keyup paste mouseup', function() {
		$('#col_amount2_g_b1').val($('#col_amount1_g_b1').val());
		$('#col_amount3_g_b1').val($('#col_amount1_g_b1').val());
		calculatePricesAPUslabcs_g_b1();
		calcPurchaserPrice_g_b1();
		calcProducerPrice_g_b1();
		calcEmployeeProducer_g_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_g_b1').on('change keyup paste mouseup', function() {
		$('#col_amount1_g_b1').val($('#col_amount2_g_b1').val());
		$('#col_amount3_g_b1').val($('#col_amount2_g_b1').val());
		calculatePricesAPUslabcs_g_b1();
		calcPurchaserPrice_g_b1();
		calcProducerPrice_g_b1();
		calcEmployeeProducer_g_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_g_b1').on('change keyup paste mouseup', function() {
		$('#col_amount1_g_b1').val($('#col_amount3_g_b1').val());
		$('#col_amount2_g_b1').val($('#col_amount3_g_b1').val());
		calculatePricesAPUslabcs_g_b1();
		calcPurchaserPrice_g_b1();
		calcProducerPrice_g_b1();
		calcEmployeeProducer_g_b1();
		calculatetotalPriceAPU();
	});

	$('#col_amount1_in_b1').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b1').val($('#col_amount1_in_b1').val());
		$('#col_amount3_in_b1').val($('#col_amount1_in_b1').val());
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_in_b1').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b1').val($('#col_amount2_in_b1').val());
		$('#col_amount3_in_b1').val($('#col_amount2_in_b1').val());
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_in_b1').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b1').val($('#col_amount3_in_b1').val());
		$('#col_amount2_in_b1').val($('#col_amount3_in_b1').val());
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
	});
	
	$('#fac_cl_in_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
	});

	$('#col_amount1_in_b3').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b3').val($('#col_amount1_in_b3').val());
		$('#col_amount3_in_b3').val($('#col_amount1_in_b3').val());
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount2_in_b3').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b3').val($('#col_amount2_in_b3').val());
		$('#col_amount3_in_b3').val($('#col_amount2_in_b3').val());
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
	});
	
	$('#col_amount3_in_b3').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b3').val($('#col_amount3_in_b3').val());
		$('#col_amount2_in_b3').val($('#col_amount3_in_b3').val());
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
	});
	
	$('#fac_cl_in_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
	});
	
	//b3 ex
	
	$('#fac_cl_ex_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		calcProducerPrice_ex_b3();
		calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_ex_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		calcProducerPrice_ex_b3();
		calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_ex_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		calcProducerPrice_ex_b3();
		calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_ex_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		calcProducerPrice_ex_b3();
		calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	//b5 in
	
	
	
	$('#fac_cl_in_b5').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b5').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b5').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b5').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	//b1 ex
	
	$('#fac_cl_ex_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_ex_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_ex_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_ex_b1').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
	});

	//b5 ex
	
	$('#fac_cl_ex_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_ex_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_ex_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_ex_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
	});
	
	
	$('#vat_percent').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs();
		calcPurchaserPrice();
		calcProducerPrice();
		calcEmployeeProducer();
		calculatetotalPriceAPU();
	});
    
    
    //b6 in
	
	$('#fac_cl_in_b6').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b6').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b6').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b6').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
	});
	
	//b6 ex
	
	$('#fac_cl_ex_b6').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_ex_b6').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_ex_b6').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_ex_b6').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
	});
	
	
	$('#fac_cl_in_b7').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b7').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b7').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b7').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	//b7 ex
	
	$('#fac_cl_ex_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_ex_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_ex_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_ex_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
	});
    
    //b8 in
	
	$('#fac_cl_in_b8').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b8').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b8').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b8').on('change keyup paste mouseup', function() {
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
	});
	
	//b8 ex
	
	$('#fac_cl_ex_b8').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_ex_b8').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_ex_b8').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_ex_b8').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
    });
    
	
	
	//create order 
	
	$('.product_in_b1').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b1');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b1');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b1');
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b1');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b1');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b1');
        }		

		$('#col_amount1_in_b1').val($('#col_amount0').val());
		$('#col_amount2_in_b1').val($('#col_amount0').val());
		$('#col_amount3_in_b1').val($('#col_amount0').val());

        calculatePricesAPUslabcs_with_multiplicator_in_b1();
		calculatePricesAPUslabcs_in_b1();
		calcPurchaserPrice_in_b1();
		calcProducerPrice_in_b1();
		calcEmployeeProducer_in_b1();
		calculatetotalPriceAPU();
		get_collection();
	});

	$('.product_in_b3').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b3');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b3');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b3');
			
			/*if(($(this).val()=="p1502")||($(this).val()=="p1503")||($(this).val()=="p1504")||($(this).val()=="p1505")||($(this).val()=="p1506")||($(this).val()=="p1507"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices');
				$('#product_p1501_apu').addClass('apus');
				$('#product_p1501_labc').addClass('labcs');
			}*/
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b3');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b3');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b3');
        }		

		$('#col_amount1_in_b3').val($('#col_amount0').val());
		$('#col_amount2_in_b3').val($('#col_amount0').val());
		$('#col_amount3_in_b3').val($('#col_amount0').val());

        calculatePricesAPUslabcs_with_multiplicator_in_b3();
		calculatePricesAPUslabcs_in_b3();
		calcPurchaserPrice_in_b3();
		calcProducerPrice_in_b3();
		calcEmployeeProducer_in_b3();
		calculatetotalPriceAPU();
		get_collection();
	});
	
	$('.product_in_b5').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b5');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b5');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b5');
			
			if(($(this).val()=="p1502")||($(this).val()=="p1503")||($(this).val()=="p1504")||($(this).val()=="p1505")||($(this).val()=="p1506")||($(this).val()=="p1507"))
			{
                          
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices_in_b5');
				$('#product_p1501_apu').addClass('apus_in_b5');
				$('#product_p1501_labc').addClass('labcs_in_b5');
			}
            
            if(($(this).val()=="p1522")||($(this).val()=="p1523")||($(this).val()=="p1524")||($(this).val()=="p1525")||($(this).val()=="p1526")||($(this).val()=="p1527"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices_in_b5');
				$('#product_p1501_apu').addClass('apus_in_b5');
				$('#product_p1501_labc').addClass('labcs_in_b5');
				
				$('#p1521').prop('checked',true);
				$('#p1521').parent().addClass('active_layout');
				$('#product_p1521_price').addClass('prices_in_b5');
				$('#product_p1521_apu').addClass('apus_in_b5');
				$('#product_p1521_labc').addClass('labcs_in_b5');
			}
			
			if(($(this).val()=="p1542")||($(this).val()=="p1543")||($(this).val()=="p1544")||($(this).val()=="p1545")||($(this).val()=="p1546")||($(this).val()=="p1547"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices_in_b5');
				$('#product_p1501_apu').addClass('apus_in_b5');
				$('#product_p1501_labc').addClass('labcs_in_b5');
				
				$('#p1541').prop('checked',true);
				$('#p1541').parent().addClass('active_layout');
				$('#product_p1541_price').addClass('prices_in_b5');
				$('#product_p1541_apu').addClass('apus_in_b5');
				$('#product_p1541_labc').addClass('labcs_in_b5');
			}
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b5');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b5');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b5');
        }
		
		$('#col_amount1_in_b5').val($('#col_amount0').val());
		$('#col_amount2_in_b5').val($('#col_amount0').val());
		$('#col_amount3_in_b5').val($('#col_amount0').val());

        calculatePricesAPUslabcs_with_multiplicator_in_b5();
        calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
		get_collection();
	});
    
    $('.product_in_b6').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b6');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b6');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b6');
			
			if(($(this).val()=="p1600")||($(this).val()=="p1601")||($(this).val()=="p1602")||($(this).val()=="p1603")||($(this).val()=="p1604")||($(this).val()=="p1605")||($(this).val()=="p1606")||($(this).val()=="p1607"))
			{
                $('#p1600').prop('checked',true);
				$('#p1600').parent().addClass('active_layout');
				$('#product_p1600_price').addClass('prices_in_b6');
				$('#product_p1600_apu').addClass('apus_in_b6');
                $('#product_p1600_labc').addClass('labcs_in_b6');
                
				$('#p1601').prop('checked',true);
				$('#p1601').parent().addClass('active_layout');
				$('#product_p1601_price').addClass('prices_in_b6');
				$('#product_p1601_apu').addClass('apus_in_b6');
				$('#product_p1601_labc').addClass('labcs_in_b6');
			}
			if(($(this).val()=="p1622")||($(this).val()=="p1623")||($(this).val()=="p1624")||($(this).val()=="p1625")||($(this).val()=="p1626")||($(this).val()=="p1627"))
			{
                $('#p1600').prop('checked',true);
				$('#p1600').parent().addClass('active_layout');
				$('#product_p1600_price').addClass('prices_in_b6');
				$('#product_p1600_apu').addClass('apus_in_b6');
                $('#product_p1600_labc').addClass('labcs_in_b6');

				$('#p1601').prop('checked',true);
				$('#p1601').parent().addClass('active_layout');
				$('#product_p1601_price').addClass('prices_in_b6');
				$('#product_p1601_apu').addClass('apus_in_b6');
				$('#product_p1601_labc').addClass('labcs_in_b6');
				
				$('#p1621').prop('checked',true);
				$('#p1621').parent().addClass('active_layout');
				$('#product_p1621_price').addClass('prices_in_b6');
				$('#product_p1621_apu').addClass('apus_in_b6');
				$('#product_p1621_labc').addClass('labcs_in_b6');
			}
			
			if(($(this).val()=="p1642")||($(this).val()=="p1643")||($(this).val()=="p1644")||($(this).val()=="p1645")||($(this).val()=="p1646")||($(this).val()=="p1647"))
			{
                $('#p1600').prop('checked',true);
				$('#p1600').parent().addClass('active_layout');
				$('#product_p1600_price').addClass('prices_in_b6');
				$('#product_p1600_apu').addClass('apus_in_b6');
                $('#product_p1600_labc').addClass('labcs_in_b6');

				$('#p1601').prop('checked',true);
				$('#p1601').parent().addClass('active_layout');
				$('#product_p1601_price').addClass('prices_in_b6');
				$('#product_p1601_apu').addClass('apus_in_b6');
				$('#product_p1601_labc').addClass('labcs_in_b6');
				
				$('#p1641').prop('checked',true);
				$('#p1641').parent().addClass('active_layout');
				$('#product_p1641_price').addClass('prices_in_b6');
				$('#product_p1641_apu').addClass('apus_in_b6');
				$('#product_p1641_labc').addClass('labcs_in_b6');
			}
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b6');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b6');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b6');
        }		

		$('#col_amount1_in_b6').val($('#col_amount0').val());
		$('#col_amount2_in_b6').val($('#col_amount0').val());
        $('#col_amount3_in_b6').val($('#col_amount0').val());

        calculatePricesAPUslabcs_with_multiplicator_in_b6();
        calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
		calculatetotalPriceAPU();
		get_collection();
    });
    
    $('.product_in_b7').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b7');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b7');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b7');
			
			if(($(this).val()=="p1700")||($(this).val()=="p1701")||($(this).val()=="p1702")||($(this).val()=="p1703")||($(this).val()=="p1704")||($(this).val()=="p1705")||($(this).val()=="p1706")||($(this).val()=="p1707"))
			{
                $('#p1700').prop('checked',true);
				$('#p1700').parent().addClass('active_layout');
				$('#product_p1700_price').addClass('prices_in_b7');
				$('#product_p1700_apu').addClass('apus_in_b7');
                $('#product_p1700_labc').addClass('labcs_in_b7');
                
				$('#p1701').prop('checked',true);
				$('#p1701').parent().addClass('active_layout');
				$('#product_p1701_price').addClass('prices_in_b7');
				$('#product_p1701_apu').addClass('apus_in_b7');
				$('#product_p1701_labc').addClass('labcs_in_b7');
			}
			if(($(this).val()=="p1722")||($(this).val()=="p1723")||($(this).val()=="p1724")||($(this).val()=="p1725")||($(this).val()=="p1726")||($(this).val()=="p1727"))
			{
                $('#p1700').prop('checked',true);
				$('#p1700').parent().addClass('active_layout');
				$('#product_p1700_price').addClass('prices_in_b7');
				$('#product_p1700_apu').addClass('apus_in_b7');
                $('#product_p1700_labc').addClass('labcs_in_b7');

				$('#p1701').prop('checked',true);
				$('#p1701').parent().addClass('active_layout');
				
				$('#p1721').prop('checked',true);
				$('#p1721').parent().addClass('active_layout');
				
				$('#product_p1701_price').addClass('prices_in_b7');
				$('#product_p1701_apu').addClass('apus_in_b7');
				$('#product_p1701_labc').addClass('labcs_in_b7');
				
				$('#product_p1721_price').addClass('prices_in_b7');
				$('#product_p1721_apu').addClass('apus_in_b7');
				$('#product_p1721_labc').addClass('labcs_in_b7');
			}
			
			if(($(this).val()=="p1742")||($(this).val()=="p1743")||($(this).val()=="p1744")||($(this).val()=="p1745")||($(this).val()=="p1746")||($(this).val()=="p1747"))
			{
                $('#p1700').prop('checked',true);
				$('#p1700').parent().addClass('active_layout');
				$('#product_p1700_price').addClass('prices_in_b7');
				$('#product_p1700_apu').addClass('apus_in_b7');
                $('#product_p1700_labc').addClass('labcs_in_b7');

				$('#p1701').prop('checked',true);
				$('#p1701').parent().addClass('active_layout');
				
				$('#p1741').prop('checked',true);
				$('#p1741').parent().addClass('active_layout');
				
				$('#product_p1701_price').addClass('prices_in_b7');
				$('#product_p1701_apu').addClass('apus_in_b7');
				$('#product_p1701_labc').addClass('labcs_in_b7');
				
				$('#product_p1741_price').addClass('prices_in_b7');
				$('#product_p1741_apu').addClass('apus_in_b7');
				$('#product_p1741_labc').addClass('labcs_in_b7');
			}	
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b7');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b7');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b7');
		}		

		$('#col_amount1_in_b7').val($('#col_amount0').val());
		$('#col_amount2_in_b7').val($('#col_amount0').val());
        $('#col_amount3_in_b7').val($('#col_amount0').val());

        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
		get_collection();
	});
    
    $('.product_in_b8').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b8');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b8');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b8');
			
			if(($(this).val()=="p1800")||($(this).val()=="p1801")||($(this).val()=="p1802")||($(this).val()=="p1803")||($(this).val()=="p1804")||($(this).val()=="p1805")||($(this).val()=="p1806")||($(this).val()=="p1807"))
			{
                $('#p1800').prop('checked',true);
				$('#p1800').parent().addClass('active_layout');
				$('#product_p1800_price').addClass('prices_in_b8');
				$('#product_p1800_apu').addClass('apus_in_b8');
                $('#product_p1800_labc').addClass('labcs_in_b8');
                
				$('#p1801').prop('checked',true);
				$('#p1801').parent().addClass('active_layout');
				$('#product_p1801_price').addClass('prices_in_b8');
				$('#product_p1801_apu').addClass('apus_in_b8');
				$('#product_p1801_labc').addClass('labcs_in_b8');
			}
			if(($(this).val()=="p1822")||($(this).val()=="p1823")||($(this).val()=="p1824")||($(this).val()=="p1825")||($(this).val()=="p1826")||($(this).val()=="p1827"))
			{
                $('#p1800').prop('checked',true);
				$('#p1800').parent().addClass('active_layout');
				$('#product_p1800_price').addClass('prices_in_b8');
				$('#product_p1800_apu').addClass('apus_in_b8');
                $('#product_p1800_labc').addClass('labcs_in_b8');

				$('#p1801').prop('checked',true);
				$('#p1801').parent().addClass('active_layout');
				
				$('#p1821').prop('checked',true);
				$('#p1821').parent().addClass('active_layout');
				
				$('#product_p1801_price').addClass('prices_in_b8');
				$('#product_p1801_apu').addClass('apus_in_b8');
				$('#product_p1801_labc').addClass('labcs_in_b8');
				
				$('#product_p1821_price').addClass('prices_in_b8');
				$('#product_p1821_apu').addClass('apus_in_b8');
				$('#product_p1821_labc').addClass('labcs_in_b8');
			}
			
			if(($(this).val()=="p1842")||($(this).val()=="p1843")||($(this).val()=="p1844")||($(this).val()=="p1845")||($(this).val()=="p1846")||($(this).val()=="p1847"))
			{
                $('#p1800').prop('checked',true);
				$('#p1800').parent().addClass('active_layout');
				$('#product_p1800_price').addClass('prices_in_b8');
				$('#product_p1800_apu').addClass('apus_in_b8');
                $('#product_p1800_labc').addClass('labcs_in_b8');
                
				$('#p1801').prop('checked',true);
				$('#p1801').parent().addClass('active_layout');
				
				$('#p1841').prop('checked',true);
				$('#p1841').parent().addClass('active_layout');
				
				$('#product_p1801_price').addClass('prices_in_b8');
				$('#product_p1801_apu').addClass('apus_in_b8');
				$('#product_p1801_labc').addClass('labcs_in_b8');
				
				$('#product_p1841_price').addClass('prices_in_b8');
				$('#product_p1841_apu').addClass('apus_in_b8');
				$('#product_p1841_labc').addClass('labcs_in_b8');
			}	
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b8');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b8');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b8');
		}		

		$('#col_amount1_in_b8').val($('#col_amount0').val());
		$('#col_amount2_in_b8').val($('#col_amount0').val());
        $('#col_amount3_in_b8').val($('#col_amount0').val());

        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
		get_collection();
    });
    
	$('.product_g_b1').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_g_b1');
			$('#product_'+$(this).val()+'_apu').addClass('apus_g_b1');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_g_b1');
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_g_b1');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_g_b1');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_g_b1');
        }		

		$('#col_amount1_g_b3').val($('#col_amount0_ex').val());
		$('#col_amount2_g_b3').val($('#col_amount0_ex').val());
		$('#col_amount3_g_b3').val($('#col_amount0_ex').val());

        calculatePricesAPUslabcs_with_multiplicator_g_b1();
		calculatePricesAPUslabcs_g_b1();
		calcPurchaserPrice_g_b1();
		calcProducerPrice_g_b1();
		calcEmployeeProducer_g_b1();
		calculatetotalPriceAPU();
		get_collection();
	});

	$('.product_ex_b1').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b1');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b1');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b1');
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b1');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b1');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b1');
        }		

		$('#col_amount1_ex_b3').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b3').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b3').val($('#col_amount0_ex').val());

        calculatePricesAPUslabcs_with_multiplicator_ex_b1();
		calculatePricesAPUslabcs_ex_b1();
		calcPurchaserPrice_ex_b1();
		calcProducerPrice_ex_b1();
		calcEmployeeProducer_ex_b1();
		calculatetotalPriceAPU();
		get_collection();
	});

	$('.product_ex_b3').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b3');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b3');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b3');
			
			/*if(($(this).val()=="p1502")||($(this).val()=="p1503")||($(this).val()=="p1504")||($(this).val()=="p1505")||($(this).val()=="p1506")||($(this).val()=="p1507"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices');
				$('#product_p1501_apu').addClass('apus');
				$('#product_p1501_labc').addClass('labcs');
			}*/
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b3');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b3');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b3');
		}		

		$('#col_amount1_ex_b3').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b3').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b3').val($('#col_amount0_ex').val());

		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		calcProducerPrice_ex_b3();
		calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
		get_collection();
	});
	
	$('.product_ex_b5').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b5');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b5');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b5');
			
			if(($(this).val()=="p1563")||($(this).val()=="p1566")||($(this).val()=="p1568")||($(this).val()=="p1567"))
			{
				$('#p1561').prop('checked',true);
				$('#p1561').parent().addClass('active_layout');
				$('#product_p1561_price').addClass('prices_ex_b5');
				$('#product_p1561_apu').addClass('apus_ex_b5');
				$('#product_p1561_labc').addClass('labcs_ex_b5');
			}
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b5');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b5');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b5');
        }		

		$('#col_amount1_ex_b5').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b5').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b5').val($('#col_amount0_ex').val());

        calculatePricesAPUslabcs_with_multiplicator_ex_b5();
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
		calculatetotalPriceAPU();
		get_collection();
	});
    
    $('.product_ex_b6').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b6');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b6');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b6');
			
			if(($(this).val()=="p1663")||($(this).val()=="p1666")||($(this).val()=="p1668")||($(this).val()=="p1667"))
			{
				$('#p1661').prop('checked',true);
				$('#p1661').parent().addClass('active_layout');
				$('#product_p1661_price').addClass('prices_ex_b6');
				$('#product_p1661_apu').addClass('apus_ex_b6');
				$('#product_p1661_labc').addClass('labcs_ex_b6');
			}
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b6');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b6');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b6');
        }		

		$('#col_amount1_ex_b6').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b6').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b6').val($('#col_amount0_ex').val());

        calculatePricesAPUslabcs_with_multiplicator_ex_b6();
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
		calculatetotalPriceAPU();
		get_collection();
    });
    
    $('.product_ex_b7').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b7');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b7');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b7');
			
			if(($(this).val()=="p1763")||($(this).val()=="p1766")||($(this).val()=="p1768")||($(this).val()=="p1767"))
			{
				$('#p1761').prop('checked',true);
				$('#p1761').parent().addClass('active_layout');
								
				$('#product_p1761_price').addClass('prices_ex_b7');
				$('#product_p1761_apu').addClass('apus_ex_b7');
				$('#product_p1761_labc').addClass('labcs_ex_b7');
			}
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b7');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b7');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b7');
        }		

		$('#col_amount1_ex_b6').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b6').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b6').val($('#col_amount0_ex').val());

        calculatePricesAPUslabcs_with_multiplicator_ex_b7();
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
		calculatetotalPriceAPU();
		get_collection();
    });
    
    $('.product_ex_b8').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b8');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b8');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b8');
			
            if(($(this).val()=="p1863")||($(this).val()=="p1866")||($(this).val()=="p1868")||($(this).val()=="p1867"))
			{
				$('#p1861').prop('checked',true);
				$('#p1861').parent().addClass('active_layout');
								
				$('#product_p1861_price').addClass('prices_ex_b8');
				$('#product_p1861_apu').addClass('apus_ex_b8');
				$('#product_p1861_labc').addClass('labcs_ex_b8');
			}
			
		}
		else
		{
			$(this).parent().removeClass('active_layout');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b8');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b8');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b8');
        }		

		$('#col_amount1_ex_b8').val($('#col_amount0_ex').val());
		$('#col_amount2_ex_b8').val($('#col_amount0_ex').val());
		$('#col_amount3_ex_b8').val($('#col_amount0_ex').val());

        calculatePricesAPUslabcs_with_multiplicator_ex_b8();
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
		get_collection();
    });

/* colorbox click */

$('.b5_layout').click(function(){
    $('#b5_nav .nav-item').removeClass('active-layoutline');
    //$(this).parent().removeClass('active-layoutline');
	$(this).parent().addClass('active-layoutline');
	//console.log($(this).parent().attr('title'));
	$("input[name='b5_selected_layoutline']").val($(this).parent().attr('title'));
});

$("textarea[name='environment_address']").on('change keyup paste mouseup',function(){
    $("textarea[name='environment_address']").val($(this).val());
});

$("textarea[name='customer_remarks_ex_b5']").on('change keyup paste mouseup',function(){
    $("textarea[name='customer_remarks_ex_b5']").val($(this).val());
});

$("textarea[name='op_remarks_ex_b5']").on('change keyup paste mouseup',function(){
    $("textarea[name='op_remarks_ex_b5']").val($(this).val());
});

$('.b6_layout').click(function(){
    $('#b6_nav .nav-item').removeClass('active-layoutline');
    //$(this).parent().removeClass('active-layoutline');
	$(this).parent().addClass('active-layoutline');
	//console.log($(this).parent().attr('title'));
	$("input[name='b6_selected_layoutline']").val($(this).parent().attr('title'));
});

$('.b7_layout').click(function(){
    $('#b7_nav .nav-item').removeClass('active-layoutline');
    //$(this).parent().removeClass('active-layoutline');
	$(this).parent().addClass('active-layoutline');
	//console.log($(this).parent().attr('title'));
	$("input[name='b7_selected_layoutline']").val($(this).parent().attr('title'));
});

$('.b8_layout').click(function(){
    $('#b8_nav .nav-item').removeClass('active-layoutline');
    //$(this).parent().removeClass('active-layoutline');
	$(this).parent().addClass('active-layoutline');
	//console.log($(this).parent().attr('title'));
	$("input[name='b8_selected_layoutline']").val($(this).parent().attr('title'));
});

/* autoselect producer */

$("#producers option[value='"+$('#producerid').val() +"']").prop('selected',true);
$("#producers").on('change',function(){
    confirm('Are you sure you want to change to another producer ?');
});

});

function col_amount_in_calculations()
{
	$('#col_amount1_in_b1').val($('#col_amount0').val());
		$('#col_amount2_in_b1').val($('#col_amount0').val());
		$('#col_amount3_in_b1').val($('#col_amount0').val());

		$('#col_amount1_in_b3').val($('#col_amount0').val());
		$('#col_amount2_in_b3').val($('#col_amount0').val());
		$('#col_amount3_in_b3').val($('#col_amount0').val());
		
		$('#col_amount1_in_b5').val($('#col_amount0').val());
		$('#col_amount2_in_b5').val($('#col_amount0').val());
		$('#col_amount3_in_b5').val($('#col_amount0').val());
        
        $('#col_amount1_in_b6').val($('#col_amount0').val());
		$('#col_amount2_in_b6').val($('#col_amount0').val());
        $('#col_amount3_in_b6').val($('#col_amount0').val());

        $('#col_amount1_in_b7').val($('#col_amount0').val());
		$('#col_amount2_in_b7').val($('#col_amount0').val());
        $('#col_amount3_in_b7').val($('#col_amount0').val());
        
        $('#col_amount1_in_b8').val($('#col_amount0').val());
		$('#col_amount2_in_b8').val($('#col_amount0').val());
        $('#col_amount3_in_b8').val($('#col_amount0').val());

		// $.removeCookie("col_amount0", { path: '/' });
		// $.cookie("col_amount0", $(this).val(), {expires: current_date, path:'/'});
		
        calculatePricesAPUslabcs_in_b5();
        calculatePricesAPUslabcs_with_multiplicator_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
        calcEmployeeProducer_in_b5();
        
        calculatePricesAPUslabcs_in_b6();
        calculatePricesAPUslabcs_with_multiplicator_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
        calcEmployeeProducer_in_b6();
        
        calculatePricesAPUslabcs_in_b7();
        calculatePricesAPUslabcs_with_multiplicator_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
        calcEmployeeProducer_in_b7();
        
        calculatePricesAPUslabcs_in_b8();
        calculatePricesAPUslabcs_with_multiplicator_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
        calcEmployeeProducer_in_b8();
        
		calculatetotalPriceAPU();
}

function col_amount_ex_calculations()
{

	$('#col_amount1_ex_b1').val($('#col_amount0_ex').val());
	$('#col_amount2_ex_b1').val($('#col_amount0_ex').val());
	$('#col_amount3_ex_b1').val($('#col_amount0_ex').val());

	$('#col_amount1_ex_b5').val($('#col_amount0_ex').val());
	$('#col_amount2_ex_b5').val($('#col_amount0_ex').val());
	$('#col_amount3_ex_b5').val($('#col_amount0_ex').val());
	
	$('#col_amount1_ex_b6').val($('#col_amount0_ex').val());
	$('#col_amount2_ex_b6').val($('#col_amount0_ex').val());
	$('#col_amount3_ex_b6').val($('#col_amount0_ex').val());

	$('#col_amount1_ex_b7').val($('#col_amount0_ex').val());
	$('#col_amount2_ex_b7').val($('#col_amount0_ex').val());
	$('#col_amount3_ex_b7').val($('#col_amount0_ex').val());

	$('#col_amount1_ex_b8').val($('#col_amount0_ex').val());
	$('#col_amount2_ex_b8').val($('#col_amount0_ex').val());
	$('#col_amount3_ex_b8').val($('#col_amount0_ex').val());

	
	// $.removeCookie("col_amount0_ex", { path: '/' });
	// $.cookie("col_amount0_ex", $("#col_amount0_ex").val(), {expires: current_date, path:'/'});
	
	calculatePricesAPUslabcs_with_multiplicator_ex_b1();
	calculatePricesAPUslabcs_ex_b1();
	calcPurchaserPrice_ex_b1();
	calcProducerPrice_ex_b1();
	calcEmployeeProducer_ex_b1();

	calculatePricesAPUslabcs_with_multiplicator_ex_b5();
	calculatePricesAPUslabcs_ex_b5();
	calcPurchaserPrice_ex_b5();
	calcProducerPrice_ex_b5();
	calcEmployeeProducer_ex_b5();
	
	calculatePricesAPUslabcs_with_multiplicator_ex_b6();
	calculatePricesAPUslabcs_ex_b6();
	calcPurchaserPrice_ex_b6();
	calcProducerPrice_ex_b6();
	calcEmployeeProducer_ex_b6();

	calculatePricesAPUslabcs_with_multiplicator_ex_b7();
	calculatePricesAPUslabcs_ex_b7();
	calcPurchaserPrice_ex_b7();
	calcProducerPrice_ex_b7();
	calcEmployeeProducer_ex_b7();

	calculatePricesAPUslabcs_with_multiplicator_ex_b8();
	calculatePricesAPUslabcs_ex_b8();
	calcPurchaserPrice_ex_b8();
	calcProducerPrice_ex_b8();
	calcEmployeeProducer_ex_b8();

	calculatetotalPriceAPU();

}

function get_collection()
{
	var product="";
	
	$('.products').each(function() {
		
		if($(this).is(":checked"))
		{
			product += $(this).val()+";";
		}
	});	
	$('#collection').val(product);
	
}

function calcPurchaserPrice_in_b1()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b1').val()) * parseFloat($('#fac_cl_in_b1').val()) * parseFloat($('#col_amount1_in_b1').val());
	
	$('#o_price_in_b1').val(purchaserPriceTotal.toFixed(2));
	
}

function calcPurchaserPrice_in_b3()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b3').val()) * parseFloat($('#fac_cl_in_b3').val()) * parseFloat($('#col_amount1_in_b3').val());
	
	$('#o_price_in_b3').val(purchaserPriceTotal.toFixed(2));
	
}

function calcPurchaserPrice_in_b5()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b5').val()) * parseFloat($('#fac_cl_in_b5').val()) * parseFloat($('#col_amount1_in_b5').val());
	
	$('#o_price_in_b5').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_in_b6()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b6').val()) * parseFloat($('#fac_cl_in_b6').val()) * parseFloat($('#col_amount1_in_b6').val());
	
	$('#o_price_in_b6').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_in_b7()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b7').val()) * parseFloat($('#fac_cl_in_b7').val()) * parseFloat($('#col_amount1_in_b7').val());
	
	$('#o_price_in_b7').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_in_b8()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_in_b8').val()) * parseFloat($('#fac_cl_in_b8').val()) * parseFloat($('#col_amount1_in_b8').val());
	
	$('#o_price_in_b8').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b3()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b3').val()) * parseFloat($('#fac_cl_ex_b3').val()) * parseFloat($('#col_amount1_ex_b3').val());
	
	$('#o_price_ex_b3').val(purchaserPriceTotal.toFixed(2));
	
}

function calcPurchaserPrice_ex_b1()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b1').val()) * parseFloat($('#fac_cl_ex_b1').val()) * parseFloat($('#col_amount1_ex_b1').val());
	
	$('#o_price_ex_b1').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_g_b1()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_g_b1').val()) * parseFloat($('#fac_cl_g_b1').val()) * parseFloat($('#col_amount1_g_b1').val());
	
	$('#o_price_g_b1').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b5()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b5').val()) * parseFloat($('#fac_cl_ex_b5').val()) * parseFloat($('#col_amount1_ex_b5').val());
	
	$('#o_price_ex_b5').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b6()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b6').val()) * parseFloat($('#fac_cl_ex_b6').val()) * parseFloat($('#col_amount1_ex_b6').val());
	
	$('#o_price_ex_b6').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b7()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b7').val()) * parseFloat($('#fac_cl_ex_b7').val()) * parseFloat($('#col_amount1_ex_b7').val());
	
	$('#o_price_ex_b7').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b8()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	purchaserPriceTotal=parseFloat($('#col_price_ex_b8').val()) * parseFloat($('#fac_cl_ex_b8').val()) * parseFloat($('#col_amount1_ex_b8').val());
	
	$('#o_price_ex_b8').val(purchaserPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b1()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b1').val())*parseFloat($('#fac_prod_in_b1').val())*parseFloat($('#col_amount2_in_b1').val());
	
	$('#o_apus_in_b1').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b3()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b3').val())*parseFloat($('#fac_prod_in_b3').val())*parseFloat($('#col_amount2_in_b3').val());
	
	$('#o_apus_in_b3').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b5()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b5').val())*parseFloat($('#fac_prod_in_b5').val())*parseFloat($('#col_amount2_in_b5').val());
	
	$('#o_apus_in_b5').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b6()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b6').val())*parseFloat($('#fac_prod_in_b6').val())*parseFloat($('#col_amount2_in_b6').val());
	
	$('#o_apus_in_b6').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b7()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b7').val())*parseFloat($('#fac_prod_in_b7').val())*parseFloat($('#col_amount2_in_b7').val());
	
	$('#o_apus_in_b7').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b8()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_in_b8').val())*parseFloat($('#fac_prod_in_b8').val())*parseFloat($('#col_amount2_in_b8').val());
	
	$('#o_apus_in_b8').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b3()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b3').val())*parseFloat($('#fac_prod_ex_b3').val())*parseFloat($('#col_amount2_ex_b3').val());
	
	$('#o_apus_ex_b3').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b1()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b1').val())*parseFloat($('#fac_prod_ex_b1').val())*parseFloat($('#col_amount2_ex_b1').val());
	
	$('#o_apus_ex_b1').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_g_b1()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_g_b1').val())*parseFloat($('#fac_prod_g_b1').val())*parseFloat($('#col_amount2_g_b1').val());
	
	$('#o_apus_g_b1').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b5()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b5').val())*parseFloat($('#fac_prod_ex_b5').val())*parseFloat($('#col_amount2_ex_b5').val());
	
	$('#o_apus_ex_b5').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b6()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b6').val())*parseFloat($('#fac_prod_ex_b6').val())*parseFloat($('#col_amount2_ex_b6').val());
	
	$('#o_apus_ex_b6').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b7()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b7').val())*parseFloat($('#fac_prod_ex_b7').val())*parseFloat($('#col_amount2_ex_b7').val());
	
	$('#o_apus_ex_b7').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b8()
{
	var producerPriceTotal=0,col_price=1;
	
	producerPriceTotal=parseFloat($('#col_apus_ex_b8').val())*parseFloat($('#fac_prod_ex_b8').val())*parseFloat($('#col_amount2_ex_b8').val());
	
	$('#o_apus_ex_b8').val(producerPriceTotal.toFixed(2));
}

function calcEmployeeProducer_in_b1()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b1').val())*parseFloat($('#fac_labc_in_b1').val())*parseFloat($('#col_amount3_in_b1').val());
	
	$('#total_labcs_in_b1').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_g_b1()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_g_b1').val())*parseFloat($('#fac_labc_g_b1').val())*parseFloat($('#col_amount3_g_b1').val());
	
	$('#total_labcs_g_b1').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b3()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b3').val())*parseFloat($('#fac_labc_in_b3').val())*parseFloat($('#col_amount3_in_b3').val());
	
	$('#total_labcs_in_b3').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b5()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b5').val())*parseFloat($('#fac_labc_in_b5').val())*parseFloat($('#col_amount3_in_b5').val());
	
	$('#total_labcs_in_b5').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b6()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b6').val())*parseFloat($('#fac_labc_in_b6').val())*parseFloat($('#col_amount3_in_b6').val());
	
	$('#total_labcs_in_b6').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b7()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b7').val())*parseFloat($('#fac_labc_in_b7').val())*parseFloat($('#col_amount3_in_b7').val());
	
	$('#total_labcs_in_b7').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b8()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_in_b8').val())*parseFloat($('#fac_labc_in_b8').val())*parseFloat($('#col_amount3_in_b8').val());
	
	$('#total_labcs_in_b8').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b3()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b3').val())*parseFloat($('#fac_labc_ex_b3').val())*parseFloat($('#col_amount3_ex_b3').val());
	
	$('#total_labcs_ex_b3').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b1()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b1').val())*parseFloat($('#fac_labc_ex_b1').val())*parseFloat($('#col_amount3_ex_b1').val());
	
	$('#total_labcs_ex_b1').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b5()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b5').val())*parseFloat($('#fac_labc_ex_b5').val())*parseFloat($('#col_amount3_ex_b5').val());
	
	$('#total_labcs_ex_b5').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b6()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b6').val())*parseFloat($('#fac_labc_ex_b6').val())*parseFloat($('#col_amount3_ex_b6').val());
	
	$('#total_labcs_ex_b6').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b7()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b7').val())*parseFloat($('#fac_labc_ex_b7').val())*parseFloat($('#col_amount3_ex_b7').val());
	
	$('#total_labcs_ex_b7').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b8()
{
	var producerTotallabc=0;
	
	producerTotallabc=parseFloat($('#col_labc_ex_b8').val())*parseFloat($('#fac_labc_ex_b8').val())*parseFloat($('#col_amount3_ex_b8').val());
	
	$('#total_labcs_ex_b8').val(producerTotallabc.toFixed(2));
}

//create order 

function calculatePricesAPUslabcs_in_b1()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_in_b1').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_in_b1').val(price.toFixed(2));
	
	$('.apus_in_b1').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_in_b1').val(apus.toFixed(2));
	
	$('.labcs_in_b1').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_in_b1').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_g_b1()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_g_b1').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_g_b1').val(price.toFixed(2));
	
	$('.apus_g_b1').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_g_b1').val(apus.toFixed(2));
	
	$('.labcs_g_b1').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_g_b1').val(labc.toFixed(2));
}

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

function calculatePricesAPUslabcs_with_multiplicator_in_b1()
{
    var p1104_fac=$('#p1104_fac').val();
    var p1106_fac=$('#p1106_fac').val();
    var p1108_fac=$('#p1108_fac').val();

    if((p1104_fac!=0)&&(p1104_fac != undefined))
    {
        
        $('#product_p1104_price').val(($('#product_p1104_price_original').val() * p1104_fac).toFixed(2));
        $('#product_p1104_apu').val(($('#product_p1104_apu_original').val() * p1104_fac).toFixed(2));
        $('#product_p1104_labc').val(($('#product_p1104_labc_original').val() * p1104_fac).toFixed(2));
    }

    if((p1106_fac!=0)&&(p1106_fac != undefined))
    {
        
        $('#product_p1106_price').val(($('#product_p1106_price_original').val() * p1106_fac).toFixed(2));
        $('#product_p1106_apu').val(($('#product_p1106_apu_original').val() * p1106_fac).toFixed(2));
        $('#product_p1106_labc').val(($('#product_p1106_labc_original').val() * p1106_fac).toFixed(2));
    }

    if((p1108_fac!=0)&&(p1108_fac != undefined))
    {
        
        $('#product_p1108_price').val(($('#product_p1108_price_original').val() * p1108_fac).toFixed(2));
        $('#product_p1108_apu').val(($('#product_p1108_apu_original').val() * p1108_fac).toFixed(2));
        $('#product_p1108_labc').val(($('#product_p1108_labc_original').val() * p1108_fac).toFixed(2));
    }

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

function calculatePricesAPUslabcs_with_multiplicator_ex_b1()
{
    var p1163_fac=$('#p1163_fac').val();
    var p1168_fac=$('#p1168_fac').val();
    var p1166_fac=$('#p1166_fac').val();
	var p116b_fac=$('#p116b_fac').val();
    var p116m_fac=$('#p116m_fac').val();
    var p116t_fac=$('#p116t_fac').val();

    if((p1163_fac!=0)&&(p1163_fac != undefined))
    {
        $('#product_p1163_price').val(($('#product_p1163_price_original').val() * p1163_fac).toFixed(2));
        $('#product_p1163_apu').val(($('#product_p1163_apu_original').val() * p1163_fac).toFixed(2));
        $('#product_p1163_labc').val(($('#product_p1163_labc_original').val() * p1163_fac).toFixed(2));
    }

    if((p1168_fac!=0)&&(p1168_fac != undefined))
    {
        $('#product_p1168_price').val(($('#product_p1168_price_original').val() * p1168_fac).toFixed(2));
        $('#product_p1168_apu').val(($('#product_p1168_apu_original').val() * p1168_fac).toFixed(2));
        $('#product_p1168_labc').val(($('#product_p1168_labc_original').val() * p1168_fac).toFixed(2));
    }

    if((p1166_fac!=0)&&(p1166_fac != undefined))
    {
        $('#product_p1166_price').val(($('#product_p1166_price_original').val() * p1166_fac).toFixed(2));
        $('#product_p1166_apu').val(($('#product_p1166_apu_original').val() * p1166_fac).toFixed(2));
        $('#product_p1166_labc').val(($('#product_p1166_labc_original').val() * p1166_fac).toFixed(2));
    }

	if((p116b_fac!=0)&&(p116b_fac != undefined))
    {
        $('#product_p116b_price').val(($('#product_p116b_price_original').val() * p116b_fac).toFixed(2));
        $('#product_p116b_apu').val(($('#product_p116b_apu_original').val() * p116b_fac).toFixed(2));
        $('#product_p116b_labc').val(($('#product_p116b_labc_original').val() * p116b_fac).toFixed(2));
    }

	if((p116m_fac!=0)&&(p116m_fac != undefined))
    {
        $('#product_p116m_price').val(($('#product_p116m_price_original').val() * p116m_fac).toFixed(2));
        $('#product_p116m_apu').val(($('#product_p116m_apu_original').val() * p116m_fac).toFixed(2));
        $('#product_p116m_labc').val(($('#product_p116m_labc_original').val() * p116m_fac).toFixed(2));
    }

	if((p116t_fac!=0)&&(p116t_fac != undefined))
    {
        $('#product_p116t_price').val(($('#product_p116t_price_original').val() * p116t_fac).toFixed(2));
        $('#product_p116t_apu').val(($('#product_p116t_apu_original').val() * p116t_fac).toFixed(2));
        $('#product_p116t_labc').val(($('#product_p116t_labc_original').val() * p116t_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_g_b1()
{
    var p11g3_fac=$('#p11g3_fac').val();
    var p11g8_fac=$('#p11g8_fac').val();
    var p11g6_fac=$('#p11g6_fac').val();
	var p11gb_fac=$('#p11gb_fac').val();
    var p11gm_fac=$('#p11gm_fac').val();
    var p11gt_fac=$('#p11gt_fac').val();

    if((p11g3_fac!=0)&&(p11g3_fac != undefined))
    {
        $('#product_p11g3_price').val(($('#product_p11g3_price_original').val() * p11g3_fac).toFixed(2));
        $('#product_p11g3_apu').val(($('#product_p11g3_apu_original').val() * p11g3_fac).toFixed(2));
        $('#product_p11g3_labc').val(($('#product_p11g3_labc_original').val() * p11g3_fac).toFixed(2));
    }

    if((p11g8_fac!=0)&&(p11g8_fac != undefined))
    {
        $('#product_p11g8_price').val(($('#product_p11g8_price_original').val() * p11g8_fac).toFixed(2));
        $('#product_p11g8_apu').val(($('#product_p11g8_apu_original').val() * p11g8_fac).toFixed(2));
        $('#product_p11g8_labc').val(($('#product_p11g8_labc_original').val() * p11g8_fac).toFixed(2));
    }

    if((p11g6_fac!=0)&&(p11g6_fac != undefined))
    {
        $('#product_p11g6_price').val(($('#product_p11g6_price_original').val() * p11g6_fac).toFixed(2));
        $('#product_p11g6_apu').val(($('#product_p11g6_apu_original').val() * p11g6_fac).toFixed(2));
        $('#product_p11g6_labc').val(($('#product_p11g6_labc_original').val() * p11g6_fac).toFixed(2));
    }

	if((p11gb_fac!=0)&&(p11gb_fac != undefined))
    {
        $('#product_p11gb_price').val(($('#product_p11gb_price_original').val() * p11gb_fac).toFixed(2));
        $('#product_p11gb_apu').val(($('#product_p11gb_apu_original').val() * p11gb_fac).toFixed(2));
        $('#product_p11gb_labc').val(($('#product_p11gb_labc_original').val() * p11gb_fac).toFixed(2));
    }

	if((p11gm_fac!=0)&&(p11gm_fac != undefined))
    {
        $('#product_p11gm_price').val(($('#product_p11gm_price_original').val() * p11gm_fac).toFixed(2));
        $('#product_p11gm_apu').val(($('#product_p11gm_apu_original').val() * p11gm_fac).toFixed(2));
        $('#product_p11gm_labc').val(($('#product_p11gm_labc_original').val() * p11gm_fac).toFixed(2));
    }

	if((p11gt_fac!=0)&&(p11gt_fac != undefined))
    {
        $('#product_p11gt_price').val(($('#product_p11gt_price_original').val() * p11gt_fac).toFixed(2));
        $('#product_p11gt_apu').val(($('#product_p11gt_apu_original').val() * p11gt_fac).toFixed(2));
        $('#product_p11gt_labc').val(($('#product_p11gt_labc_original').val() * p11gt_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_ex_b5()
{
    var p1561_fac=$('#p1561_fac').val();
    var p1563_fac=$('#p1563_fac').val();
    var p1566_fac=$('#p1566_fac').val();
	var p1581_fac=$('#p1581_fac').val();

    if((p1561_fac!=0)&&(p1561_fac != undefined))
    {
        $('#product_p1561_price').val(($('#product_p1561_price_original').val() * p1561_fac).toFixed(2));
        $('#product_p1561_apu').val(($('#product_p1561_apu_original').val() * p1561_fac).toFixed(2));
		$('#p1561_fac_total').text(($('#product_p1561_apu_original').val() * p1561_fac).toFixed(2));
        $('#product_p1561_labc').val(($('#product_p1561_labc_original').val() * p1561_fac).toFixed(2));
    }

    if((p1563_fac!=0)&&(p1563_fac != undefined))
    {
        $('#product_p1563_price').val(($('#product_p1563_price_original').val() * p1563_fac).toFixed(2));
        $('#product_p1563_apu').val(($('#product_p1563_apu_original').val() * p1563_fac).toFixed(2));
		$('#p1563_fac_total').text(($('#product_p1563_apu_original').val() * p1563_fac).toFixed(2));
        $('#product_p1563_labc').val(($('#product_p1563_labc_original').val() * p1563_fac).toFixed(2));
    }

    if((p1566_fac!=0)&&(p1566_fac != undefined))
    {
        $('#product_p1566_price').val(($('#product_p1566_price_original').val() * p1566_fac).toFixed(2));
        $('#product_p1566_apu').val(($('#product_p1566_apu_original').val() * p1566_fac).toFixed(2));
		$('#p1566_fac_total').text(($('#product_p1566_apu_original').val() * p1566_fac).toFixed(2));
        $('#product_p1566_labc').val(($('#product_p1566_labc_original').val() * p1566_fac).toFixed(2));
    }

	if((p1581_fac!=0)&&(p1581_fac != undefined))
	{
		$('#product_p1581_price').val(($('#product_p1581_price_original').val() * p1581_fac).toFixed(2));
		$('#product_p1581_apu').val(($('#product_p1581_apu_original').val() * p1581_fac).toFixed(2));
		$('#p1581_fac_total').text(($('#product_p1581_apu_original').val() * p1581_fac).toFixed(2));
		$('#product_p1581_labc').val(($('#product_p1581_labc_original').val() * p1581_fac).toFixed(2));
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
	var p1681_fac=$('#p1681_fac').val();
	var p166p_fac=$('#p166p_fac').val();

    if((p1661_fac!=0)&&(p1661_fac != undefined))
    {
        $('#product_p1661_price').val(($('#product_p1661_price_original').val() * p1661_fac).toFixed(2));
        $('#product_p1661_apu').val(($('#product_p1661_apu_original').val() * p1661_fac).toFixed(2));
		$('#p1661_fac_total').text(($('#product_p1661_apu_original').val() * p1661_fac).toFixed(2));
        $('#product_p1661_labc').val(($('#product_p1661_labc_original').val() * p1661_fac).toFixed(2));
    }

    if((p1663_fac!=0)&&(p1663_fac != undefined))
    {
        $('#product_p1663_price').val(($('#product_p1663_price_original').val() * p1663_fac).toFixed(2));
        $('#product_p1663_apu').val(($('#product_p1663_apu_original').val() * p1663_fac).toFixed(2));
		$('#p1663_fac_total').text(($('#product_p1663_apu_original').val() * p1663_fac).toFixed(2));
        $('#product_p1663_labc').val(($('#product_p1663_labc_original').val() * p1663_fac).toFixed(2));
    }

    if((p1666_fac!=0)&&(p1666_fac != undefined))
    {
        $('#product_p1666_price').val(($('#product_p1666_price_original').val() * p1666_fac).toFixed(2));
        $('#product_p1666_apu').val(($('#product_p1666_apu_original').val() * p1666_fac).toFixed(2));
		$('#p1666_fac_total').text(($('#product_p1666_apu_original').val() * p1666_fac).toFixed(2));
        $('#product_p1666_labc').val(($('#product_p1666_labc_original').val() * p1666_fac).toFixed(2));
    }

	if((p1681_fac!=0)&&(p1681_fac != undefined))
	{
		$('#product_p1681_price').val(($('#product_p1681_price_original').val() * p1681_fac).toFixed(2));
		$('#product_p1681_apu').val(($('#product_p1681_apu_original').val() * p1681_fac).toFixed(2));
		$('#p1681_fac_total').text(($('#product_p1681_apu_original').val() * p1681_fac).toFixed(2));
		$('#product_p1681_labc').val(($('#product_p1681_labc_original').val() * p1681_fac).toFixed(2));
	}

	if((p166p_fac!=0)&&(p166p_fac != undefined))
    {
        $('#product_p166p_price').val(($('#product_p166p_price_original').val() * p166p_fac).toFixed(2));
        $('#product_p166p_apu').val(($('#product_p166p_apu_original').val() * p166p_fac).toFixed(2));
		$('#p166p_fac_total').text(($('#product_p166p_apu_original').val() * p166p_fac).toFixed(2));
        $('#product_p166p_labc').val(($('#product_p166p_labc_original').val() * p166p_fac).toFixed(2));
    }
}

function calculatePricesAPUslabcs_with_multiplicator_in_b7()
{
    var p1700_fac=$('#p1700_fac').val();
    var p1701_fac=$('#p1701_fac').val();
    var p1704_fac=$('#p1704_fac').val();
    var p1721_fac=$('#p1721_fac').val();
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
	var p1781_fac=$('#p1781_fac').val();

    if((p1761_fac!=0)&&(p1761_fac != undefined))
    {
        $('#product_p1761_price').val(($('#product_p1761_price_original').val() * p1761_fac).toFixed(2));
        $('#product_p1761_apu').val(($('#product_p1761_apu_original').val() * p1761_fac).toFixed(2));
		$('#p1761_fac_total').text(($('#product_p1761_apu_original').val() * p1761_fac).toFixed(2));
        $('#product_p1761_labc').val(($('#product_p1761_labc_original').val() * p1761_fac).toFixed(2));
    }
    if((p1763_fac!=0)&&(p1763_fac != undefined))
    {
        $('#product_p1763_price').val(($('#product_p1763_price_original').val() * p1763_fac).toFixed(2));
        $('#product_p1763_apu').val(($('#product_p1763_apu_original').val() * p1763_fac).toFixed(2));
		$('#p1763_fac_total').text(($('#product_p1763_apu_original').val() * p1763_fac).toFixed(2));
        $('#product_p1763_labc').val(($('#product_p1763_labc_original').val() * p1763_fac).toFixed(2));
    }

    if((p1766_fac!=0)&&(p1766_fac != undefined))
    {
        $('#product_p1766_price').val(($('#product_p1766_price_original').val() * p1766_fac).toFixed(2));
        $('#product_p1766_apu').val(($('#product_p1766_apu_original').val() * p1766_fac).toFixed(2));
		$('#p1766_fac_total').text(($('#product_p1766_apu_original').val() * p1766_fac).toFixed(2));
        $('#product_p1766_labc').val(($('#product_p1766_labc_original').val() * p1766_fac).toFixed(2));
    }

	if((p1781_fac!=0)&&(p1781_fac != undefined))
	{
		$('#product_p1781_price').val(($('#product_p1781_price_original').val() * p1781_fac).toFixed(2));
		$('#product_p1781_apu').val(($('#product_p1781_apu_original').val() * p1781_fac).toFixed(2));
		$('#p1781_fac_total').text(($('#product_p1781_apu_original').val() * p1781_fac).toFixed(2));
		$('#product_p1781_labc').val(($('#product_p1781_labc_original').val() * p1781_fac).toFixed(2));
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
	var p1881_fac=$('#p1881_fac').val();

    if((p1861_fac!=0)&&(p1861_fac != undefined))
    {
        $('#product_p1861_price').val(($('#product_p1861_price_original').val() * p1861_fac).toFixed(2));
        $('#product_p1861_apu').val(($('#product_p1861_apu_original').val() * p1861_fac).toFixed(2));
		$('#p1861_fac_total').text(($('#product_p1861_apu_original').val() * p1861_fac).toFixed(2));
        $('#product_p1861_labc').val(($('#product_p1861_labc_original').val() * p1861_fac).toFixed(2));
    }

    if((p1863_fac!=0)&&(p1863_fac != undefined))
    {
        $('#product_p1863_price').val(($('#product_p1863_price_original').val() * p1863_fac).toFixed(2));
        $('#product_p1863_apu').val(($('#product_p1863_apu_original').val() * p1863_fac).toFixed(2));
		$('#p1863_fac_total').text(($('#product_p1863_apu_original').val() * p1863_fac).toFixed(2));
        $('#product_p1863_labc').val(($('#product_p1863_labc_original').val() * p1863_fac).toFixed(2));
    }

    if((p1866_fac!=0)&&(p1866_fac != undefined))
    {
        $('#product_p1866_price').val(($('#product_p1866_price_original').val() * p1866_fac).toFixed(2));
        $('#product_p1866_apu').val(($('#product_p1866_apu_original').val() * p1866_fac).toFixed(2));
		$('#p1866_fac_total').text(($('#product_p1866_apu_original').val() * p1866_fac).toFixed(2));
        $('#product_p1866_labc').val(($('#product_p1866_labc_original').val() * p1866_fac).toFixed(2));
    }

	if((p1881_fac!=0)&&(p1881_fac != undefined))
	{
		$('#product_p1881_price').val(($('#product_p1881_price_original').val() * p1881_fac).toFixed(2));
		$('#product_p1881_apu').val(($('#product_p1881_apu_original').val() * p1881_fac).toFixed(2));
		$('#p1881_fac_total').text(($('#product_p1881_apu_original').val() * p1881_fac).toFixed(2));
		$('#product_p1881_labc').val(($('#product_p1881_labc_original').val() * p1881_fac).toFixed(2));
	}
}

function calculatePricesAPUslabcs_in_b5()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	/*$('.product_in_b5').each(function() {
		
		if($(this).is(":checked"))
		{
			product += $(this).val()+";";
		}
	});	
	
	$('.product_ex_b5').each(function() {
		
		if($(this).is(":checked"))
		{
			product += $(this).val()+";";
		}
	});	
	
	$('#collection').val(product);
	*/
	$('.prices_in_b5').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
    });
	
	$('.apus_in_b5').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	
	$('.labcs_in_b5').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
    });	

    $('#col_price_in_b5').val(price.toFixed(2));
    $('#col_apus_in_b5').val(apus.toFixed(2));
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
	
	$('.apus_in_b6').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	
	$('.labcs_in_b6').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
    });	

    $('#col_price_in_b6').val(price.toFixed(2));
    $('#col_apus_in_b6').val(apus.toFixed(2));
	$('#col_labc_in_b6').val(labc.toFixed(2));
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

function calculatePricesAPUslabcs_ex_b1()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	$('.prices_ex_b1').each(function() {	
		price = parseFloat(price) + parseFloat($(this).val());
	});
	$('#col_price_ex_b1').val(price.toFixed(2));
	
	$('.apus_ex_b1').each(function() {
		apus = parseFloat(apus) + parseFloat($(this).val());
	});
	$('#col_apus_ex_b1').val(apus.toFixed(2));
	
	$('.labcs_ex_b1').each(function() {
		labc = parseFloat(labc) + parseFloat($(this).val());
	});	
	$('#col_labc_ex_b1').val(labc.toFixed(2));
}

function calculatePricesAPUslabcs_ex_b5()
{
	var price=0;
	var apus=0;
	var labc=0;
	
	/*$('.product_in_b5').each(function() {
		
		if($(this).is(":checked"))
		{
			product += $(this).val()+";";
		}
	});	
	
	$('.product_ex_b5').each(function() {
		
		if($(this).is(":checked"))
		{
			product += $(this).val()+";";
		}
	});	
	
	$('#collection').val(product);
	*/
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
    if(isNaN(o_price_ex_b6))
	{
		o_price_ex_b6=0;
	}
	if(isNaN(o_price_in_b7))
	{
		o_price_in_b7=0;
    }
    if(isNaN(o_price_in_b8))
	{
		o_price_in_b8=0;
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
    if(isNaN(o_apus_ex_b6))
	{
		o_apus_ex_b6=0;
	}
	if(isNaN(o_apus_in_b7))
	{
		o_apus_in_b7=0;
	}
	if(isNaN(o_apus_ex_b7))
	{
		o_apus_ex_b7=0;
    }
    if(isNaN(o_apus_in_b8))
	{
		o_apus_in_b8=0;
	}
	if(isNaN(o_apus_ex_b8))
	{
		o_apus_ex_b8=0;
	}
	var totalPrice =  o_price_in_b3 + o_price_in_b5 + o_price_in_b6 + o_price_ex_b5 + o_price_ex_b6 + o_price_in_b7 + o_price_ex_b7 + o_price_in_b8 + o_price_ex_b8;
	var totalAPU = o_apus_in_b3 + o_apus_in_b5 + o_apus_in_b6 + o_apus_ex_b5 + o_apus_ex_b6 + o_apus_in_b7 + o_apus_ex_b7 + o_apus_in_b8 + o_apus_ex_b8;
	
	$('#total_price').text(totalPrice.toFixed(2));
	$('#total_price2').val(totalPrice.toFixed(2));
	$('#total_apu').text(totalAPU.toFixed(2));
	}
}