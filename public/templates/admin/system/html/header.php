<?php echo $this->doctype() ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
       	<?php echo $this->headTitle() ?>
       	<?php echo $this->headMeta() ?>
		<?php echo $this->headLink() ?>
		<link rel="stylesheet" href="/resources/demos/style.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<?php echo $this->headScript() ?>
		
		<?php
			$ssFilter = $this->arrParam['ssFilter'];
			$langTmp = $ssFilter['lang'];
			$lang = '';
			if(empty($langTmp)){
				$lang = '';
			}else{
				$lang = 'lang/' . $langTmp;
			}
		?>
    </head>
    <body id="minwidth-body">   
        <div id="border-top" class="h_green">
            <div>
                <div>
                    <span class="title" style="padding-left:20px"><?php echo $this->translate('Administrator')?></span>
                    <?php require_once 'link-lang.php'; ?>
                </div>
            </div>
        </div>
        <div id="header-box">
            <div id="module-status">
                <span class="preview">
                    <a target="_blank" href="http://congtynem.com/vi"><?php echo $this->translate('Site')?></a>
                </span>
                <span class="logout">
                    <a href="<?php echo $this->baseUrl('/default/public/logout');?>">Logout</a>
                </span>
            </div>
            <div id="module-menu">

                <!-- BEGIN: Menu -->
                <ul class="menuTiny" id="menuTiny">
                	<li><a href="<?php echo $this->baseUrl('/default/admin/index/'.$lang);?>"><?php echo $this->translate('Home')?></a></li>
                    <li><a href="<?php echo $this->baseUrl('/default/admin-users/index/'.$lang);?>" class="menuTinyLink"><?php echo $this->translate('Member')?></a>
                        <ul>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-group/index/'.$lang);?>"><?php echo $this->translate('Groups')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-users/index/'.$lang);?>"><?php echo $this->translate('Users')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-supports/index/'.$lang);?>"><?php echo $this->translate('Supports')?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->baseUrl('/products/admin-product/index/'.$lang);?>" class="menuTinyLink"><?php echo $this->translate('Product')?></a>
                        <ul>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-product/index/'.$lang);?>"><?php echo $this->translate('Product')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-size/index/'.$lang);?>"><?php echo $this->translate('Size')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-price-pro/index/'.$lang);?>"><?php echo $this->translate('Price Product')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-invoice/index/'.$lang);?>"><?php echo $this->translate('Invoice')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-guest/index/'.$lang);?>"><?php echo $this->translate('Guest')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-comments/index/'.$lang);?>"><?php echo $this->translate('Comments')?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo $this->baseUrl('/collections/admin-collection/index/'.$lang);?>" class="menuTinyLink"><?php echo $this->translate('Collection')?></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->baseUrl('/news/admin-news-item/index/'.$lang);?>" class="menuTinyLink"><?php echo $this->translate('News')?></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->baseUrl('/menus/admin-menus-item/index/'.$lang);?>" class="menuTinyLink"><?php echo $this->translate('Menu')?></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->baseUrl('/publisher/admin-publisher/index/'.$lang);?>" class="menuTinyLink"><?php echo $this->translate('Publisher')?></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->baseUrl('/units/admin-units/index/'.$lang);?>" class="menuTinyLink"><?php echo $this->translate('Units Issued')?></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->baseUrl('/adverts/admin-adverts/index/'.$lang)?>" class="menuTinyLink"><?php echo $this->translate('Adverts')?></a>
                        <ul>
                            <li><a href="<?php echo $this->baseUrl('/adverts/admin-adverts/index/'.$lang)?>" class="menuTinyLink"><?php echo $this->translate('Adverts')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/adverts/admin-positions/index/'.$lang);?>"><?php echo $this->translate('Positions advert')?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="menuTinyLink"><?php echo $this->translate('Manage website')?></a>
                        <ul>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-about/index/'.$lang);?>"><?php echo $this->translate('About')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-contact/index/'.$lang);?>"><?php echo $this->translate('Contact')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/default/admin-help/index/'.$lang);?>"><?php echo $this->translate('Help')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-slide/index/'.$lang);?>"><?php echo $this->translate('Slide images')?></a></li>
                            <li><a href="<?php echo $this->baseUrl('/products/admin-link/index/'.$lang);?>"><?php echo $this->translate('Text link')?></a></li>
                        </ul>
                    </li>
                </ul>

                <script type="text/javascript">
                    var menu=new menu.dd("menu");
                    menu.init("menuTiny","menuTinyHover");
                </script><!-- END: Menu -->
            </div>
            <div class="clr"></div>
        </div>