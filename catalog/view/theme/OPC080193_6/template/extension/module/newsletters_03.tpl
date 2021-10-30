<script>
		function subscribe()
		{
			var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var email = $('#txtemail').val();
			if(email != "")
			{
				if(!emailpattern.test(email))
				{
					$('.text-danger').remove();
					var str = '<span class="error">Invalid Email</span>';
					$('#txtemail').after('<div class="text-danger">Invalid Email</div>');

					return false;
				}
				else
				{
					$.ajax({
						url: 'index.php?route=extension/module/newsletters/news',
						type: 'post',
						data: 'email=' + $('#txtemail').val(),
						dataType: 'json',
						
									
						success: function(json) {
						
						$('.text-danger').remove();
						$('#txtemail').after('<div class="text-danger">' + json.message + '</div>');
						
						}
						
					});
					return false;
				}
			}
			else
			{
				$('.text-danger').remove();
				$('#txtemail').after('<div class="text-danger">Email Is Require</div>');
				$(email).focus();

				return false;
			}
			

		}
	</script>
	


<div class="newsletter-container">
<i class="fa fa-envelope-o"></i><h2><?php echo $heading_title; ?></h2>	
<div class="newsletter">
	<form method="post">
		<div class="form-group required"> 
            <div class="newsletter-box">
              <input type="email" name="txtemail" id="txtemail" value="" placeholder="<?php echo $entry_email; ?>" class="form-control input-lg"  /> 
    	      <button type="submit" class="btn btn-default btn-lg" onclick="return subscribe();"><?php echo $text_button; ?></button>   
            </div>
		</div>	
	</form>
</div>	        
</div>
