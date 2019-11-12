 <?php
   echo $this->Html->script('ckeditor/ckeditor.js');
   echo $this->Html->script('ckeditor/adapters/jquery.js');
?>
<section class="content">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">groups</i> Vendors',array('controller'=>'vouchers','action'=>'vendors'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>Add Vendor</li>
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
                        Add Vendor
                    </h2>
                </div>

                      <div class="body">
                                <?php echo $this->Form->create('Vendor',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'VendorAddForm', 'enctype' => "multipart/form-data")) ;?>                        
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email_address">Vendor Name<span class="red_star">*</span></label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?php echo $this->Form->text('Vendor.name',array('placeholder' => 'Enter vendor Name','class' => 'form-control')); ?>
                                                    
                                              </div>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <label for="email_address">Vendor URL<span class="red_star"></span></label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?php echo $this->Form->text('Vendor.vendor_url',array('placeholder' => 'Enter vendor URL','class' => 'form-control')); ?>
                                                    
                                              </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email_address">Vendor Logo<span class="red_star">*</span></label>
                                        <div class="remove-section edit-remove-section">
                                          <div class="remove-image-1 edit-common-img margin_bottom5">
                                              <?php $imagepath = "wecontrol/user.png";?>  
                                              <span class="jq_remove_image "></span>                              
                                              <?php echo $this->Html->image($imagepath,array('width'=>'100%;'));?>
                                          </div>
                                          <div class="rows fileUpload btn btn-primary">
                                              <span class="rows upload_button pull-left">Upload logo</span>
                                              <?php echo $this->Form->file('Vendor.logo', array('class'=>'upload jq_file_upload','id'=>'58')); ?>
                                          </div>
                                        <div class="form-group">
                                          <div class="form-line">
                                             <div id="VendorLogo"> </div>
                                         </div>
                                         </div>

                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email_address">Background Logo<span class="red_star">*</span></label>
                                        <div class="remove-section edit-remove-section">
                                          <div class="remove-image-1 edit-common-img margin_bottom5">
                                              <?php $imagepath = "wecontrol/user.png";?>  
                                              <span class="jq_remove_image "></span>                              
                                              <?php echo $this->Html->image($imagepath,array('width'=>'100%;'));?>
                                          </div>
                                          <div class="rows fileUpload btn btn-primary">
                                              <span class="rows upload_button pull-left">Upload background logo</span>
                                              <?php echo $this->Form->file('Vendor.background_logo', array('class'=>'upload jq_file_upload','id'=>'589')); ?>
                                          </div>
                                        <div class="form-group">
                                          <div class="form-line">
                                             <div id="VendorBackgroundLogo"> </div>
                                         </div>
                                         </div>

                                      </div>
                                    </div>

                                     
                                </div>

                                <div  class="row m-t-15">
                                    <div class="col-md-12">
                                        <label for="email_address">Vouchers T&C</label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?php echo $this->Form->textarea('Vendor.terms_and_conditions',array('placeholder' => 'Enter Content','class' => 'form-control t_and_c','rows'=>5)); ?>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>

                                 <div  class="row m-t-15">
                                    <div class="col-md-12">
                                        <label for="email_address">Vouchers Description<span class="red_star">*</span></label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?php echo $this->Form->textarea('Vendor.description',array('placeholder' => 'Enter Content','class' => 'form-control','rows'=>5,'id'=>'desp')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row m-t-15">
                                    <div class="col-md-12">
                                        <label for="email_address">Vendor Tags<span class="red_star"></span></label>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <?php echo $this->Form->text('Vendor.tags',array('placeholder' => 'Enter tags','class' => 'form-control')); ?>
                                                    
                                              </div>
                                        </div>
                                    </div>
                                </div>



                                 <div class="row">
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect align-center jq_add_vendor">Submit</button>
                                        </div>
                                    </div>
                                </div>

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
     $( '.t_and_c' ).ckeditor(); // Use CKEDITOR.replace() if element is <textarea>. 


  

    $(".jq_add_vendor").click( function() {

        $("#loading_image").show();
        $('.err-remove-validate').remove();
        $('.form-line').removeClass('error');
        $('.form-line').removeClass('focused');
        var ajaxOptions = {
        url         : adminUrl+'vouchers/add_vendor',
        resetForm   : false,
        dataType    : 'json',
        success     : ajaxSuccess
        };
        $( '#VendorAddForm' ).ajaxForm( ajaxOptions );
        $( '#VendorAddForm' ).on('submit',function() {
        $("#loading_image").show();
        });
        function ajaxSuccess( data , responseCode , xhr ) {  

  
        if(data.success == false){
            var errors  = data.message;
            $.each( data.message, function( key, value ) {
                $('<label class="error err-remove-validate">'+value+'</label>').insertAfter($('#'+key).parents('.form-line'));
                $('#'+key).parents('.form-line').addClass('error');
                $('#'+key).parents('.form-line').addClass('focused'); 
            });

              $("#loading_image").hide();
            }else if(data.success == true){
               $(".success_box").show();
               $(".success_msg").html(data.message);
               $("#loading_image").hide();
              setTimeout(function(){ window.location.href = adminUrl+'vouchers/vendors'; }, 500);      
        } 
        }
    });   
});

</script>

<style type="text/css">
  
.cke_wysiwyg_frame, .cke_wysiwyg_div{
    background-color:#FCF1DC !important;
}
</style>
