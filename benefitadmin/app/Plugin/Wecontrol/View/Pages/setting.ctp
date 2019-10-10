<section class="content content-custom">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>       
      <li class="active"><i class="material-icons">settings</i> Settings </li>
  </ol>
  <?php echo $this->element('flash_message'); ?>
  <div class="container-fluid">  
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Settings
                </h2>
            </div>
            <div class="body">
               
              <?php echo $this->Form->create('Setting',array('novalidate' => true,'id' => 'AddSettingForm', 'enctype' => "multipart/form-data")) ;
              echo $this->Form->hidden('Setting.id');
              ?>

              <div class="row">
                <div class="col-md-6">
                  <div class="card">
                    <div class="header">
                        <h2>
                            Contact Setting
                        </h2>
                    </div>
                    <div class="body">
                      <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">Contact</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.contact_no',array('placeholder' => 'Enter Contact','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.contact_no', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>                       
                       <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">Contact Email</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.contact_email',array('placeholder' => 'Enter Contact Email','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.contact_email', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>   
                        <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">Email From</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.from_email',array('placeholder' => 'Enter Contact Email','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.from_email', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>  
                        <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">Email Newsletter</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.newsletter_email',array('placeholder' => 'Enter Newsletter Email','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.newsletter_email', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>                                            
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="header">
                        <h2>
                           Manage SMTP
                        </h2>
                    </div>
                    <div class="body">
                      <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">SMTP Server</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.smtp_server',array('placeholder' => 'Enter SMTP','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.smtp_server', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>  
                      <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">SMTP Port</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.smtp_port',array('placeholder' => 'Enter SMTP Port','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.smtp_port', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>  
                        <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">SMTP Username</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.smtp_username',array('placeholder' => 'Enter SMTP Username','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.smtp_username', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>    
                       <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">SMTP Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.smtp_password',array('placeholder' => 'Enter SMTP Password','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.smtp_password', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>                                      
                    </div>
                  </div>
                </div>  
                <div class="col-md-12">
                  <div class="card">
                    <div class="header">
                        <h2>
                           SMS Server
                        </h2>
                    </div>
                    <div class="body">
                      <div class="row">
                        <div class="col-md-6">
                            <label for="email_address">Server ID</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.sms_server_id',array('placeholder' => 'Enter SMS Server ID','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.sms_server_id', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email_address">Server Password</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.sms_server_password',array('placeholder' => 'Enter SMS Server Password','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.sms_server_password', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>                                     
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="header">
                        <h2>
                           Coins Information
                        </h2>
                    </div>
                    <div class="body">
                      <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">Coins</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.coins',array('placeholder' => 'Enter coins redeemed from Steps','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.coins', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="email_address">Steps For Coins</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.coins_step',array('placeholder' => 'Enter Steps','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.coins_step', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>                                     
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card">
                    <div class="header">
                        <h2>
                           Calories Information
                        </h2>
                    </div>
                    <div class="body">
                      <div class="row">
                        <div class="col-md-12">
                            <label for="email_address">Calories</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.calories',array('placeholder' => 'Enter calories redeemed from Steps','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.calories', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="email_address">Steps For Calories</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.calories_step',array('placeholder' => 'Enter Steps','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.calories_step', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>               
                      </div>                                     
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="card">
                    <div class="header">
                        <h2>
                           Goal
                        </h2>
                    </div>
                    <div class="body">
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Setting.goal',array('placeholder' => 'Set goal','class' => 'form-control')); ?>
                                    <?php echo $this->Form->error('Setting.goal', array('class'=>'m-b-none text-danger', 'div'=>false));?>
                                </div>
                            </div>
                        </div>
                      </div>                                     
                    </div>
                  </div>
                </div> 
              </div>              
            
              <button type="submit" class="btn btn-primary m-t-15 waves-effect add_Setting">Update</button>
             <?php echo $this->Form->end(); ?>      
            </div>
        </div>
      </div>
    </div>            
  </div>
</section>
<!-- <script type="text/javascript">
  $('.add_Setting').click(function(){
     
    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
    $("#loading_image2").show();
    // var id = 1;
    // id = btoa(id);
    $.ajax({
      type: "POST",
      async: true,
      url: adminUrl+'pages/setting',
      dataType: 'json',
      error:function(a,b,c) {
        $("#loading_image2").hide();              
      },             
      success: function (data) {
        $("#loading_image2").hide();
        if(data.success == false){
          //console.log('hi');
          var errors  = data.message;
          $.each( data.message, function( key, value ) {
            $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
            $('#'+key).parents('.form-line').addClass('error');
            $('#'+key).parents('.form-line').addClass('focused');             
          });
        }else if(data.success == true){
          $('#modal-form').modal('toggle');
          $('.success_box').slideDown(500,function() {
          $('.success_msg').html(data.message);
          });
          var url = adminUrl+'pages/setting';
          loadPiece(url,'#empdata');
          // setTimeout(function(){ 
          // window.location.href = adminUrl+'faqs'; }, 1000);    
          // setTimeout(function(){ window.location.href = adminUrl+'pages/setting'; }, 500);                  
        } 
      }
    });
  });
 
</script> -->

