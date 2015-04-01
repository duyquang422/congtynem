<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Công Ty Nệm</title>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet/less" type="text/css">
        <link href="css/slideshow.css" rel="stylesheet" type="text/css">
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="js/bootstrap.js" type="text/javascript"></script>
        <script src="js/less.min.js" type="text/javascript"></script>
        <script src="js/modernizr.custom.53451.js" type="text/javascript"></script>       
        <script src="js/jquery.gallery.js" type="text/javascript"></script>
        <script type="text/javascript">
          $(function() {
                $('#dg-container').gallery();
                $( "#slider-range" ).slider({
                    range: true,
                    min: 1000000,
                    max: 7000000,
                    values: [ 0, 7000000 ],
                    slide: function( event, ui ) {
                        $( "#amount" ).val( ui.values[ 0 ] + "VNĐ - " + ui.values[ 1 ] + "VNĐ");
                    }
                });
                 $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                    " - VNĐ" + $( "#slider-range" ).slider( "values", 1 ) );
          });
        </script>
    <body>
    <section>
        <?php include_once 'html/header.php';?>
    </section>
    <section id="header">
        <?php include_once 'html/header-sidebar.php';?>
    </section> 
    <section>
        <?php include_once 'html/main-category.php';?>
    </section>
    <section>
        <?php include_once 'html/footer.php';?>
    </section>
    </body>
</html>
