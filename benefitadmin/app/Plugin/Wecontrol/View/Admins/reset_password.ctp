 <div class="login-box">
  <div class="logo">
    <a href="javascript:void(0);">ADMIN</a>
    <small><?php echo projectTitle; ?></small>
  </div>
  <div class="card"> 
    <div class="body">
      <?php  echo $this->Form->create('User', array('url'=>'javascript:void(0);', 'class'=>"lr-form talk-form", 'id'=>'reset-pass-form'));  ?>   
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
            <div class="msg">Forgot Password</div>
               
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                </span>
                <div class="form-line">
                <?php echo $this->Form->input("Admin.password",array("type"=>"password", "class"=>"form-control", "placeholder"=>"Password","label"=>false,"div"=>false,'autofocus'=>true));?>
                   
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                </span>
                <div class="form-line">
                <?php echo $this->Form->input("Admin.confirm_password",array("type"=>"password", "class"=>"form-control", "placeholder"=>"Confirm Password","label"=>false,"div"=>false,'autofocus'=>true));?>
                   
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-8 p-t-5">                           
                    
                </div>
                <div class="col-xs-4">
                 
                    <button class="btn btn-block bg-pink waves-effect jq_Reset_pass" type="submit">Update</button>
                </div>
            </div>
            <?php /*
            <div class="row m-t-15 m-b--20">
                <div class="col-xs-6">
                    
                </div>
                <div class="col-xs-6 align-right">
                    <?php echo $this->Html->link('SIGN IN',array('controller'=>'users','action'=>'login')); ?>
                    
                </div>
            </div>
            */ ?>
        <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>
<script type="text/javascript">

$(document).ready(function(){
 var secretkey = '<?php echo $secretkey;?>';
  $('.jq_Reset_pass').click(function() {    
      $('.jq_reset_loader').removeClass('hide');          
      $('.jq_reset_pass').addClass('hide');            
       $('.err-remove-validate').remove();
        $('.form-line').removeClass('error');
        $('.form-line').removeClass('focused');
      $('.group').removeClass('has-error'); 
      $("#loading_image").show();
      $.ajax({
        url: siteUrl+'admins/reset_pass/'+secretkey,
        data: $('#reset-pass-form').serialize(),
        type: 'POST',
        dataType: 'json',
        error: function() {
          //show_message('error', 'There was an error while signing in. Please try again.', $('#reset-pass-form'));
        
        },
        success: function (data) {
            $("#loading_image").hide();
            if(data.success == false){
              if( data.validationErrors == true ) {    
                  $.each( data.msg, function( key, value ) {
                    
                    $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                    $('#'+key).parents('.form-line').addClass('error');
                    $('#'+key).parents('.form-line').addClass('focused');                   
                  });
              } else {
                
                $('.reset_error_box').show();
                $('.reset_success_box').hide();
                $('.error_msg').html(data.msg);
              }
            } else {                
             
              $('.reset_success_box').show();
              $('.reset_error_box').hide();
              $('.success_msg').html(data.msg);
              setTimeout(function(){
                $("#loading_image").show();
                window.location.href = siteUrl; }, 3000);
            }
                
            }
            
        });
    });
 
});

</script>
