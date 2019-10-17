<section class="content">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">groups</i> Vouchers',array('controller'=>'vouchers','action'=>'venders'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>Edit Vendor</li>
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
                        Edit Vender
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

     var verdorId = "<?php echo $vendorid; ?>";

    $(".jq_add_vendor").click( function() {

        $("#loading_image").show();
        $('.err-remove-validate').remove();
        $('.form-line').removeClass('error');
        $('.form-line').removeClass('focused');
        var ajaxOptions = {
        url         : adminUrl+'vouchers/edit_vendor/'+verdorId,
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
