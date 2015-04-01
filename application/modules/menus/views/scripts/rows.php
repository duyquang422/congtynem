<?php 
	if($this->info==0){
?>
		<div id="row">
			<div class="label"><?php echo $this->Label;?></div>
			<div style="<?php echo $this->style;?>"><?php echo $this->input;?></div>
			<div class="clr"></div>			
		</div>
		<div class="clr"></div>
<?php
	}else{ 
?>

		<div id="row">
			<div class="label"><?php echo $this->Label;?></div>
			<div style="<?php echo $this->style;?>">
				<span class="infor_item"><?php echo $this->input;?></span>
			</div>	
		</div>
		<div class="clr"></div>
<?php
	} 
?>
		
	 
