 <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">ADMIN</a>
            <small><?php echo projectTitle; ?></small>
        </div>
        <div class="card">
             
             
            <div class="body">
                <?php  echo $this->Form->create('Admin', array('url'=>'javascript:void(0);', 'class'=>"form-signin form-horizontal custom-form", 'id'=>'user-signin-form'));                      
                    ?> 
                    <div class="alert alert-danger alert-dismissible error_box" style = "display:none;" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" id = "close_error">
                          <span aria-hidden="true"  >&times;</span>
                        </button>
                       <div class = "error_msg"></div>   
                    </div> 
                    <div class="alert alert-success alert-dismissible success_box" style = "display:none;" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true"  >&times;</span>
                        </button>
                       <div class = "success_msg"></div>   
                    </div> 
                    <div class="msg">Sign In</div>
                      <?php echo $this->Form->input( 'Admin.redirect_page_url', array ( 'div' => false, 'label' => false, 'type' => 'hidden', 'value' => @$redirect_page_url ) ) ;?> 
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                        <?php echo $this->Form->input("Admin.username",array("type"=>"text", "class"=>"form-control", "placeholder"=>"Username","label"=>false,"div"=>false,'autofocus'=>true));?>
                           
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                          <?php echo $this->Form->input("Admin.password",array("type"=>"password", "class"=>"form-control", "placeholder"=>"Password","label"=>false,"div"=>false,'autofocus'=>true));?>
                         
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">                           
                            
                        </div>
                        <div class="col-xs-4">
                         
                            <button class="btn btn-block bg-pink waves-effect jq_user_sign_in" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            
                        </div>
                        <div class="col-xs-6 align-right">
                            <?php echo $this->Html->link('Forgot Password?',array('controller'=>'admins','action'=>'forgot_password'));?>
                           
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
<script type="text/javascript">

$(document).ready(function(){

    $('#close_error').click(function() {
       window.location.href = siteUrl; 
    });  

    $('.jq_user_sign_in').click(function(e) {  
        $('#loading_image').show();
        $('.err-remove-validate').remove();
        $('.form-line').removeClass('error');
        $('.form-line').removeClass('focused');

        $.ajax({
          url: siteUrl+'admins/login/',
          data: $('#user-signin-form').serialize(),
          type: 'POST',
          dataType: 'json',
          error: function() {
            show_message('error', 'There was an error while signing in. Please try again.', $('#user-signin-form'));
            $('#loading_image').hide();
          },
          success: function (data) {
              $('#loading_image').hide();
              if(data.success == false){
                if( data.validationErrors == true ) {    
                    $.each( data.msg, function( key, value ) {
                        $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                        $('#'+key).parents('.form-line').addClass('error');
                        $('#'+key).parents('.form-line').addClass('focused');
                   
                  });
                } else {
                  $('.error_box').show();
                  $('.success_box').hide();
                  $('.error_msg').html(data.msg);
                }
              } else {                
                $('.success_box').show();
                $('.error_box').hide();
                $('.success_msg').html(data.msg);
                 window.location.href = siteUrl+data.redirect_url; 
              }
            }
        });
      });

      $('#modal-form').css('top', $(window).scrollTop());
      $('#modal-form').css('bottom', -$(window).scrollTop());
 
});

</script>
