$(document).ready(function() {
	
	var current_date = new Date();
	var minutes = 5;
	current_date.setTime(current_date.getTime() + (minutes * 60 * 1000));

	calculatePricesAPUslabcs_in_b3();
	calculatePricesAPUslabcs_in_b5();
	calculatePricesAPUslabcs_in_b6();
	calculatePricesAPUslabcs_in_b7();
	calculatePricesAPUslabcs_in_b8();

	calculatePricesAPUslabcs_ex_b3();
	calculatePricesAPUslabcs_ex_b5();
	calculatePricesAPUslabcs_ex_b6();
	calculatePricesAPUslabcs_ex_b7();
	calculatePricesAPUslabcs_ex_b8();

	calcPurchaserPrice_in_b3();
	calcPurchaserPrice_in_b5();
	calcPurchaserPrice_in_b6();
	calcPurchaserPrice_in_b7();
	calcPurchaserPrice_in_b8();

	calcPurchaserPrice_ex_b3();
	calcPurchaserPrice_ex_b5();
	calcPurchaserPrice_ex_b6();
	calcPurchaserPrice_ex_b7();
	calcPurchaserPrice_ex_b8();

	calcProducerPrice_in_b3();
	calcProducerPrice_in_b5();
	calcProducerPrice_in_b6();
	calcProducerPrice_in_b7();
	calcProducerPrice_in_b8();

	//calcProducerPrice_ex_b3();
	calcProducerPrice_ex_b5();
	calcProducerPrice_ex_b6();
	calcProducerPrice_ex_b7();
	calcProducerPrice_ex_b8();

	calcEmployeeProducer_in_b3();
	calcEmployeeProducer_in_b5();
	calcEmployeeProducer_in_b6();
	calcEmployeeProducer_in_b7();
	calcEmployeeProducer_in_b8();

	//calcEmployeeProducer_ex_b3();
	calcEmployeeProducer_ex_b5();
	calcEmployeeProducer_ex_b6();
	calcEmployeeProducer_ex_b7();
	calcEmployeeProducer_ex_b8();

	calculatetotalPriceAPU();
    
    get_collection();
	//stairs

	$('#st_id0').click(function(){
		$('#st_id1').val($(this).val());
	});

	$('#st_id1').click(function(){
		$('#st_id0').val($(this).val());
	});

	//b5 in short order 
	
	
	var selected_roof_tile=$("#b5_roof_material option:selected").val();
	
	$('#'+selected_roof_tile).removeClass('hidden');
	
	
	$("#b5_roof_material").on('change',function()
	{
		
		$("select[name='b5_roof_color'").addClass('hidden');
		
		var roof_material_id=$("#b5_roof_material").val();
		
		$('#'+roof_material_id).removeClass('hidden');
		
	});
		
			
	$("select[name='b5_roof_color'").on('change',function()
	{
		if($(this).attr('id')==$("#b5_roof_material option:selected").val())
		{
			window.location.href=$(this).val();
		}
	});	
	
	$("#b5_rs_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
		
	$("#b5_rop_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b5_ww_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b5_wc_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b5_door_texture").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b5_door_shape_sides").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b5_door_color").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b5_gc_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b5_garage_size").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	
	$('#b5_facade_color_1').on('change',function()
	{
		var facade_color_1=$(this).val();
		var facade_color_2=$('#b5_facade_color_2').val();
		var color_link=$('#b5_color_link').val();
		
		var wlc_id=facade_color_1+";"+facade_color_2+";";
		
		window.location.href=color_link+wlc_id+"#exterior";
	});
	
	$('#b5_facade_color_2').on('change',function()
	{
		var facade_color_2=$(this).val();
		var facade_color_1=$('#b5_facade_color_1').val();
		var color_link=$('#b5_color_link').val();
		
		var wlc_id=facade_color_1+";"+facade_color_2+";";
		
		window.location.href=color_link+wlc_id+"#exterior";
	});
	
	//b7 in short order 
	
	var selected_roof_tile=$("#b7_roof_material option:selected").val();
	
	$('#'+selected_roof_tile).removeClass('hidden');
	
	
	$("#b7_roof_material").on('change',function()
	{
		
		$("select[name='b7_roof_color'").addClass('hidden');
		
		var roof_material_id=$("#b7_roof_material").val();
		
		$('#'+roof_material_id).removeClass('hidden');
		
	});
		
			
	$("select[name='b7_roof_color'").on('change',function()
	{
		if($(this).attr('id')==$("#b7_roof_material option:selected").val())
		{
			window.location.href=$(this).val();
		}
	});	
	
	$("#b7_rs_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_st_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_rop_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_ww_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_wc_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_door_texture").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_door_shape_sides").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_door_color").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_gc_id").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	$("#b7_garage_size").on('change',function()
	{
		if ($(this).val())
		{
			window.location.href=$(this).val();
		}
	});
	
	
	$('#b7_facade_color_1').on('change',function()
	{
		var facade_color_1=$(this).val();
		var facade_color_2=$('#b7_facade_color_2').val();
		var color_link=$('#b7_color_link').val();
		
		var wlc_id=facade_color_1+";"+facade_color_2+";";
		
		window.location.href=color_link+wlc_id+"#exterior";
	});
	
	$('#b7_facade_color_2').on('change',function()
	{
		var facade_color_2=$(this).val();
		var facade_color_1=$('#b7_facade_color_1').val();
		var color_link=$('#b7_color_link').val();
		
		var wlc_id=facade_color_1+";"+facade_color_2+";";
		
		window.location.href=color_link+wlc_id+"#exterior";
	});
	
	
	
	$('#col_amount0').on('change keyup paste mouseup', function() {
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

		$.removeCookie("col_amount0", { path: '/' });
		$.cookie("col_amount0", $(this).val(), {expires: current_date, path:'/'});
		
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
        calculatetotalPriceAPU();
        
        if($(this).val()>0)
        {        
            $(".product_in_b3").each(function()
            {
                $(this).prop('disabled', false);
            });

            $(".product_in_b5").each(function()
            {
                $(this).prop('disabled', false);
            });
        }
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
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b5').val(0);
            $('#col_amount2_in_b5').val(0);
            $('#col_amount3_in_b5').val(0);
        }
	});
	
	$('#col_amount2_in_b5').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b5').val($('#col_amount2_in_b5').val());
		$('col_amount3_in_b5').val($('#col_amount2_in_b5').val());
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b5').val(0);
            $('#col_amount2_in_b5').val(0);
            $('#col_amount3_in_b5').val(0);
        }
	});
	
	$('#col_amount3_in_b5').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b5').val($('#col_amount3_in_b5').val());
		$('#col_amount2_in_b5').val($('#col_amount3_in_b5').val());
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b5').val(0);
            $('#col_amount2_in_b5').val(0);
            $('#col_amount3_in_b5').val(0);
        }
	});
	
	//b6 in
	
	$('#col_amount1_in_b6').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b6').val($('#col_amount1_in_b6').val());
		$('#col_amount3_in_b6').val($('#col_amount1_in_b6').val());
		calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b6').val(0);
            $('#col_amount2_in_b6').val(0);
            $('#col_amount3_in_b6').val(0);
        }
	});
	
	$('#col_amount2_in_b6').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b6').val($('#col_amount2_in_b6').val());
		$('col_amount3_in_b6').val($('#col_amount2_in_b6').val());
		calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b6').val(0);
            $('#col_amount2_in_b6').val(0);
            $('#col_amount3_in_b6').val(0);
        }
	});
	
	$('#col_amount3_in_b6').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b6').val($('#col_amount3_in_b6').val());
		$('#col_amount2_in_b6').val($('#col_amount3_in_b6').val());
		calculatePricesAPUslabcs_in_b6();
		calcPurchaserPrice_in_b6();
		calcProducerPrice_in_b6();
		calcEmployeeProducer_in_b6();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b6').val(0);
            $('#col_amount2_in_b6').val(0);
            $('#col_amount3_in_b6').val(0);
        }
	});

	//b7 in
	
	$('#col_amount1_in_b7').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b7').val($('#col_amount1_in_b7').val());
		$('#col_amount3_in_b7').val($('#col_amount1_in_b7').val());
		calculatePricesAPUslabcs_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b7').val(0);
            $('#col_amount2_in_b7').val(0);
            $('#col_amount3_in_b7').val(0);
        }
	});
	
	$('#col_amount2_in_b7').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b7').val($('#col_amount2_in_b7').val());
		$('col_amount3_in_b7').val($('#col_amount2_in_b7').val());
		calculatePricesAPUslabcs_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b7').val(0);
            $('#col_amount2_in_b7').val(0);
            $('#col_amount3_in_b7').val(0);
        }
	});
	
	$('#col_amount3_in_b7').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b7').val($('#col_amount3_in_b7').val());
		$('#col_amount2_in_b7').val($('#col_amount3_in_b7').val());
		calculatePricesAPUslabcs_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b7').val(0);
            $('#col_amount2_in_b7').val(0);
            $('#col_amount3_in_b7').val(0);
        }
	});
	
	//b8 in
	
	$('#col_amount1_in_b8').on('change keyup paste mouseup', function() {
		$('#col_amount2_in_b8').val($('#col_amount1_in_b8').val());
		$('#col_amount3_in_b8').val($('#col_amount1_in_b8').val());
		calculatePricesAPUslabcs_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b8').val(0);
            $('#col_amount2_in_b8').val(0);
            $('#col_amount3_in_b8').val(0);
        }
	});
	
	$('#col_amount2_in_b8').on('change keyup paste mouseup', function() {
		$('col_amount1_in_b8').val($('#col_amount2_in_b8').val());
		$('col_amount3_in_b8').val($('#col_amount2_in_b8').val());
		calculatePricesAPUslabcs_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b8').val(0);
            $('#col_amount2_in_b8').val(0);
            $('#col_amount3_in_b8').val(0);
        }
	});
	
	$('#col_amount3_in_b8').on('change keyup paste mouseup', function() {
		$('#col_amount1_in_b8').val($('#col_amount3_in_b8').val());
		$('#col_amount2_in_b8').val($('#col_amount3_in_b8').val());
		calculatePricesAPUslabcs_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_in_b8').val(0);
            $('#col_amount2_in_b8').val(0);
            $('#col_amount3_in_b8').val(0);
        }
	});

	//b5 ex 
	
	$('#col_amount1_ex_b5').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b5').val($('#col_amount1_ex_b5').val());
		$('#col_amount3_ex_b5').val($('#col_amount1_ex_b5').val());
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b5').val(0);
            $('#col_amount2_ex_b5').val(0);
		    $('#col_amount3_ex_b5').val(0);
        }
	});
	
	$('#col_amount2_ex_b5').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b5').val($('#col_amount2_ex_b5').val());
		$('col_amount3_ex_b5').val($('#col_amount2_ex_b5').val());
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b5').val(0);
            $('#col_amount2_ex_b5').val(0);
		    $('#col_amount3_ex_b5').val(0);
        }
	});
	
	$('#col_amount3_ex_b5').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b5').val($('#col_amount3_ex_b5').val());
		$('#col_amount2_ex_b5').val($('#col_amount3_ex_b5').val());
		calculatePricesAPUslabcs_ex_b5();
		calcPurchaserPrice_ex_b5();
		calcProducerPrice_ex_b5();
		calcEmployeeProducer_ex_b5();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b5').val(0);
            $('#col_amount2_ex_b5').val(0);
		    $('#col_amount3_ex_b5').val(0);
        }
	});
	
	//b6 ex 
	
	$('#col_amount1_ex_b6').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b6').val($('#col_amount1_ex_b6').val());
		$('#col_amount3_ex_b6').val($('#col_amount1_ex_b6').val());
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b6').val(0);
            $('#col_amount2_ex_b6').val(0);
		    $('#col_amount3_ex_b6').val(0);
        }
	});
	
	$('#col_amount2_ex_b6').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b6').val($('#col_amount2_ex_b6').val());
		$('col_amount3_ex_b6').val($('#col_amount2_ex_b6').val());
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b6').val(0);
            $('#col_amount2_ex_b6').val(0);
		    $('#col_amount3_ex_b6').val(0);
        }
	});
	
	$('#col_amount3_ex_b6').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b6').val($('#col_amount3_ex_b6').val());
		$('#col_amount2_ex_b6').val($('#col_amount3_ex_b6').val());
		calculatePricesAPUslabcs_ex_b6();
		calcPurchaserPrice_ex_b6();
		calcProducerPrice_ex_b6();
		calcEmployeeProducer_ex_b6();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b6').val(0);
            $('#col_amount2_ex_b6').val(0);
		    $('#col_amount3_ex_b6').val(0);
        }
	});

	//b7 ex 
	
	$('#col_amount1_ex_b7').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b7').val($('#col_amount1_ex_b7').val());
		$('#col_amount3_ex_b7').val($('#col_amount1_ex_b7').val());
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b7').val(0);
            $('#col_amount2_ex_b7').val(0);
		    $('#col_amount3_ex_b7').val(0);
        }
	});
	
	$('#col_amount2_ex_b7').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b7').val($('#col_amount2_ex_b7').val());
		$('col_amount3_ex_b7').val($('#col_amount2_ex_b7').val());
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b7').val(0);
            $('#col_amount2_ex_b7').val(0);
		    $('#col_amount3_ex_b7').val(0);
        }
	});
	
	$('#col_amount3_ex_b7').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b7').val($('#col_amount3_ex_b7').val());
		$('#col_amount2_ex_b7').val($('#col_amount3_ex_b7').val());
		calculatePricesAPUslabcs_ex_b7();
		calcPurchaserPrice_ex_b7();
		calcProducerPrice_ex_b7();
		calcEmployeeProducer_ex_b7();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b7').val(0);
            $('#col_amount2_ex_b7').val(0);
		    $('#col_amount3_ex_b7').val(0);
        }
	});
	
	//b8 ex 
	
	$('#col_amount1_ex_b8').on('change keyup paste mouseup', function() {
		$('#col_amount2_ex_b8').val($('#col_amount1_ex_b8').val());
		$('#col_amount3_ex_b8').val($('#col_amount1_ex_b8').val());
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b8').val(0);
            $('#col_amount2_ex_b8').val(0);
		    $('#col_amount3_ex_b8').val(0);
        }
	});
	
	$('#col_amount2_ex_b8').on('change keyup paste mouseup', function() {
		$('col_amount1_ex_b8').val($('#col_amount2_ex_b8').val());
		$('col_amount3_ex_b8').val($('#col_amount2_ex_b8').val());
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b8').val(0);
            $('#col_amount2_ex_b8').val(0);
		    $('#col_amount3_ex_b8').val(0);
        }
	});
	
	$('#col_amount3_ex_b8').on('change keyup paste mouseup', function() {
		$('#col_amount1_ex_b8').val($('#col_amount3_ex_b8').val());
		$('#col_amount2_ex_b8').val($('#col_amount3_ex_b8').val());
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
        calculatetotalPriceAPU();
        if($(this).val()==0)
        {
            $('#col_amount1_ex_b8').val(0);
            $('#col_amount2_ex_b8').val(0);
		    $('#col_amount3_ex_b8').val(0);
        }
	});

	//b3 in
	
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
		//calcProducerPrice_ex_b3();
		//calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_ex_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		//calcProducerPrice_ex_b3();
		//calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_ex_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		//calcProducerPrice_ex_b3();
		//calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_ex_b3').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		//calcProducerPrice_ex_b3();
		//calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
	});
	
	//b5 in
	
	$('#fac_cl_in_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b5').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b5();
		calcPurchaserPrice_in_b5();
		calcProducerPrice_in_b5();
		calcEmployeeProducer_in_b5();
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
	
	//b7 in
	
	$('#fac_cl_in_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#fac_labc_in_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#col_apus_in_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
	});
	
	$('#fac_prod_in_b7').on('change keyup paste mouseup', function() {
		calculatePricesAPUslabcs_in_b7();
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
	
	//create order 
	
	$('.product_in_b3').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout red_border');
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
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b3');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b3');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b3');
		}		
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
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b5');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b5');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b5');
			
			/*if(($(this).val()=="p1502")||($(this).val()=="p1503")||($(this).val()=="p1504")||($(this).val()=="p1505")||($(this).val()=="p1506")||($(this).val()=="p1507"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices_in_b5');
				$('#product_p1501_apu').addClass('apus_in_b5');
				$('#product_p1501_labc').addClass('labcs_in_b5');
			}*/
			
		}
		else
		{
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b5');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b5');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b5');
		}		
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
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b6');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b6');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b6');
			
			/*if(($(this).val()=="p1502")||($(this).val()=="p1503")||($(this).val()=="p1504")||($(this).val()=="p1505")||($(this).val()=="p1506")||($(this).val()=="p1507"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices_in_b6');
				$('#product_p1501_apu').addClass('apus_in_b6');
				$('#product_p1501_labc').addClass('labcs_in_b6');
			}*/
			
		}
		else
		{
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b6');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b6');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b6');
		}		
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
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b7');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b7');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b7');
			
			/*if(($(this).val()=="p1502")||($(this).val()=="p1503")||($(this).val()=="p1504")||($(this).val()=="p1505")||($(this).val()=="p1506")||($(this).val()=="p1507"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices_in_b7');
				$('#product_p1501_apu').addClass('apus_in_b7');
				$('#product_p1501_labc').addClass('labcs_in_b7');
			}*/
			
		}
		else
		{
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b7');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b7');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b7');
		}		
		calculatePricesAPUslabcs_in_b7();
		calcPurchaserPrice_in_b7();
		calcProducerPrice_in_b7();
		calcEmployeeProducer_in_b7();
		calculatetotalPriceAPU();
		get_collection();
	});

	$('.product_in_b8').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_in_b8');
			$('#product_'+$(this).val()+'_apu').addClass('apus_in_b8');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_in_b8');
			
			/*if(($(this).val()=="p1502")||($(this).val()=="p1503")||($(this).val()=="p1504")||($(this).val()=="p1505")||($(this).val()=="p1506")||($(this).val()=="p1507"))
			{
				$('#p1501').prop('checked',true);
				$('#p1501').parent().addClass('active_layout');
				$('#product_p1501_price').addClass('prices_in_b8');
				$('#product_p1501_apu').addClass('apus_in_b8');
				$('#product_p1501_labc').addClass('labcs_in_b8');
			}*/
			
		}
		else
		{
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_in_b8');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_in_b8');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_in_b8');
		}		
		calculatePricesAPUslabcs_in_b8();
		calcPurchaserPrice_in_b8();
		calcProducerPrice_in_b8();
		calcEmployeeProducer_in_b8();
		calculatetotalPriceAPU();
		get_collection();
	});

	$('.product_ex_b3').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout red_border');
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
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b3');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b3');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b3');
		}		
		calculatePricesAPUslabcs_ex_b3();
		calcPurchaserPrice_ex_b3();
		//calcProducerPrice_ex_b3();
		//calcEmployeeProducer_ex_b3();
		calculatetotalPriceAPU();
		get_collection();
	});
	
	$('.product_ex_b5').click(function(){		
		if($(this).is(":checked"))
		{
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b5');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b5');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b5');
			
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
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b5');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b5');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b5');
		}		
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
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b6');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b6');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b6');
			
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
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b6');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b6');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b6');
		}		
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
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b7');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b7');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b7');
			
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
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b7');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b7');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b7');
		}		
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
			$(this).parent().addClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').addClass('prices_ex_b8');
			$('#product_'+$(this).val()+'_apu').addClass('apus_ex_b8');
			$('#product_'+$(this).val()+'_labc').addClass('labcs_ex_b8');
			
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
			$(this).parent().removeClass('active_layout red_border');
			$('#product_'+$(this).val()+'_price').removeClass('prices_ex_b8');
			$('#product_'+$(this).val()+'_apu').removeClass('apus_ex_b8');
			$('#product_'+$(this).val()+'_labc').removeClass('labcs_ex_b8');
		}		
		calculatePricesAPUslabcs_ex_b8();
		calcPurchaserPrice_ex_b8();
		calcProducerPrice_ex_b8();
		calcEmployeeProducer_ex_b8();
		calculatetotalPriceAPU();
		get_collection();
	});

/* colorbox click */

$('.colorbox').click(function(){
	$('.nav-item').removeClass('active-layoutline');
	$(this).parent().addClass('active-layoutline');
	//console.log($(this).parent().attr('title'));
	$("input[name='selected_layoutline']").val($(this).parent().attr('title'));
});


/* autoselect producer */

$("#producers option[value='"+$('#producerid').val() +"']").prop('selected',true);

});

function get_collection()
{
	var product="";
	
	$('.products').each(function() {
		
		if(($(this).is(":checked"))&&($(this).is(":not(:disabled)")))
		{
			product += $(this).val()+";";
		}
	});	
	$('#collection').val(product);
	
}

function calcPurchaserPrice_in_b3()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	if($('#col_amount1_in_b3').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b3').val()) * parseFloat($('#fac_cl_in_b3').val()) * parseFloat($('#col_amount1_in_b3').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b3').val()) * parseFloat($('#fac_cl_in_b3').val()) * parseFloat($('#in_old_amount').val());
	}
	$('#o_price_in_b3').val(purchaserPriceTotal.toFixed(2));
	
}

function calcPurchaserPrice_in_b5()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_in_b5').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b5').val()) * parseFloat($('#fac_cl_in_b5').val()) * parseFloat($('#col_amount1_in_b5').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b5').val()) * parseFloat($('#fac_cl_in_b5').val()) * parseFloat($('#in_old_amount').val());
	}
	$('#o_price_in_b5').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_in_b6()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_in_b6').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b6').val()) * parseFloat($('#fac_cl_in_b6').val()) * parseFloat($('#col_amount1_in_b6').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b6').val()) * parseFloat($('#fac_cl_in_b6').val()) * parseFloat($('#in_old_amount').val());
	}
	$('#o_price_in_b6').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_in_b7()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_in_b7').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b7').val()) * parseFloat($('#fac_cl_in_b7').val()) * parseFloat($('#col_amount1_in_b7').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b7').val()) * parseFloat($('#fac_cl_in_b7').val()) * parseFloat($('#in_old_amount').val());
	}
	$('#o_price_in_b7').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_in_b8()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_in_b8').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b8').val()) * parseFloat($('#fac_cl_in_b8').val()) * parseFloat($('#col_amount1_in_b8').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_in_b8').val()) * parseFloat($('#fac_cl_in_b8').val()) * parseFloat($('#in_old_amount').val());
	}
	$('#o_price_in_b8').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b3()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_ex_b3').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b3').val()) * parseFloat($('#fac_cl_ex_b3').val()) * parseFloat($('#col_amount1_ex_b3').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b3').val()) * parseFloat($('#fac_cl_ex_b3').val()) * parseFloat($('#ex_old_amount').val());
	}
	$('#o_price_ex_b3').val(purchaserPriceTotal.toFixed(2));
	
}

function calcPurchaserPrice_ex_b5()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_ex_b5').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b5').val()) * parseFloat($('#fac_cl_ex_b5').val()) * parseFloat($('#col_amount1_ex_b5').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b5').val()) * parseFloat($('#fac_cl_ex_b5').val()) * parseFloat($('#ex_old_amount').val());
	}
	$('#o_price_ex_b5').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b6()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_ex_b6').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b6').val()) * parseFloat($('#fac_cl_ex_b6').val()) * parseFloat($('#col_amount1_ex_b6').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b6').val()) * parseFloat($('#fac_cl_ex_b6').val()) * parseFloat($('#ex_old_amount').val());
	}
	$('#o_price_ex_b6').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b7()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_ex_b7').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b7').val()) * parseFloat($('#fac_cl_ex_b7').val()) * parseFloat($('#col_amount1_ex_b7').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b7').val()) * parseFloat($('#fac_cl_ex_b7').val()) * parseFloat($('#ex_old_amount').val());
	}
	$('#o_price_ex_b7').val(purchaserPriceTotal.toFixed(2));
}

function calcPurchaserPrice_ex_b8()
{
	var purchaserPriceTotal=0,brut_price=0,vat_amount=1;
	
	if($('#col_amount1_ex_b8').val()!=0)
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b8').val()) * parseFloat($('#fac_cl_ex_b8').val()) * parseFloat($('#col_amount1_ex_b8').val());
	}
	else
	{
		purchaserPriceTotal=parseFloat($('#col_price_ex_b8').val()) * parseFloat($('#fac_cl_ex_b8').val()) * parseFloat($('#ex_old_amount').val());
	}
	$('#o_price_ex_b8').val(purchaserPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b3()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_in_b3').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b3').val())*parseFloat($('#fac_prod_in_b3').val())*parseFloat($('#col_amount2_in_b3').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b3').val())*parseFloat($('#fac_prod_in_b3').val())*parseFloat($('#in_old_amount').val());
	}
	$('#o_apus_in_b3').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b5()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_in_b5').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b5').val())*parseFloat($('#fac_prod_in_b5').val())*parseFloat($('#col_amount2_in_b5').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b5').val())*parseFloat($('#fac_prod_in_b5').val())*parseFloat($('#in_old_amount').val());
	}
	$('#o_apus_in_b5').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b6()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_in_b6').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b6').val())*parseFloat($('#fac_prod_in_b6').val())*parseFloat($('#col_amount2_in_b6').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b6').val())*parseFloat($('#fac_prod_in_b6').val())*parseFloat($('#in_old_amount').val());
	}
	$('#o_apus_in_b6').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b7()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_in_b7').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b7').val())*parseFloat($('#fac_prod_in_b7').val())*parseFloat($('#col_amount2_in_b7').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b7').val())*parseFloat($('#fac_prod_in_b7').val())*parseFloat($('#in_old_amount').val());
	}
	$('#o_apus_in_b7').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_in_b8()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_in_b8').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b8').val())*parseFloat($('#fac_prod_in_b8').val())*parseFloat($('#col_amount2_in_b8').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_in_b8').val())*parseFloat($('#fac_prod_in_b8').val())*parseFloat($('#in_old_amount').val());
	}
	$('#o_apus_in_b8').val(producerPriceTotal.toFixed(2));
}

//no b3 ex products yet

function calcProducerPrice_ex_b5()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_ex_b5').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b5').val())*parseFloat($('#fac_prod_ex_b5').val())*parseFloat($('#col_amount2_ex_b5').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b5').val())*parseFloat($('#fac_prod_ex_b5').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#o_apus_ex_b5').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b6()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_ex_b6').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b6').val())*parseFloat($('#fac_prod_ex_b6').val())*parseFloat($('#col_amount2_ex_b6').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b6').val())*parseFloat($('#fac_prod_ex_b6').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#o_apus_ex_b6').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b7()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_ex_b7').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b7').val())*parseFloat($('#fac_prod_ex_b7').val())*parseFloat($('#col_amount2_ex_b7').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b7').val())*parseFloat($('#fac_prod_ex_b7').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#o_apus_ex_b7').val(producerPriceTotal.toFixed(2));
}

function calcProducerPrice_ex_b8()
{
	var producerPriceTotal=0,col_price=1;
	
	if($('#col_amount2_ex_b8').val()!=0)
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b8').val())*parseFloat($('#fac_prod_ex_b8').val())*parseFloat($('#col_amount2_ex_b8').val());
	}
	else
	{
		producerPriceTotal=parseFloat($('#col_apus_ex_b8').val())*parseFloat($('#fac_prod_ex_b8').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#o_apus_ex_b8').val(producerPriceTotal.toFixed(2));
}

function calcEmployeeProducer_in_b3()
{
	var producerTotallabc=0;
	
	if($('#col_amount3_in_b3').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_in_b3').val())*parseFloat($('#fac_labc_in_b3').val())*parseFloat($('#col_amount3_in_b3').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_in_b3').val())*parseFloat($('#fac_labc_in_b3').val())*parseFloat($('#in_old_amount').val());
	}
	$('#total_labcs_in_b3').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b5()
{
	var producerTotallabc=0;
	
	
	if($('#col_amount3_in_b5').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_in_b5').val())*parseFloat($('#fac_labc_in_b5').val())*parseFloat($('#col_amount3_in_b5').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_in_b5').val())*parseFloat($('#fac_labc_in_b5').val())*parseFloat($('#in_old_amount').val());
	}
	$('#total_labcs_in_b5').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b6()
{
	var producerTotallabc=0;
	
	
	if($('#col_amount3_in_b6').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_in_b6').val())*parseFloat($('#fac_labc_in_b6').val())*parseFloat($('#col_amount3_in_b6').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_in_b6').val())*parseFloat($('#fac_labc_in_b6').val())*parseFloat($('#in_old_amount').val());
	}
	$('#total_labcs_in_b6').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b7()
{
	var producerTotallabc=0;
	
	if($('#col_amount3_in_b7').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_in_b7').val())*parseFloat($('#fac_labc_in_b7').val())*parseFloat($('#col_amount3_in_b7').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_in_b7').val())*parseFloat($('#fac_labc_in_b7').val())*parseFloat($('#in_old_amount').val());
	}
	$('#total_labcs_in_b7').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_in_b8()
{
	var producerTotallabc=0;
	
	if($('#col_amount3_in_b8').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_in_b8').val())*parseFloat($('#fac_labc_in_b8').val())*parseFloat($('#col_amount3_in_b8').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_in_b8').val())*parseFloat($('#fac_labc_in_b8').val())*parseFloat($('#in_old_amount').val());
	}
	$('#total_labcs_in_b8').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b5()
{
	var producerTotallabc=0;
	
	if($('#col_amount3_ex_b5').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b5').val())*parseFloat($('#fac_labc_ex_b5').val())*parseFloat($('#col_amount3_ex_b5').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b5').val())*parseFloat($('#fac_labc_ex_b5').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#total_labcs_ex_b5').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b6()
{
	var producerTotallabc=0;
	
	if($('#col_amount3_ex_b6').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b6').val())*parseFloat($('#fac_labc_ex_b6').val())*parseFloat($('#col_amount3_ex_b6').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b6').val())*parseFloat($('#fac_labc_ex_b6').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#total_labcs_ex_b6').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b7()
{
	var producerTotallabc=0;
	
	if($('#col_amount3_ex_b7').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b7').val())*parseFloat($('#fac_labc_ex_b7').val())*parseFloat($('#col_amount3_ex_b7').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b7').val())*parseFloat($('#fac_labc_ex_b7').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#total_labcs_ex_b7').val(producerTotallabc.toFixed(2));
}

function calcEmployeeProducer_ex_b8()
{
	var producerTotallabc=0;
	
	if($('#col_amount3_ex_b8').val()!=0)
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b8').val())*parseFloat($('#fac_labc_ex_b8').val())*parseFloat($('#col_amount3_ex_b8').val());
	}
	else
	{
		producerTotallabc=parseFloat($('#col_labc_ex_b8').val())*parseFloat($('#fac_labc_ex_b8').val())*parseFloat($('#ex_old_amount').val());
	}
	$('#total_labcs_ex_b8').val(producerTotallabc.toFixed(2));
}

//create order 

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

function calculatePricesAPUslabcs_ex_b3()
{
	var price=0;
	var apus=0;
	var labc=0;
	
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
	if(isNaN(o_price_ex_b7))
	{
		o_price_ex_b7=0;
	}
	if(isNaN(o_price_in_b8))
	{
		o_price_in_b8=0;
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
	if(isNaN(o_apus_ex_b5))
	{
		o_apus_ex_b5=0;
	}
	if(isNaN(o_apus_in_b6))
	{
		o_apus_in_b6=0;
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
	var totalPrice =  o_price_in_b3 + o_price_in_b5 + o_price_ex_b5 + o_price_in_b6 + o_price_ex_b6 + o_price_in_b7 + o_price_ex_b7 + o_price_in_b8 + o_price_ex_b8;
	var totalAPU = o_apus_in_b3 + o_apus_in_b5 + o_apus_ex_b5 + o_apus_in_b6 + o_apus_ex_b6 + o_apus_in_b7 + o_apus_ex_b7 + o_apus_in_b8 + o_apus_ex_b8;
	
	$('#total_price').val(totalPrice.toFixed(2));
	$('#total_apu').val(totalAPU.toFixed(2));
	}
}