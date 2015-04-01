<?php
	$price_ins		= $this->formText('price_ins',str_replace("\\","",number_format($this->Item['price'],0)),array('class'=>'ins-price'));
	$optionPrepay	= array(
		0 => 'Trả trước',
		1 => '10%',
		2 => '20%',
		3 => '30%',
		4 => '40%',
		5 => '50%'
	);
	$prepay			= $this->formSelect('prepay',0,null,$optionPrepay);
										
	$optionTerm		= array(
		0 => 'Hạn trả góp',
		1 => '6 tháng',
		2 => '12 tháng',
		3 => '24 tháng',
	);
	$term_loan		= $this->formSelect('term_loan',0,null,$optionTerm);
	
	$optionInterest	= array(
		0 => 'Lãi suất',
		1 => '0%',
		2 => '2.45',
	);
	$interest		= $this->formSelect('interest',0,null,$optionInterest);
	$submit			= $this->formSubmit('submit','BẢNG TÍNH',array("class"=>"sub-ins"));
?>
<div class='form-ins'>
	<form id='subins' action="<?php echo $this->baseUrl("products/index/installment") ?>" method="post"  enctype="multipart/form-data">
		<?php echo $price_ins . '<span class="unit"> .VND </span>'?>
		<?php echo $prepay?>
		<?php echo $term_loan?>
		<?php echo $interest?>
		<?php echo $submit?>
	</form>
	<div id='suc-ins'></div>
</div>


<script type="text/javascript" language="javascript">
	$("#subins").submit(function(e){
			var postData = $(this).serializeArray();
			var formURL = $(this).attr("action");
			$.ajax({
				url : formURL,
				type: "POST",
				data : postData,
				success:function(data, textStatus, jqXHR){
					$('#suc-ins').html(data);
				},
				error: function(jqXHR, textStatus, errorThrown){
					
				}
			});
		    e.preventDefault();	//STOP default action
		});
			
</script>