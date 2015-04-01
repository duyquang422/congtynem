<?php
if (empty($sale)){
				            			$tblMenu	= new Zendvn_Models_Menu();
				            			$item		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$menu_id));
				            			
				            			if(!empty($item)){
					            			if(!empty($item['sale_off'])){
					            				$sale = $item['sale_off'] ;
					            			}else{
					            				$parents 	= $item['parents'];
					            				$item		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$parents));
					            				if(!empty($item)){
						            				if(!empty($item['sale_off'])){
						            					$sale = $item['sale_off'] ;
						            				}else{
						            					$parents 	= $item['parents'];
						            					$item		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$parents));
						            					if(!empty($item)){
						            						if(!empty($item['sale_off'])){
								            					$sale = $item['sale_off'] ;
								            				}else{
								            					$parents 	= $item['parents'];
								            					$item		= $tblMenu->getItem($this->arrParam,array('task'=>'spec-child','id'=>$parents));
								            					if(!empty($item['sale_off']))$sale = $item['sale_off'] ;
								            				}
						            					}
						            				}
					            				}
					            			}
				            			}
				            		}