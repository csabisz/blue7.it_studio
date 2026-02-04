$(document).ready(function(){

$('#users_start_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
		
	});

$('#users_end_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
		
	});

$('#traders_start_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
		
	});

$('#traders_end_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
		
	});

$('#total_apus').text($('#tot_apus').val());
$('#total_labc').text($('#tot_labc').val());
});

