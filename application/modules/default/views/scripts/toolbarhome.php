<?php 
	if($this->arrParam['action'] == 'add'){
		$linkSaveItem = $this->baseUrl($this->currentController . '/add');
	}else{
		$linkSaveItem = $this->baseUrl($this->currentController . '/sort');
	}
	$btnSaveItem = $this->cmsButton($this->translate('Save'),$linkSaveItem,
										$this->imgUrl . '/toolbar/icon-32-save.png','submit');
?>
<div id="toolbar-box">
                            <div class="t"><div class="t"><div class="t"></div></div></div>
                            <div class="m">
                                <div id="toolbar" class="toolbar" >				
                                  
                            <?php echo $btnSaveItem;?>
                             
                                   
                                  <div class="clr"></div>
                                </div>
                                <div class="header icon-48-install"><?php echo $this->Title;?></div>
                                
                                <div class="clr"></div>
                            </div>
                            <div class="b"><div class="b"><div class="b"></div></div></div>
                        </div>