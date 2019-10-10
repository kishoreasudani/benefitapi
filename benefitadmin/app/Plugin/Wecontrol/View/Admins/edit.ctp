<section class="content">   <ol class="breadcrumb breadcrumb-col-teal">
<li><?php  echo $this->Html->link('<i class="material-icons">home</i>Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)); ?></li> <li><?php  echo $this->Html->link('<i
class="material-icons">person</i>Admins',array('controller'=>'admins','action'=>'index'),array('escape'=>false))
; ?></li>         <li class="active"><i class="material-icons"></i> Edit Admin</li> </ol>
    
    <div class="container-fluid">                   
    <div class="alert alert-danger alert-dismissible error_box" style = "display:none;" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"  >&times;</span>
          </button>
         <div class = "error_msg"></div>   
      </div>
    <div class="alert alert-success alert-dismissible success_box" style = "display:none;" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
         <div class="success_msg"></div>
    </div> 
     <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Edit Admin
                    </h2>
                </div>
                <div class="body">
                  <?php 
                    echo $this->Form->create('Admin',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'adminEdit', 'enctype' => "multipart/form-data")) ;
                    echo $this->Form->hidden('Admin.id', array('class'=>'panel form-horizontal', 'value'=>$this->data['Admin']['id'],'id'=>'user_hidden_id'));
                  ?>                        
                <div class="row">
                  <div class="col-md-6">
                      <label for="email_address">First Name<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->text('Admin.first_name',array('placeholder' => 'Enter First Name','class' => 'form-control')); ?>
                              
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <label for="email_address">Last Name<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                              <?php echo $this->Form->text('Admin.last_name',array('placeholder' => 'Enter Last Name','class' => 'form-control')); ?>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <label for="email_address">Email<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                             <?php echo $this->Form->text('Admin.email',array('placeholder' => 'Enter Email','class' => 'form-control')); ?>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <label for="email_address">Username<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                              <?php   echo $this->Form->text('Admin.username',array('placeholder' => 'Enter Username','class' => 'form-control')); ?>
                          </div>
                      </div>
                  </div>
                </div>                     
                <div class="row">
                  <div class="col-md-6">
                      <label for="email_address">Password </label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->password('Admin.password1',array('placeholder' => 'Enter Password','class' => 'form-control')); ?>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <label for="email_address">Confirm Password </label>
                      <div class="form-group">
                          <div class="form-line">
                              <?php echo $this->Form->password('Admin.confirm_password',array('placeholder' => 'Confirm Password','class' => 'form-control')); ?>
                          </div>
                      </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary m-t-15 waves-effect edit_user_data">Update</button>
              <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>            
    </div>
</section>
<script type="text/javascript">
  $(document).ready(function(){

  $(".jq_file_upload").on('change', function() {
      //Get count of selected files
      var imgPath = $(this)[0].value;
      var $this = $(this);
      var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
      if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
        if (typeof(FileReader) != "undefined") {
          //loop for each file selected for uploaded.
            var reader = new FileReader();
            reader.onload = function(e) {
             $this.parent('.fileUpload').prev('div').find('.jq_remove_image').next('img').attr('src',e.target.result);
            }
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
          alert("This browser does not support FileReader.");
        }
      } else {
        alert("Pls select only images");
      }
  });
  $(".edit_user_data").click( function() {
      $("#loading_image").show();
     
      $('.err-remove-validate').remove();
      $('.form-line').removeClass('error');
      $('.form-line').removeClass('focused');
      var user_id = $("#user_hidden_id").val();
      var user_id = btoa(user_id);
    
      var ajaxOptions = {
          url         : adminUrl+'admins/edit/'+user_id,
          resetForm   : false,
          dataType    : 'json',
          success     : ajaxSuccess
      };
      $( '#adminEdit' ).ajaxForm( ajaxOptions );
      $( '#adminEdit' ).on('submit',function() {

          $("#loading_image").show();
      });
        function ajaxSuccess( data , responseCode , xhr ) {            
                         
         $("#loading_image").hide();
         if(data.success == false){
              var errors  = data.message;
              $.each( data.message, function( key, value ) {
                  $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                  $('#'+key).parents('.form-line').addClass('error');
                  $('#'+key).parents('.form-line').addClass('focused');             
              });
          }else if(data.success == true){
               
              window.location.href = adminUrl+'admins';
               
          } 
        }
  }); 

});

</script>