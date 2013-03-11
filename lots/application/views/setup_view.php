<article class="align-center highlight">
		<?php 
		if (!empty($error)) {
			echo $error;
		}?>
		<div  class="input_holder">
		<span class="add_field">Add</span>
		<span class="remove_field">Remove</span>
		<?php echo form_open_multipart('upload/do_upload');?>
		<input id="input_clone" type="file" name="uploaded_files[]" size="20" >
		</div>
		
		<section>
		<label for="meeting_password">Meeting Password:</label>
		<input size="20" id="meeting_password" name="meeting_password"/>
		</section>
		<section>
		<label for="email">Email:</label>
		<input size="20" id="email" name="email"/>
		</section>
		<input type="submit" value="Create Meeting" />
		</form> <!-- End form for upload -->
</article>

<script type="text/javascript">
 
        $('.add_field').click(function(){
     
            var input = $('#input_clone');
            var clone = input.clone(true);
            clone.removeAttr ('id');
            clone.val('');
            clone.appendTo('.input_holder'); 
         
        });
 
        $('.remove_field').click(function(){
         
            if($('.input_holder input:last-child').attr('id') != 'input_clone'){
                  $('.input_holder input:last-child').remove();
            }
         
        });
 
</script>