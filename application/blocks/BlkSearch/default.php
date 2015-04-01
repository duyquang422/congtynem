<?php
	//CREATE SEARCH AREA
	$ssFilter 		= $view->arrParam['ssFilter'];
	$keywords 		= $view->formText('keywords',null,array('class'=>'keyword autocom','placeholder'=>'Tìm kiếm sản phẩm'));
	
	$tblMenu		= new Zendvn_Models_Menus();
	$menu 			= $tblMenu->itemInSelectbox($view->_arrParam, array('task'=>'products'));
	$GroupCategory 	= $view->cmsSelect('menu_id',$ssFilter['menu_id'],$menu,null);
	
	$linkSearch 		= $view->baseUrl($view->baseUrl . 'products/index/filter/type/search/key/1');
	
	$btnSearch 			= $view->formSubmit('search-now','Tìm kiếm',
									array('class'=>'submit'));
	$strSearch			= $keywords . '' . $GroupCategory . ' ' . $btnSearch;
?>

<div class="search float-right width-40">
	<form name="appForm" method="post" action="<?php echo $linkSearch?>">
		<?php echo $strSearch?>
	</form>
</div>
	<?php
		$tblPro	= new Zendvn_Models_ProItem();
		$items 	= $tblPro->listItem($view->arrParam,array('task'=>'public-search'));
	?>

 	<script>
		$(function() {
			var availableTags = [
							<?php
								foreach ($items as $val) {
									echo '"'.$val['name'] .'",';
								} 
							?>
							];
			$( ".autocom" ).autocomplete({
			source: availableTags
			});
		});
	</script>

