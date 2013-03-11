<div id="content">
	<div class="clear"></div>
	<div class="inner-content">
		<?php 
		if (!empty($error)) {
			echo $error;
		}?>

		<?php echo form_open('join/form_meeting_code_submitted');?>
		<div>
		<label for="meeting_password">Enter your meeting password:</label>
		<input size="20" id="meeting_password" name="meeting_password"/>
		</div>
		<br /><br />

		<input type="submit" value="Join Meeting" />
		</form> <!-- End form for upload -->
	</div>
</div>