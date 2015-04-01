<?php 
	
	$ssFilter = $this->arrParam['ssFilter'];
	$langTmp = $ssFilter['lang'];
	$lang = '';
	if(!empty($langTmp)){
		$lang = '/lang/' . $langTmp;
	}
	//1. Active Items - submit
	$linkActiveItems = $this->baseUrl($this->currentController . '/status/type/1' . $lang);
	$btnActiveItems = $this->cmsButton($this->translate('Active'),$linkActiveItems,
										$this->imgUrl . '/toolbar/icon-32-active.png','submit');
	//2. Inactive Items - submit										
	$linkInactiveItems = $this->baseUrl($this->currentController . '/status/type/0' . $lang);
	$btnInactiveItems = $this->cmsButton($this->translate('Inactive'),$linkInactiveItems,
										$this->imgUrl . '/toolbar/icon-32-inactive.png','submit');
	//3. Add new - link - /default/admin-group/add
	$linkAddNew = $this->baseUrl($this->currentController . '/add' . $lang);
	$btnAddNew = $this->cmsButton($this->translate('Add new'),$linkAddNew,
										$this->imgUrl . '/toolbar/icon-32-new.png','link');	
	//4. Sort Item - submit -
	$linkSortItem =  $this->baseUrl($this->currentController . '/sort' . $lang);
	$btnSortItem = $this->cmsButton($this->translate('Sort'),$linkSortItem,
										$this->imgUrl . '/toolbar/icon-32-sort.png','submit');
	//5. Delete Items - submit	
	$linkDeleteItems = $this->baseUrl($this->currentController . '/multi-delete' . $lang);
	$btnDeleteItems = $this->cmsButton($this->translate('Delete'),$linkDeleteItems,
										$this->imgUrl . '/toolbar/icon-32-delete.png','submit');	
	//6. Save Item - submit - default/admin-group/add
	//7. Save Item - submit - default/admin-group/edit/id/1
	if($this->arrParam['action'] == 'add'){
		$linkSaveItem = $this->baseUrl($this->currentController . '/add' . $lang);
	}else{
		$linkSaveItem = $this->baseUrl($this->currentController . '/edit/id/' . $this->arrParam['id'] . $lang);
	}
	$btnSaveItem = $this->cmsButton($this->translate('Save'),$linkSaveItem,
										$this->imgUrl . '/toolbar/icon-32-save.png','submit');
										
	//10. Cancel - link - default/admin-group/index
	$linkCancel = $this->baseUrl($this->currentController . '/index' . $lang);
	$btnCancel = $this->cmsButton($this->translate('Cancel'),$linkCancel,
										$this->imgUrl . '/toolbar/icon-32-cancel.png','link');	
										
	//9. Edit Item - link - default/admin-group/edit/id/1
	$linkEditItem = $this->baseUrl($this->currentController . '/edit/id/' . $this->Item['id'] . $lang);
	$btnEditItem = $this->cmsButton($this->translate('Edit'),$linkEditItem,
										$this->imgUrl . '/toolbar/icon-32-edit.png','link');	
										
	//11. Back - link  - default/admin-group/index
	$linkBack = $this->baseUrl($this->currentController . '/index' . $lang);
	$btnBack = $this->cmsButton($this->translate('Back'),$linkBack,
										$this->imgUrl . '/toolbar/icon-32-back.png','link');
	//12. Accept - submit - default/admin-group/delete/id/1
	$linkAccept = $this->baseUrl($this->currentController . '/delete/id/'  . $this->arrParam['id'] . $lang);
	$btnAccept = $this->cmsButton($this->translate('Accept'),$linkAccept,
										$this->imgUrl . '/toolbar/icon-32-accept.png','submit');
																																			
	switch ($this->arrParam['action']){
		case 'index' : $strBtn = $btnActiveItems . ' ' . $btnInactiveItems . ' ' . $btnSortItem .  ' ' . $btnDeleteItems;
			  			break;
		case 'edit' : $strBtn = $btnSaveItem . ' ' . $btnCancel;
			  			break;	
		case 'add' : $strBtn = $btnSaveItem . ' ' . $btnCancel;
			  			break;	
		case 'delete' : $strBtn = $btnAccept . ' ' . $btnCancel;
			  			break;	
		case 'info' : $strBtn = $btnEditItem . ' ' . $btnBack;
			  			break;		
		default:	$strBtn = '';				  				  					  					  					  				
	}										
	
?>
<div id="toolbar-box">
                            <div class="t"><div class="t"><div class="t"></div></div></div>
                            <div class="m">
                                <div id="toolbar" class="toolbar" >				
                                  
                            <?php echo $strBtn;?>
                             
                                   
                                  <div class="clr"></div>
                                </div>
                                <div class="header icon-48-install"><?php echo $this->Title;?></div>
                                
                                <div class="clr"></div>
                            </div>
                            <div class="b"><div class="b"><div class="b"></div></div></div>
                        </div>