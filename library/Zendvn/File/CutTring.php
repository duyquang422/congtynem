<?php
class Zendvn_File_CutTring extends Zend_File_Transfer_Adapter_Http{
	
	public function cutTring($lenghTri,$sumTmp, $options){
            if(mb_strlen($sumTmp) > $lenghTri){
	            if(mb_strpos($sumTmp, ' ', $lenghTri)){
		            $lengh = mb_strpos($sumTmp, ' ', $lenghTri);
		            $sumarry = mb_substr($sumTmp, 0, $lengh) . ' ...';
	            }else{
		            $lengh = mb_strlen($sumTmp);
		            $sumarry = mb_substr($sumTmp, 0, $lengh);
	            }
            }else{
                    $sumarry = $sumTmp;
             }

		return $sumarry;
	}
}