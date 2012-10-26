<?php 

	
	foreach($wines as $row):
		
		echo '<p><img height="600px" src="'.base_url().'images/wines/'.$row->product_image.'"/><h3>'.$row->product_name.'</h3>'.$row->description."</p><br/>";
		
	endforeach;
	
	?>