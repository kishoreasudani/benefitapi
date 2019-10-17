<?php
  echo $this->Html->script('wecontrol/filemanager_in_ckeditor/js/ckeditor/ckeditor');
  echo $this->Html->script('wecontrol/filemanager_in_ckeditor/js/ckeditor/adapters/jquery');
?>
<script type="text/javascript" language="javascript">
  $().ready( function() {
    $( '.t_and_c' ).ckeditor({

       toolbar:
        [
          ['Source'],
          ['FontSize','TextColor','BGColor'],
          ['Cut', 'Copy', 'PasteText','Bold', 'Italic', 'Underline','Subscript','Superscript','Maximize'],
          ['NumberedList', 'BulletedList','JustifyLeft','JustifyRight','JustifyCenter','JustifyBlock'],
          ['MediaEmbed'],['Link']
          
          
        ],
    
      filebrowserBrowseUrl :'<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Connector=<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
      filebrowserImageBrowseUrl : '<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
      filebrowserFlashBrowseUrl :'<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/connector.php',
      
      filebrowserUploadUrl  :'<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
      filebrowserImageUploadUrl : '<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
      filebrowserFlashUploadUrl : '<?php echo Configure::read('SiteSettings.applicationFolder')  ?>js/wecontrol/filemanager_in_ckeditor/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
      
    });
    $( '.desp' ).ckeditor({

       toolbar:
        [
          ['Source'],
          ['FontSize','TextColor','BGColor'],
          ['Cut', 'Copy', 'PasteText','Bold', 'Italic', 'Underline','Subscript','Superscript','Maximize'],
          ['NumberedList', 'BulletedList','JustifyLeft','JustifyRight','JustifyCenter','JustifyBlock'],
          ['MediaEmbed'],
          
          
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
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">collections_bookmark</i> Vouchers',array('controller'=>'vouchers','action'=>'index'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>Edit Voucher</li>
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
                        Edit Voucher
                    </h2>
                </div>
                <div class="body">
                    <?php echo $this->Form->create('Voucher',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'VoucherEditForm', 'enctype' => "multipart/form-data")) ;
                      echo $this->Form->hidden('Voucher.id', array('class'=>'panel form-horizontal', 'value'=>$this->data['Voucher']['id']));        ?>              
                    <div class="row">
                        <div class="col-md-4">
                            <label for="email_address">Name<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Voucher.name',array('placeholder' => 'Enter Name','class' => 'form-control')); ?>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="email_address">Code<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Voucher.code',array('placeholder' => 'Enter Voucher Code','class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>

                          <div class="col-md-4">
                            <label for="email_address">Vendor<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                   <?php       
                                      echo $this->Form->input('Voucher.vendor_id', array('type'=>'select','empty'=> 'Select Vendor', 'options'=>$vendorsList,'class'=>'form-control','label'=>false)); ?>
                                </div>
                            </div>
                        </div> 
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="email_address">Amount<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Voucher.amount',array('placeholder' => 'Enter Voucher Amount','class' => 'form-control')); ?>
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <label for="email_address">Coins Required<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php   echo $this->Form->text('Voucher.coins_required',array('placeholder' => 'Enter Coins Required','class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>   

                    <div class="row">
                        <div class="col-md-6">
                            <label for="email_address">Start Date<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Voucher.start_date',array('placeholder' => 'Enter Start Date','class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email_address">End Date<span class="red_star">*</span></label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->text('Voucher.end_date',array('placeholder' => 'Enter End Date','class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="email_address">T&C</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->textarea('Voucher.terms_and_conditions',array('placeholder' => 'Enter Content','class' => 'form-control t_and_c','rows'=>5)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email_address">Description</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo $this->Form->textarea('Voucher.descriptions',array('placeholder' => 'Enter Content','class' => 'form-control','rows'=>5)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="icon">Logo</label>
                            <div class="remove-section edit-remove-section">
                                <?php   if(isset($this->data['Voucher']['image']) && !empty($this->data['Voucher']['image'])){?>
                                    <div class="remove-image-1 edit-common-img margin_bottom5">
                                        <?php $fileName = $this->data['Voucher']['image'];
                                        $imagepath = Configure::read('SiteSettings.Relative.VoucherImage').'/'.$fileName;
                                        if(!is_dir($imagepath) && file_exists( $imagepath)){
                                        $imagepath = Configure::read('SiteSettings.Absolute.VoucherImage').'/'.$fileName;
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
                                <?php } ?>
                                <div class="rows fileUpload btn btn-primary">
                                    <span class="rows upload_button pull-left">Image</span>
                                    <?php echo $this->Form->file('Voucher.image1', array('class'=>'upload jq_file_upload')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="icon">Background Image</label>
                            <div class="remove-section edit-remove-section">
                                <?php   if(isset($this->data['Voucher']['bg_image']) && !empty($this->data['Voucher']['bg_image'])){?>
                                    <div class="remove-image-1 edit-common-img margin_bottom5">
                                        <?php $fileName_bg = $this->data['Voucher']['bg_image'];
                                        $imagepath_bg = Configure::read('SiteSettings.Relative.VoucherImage').'/'.$fileName_bg;
                                        if(!is_dir($imagepath_bg) && file_exists( $imagepath_bg)){
                                        $imagepath_bg = Configure::read('SiteSettings.Absolute.VoucherImage').'/'.$fileName_bg;
                                        } ?>  
                                        <span class="jq_remove_image "></span>                              
                                        <?php echo $this->Html->image($imagepath_bg,array('width'=>'100%;'));?>
                                    </div>
                                <?php } else {?>
                                    <div class="remove-image-1 edit-common-img margin_bottom5">
                                        <?php $imagepath = "wecontrol/user.png";?>  
                                        <span class="jq_remove_image "></span>                              
                                        <?php echo $this->Html->image($imagepath,array('width'=>'100%;'));?>
                                    </div>
                                <?php } ?>
                                <div class="rows fileUpload btn btn-primary">
                                    <span class="rows upload_button pull-left">Image</span>
                                    <?php echo $this->Form->file('Voucher.image_bg', array('class'=>'upload jq_file_upload')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect jq_voucher_edit">Submit</button>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>            
  </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
    
    $('#VoucherStartDate').bootstrapMaterialDatePicker({
        minDate : moment(),
        time : false,
        switchOnClick: true,
        clearText: true,
        format : 'YYYY-MM-DD',
    });
    $('#VoucherEndDate').bootstrapMaterialDatePicker({
        minDate : moment(),
        time : false,
        switchOnClick: true,
        clearText: true,
        format : 'YYYY-MM-DD'
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

    $(".jq_voucher_edit").click( function() {
        var id = '<?php echo $voucherid;?>';
        $("#loading_image").show();
        $('.err-remove-validate').remove();
        $('.form-line').removeClass('error');
        $('.form-line').removeClass('focused');
        var ajaxOptions = {
        url         : adminUrl+'vouchers/edit_voucher/'+id,
        resetForm   : false,
        dataType    : 'json',
        success     : ajaxSuccess
        };
        $( '#VoucherEditForm' ).ajaxForm( ajaxOptions );
        $( '#VoucherEditForm' ).on('submit',function() {
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
            var url = adminUrl+'vouchers/';
            loadPiece(url,'#empdata');
            setTimeout(function(){ window.location.href = adminUrl+'vouchers'; }, 500);      
        } 
        }
    });
    $('#VoucherDiscountType').on('change', function() {
        var change_val = $(this).val();
       
        if(change_val == 'percentage'){
            $('.h_s_discount').removeClass('hide');
        }else{
            $('.h_s_discount').addClass('hide');
        }
    });

    $('#VoucherDiscountType').trigger('change');

});

</script>
