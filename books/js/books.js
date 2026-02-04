$(document).ready(function()
{
	//autoselect listbox create payment
	
    $("#licence option[value='"+$('#selected_licence').val() +"']").prop('selected',true);
	$("#currency option[value='"+$('#selected_currency').val() +"']").prop('selected',true); 
	$("#order_id option[value='"+$('#selected_o_id').val() +"']").prop('selected',true);
	
	//autoselect listbox modify payment
	
	$("#modify_licence option[value='"+$('#modify_selected_licence').val() +"']").prop('selected',true);
	$("#modify_order_id option[value='"+$('#modify_selected_o_id').val() +"']").prop('selected',true);
	$("#modify_currency option[value='"+$('#modify_selected_currency').val() +"']").prop('selected',true); 
	
	//date picker create payment

	$('#payment_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd.mm.yy"
		
	}).datepicker("setDate", new Date());
	
	//date picker create payment
	
	$('#modify_payment_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd.mm.yy"
		
	});
});