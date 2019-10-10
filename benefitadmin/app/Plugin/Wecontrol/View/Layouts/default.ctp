<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin - <?php echo projectTitle;?></title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- <link rel="shortcut icon" type="image/png" href="<?php echo $this->webroot;?>fav-icon.ico?v=123" />  -->
    <?php          
        echo $this->Html->css("wecontrol/bootstrap");
        //echo $this->Html->css("wecontrol/bootstrap-select.min");
        echo $this->Html->css("wecontrol/waves");
        echo $this->Html->css("wecontrol/multi-select");
        echo $this->Html->css("wecontrol/jquery-nestable");
        echo $this->Html->css("wecontrol/animate");
        echo $this->Html->css("wecontrol/morris");
        echo $this->Html->css("wecontrol/materialize");
        echo $this->Html->css("wecontrol/style");
        echo $this->Html->css("wecontrol/all-themes");
        echo $this->Html->css("wecontrol/custom");
       
        echo $this->Html->css("wecontrol/responsive");
        echo $this->Html->css("wecontrol/font-awesome.min");
    	echo $this->Html->css("wecontrol/bootstrap-material-datetimepicker");
        echo $this->Html->css(array('wecontrol/select2.css'));
        echo $this->Html->css(array('wecontrol/theme.css'));
         
    ?>
    <script type="text/javascript">
        var adminUrl = "<?php echo Configure::read('SiteSettings.siteUrl'); ?>";
    </script>

    <?php  
        echo $this->Html->script("wecontrol/jquery.min");   
        //echo $this->Html->script("wecontrol/bootstrap-select.min");  

        echo $this->Html->script("wecontrol/app");
        echo $this->Html->script("wecontrol/jquery.form");
		//echo $this->Html->script("wecontrol/jquery.multi-select");	
        echo $this->Html->script("wecontrol/bootstrap");

        echo $this->Html->script("wecontrol/jquery.slimscroll");    
        echo $this->Html->script("wecontrol/jquery.nestable");    
		echo $this->Html->script("wecontrol/waves");	
		echo $this->Html->script("wecontrol/jquery.countTo");	
		echo $this->Html->script("wecontrol/jquery.validate");	
		echo $this->Html->script("wecontrol/admin");	
		echo $this->Html->script("wecontrol/bootbox.min");	
        echo $this->Html->script("wecontrol/demo"); 
        echo $this->Html->script("wecontrol/moment"); 
        echo $this->Html->script("wecontrol/bootstrap-material-datetimepicker");
        echo $this->Html->script(array('wecontrol/select2.min.js'));
        echo $this->Html->script("wecontrol/raphael.min.js"); 
        //echo $this->Html->script("wecontrol/morris.js"); 
         
        //echo $this->Html->script("wecontrol/charts/morris.js");
		
	 ?>

<script type="text/javascript">
    function addNew(Url) {
        $('#modal-form').modal('show');
        $('.modal-body').html('');
        $.ajax({
          url    : Url,
          type     : 'POST',
          dataType : 'html',
          success:function(respons) {
            
            $("#loading_image").hide();
            $('.modal-body').html(respons);
          }
        });
    }
    function goBack() {
        window.history.back();
    }
</script>
</head>

<body class="theme-teal sidebar-collaps1">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
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
   
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>   
    <?php 
        echo $this->element('top');
        echo $this->element('left');
        echo $content_for_layout;
        //echo $this->element('sql_dump');?>   
</body>
</html>