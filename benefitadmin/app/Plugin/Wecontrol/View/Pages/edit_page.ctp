 <?php
   echo $this->Html->script('ckeditor/ckeditor.js');
   echo $this->Html->script('ckeditor/adapters/jquery.js');
?>
<section class="content">  
    <ol class="breadcrumb breadcrumb-col-teal">
        <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Dashboard',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
        <li><?php  echo $this->Html->link('<i class="material-icons">pages</i><span>Pages</span>',array('controller'=>'pages','action'=>'static_page'),array('escape'=>false)) ; ?></li>        
        <li class="active"><i class="material-icons"></i> Edit Page</li>
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
                            Edit Page
                        </h2>
                    </div>
                    <div class="body">
                        <?php echo $this->Form->create('Page',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'EditPageForm', 'enctype' => "multipart/form-data")) ;
                        echo $this->Form->hidden('Page.id');
                        ?>                        
                      <div class="row">
                        <div class="col-md-6">
                            <label for="PageTitle">Page Title<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Page.title',array('placeholder' => 'Enter Page Title','class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <label for="PageHeading">Page Heading<span class="red_star">*</span>  </label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Page.heading',array('placeholder' => 'Enter Page Heading','class' => 'form-control')); ?>
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
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect edit_page">Update</button>
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
     $( '#PageDescription' ).ckeditor(); // Use CKEDITOR.replace() if element is <textarea>.



  $('.edit_page').click(function(){

    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
    $("#loading_image").show();
    var page_id ="<?php echo $id;?>";
    var ajaxOptions = {
      url: adminUrl+'pages/edit_page/'+page_id,
      resetForm   : false,
      datatype    : 'json',
      success     : ajaxSuccess,
    };
    $( '#EditPageForm' ).ajaxForm( ajaxOptions );
    $( '#EditPageForm' ).on('submit',function() {

      $("#loading_image").show();
    }); 
    function ajaxSuccess( response , responseCode , errorThrown ){

           $("#loading_image").hide();
           $('.err-remove-validate').remove();
           var response = $.parseJSON( response );
           if( response.type == 'validationError' ){

            $.each( response.data , function( field , message ){
            

              $('<label class="error err-remove-validate">'+message+'</label>').insertAfter($('#'+field).parents('.form-line'));
              $('#'+field).parents('.form-line').addClass('error');
              $('#'+field).parents('.form-line').addClass('focused');  
            });
      } else if( response.type == 'success' ){
        setTimeout(function(){ window.location.href = adminUrl+'pages/static_page'; }, 500);
      }
    }        
  });

});

</script>
