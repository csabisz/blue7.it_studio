$(document).ready(function()
{
	var imageW=800,imageH=600;
	//$('[id^="image_tooltip_"]').css("display", "none");
	
	for(var i=0;i<=150;i++)
	{
		$('#image_tooltip_container_'+i).qtip({
			 content: $('#image_tooltip_'+i),
			 position: {
				 target: $(window),
				 my: 'center', 
				 at: 'center'
			 },
			 show: { delay: 1000 },
			 hide: { delay: 2000 },
			 style: { /*classes: 'mytooltip', */
			 tip: {
				width: imageW,
				height: imageH
			} }
		 });
	} 
	 
});