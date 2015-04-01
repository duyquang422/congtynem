<?php 
	$linkGroupManager = $this->baseUrl('/default/admin-group/index/');
	$linkPermission = $this->baseUrl('/default/admin-permission/index/');
?>
<div id="submenu-box">
                            <div style="border:1px solid #CCCCCC; padding:5px">
                                <ul id="submenu">
                                    <li>
                                        <a href="<?php echo $linkGroupManager;?>" >Group manager</a>
                                    </li>
                                    <li>
                                        <a href="#" class="active">Member manager</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $linkMemberManager;?>">Permission</a>
                                    </li>
                                </ul>
                                <div class="clr"></div>
                            </div>
                        </div>	