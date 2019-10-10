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
<section>  
  <div class="container-fluid">  
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                 <div class="header">
                    <h2>
                        Add FAQ
                    </h2>
                </div>
                <div class="body">
                    <?php echo $this->Form->create('Faq',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'AddFaqForm', 'enctype' => "multipart/form-data")) ;?>                        
                  
                  <div class="row">
                      <div class="col-md-12">
                          <label for="email_address">Question<span class="red_star">*</span></label>
                          <div class="form-group">
                              <div class="form-line">
                                <?php echo $this->Form->text('Faq.question',array('placeholder' => 'Enter Question','class' => 'form-control')); ?>
                                  
                              </div>
                          </div>
                      </div> 
                                              
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label for="email_address">Answer<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->textarea('Faq.answer',array('placeholder' => 'Enter Answer','class' => 'form-control content_data1','rows'=>5)); ?>
                              
                          </div>
                      </div>
                    </div>
                  </div>
                
                <button type="submit" class="btn btn-primary m-t-15 waves-effect add_faq">Submit</button>
                <button type="submit" class="btn btn-default m-t-15 waves-effect m-l-15" data-dismiss="modal">Close</button>
              <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>            
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
  $('#FaqPickupDate').bootstrapMaterialDatePicker({
     time : false,
     minDate:new Date()
  });
  $('.add_faq').click(function(){
    var frmData = $("#AddFaqForm").serialize();  
    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
        $("#loading_image2").show();
        $.ajax({
            type: "POST",
            async: true,
            url: adminUrl+'pages/add_faq/',
            data: frmData,
            dataType: 'json',
          error:function(a,b,c) {
              $("#loading_image2").hide();              
          },             
            success: function (data) {
              $("#loading_image2").hide();
               if(data.success == false){
                    var errors  = data.message;
                    $.each( data.message, function( key, value ) {
                        $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                        $('#'+key).parents('.form-line').addClass('error');
                        $('#'+key).parents('.form-line').addClass('focused');             
                    });
                }else if(data.success == true){
                  $('#modal-form').modal('toggle');
                  $('.alert-success').hide();
                  $('.alert-danger').hide();
                  $('.success_box').slideDown(500,function() {
                    $('.success_msg').html(data.message);
                  });
                  var url = adminUrl+'pages/load_faq/';
                  loadPiece(url,'#empdata');
                                       
                } 
            }
        });
  });

});
</script>