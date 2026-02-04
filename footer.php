
<div class="container-fluid" style="position: absolute; bottom: 0; width: 99%; height: 50px;">
<hr>
<footer>
	<div class="row mx-0 w-100">
        <p class="w-100 text-center">&copy; Copyright 2016 - <?php echo date("Y");?> - Francis Plitt</p>
    </div>
	
	<!-- <script type="text/javascript" src="../js/jquery-ui.js"></script> -->
    <script>
        function submitContactForm(){
            var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            var name = $('#inputName').val();
            var email = $('#inputEmail').val();
            var message = $('#inputMessage').val();
            if(name.trim() == '' ){
                alert('Please enter your name.');
                $('#inputName').focus();
                return false;
            }else if(email.trim() == '' ){
                alert('Please enter your email.');
                $('#inputEmail').focus();
                return false;
            }else if(email.trim() != '' && !reg.test(email)){
                alert('Please enter valid email.');
                $('#inputEmail').focus();
                return false;
            }else if(message.trim() == '' ){
                alert('Please enter your message.');
                $('#inputMessage').focus();
                return false;
            }else{
                $.ajax({
                    type:'POST',
                    url:'submit_form.php',
                    data:'contactFrmSubmit=1&name='+name+'&email='+email+'&message='+message,
                    beforeSend: function () {
                        $('.submitBtn').attr("disabled","disabled");
                        $('.modal-body').css('opacity', '.5');
                    },
                    success:function(msg){
                        if(msg == 'ok'){
                            $('#inputName').val('');
                            $('#inputEmail').val('');
                            $('#inputMessage').val('');
                            $('.statusMsg').html('<span style="color:green;">Thanks for contacting us, we\'ll get back to you soon.</p>');
                        }else{
                            $('.statusMsg').html('<span style="color:red;">Some problem occurred, please try again.</span>');
                        }
                        $('.submitBtn').removeAttr("disabled");
                        $('.modal-body').css('opacity', '');
                    }
                });
            }
        }
    </script>
    <script type="text/javascript" src="<?php echo $base_url;?>js/online_creators.js"></script> 
    <!--<script type="text/javascript" src="../js/tooltip.js"></script> -->
    <!-- <script type="text/javascript" src="../js/bootstrap.min.js"></script> -->
</footer>
<script>
    $(window).scroll(function() {
        var height = $(window).scrollTop();
        if (height > 100) {
            $('#back2Top').css('display', 'block');
        } else {
            $('#back2Top').css('display','none');
        }
    });
        
    $('body').scrollspy({
	    target: '#back2Top'
    });

    $("#back2Top").on('click', function(event) {
	    if (this.hash !== "") {
		    event.preventDefault();

		    const hash = this.hash;

		    $('html, body').animate({
			    scrollTop: $(hash).offset().top
		    }, 800, function() {

			    window.location.hash = hash;
		    });
	    }
    });

</script>

<script>
    $(function(){
        var current_page_URL = location.href;
        $( "a.nav-link" ).each(function() {

            if ($(this).attr("href") !== "#") {

                var target_URL = $(this).prop("href");
                    if (target_URL == current_page_URL) {
                        $('nav a').parents('li, ul').removeClass('active_menu');
                        $(this).parent('li').addClass('active_menu');
                        return false;
                    }
            }
        }); });
</script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
</div> <!-- end container -->
</body>
</html>