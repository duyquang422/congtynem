<?php
if (empty($sale)){
				            			$tblMenu	= new Zendvn_Models_Menus();
				            			$itemMenu		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$menu_id));
				            			
				            			if(!empty($itemMenu)){
					            			if(!empty($itemMenu['sale_off'])){
					            				$sale = $itemMenu['sale_off'] ;
					            			}else{
					            				$parents 	= $itemMenu['parents'];
					            				$itemMenu		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$parents));
					            				if(!empty($itemMenu)){
						            				if(!empty($itemMenu['sale_off'])){
						            					$sale = $itemMenu['sale_off'] ;
						            				}else{
						            					$parents 	= $itemMenu['parents'];
						            					$itemMenu		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$parents));
						            					if(!empty($itemMenu)){
						            						if(!empty($itemMenu['sale_off'])){
								            					$sale = $itemMenu['sale_off'] ;
								            				}else{
								            					$parents 	= $itemMenu['parents'];
								            					$itemMenu		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$parents));
								            					if(!empty($itemMenu['sale_off']))$sale = $itemMenu['sale_off'] ;
								            				}
						            					}
						            				}
					            				}
					            			}
				            			}
				            		}