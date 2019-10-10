 <div class="login-box">
  <div class="logo">
      <a href="javascript:void(0);">ADMIN</a>
      <small><?php echo projectTitle; ?></small>
  </div>
  <div class="card">

      <div class="body">
          <?php  echo $this->Form->create('Admin', array('url'=>'javascript:void(0);', 'class'=>"form-signin form-horizontal custom-form", 'id'=>'forget-pass-form'));                      
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
              <div class="msg">Forgot Password</div>
                <?php echo $this->Form->input( 'Admin.redirect_page_url', array ( 'div' => false, 'label' => false, 'type' => 'hidden', 'value' => @$redirect_page_url ) ) ;?> 
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="material-icons">person</i>
                  </span>
                  <div class="form-line">
                  <?php echo $this->Form->input("Admin.email",array("type"=>"text", "class"=>"form-control", "placeholder"=>"Email","label"=>false,"div"=>false,'autofocus'=>true));?>
                     
                  </div>
              </div>
              
              <div class="row">
                  <div class="col-xs-8 p-t-5">                           
                      
                  </div>
                  <div class="col-xs-4">
                   
                      <button class="btn btn-block bg-pink waves-effect jq_f_pass" type="submit">SEND</button>
                  </div>
              </div>
              <div class="row m-t-15 m-b--20">
                  <div class="col-xs-6">
                      
                  </div>
                  <div class="col-xs-6 align-right">
                      <?php echo $this->Html->link('SIGN IN',array('controller'=>'admins','action'=>'login')); ?>
                      
                  </div>
              </div>
          <?php echo $this->Form->end(); ?>
      </div>
  </div>
</div>
<script type="text/javascript">

$(document).ready(function(){
 
  $('.jq_f_pass').click(function() { 
      $("#loading_image").show();
      $('.err-remove-validate').remove();
      $('.form-line').removeClass('error');
      $('.form-line').removeClass('focused');
      
      $.ajax({
        url: siteUrl+'admins/forgot_pass/',
        data: $('#forget-pass-form').serialize(),
        type: 'POST',
        dataType: 'json',
        error: function() {
          //show_message('error', 'There was an error while signing in. Please try again.', $('#forget-pass-form'));
         
          $("#loading_image").hide();
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
                
                $('.error_box').show();
                $('.success_box').hide();
                $('.error_msg').html(data.msg);
              }
            } else {                
             
              $('.success_box').show();
              $('.error_box').hide();
              $('.success_msg').html(data.msg);
              $('#UserEmail').val('');
              //setTimeout(function(){window.location.href = siteUrl; }, 3000);
              
            }
                
          }
          
      });
  });
 
});

</script>
