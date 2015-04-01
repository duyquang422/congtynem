<?php
 	if (isset($_GET['term'])){
	$return_arr = array();

	try {
		$tblPro	= new Zendvn_Models_ProItem();
		$items 	= $tblPro->listItem($view->arrParam,array('task'=>'public-search'));
		
	    $stmt = $conn->prepare('SELECT country FROM countries WHERE country LIKE :term');
	    $stmt->execute(array('term' => '%'.$_GET['term'].'%'));
	    
	    while($items) {
	        $return_arr[] =  $items['country'];
	    }
	    echo '<pre>';
	    												print_r($return_arr);
	    											echo '</pre>';

	} catch(PDOException $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}

?>
