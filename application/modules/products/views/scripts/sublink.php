<?php
	$ssFilter = $this->arrParam['ssFilter'];
	$langTmp = $ssFilter['lang'];
	$lang = '';
	if(!empty($langTmp)){
		$lang = 'lang/' . $langTmp;
	}
	$linkMember		 		= $this->baseUrl ( '/default/admin-users/index/' .$lang );
	$linkGroup		 		= $this->baseUrl ( '/default/admin-group/index/' .$lang);
	$linkSupports		 	= $this->baseUrl ( '/default/admin-supports/index/' .$lang);
	$linkProduct		 	= $this->baseUrl ( '/products/admin-product/index/' .$lang );
	$linkUnits		 		= $this->baseUrl ( '/units/admin-units/index/' .$lang );
	$linkPublisher		 	= $this->baseUrl ( '/publisher/admin-publisher/index/' .$lang );
	$linkPrice			 	= $this->baseUrl ( '/products/admin-price/index/' .$lang );
	$linkInvoice 			= $this->baseUrl ( '/products/admin-invoice/index/' .$lang );
	$linkServices		 	= $this->baseUrl ( '/services/admin-product/index/' .$lang );
	$linkNews 				= $this->baseUrl ( '/news/admin-news-item/index/'.$lang);
	$linkMenus 				= $this->baseUrl ( '/menus/admin-menus-item/index/'.$lang);
	$linkAbout 				= $this->baseUrl ( '/default/admin-about/index/'.$lang);
	$linkHelp 				= $this->baseUrl ( '/default/admin-help/index/'.$lang);
	$linkSlide 				= $this->baseUrl ( '/products/admin-slide/index/'.$lang);
	$linkPosition 			= $this->baseUrl ( '/adverts/admin-positions/index/'.$lang);
	$linkAdvert 			= $this->baseUrl ( '/adverts/admin-adverts/index/'.$lang);
	
?>
<div id="submenu-box">
<div style="border: 1px solid #CCCCCC; padding: 5px">
<ul id="submenu">
	<li><a id='default-admin-group' href="<?php echo $linkGroup?>"><?php echo $this->translate('Groups')?></a></li>
	<li><a id='default-admin-users' href="<?php echo $linkMember?>"><?php echo $this->translate('Member')?></a></li>
	<li><a id='default-admin-supports' href="<?php echo $linkSupports?>"><?php echo $this->translate('Supports')?></a></li>
	<li><a id='units-admin-units' href="<?php echo $linkUnits?>"><?php echo $this->translate('Units Issued')?></a></li>
	<li><a id='publisher-admin-publisher' href="<?php echo $linkPublisher?>"><?php echo $this->translate('Publisher')?></a></li>
	<li><a id='products-admin-product' href="<?php echo $linkProduct?>"><?php echo $this->translate('Products')?></a></li>
	<li><a id='products-admin-invoice' href="<?php echo $linkInvoice?>"><?php echo $this->translate('Invoice')?></a></li>
	<li><a id='news-admin-news-item' href="<?php echo $linkNews?>"><?php echo $this->translate('News')?></a></li>
	<li><a id='menus-admin-menus-item' href="<?php echo $linkMenus?>"><?php echo $this->translate('Menu')?></a></li>
	<li><a id='default-admin-about' href="<?php echo $linkAbout?>"><?php echo $this->translate('About')?></a></li>
	<li><a id='default-admin-help' href="<?php echo $linkHelp?>"><?php echo $this->translate('Help')?></a></li>
	<li><a id='products-admin-slide' href="<?php echo $linkSlide?>"><?php echo $this->translate('Slide images')?></a></li>
	<li><a id='adverts-admin-positions' href="<?php echo $linkPosition?>"><?php echo $this->translate('Positions advert')?></a></li>
	<li><a id='adverts-admin-adverts' href="<?php echo $linkAdvert?>"><?php echo $this->translate('Adverts')?></a></li>
</ul>
<div class="clr"></div>
</div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
	  var controller = '<?php echo $this->arrParam['module'] . '-' . $this->arrParam['controller']; ?>';
	  $('#'+controller) .addClass('active');
   })                  	
</script>
