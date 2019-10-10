<section class="content">  
  <ol class="breadcrumb breadcrumb-col-teal">
      <li><?php  echo $this->Html->link('<i class="material-icons">home</i> Home',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)) ; ?></li>
      <li><?php  echo $this->Html->link('<i class="material-icons">speaker_notes</i> Daily Limits',array('controller'=>'masters','action'=>'dailylimits'),array('escape'=>false)) ; ?></li>        
      <li class="active"><i class="material-icons"></i>Add Limit</li>
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
                    <?php echo $this->Form->create('DailyLimit',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'LimitAddForm', 'enctype' => "multipart/form-data")) ;?>                        
                <div class="row">
                  <div class="col-md-6">
                      <label for="email_address">Limit<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->text('DailyLimit.limit',array('placeholder' => 'Enter Limit','class' => 'form-control')); ?>
                              
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <label for="email_address">Effective Date<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->text('DailyLimit.effective_date',array('placeholder' => 'Enter Effective Date','class' => 'form-control')); ?>
                              
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
   
  $('#DailyLimitEffectiveDate').bootstrapMaterialDatePicker({
        time : false,
        switchOnClick: true,
        clearText: true,
        format : 'YYYY-MM-DD',
        minDate : moment()
  });

  $(".jq_add").click( function() {

    $("#loading_image").show();
    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
    var ajaxOptions = {
      url         : adminUrl+'masters/add_limit/',
      resetForm   : false,
      dataType    : 'json',
      success     : ajaxSuccess
    };
    $( '#LimitAddForm' ).ajaxForm( ajaxOptions );
    $( '#LimitAddForm' ).on('submit',function() {
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
                   
          setTimeout(function(){ window.location.href = adminUrl+'masters/dailylimits'; }, 500);      
      } 
    }
  });

});

</script>
