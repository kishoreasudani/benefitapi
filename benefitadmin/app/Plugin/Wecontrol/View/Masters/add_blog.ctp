 <?php
   echo $this->Html->script('ckeditor/ckeditor.js');
   echo $this->Html->script('ckeditor/adapters/jquery.js');
?>
<section class="content">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">speaker_notes</i> Blogs',array('controller'=>'masters','action'=>'blogs'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>Add Blog</li>
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
                        Add Blog
                    </h2>
                </div>
                <div class="body">
                    <?php echo $this->Form->create('Blog',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'BlogAddForm', 'enctype' => "multipart/form-data")) ;?>                        
                <div class="row">
                  <div class="col-md-6">
                      <label for="email_address">Title<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->text('Blog.title',array('placeholder' => 'Enter Title','class' => 'form-control')); ?>
                              
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <label for="email_address">Publish Date<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->text('Blog.publish_date',array('placeholder' => 'Enter Publish Date','class' => 'form-control')); ?>
                              
                          </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="email_address">Summary<span class="red_star">*</span></label>
                    <div class="form-group">
                        <div class="form-line">
                          <?php echo $this->Form->textarea('Blog.summary',array('placeholder' => 'Enter Summary','class' => 'form-control')); ?>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <label for="email_address">Content<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                          <?php echo $this->Form->textarea('Blog.content',array('placeholder' => 'Enter Content','class' => 'form-control content_data','rows'=>5)); ?>
                          </div>
                      </div>
                  </div>
                </div>               
                <br>
                <button type="submit" class="btn btn-primary m-t-15 waves-effect jq_add">Submit</button>
              <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>            
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(){


   CKEDITOR.disableAutoInline = true;
     $( '.content_data' ).ckeditor(); // Use CKEDITOR.replace() if element is <textarea>. 

   
  $('#BlogPublishDate').bootstrapMaterialDatePicker({
        time : false,
        switchOnClick: true,
        clearText: true,
        format : 'YYYY-MM-DD',
        minDate : moment()
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
        alert("Pls select only images");
      }
  });

  $(".jq_add").click( function() {

    $("#loading_image").show();
    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
    var ajaxOptions = {
      url         : adminUrl+'masters/add_blog/',
      resetForm   : false,
      dataType    : 'json',
      success     : ajaxSuccess
    };
    $( '#BlogAddForm' ).ajaxForm( ajaxOptions );
    $( '#BlogAddForm' ).on('submit',function() {
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
                   
          setTimeout(function(){ window.location.href = adminUrl+'masters/blogs'; }, 500);      
      } 
    }
  });

});

</script>
