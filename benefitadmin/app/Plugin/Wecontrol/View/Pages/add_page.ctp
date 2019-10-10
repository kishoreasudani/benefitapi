<?php
  echo $this->Html->script('wecontrol/filemanager_in_ckeditor/js/ckeditor/ckeditor');
  echo $this->Html->script('wecontrol/filemanager_in_ckeditor/js/ckeditor/adapters/jquery');
?>
<script type="text/javascript" language="javascript">
  $().ready( function() {
    $( '.content_data' ).ckeditor({

       toolbar:
        [
          ['Source'],
          ['FontSize','TextColor','BGColor'],
          ['Cut', 'Copy', 'PasteText','Bold', 'Italic', 'Underline','Subscript','Superscript','Maximize'],
          ['NumberedList', 'BulletedList','JustifyLeft','JustifyRight','JustifyCenter','JustifyBlock'],
          ['MediaEmbed'],
          ['Link','Unlink','Image'],
          
        ],
    
      filebrowserBrowseUrl :'<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
      filebrowserImageBrowseUrl : '<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
      filebrowserFlashBrowseUrl :'<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
      
      filebrowserUploadUrl  :'<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
      filebrowserImageUploadUrl : '<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
      filebrowserFlashUploadUrl : '<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
      
    });
  });
</script>
<section class="content">  
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
        <li><?php  echo $this->Html->link('<i class="material-icons">pages</i><span>Pages</span>',array('controller'=>'pages','action'=>'static_page'),array('escape'=>false)) ; ?></li>        
        <li class="active"><i class="material-icons"></i> Add Page</li>
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
                            ADD Page
                        </h2>
                    </div>
                    <div class="body">
                        <?php echo $this->Form->create('Page',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'AddPageForm', 'enctype' => "multipart/form-data")) ;?>                        
                      <div class="row">
                        <div class="col-md-6">
                          <label for="PageTitle">Page Title<span class="red_star">*</span></label>
                          <div class="form-group">
                              <div class="form-line">
                                  <?php echo $this->Form->text('Page.title',array('placeholder' => 'Enter Title','class' => 'form-control')); ?>
                              </div>
                          </div>
                        </div>
                         <div class="col-md-6">
                            <label for="PageHeading">Page Heading<span class="red_star">*</span> </label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Page.heading',array('placeholder' => 'Enter Heading','class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                      </div> 
                    
                      <div class="row">
                        <div class="col-md-12">
                            <label for="PageDescription">Description<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                  <?php echo $this->Form->textarea('Page.description',array('placeholder' => 'Enter Description','class' => 'form-control content_data')); ?>
                                 
                                </div>
                            </div>
                        </div>                        
                      </div>   
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect add_page">Submit</button>
                    <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>            
    </div>
</section>
<script type="text/javascript">
$(document).ready(function(){

  $(".add_page").click( function() {

    $("#loading_image").show();
    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
    var ajaxOptions = {
      url         : adminUrl+'pages/add_page/',
      resetForm   : false,
      dataType    : 'json',
      success     : ajaxSuccess
    };
    $( '#AddPageForm' ).ajaxForm( ajaxOptions );
    $( '#AddPageForm' ).on('submit',function() {
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
                   
          setTimeout(function(){ window.location.href = adminUrl+'pages/static_page'; }, 500); 
                   
      } 
    }
  });

});

</script>
