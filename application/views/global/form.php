<input type="hidden" id="lastReview"/>
<div id="detailsForm" class="popupBack">
	<div class="popup">
	<div class="boxPadding">
		<div class="closePopup"></div>
		<h1>Thanks<br/> for your rating</h1>
		<h2>
			Enter the prize draw to
win a case of this wine
		</h2>
		<?php 
		$name = "";
		$email = "";
		$phone = "";
		
		if($entry != NULL) { foreach($entry as $row):?>
	<?php 
	$name = $row->name;
	$email = $row->email;
	$phone = $row->phone;
	
	?>
	<?php endforeach; } ?>
		<div class="registerBox">
			<p class="validateTips">* Required field</p>
		<p>Name:*<br/><input  id="keyboard" type="text" name="name" value="<?=$name?>"/></p>
		
		<p>Email:*<br/><input  id="keyboard2" type="text" name="email" value="<?=$email?>"/></p>
		
		<p>Phone:<br/><input  id="keyboard3" type="text" name="phone" value="<?=$phone?>"/></p>
		<p></p>
		<div class="formCheckbox" ></div><p style="margin-bottom:0px; float:left;">I have read the terms:*</p>
		<input  id="termsCheck" type="hidden" name="termsCheck"/>
		<input type="hidden" id="sessionID" name="sessionID" value="<?=$currentSession?>"/>
			<div style="width:230px; float:right; " class="buttonContainer">
	
<div id="submitEntry" class="buttonBevel submitEntry">

		Submit
</div>

</div>
		
		<div class="loadTerms" style="margin-top:30px; text-align:center; clear:both;">View Terms and Conditions</div>
		
		</div>
	</div>
	</div>
	
</div>