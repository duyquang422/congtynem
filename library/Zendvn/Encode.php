<?php
class Zendvn_Encode{
	public function password($value){
		$newPass = md5($value);
		return $newPass;
	}
}