<section>  
  <div class="container-fluid">  
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                 <div class="header">
                    <h2>
                        Add Address
                    </h2>
                </div>
                <div class="body">
                    <?php 
                    echo $this->Form->create('UserAddress',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'AddUserAddressForm', 'enctype' => "multipart/form-data")) ;
                    echo $this->Form->hidden('UserAddress.user_id',array('value'=>$user_id)); 
                    ?>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="email_address">Address1<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->textarea('UserAddress.address_1',array('placeholder' => 'Enter Address1','class' => 'form-control','rows'=>3)); ?>
                              
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="email_address">Address2</label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->textarea('UserAddress.address_2',array('placeholder' => 'Enter Address2','class' => 'form-control','rows'=>3)); ?>
                              
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                          <label for="email_address">Country<span class="red_star">*</span></label>
                          <div class="form-group">
                              <div class="form-line">
                                <?php echo $this->Form->select('UserAddress.country_id',$countryList,array('empty' => 'Select Country','class' => 'form-control','default'=>38)); ?>
                              </div>
                          </div>
                      </div>
                    <div class="col-md-6">
                          <label for="email_address">State<span class="red_star">*</span></label>
                          <div class="form-group">
                              <div class="form-line">
                                   <?php echo $this->Form->select('UserAddress.state_id',$stateList,array('empty' => 'Select State','class' => 'form-control get_city_name',)); ?>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                          <label for="email_address">City<span class="red_star">*</span></label>
                          <div class="form-group">
                              <div class="form-line">
                                <?php echo $this->Form->select('UserAddress.city_id',null,array('empty' => 'Select City','class' => 'form-control city_dropdown',)); ?>
                              </div>
                          </div>
                      </div>
                    <div class="col-md-6">
                      <label for="email_address">Zip Code<span class="red_star">*</span></label>
                      <div class="form-group">
                          <div class="form-line">
                            <?php echo $this->Form->text('UserAddress.zip_code',array('class'=>'form-control show-tick','label'=>false,'empty' => false)); ?>
                          </div>
                      </div>
                    </div>
                  
                  </div>
                   
                
                <button type="submit" class="btn btn-primary m-t-15 waves-effect jq_add">Submit</button>
                <button type="button" class="btn btn-grey m-t-15 m-l-10 waves-effect close-popup">Close</button>
                <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>            
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
  
  var userid = $('#UserAddressUserId').val();
  $('.jq_add').click(function(){
    var frmData = $("#AddUserAddressForm").serialize();  
    $('.err-remove-validate').remove();
    $('.form-line').removeClass('error');
    $('.form-line').removeClass('focused');
        $("#loading_image2").show();
        $.ajax({
            type: "POST",
            async: true,
            url: adminUrl+'users/add_address/'+userid,
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
                  $('#modal-form').modal('hide');  
                  $('.success_box').show();              
                  $('.success_box').slideDown(500,function() {
                    $('.success_msg').html(data.message);
            
                  }); 
                 var url = adminUrl+'users/address_data/'+userid;
                 loadPiece(url,'#empdata');                        
                } 
            }
        });
  });
  
  $('.close-popup').on('click',function(){
    $('#modal-form').modal('hide');
  });

  $(".get_city_name").change(function(){

      var state_id = this.value;
      if(state_id == ''){
        $('.city_dropdown').html('<option value=" ">Select City</option>');
        
        return false;
      }
      $("#loading_image").show();
      $.ajax({
          type: "POST",
          async: true,
          url: adminUrl+'users/getCity/'+state_id,
          data: null,
          dataType: 'html',
          error: function(a,b,c) {
          //alert('Unable to process request. - ' + a);
        },              
        success: function (data) {
          $("#loading_image").hide();
          $('.city_dropdown').html(data);
        }
      });
  });

});
</script>