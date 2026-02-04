$(document).ready(function()
{
$('#bs_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: "yy-mm-dd"
	
}).datepicker("setDate", '2025-01-01');

$('#be_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: "yy-mm-dd"
	
}).datepicker("setDate", '2025-12-31');

$('#update_bs_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: "yy-mm-dd"
	
});

$('#update_be_date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat: "yy-mm-dd"
	
});

});