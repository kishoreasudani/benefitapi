<?php
  echo $this->Html->script('wecontrol/edit_area_full.js');
  
?>
 
<section class="content">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">mail_outline </i>Email Templates',array('controller'=>'masters','action'=>'email_templates'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i> Edit Template</li>
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
                Edit Template
            </h2>
          </div>
          <div class="body">
            <?php 
              echo $this->Form->create('NotifyTemplate',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'CityEditForm', 'enctype' => "multipart/form-data")) ;
              echo $this->Form->hidden('NotifyTemplate.id', array('class'=>'panel form-horizontal', 'value'=>$this->data['NotifyTemplate']['id']));
            ?>                   
            <div class="row">
              <div class="col-md-6">
                  <label for="email_address">Title<span class="red_star">*</span></label>
                  <div class="form-group">
                      <div class="form-line">
                        <?php echo $this->Form->text('NotifyTemplate.title',array('placeholder' => 'Enter Title','class' => 'form-control')); ?>
                          
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <label for="email_address">Subject<span class="red_star">*</span></label>
                  <div class="form-group">
                      <div class="form-line">
                        <?php echo $this->Form->text('NotifyTemplate.subject',array('placeholder' => 'Enter Email Subject','class' => 'form-control')); ?>
                          
                      </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                  <label for="email_address">Content<span class="red_star">*</span></label>
                  <div class="form-group">
                      <div class="form-line">
                        <?php echo $this->Form->textarea('NotifyTemplate.content',array('placeholder' => 'Enter Email Subject','class' => 'form-control content_data', 'rows' => "10")); ?>
                          
                      </div>
                  </div>
              </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary m-t-15 waves-effect jq_edit">Submit</button>
            <?php echo $this->Form->end(); ?>
          </div>   
        </div>
      </div>
    </div>
  </div>            
</section>
<script type="text/javascript">
$(document).ready(function(){

  $(".jq_edit").click( function() {

    $("#loading_image").show();
    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
    var id = $("#CategoryId").val();
    var id = btoa(id);
    var ajaxOptions = {
      url         : adminUrl+'masters/edit_template/'+id,
      resetForm   : false,
      dataType    : 'json',
      success     : ajaxSuccess
    };
    $( '#CityEditForm' ).ajaxForm( ajaxOptions );
    $( '#CityEditForm' ).on('submit',function() {
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
             setTimeout(function(){ window.location.href = adminUrl+'masters/email_templates'; }, 500); 
                   
      } 
    }
  });

});

editAreaLoader.init({
    id: "NotifyTemplateContent" // id of the textarea to transform    
        ,
    start_highlight: true // if start with highlight
        ,
    allow_resize: "both",
    allow_toggle: false,
    word_wrap: true,
    language: "en",
    syntax: "php",
    toolbar: "go_to_line",
    syntax_selection_allow: "css,html,js,php,python,vb,xml,c,cpp,sql,basic,pas,brainfuck",
    begin_toolbar: "",
    end_toolbar: ""
});

</script>
