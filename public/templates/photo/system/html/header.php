<?php echo $this->doctype() ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-language" content="vi" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="8Z0N3ZM4DCVtGK3n8JzHedNxdGwFHGTE18nic07eMmw" />
<?php echo $this->headTitle()?>
<?php echo $this->headMeta() ?>
<?php echo $this->headLink() ?>
<?php echo $this->headScript() ?>

<script type="text/javascript">
	Cufon.replace('span');
	Cufon.replace('h1', {
		textShadow: '0px 1px #ddd'
	});
</script>

<style type="text/css">
	h1{
		font-size:50px;
		margin:50px;
		color:#333;
	}
	span.reference{
		font-family:Arial;
		position:fixed;
		right:10px;
		top:10px;
		font-size:15px;
	}
	span.reference a{
		color:#fff;
		text-transform:uppercase;
		text-decoration:none;
	}
</style>

</head>