<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Mind Stock</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link rel="shortcut icon" type="image/webp" href="<?php echo $this->webroot;?>fav-icon.ico?v=123" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php 
            //echo $this->Html->css('front/bootstrap-datetimepicker.css');
            echo $this->Html->css('front/owl.theme.default.min.css');
            echo $this->Html->css('front/owl.carousel.min.css');
            echo $this->Html->css('front/bootstrap.css');
            echo $this->Html->css('front/style.css');
            echo $this->Html->css('front/responsive.css');
            
        ?>
        <script type="text/javascript">
        var siteUrl = '<?php echo Configure::read("SiteSettings.portalUrl"); ?>';


    </script>
    </head>
    <body>       
        <div class="custom-loader"style="display:none" id="loading_image"><div class="lds-dual-ring"></div></div>       
        <?php
            // echo $this->Html->script('front/bootstrap-datetimepicker.min.js');       
            echo $this->Html->script('front/jquery.min.js');
            echo $this->Html->script('front/popper.min.js');
            echo $this->Html->script('front/jquery-3.4.1.min.js');
            echo $this->Html->script('front/bootstrap.min.js');
            echo $this->Html->script('https://kit.fontawesome.com/387a27b8f4.js');
            echo $this->Html->script('front/owl.carousel.min.js');
        ?>        
        <?php
            echo $this->element('header');         
            echo $this->fetch('content');
            echo $this->element('footer');
        ?>
    <div class="modal fade custom-modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
                    
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade custom-modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body register-popup">
            
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade otp-modal" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body otp-popup">
            
          </div>
        </div>
      </div>
    </div>
        <script type="text/javascript">            
             function addNew(Url) {
              //$("#loading_image").show();
              $('#loginModal').modal('show');
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

            function addNewRegister(Url) {
              //$("#loading_image").show();
              $('#registerModal').modal('show');
              $('.register-popup').html('');
              $.ajax({
                url    : Url,
                type     : 'POST',
                dataType : 'html',
                success:function(respons) {
                  $("#loading_image").hide();
                  $('.register-popup').html(respons);
                }
              });
            }
            
                     

            function addNewOtp(Url) {
              //$("#loading_image").show();
              $('#otpModal').modal('show');
              $('.otp-popup').html('');
              $.ajax({
                url    : Url,
                type     : 'POST',
                dataType : 'html',
                success:function(respons) {
                  $("#loading_image").hide();
                  $('.otp-popup').html(respons);
                }
              });
            }
        </script>
        <script type="text/javascript">

            $(document).ready(function(){
                $(".mobile-inner-header-icon").click(function(){
                    $(this).toggleClass("mobile-inner-header-icon-click mobile-inner-header-icon-out"),
                    $(".main-menu").toggleClass("active"),
                    $(".jq_overlay").toggleClass("active"),
                    $("body").toggleClass("body-overflow")
                });
                $(".jq_overlay").click(function(){
                    $(".mobile-inner-header-icon").toggleClass("mobile-inner-header-icon-click mobile-inner-header-icon-out"),
                    $(".main-menu").removeClass("active"),
                    $(".jq_overlay").removeClass("active"),
                    $("body").removeClass("body-overflow")
                });
           
                $('.banner-slider').owlCarousel({
                    loop:true,
                    margin:10,
                    nav:true,
                    dots:false,
                    stagePadding: 185,
                    responsiveClass:true,
                    responsive:{
                        0:{
                            items:1,
                            stagePadding: 0
                        },
                        480:{
                            items:1,
                            stagePadding: 50
                        },
                        768:{
                            items:1,
                            stagePadding: 90
                        },
                        1025:{
                            items:1
                        }
                    }
                });
                $('.testimonial-slider').owlCarousel({
                    loop:true,
                    margin:0,
                    nav:true,
                    dots:false,
                    responsiveClass:true,
                    responsive:{
                        0:{
                            items:1
                        },
                        1025:{
                            items:1
                        }
                    }
                });
            });
            
        </script>

    </body>

    
</html>