<?php
$info = new Zendvn_System_Info();
$memberInfo = $info->getMemberInfo('id');
$tblGroup	= new Zendvn_Models_Users();
$user		= $tblGroup->listItem($this->arrParam,array('task'=>'user','id'=>$memberInfo));
$group_id 	= $user['group_id'];