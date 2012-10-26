<style type="text/css">
	.wineRack {
		text-align: center;
		border: 0px solid #000;
		float: left;
		padding-left: 5px;
		padding-right: 5px;
		width: 217px;
		height: 395px;
	}
	.wineRackImage {
		height: 300px;
	}
	.slideshow {
		width:800px;
		margin:0 auto;
	}
	.smallStar {
		width:30px;
		height:30px;
		
	}

</style>
<div class="slideshow">
<?php $count = 0;?>
<?php foreach($recent_wine as $row):?>
	<?php if($count == 0) { echo "<div>"; } ?>
	<?php $count = $count + 1;?>
	<span id="wineContainer">

			<div class="wineRack">
				<img class="wineRackImage"   src="<?=base_url() ?>images/wines/<?=$row->product_image?>"/>
				
				<br/>
				
	<img class="smallStar"  src='<?=base_url()?>css/assets/starOn.png'/>
	<img class="smallStar"  src='<?=base_url()?>css/assets/<?php if($row->rating > 1){ echo "starOn.png"; } else { echo "starOff.png"; }?>'/>
	<img class="smallStar"  src='<?=base_url()?>css/assets/<?php if($row->rating > 2){ echo "starOn.png"; } else { echo "starOff.png"; }?>'/>
	<img class="smallStar"  src='<?=base_url()?>css/assets/<?php if($row->rating > 3){ echo "starOn.png"; } else { echo "starOff.png"; }?>'/>
	<img class="smallStar"  src='<?=base_url()?>css/assets/<?php if($row->rating > 4){ echo "starOn.png"; } else { echo "starOff.png"; }?>'/>
	<br/>
				<?=$row->product_name?>
			</div>

		</span>
	<?php if($count == 3) { echo "</div>"; $count = 0; } ?>
	<?php endforeach;?>
</div>
