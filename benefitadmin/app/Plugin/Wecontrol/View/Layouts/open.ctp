<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo projectTitle;?></title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">    
    <link rel="shortcut icon" type="image/png" href="<?php echo $this->webroot;?>fav-icon.ico?v=123" /> 
    <?php          
    	echo $this->Html->css("wecontrol/bootstrap");
    	echo $this->Html->css("wecontrol/waves");
    	echo $this->Html->css("wecontrol/animate");
    	echo $this->Html->css("wecontrol/materialize");
    	echo $this->Html->css("wecontrol/style");
    ?>

     <!-- Jquery Core Js -->
    <script type="text/javascript">
        var siteUrl = "<?php echo Configure::read('SiteSettings.siteUrl'); ?>";
    </script>

    <?php      
		echo $this->Html->script("wecontrol/jquery.min");	
		echo $this->Html->script("wecontrol/bootstrap");	
		echo $this->Html->script("wecontrol/waves");	
		echo $this->Html->script("wecontrol/jquery.validate");	
		echo $this->Html->script("wecontrol/admin");	
        echo $this->Html->script("wecontrol/sign-in");  
		
	 ?>
</head>

    <body class="login-page">
        <div class="page-loader-wrapper" id="loading_image">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-teal">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <?php echo $content_for_layout;
    	//echo $this->element('sql_dump');?>

    </body>

</html>