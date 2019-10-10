<section class="content">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">people</i> Users',array('controller'=>'users','action'=>'index'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons">account_circle</i> Edit User</li>
  </ol>
    
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
                        EDIT USER
                    </h2>
                </div>
                <div class="body">
                    <?php echo $this->Form->create('User',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'UserDataEditForm', 'enctype' => "multipart/form-data")) ;?>
                    <?php echo $this->Form->hidden('User.id', array('class'=>'panel form-horizontal', 'value'=>$this->data['User']['id'],'id'=>'user_hidden_id')); ?>
                     <div class="row">
                  <div class="col-md-6">
                      <label for="email_address">First Name<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->text('User.first_name',array('placeholder' => 'Enter First Name','class' => 'form-control')); ?>
                              
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <label for="email_address">Last Name<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                              <?php echo $this->Form->text('User.last_name',array('placeholder' => 'Enter Last Name','class' => 'form-control')); ?>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="email_address">Email<span class="red_star">*</span></label>
                    <div class="form-group">
                      <div class="form-line">
                        <?php echo $this->Form->text('User.email',array('placeholder' => 'Enter Email','class' => 'form-control','readonly'=>true)); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="email_address">Username<span class="red_star">*</span></label>
                    <div class="form-group">
                      <div class="form-line">
                        <?php echo $this->Form->text('User.username',array('placeholder' => 'Enter Username','class' => 'form-control','readonly'=>true)); ?>
                      </div>
                    </div>
                  </div>
                </div>                     
                <div class="row">
                  <div class="col-md-6">
                    <label for="icon">Image</label>
                    <div class="remove-section edit-remove-section">
                      <?php 
                        if(isset($this->data['User']['avatar']) && !empty($this->data['User']['avatar'])){?>
                          <div class="remove-image-1 edit-common-img margin_bottom5">
                            <?php $fileName = $this->data['User']['avatar'];
                              $imagepath = Configure::read('SiteSettings.Absolute.UserImage').$this->data['User']['id'].'/'.$fileName;
                              if(!is_dir($imagepath) && file_exists( $imagepath)){
                                $imagepath = Configure::read('SiteSettings.Absolute.UserImage').$this->data['User']['id'].'/'.$fileName;
                            } ?>  
                            <span class="jq_remove_image "></span>                              
                            <?php echo $this->Html->image($imagepath,array('width'=>'100%;'));?>
                          </div>
                        <?php } else {?>
                          <div class="remove-image-1 edit-common-img margin_bottom5">
                            <?php $imagepath = "wecontrol/user.png";?>  
                            <span class="jq_remove_image "></span>                              
                            <?php echo $this->Html->image($imagepath,array('width'=>'100%;'));?>
                          </div>
                        <?php } 
                      ?>
                      <div class="rows fileUpload btn btn-primary">
                        <span class="rows upload_button pull-left">Image</span>
                        <?php echo $this->Form->file('User.image1', array('class'=>'upload jq_file_upload')); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="email_address">Mobile Number<span class="red_star">*</span></label>
                    <div class="form-group">
                      <div class="form-line">
                        <?php echo $this->Form->text('User.mobile',array('placeholder' => 'Enter Mobile','class' => 'form-control','readonly'=>true)); ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="email_address">Total Coins<span class="red_star">*</span></label>
                    <div class="form-group">
                      <div class="form-line">
                        <?php echo $this->Form->text('Coin.total_coins',array('placeholder' => 'Enter Coins','class' => 'form-control')); ?>
                      </div>
                    </div>
                  </div>       
                </div>
                <br>
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
   $('#UserDob').bootstrapMaterialDatePicker({
        time : false,
        switchOnClick: true,
        clearText: true,
        format : 'MM/DD/YYYY'
         
    });

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
      alert("Please select only images.");
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
          url         : adminUrl+'users/edit/'+user_id,
          resetForm   : false,
          dataType    : 'json',
          success     : ajaxSuccess
      };
      $( '#UserDataEditForm' ).ajaxForm( ajaxOptions );
      $( '#UserDataEditForm' ).on('submit',function() {

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
               
              window.location.href = adminUrl+'users';
               
          } 
        }
  }); 

});

</script>