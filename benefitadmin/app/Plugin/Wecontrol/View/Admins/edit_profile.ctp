<section class="content content-custom">  
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>       
        <li class="active"><i class="material-icons">person</i> Edit Profile</li>
    </ol>
    
    <div class="container-fluid">                   
       <?php echo $this->element('flash_message'); ?>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            EDIT PROFILE
                        </h2>
                    </div>
                    <div class="body">
                        <?php echo $this->Form->create('Admin',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'EditAdminProfileForm')) ;?>                        
                    <div class="row">
                          <div class="col-md-6">
                              <label for="AdminFirstName">First Name</label>
                              <div class="form-group">
                                  <div class="form-line">
                                    <?php echo $this->Form->text('Admin.first_name',array('placeholder' => 'Enter First Name','class' => 'form-control')); ?>
                                      
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <label for="AdminLastName">Last Name</label>
                              <div class="form-group">
                                  <div class="form-line">
                                      <?php echo $this->Form->text('Admin.last_name',array('placeholder' => 'Enter Last Name','class' => 'form-control')); ?>
                                       
                                  </div>
                              </div>
                          </div>
                    </div>  
                    <div class="row">
                      <div class="col-md-6">
                          <label for="AdminAdminname">UserName</label>
                          <div class="form-group">
                              <div class="form-line">
                                   <?php echo $this->Form->text('Admin.username',array('placeholder' => '','class' => 'form-control','readonly'=>'readonly')); ?>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <label for="AdminEmail">Email</label>
                          <div class="form-group">
                              <div class="form-line">
                                <?php echo $this->Form->text('Admin.email',array('placeholder' => 'Enter Email','class' => 'form-control','readonly'=>'readonly')); ?>
                                  
                              </div>
                          </div>
                      </div>
                    </div>
<!--Shifted password to change_password.ctp 13th June-->               
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect add_coupon">Update</button>
                    <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>            
    </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
$('.add_coupon').click(function(){
    
      var frmData = $("#EditAdminProfileForm").serialize();  
      $('.err-remove-validate').remove();
      $('.form-line').removeClass('error');
      $('.form-line').removeClass('focused');
          $("#loading_image").show();
          $.ajax({
              type: "POST",
              async: true,
              url: adminUrl+'admins/edit_profile/',
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
                          window.location.href = adminUrl+'edit-profile'; }, 500);
 
                  } 
              }
          });
    });

});
</script>