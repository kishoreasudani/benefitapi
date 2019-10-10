<section class="content">  
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>       
        <li class="active"><i class="material-icons">person</i> Change Password</li>
    </ol>
    
    <div class="container-fluid">                   
       <?php echo $this->element('flash_message'); ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                    <!--Created 13th June (Start)-->
                        <h2>
                            CHANGE PASSWORD 
                        </h2>
                    </div>
                    <div class="body">
                        <?php echo $this->Form->create('Admin',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'jq_edit_password')) ;?>

                    <div class="row">
                      <div class="col-md-6">
                          <label for="UserPassword">Old password</label>
                          <div class="form-group">
                              <div class="form-line">
                                <?php echo $this->Form->password('Admin.old_password',array('placeholder' => 'Enter old password','class' => 'form-control')); ?>
                                  
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <label for="UserPassword">Password</label>
                          <div class="form-group">
                              <div class="form-line">
                                <?php echo $this->Form->password('Admin.new_password',array('placeholder' => 'Enter Password','class' => 'form-control')); ?>
                                  
                              </div>
                          </div>
                      </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <label for="UserPassword">Confirm password</label>
                              <div class="form-group">
                                  <div class="form-line">
     
                                    <?php echo $this->Form->password('Admin.confirm_password',array('placeholder' => 'Enter Confirm password','class' => 'form-control')); ?>     
                                  </div>
                              </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect edit_password">Update</button>
                    </div>   
<!--Created 13th June (End)-->                
                    
                    <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>            
    </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
$('.edit_password').click(function(){
    
      var frmData = $("#jq_edit_password").serialize();  
      $('.err-remove-validate').remove();
      $('.form-line').removeClass('error');
      $('.form-line').removeClass('focused');
          $("#loading_image").show();
          $.ajax({
              type: "POST",
              async: true,
              url: adminUrl+'admins/change_password/',
              data: frmData,
              dataType: 'json',
            error:function(a,b,c) {
                $("#loading_image").hide();              
            },             
              success: function (data) {
                $("#loading_image").hide();
                 if(data.success == false){
                      var errors  = data.message;
                      $.each( data.message, function( key, value ) {
                          $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                          $('#'+key).parents('.form-line').addClass('error');
                          $('#'+key).parents('.form-line').addClass('focused');             
                      });
                  }else if(data.success == true){
                       
                    setTimeout(function(){ 
                      window.location.href = adminUrl+'change-password'; }, 500);
 
                  } 
              }
          });
    });

});
</script>