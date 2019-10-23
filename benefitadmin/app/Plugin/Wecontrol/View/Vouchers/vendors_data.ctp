 <div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                      <th width="5%" style="text-align:center;">#</th>
                      <th  class="sortLink" width="15%"><?php echo $this->Paginator->sort('Vendor.name','Name'); ?></th>      
                      <th  class="sortLink" width="15%">Vouchers</th>

                       <th  class="sortLink" width="15%">Logo</th>

                        <th  class="sortLink" width="15%">Background</th>

                      <th class="sortLink" width="15%" style="text-align:center;"><?php echo $this->Paginator->sort('Vendor.status','Status'); ?></th>
                      <th class="sortLink" width="15%" style="text-align:center;"><?php echo $this->Paginator->sort('Vendor.created','Created'); ?></th>                     
                      <th style="text-align:center;" width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php     
                    if(isset($listingData) && !empty($listingData)){   
                    $i = 1;       
                      foreach ($listingData as $key => $value) {   
                    ?>
                    <tr>
                      <td align="center"><?php echo $i++; ?></td>
                      <td><?php echo $value['Vendor']['name'] ?> </td>
                      <td><?php echo $value['Vendor']['count'] ?> </td>

                      <td> <?php $imagepath = Configure::read('SiteSettings.Absolute.VendorLogo').$value['Vendor']['logo'];                               
                           echo $this->Html->image($imagepath,array('width'=>'60px','height'=>'50px'));?>
                       </td>

                        <td> <?php $imagepath = Configure::read('SiteSettings.Absolute.VendorLogo').$value['Vendor']['background_logo'];                               
                           echo $this->Html->image($imagepath,array('width'=>'60px','height'=>'50px'));?>
                       </td>

                      <td><?php echo $this->Form->select('Vendor.status',Configure::read('General.status'),array('default' => $value['Vendor']['status'],'class'=>'form-control show-tick change_status','label'=>false,'empty' => false,'id' => base64_encode( $value['Vendor']['id'] )));?></td> 

                      <td align="center"><?php   echo date(dateFormat,strtotime($value['Vendor']['created'])); ?> </td>

                      <td align="center">         
                        <?php 
                        echo $this->Html->link('<i class="material-icons">remove_red_eye</i>',array('controller'=>'vouchers','action'=>'index',base64_encode($value['Vendor']['id'])),array('class' => 'btn bg-grey waves-effect btn-xs','escape'=>false,'title'=>'View Vouchers')) ; 
                        echo "&nbsp;&nbsp;";
                        echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'vouchers','action'=>'edit_vendor',base64_encode($value['Vendor']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs','escape'=>false,'title'=>'Edit Vendor')); 
                        echo "&nbsp;&nbsp;";
                        echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['Vendor']['id'],'title'=>'Delete')) ; 
                        ?>
                      </td> 
                    </tr>
                    <tr class="edit_u_account_details" style="display:none;">
                      <td colspan="6"></td>
                    </tr>
                    <?php   }
                     }else{ ?>
                    <tr align="center">
                      <td colspan="56">No data found.</td>
                    </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            <?php echo $this->element('pagination_new'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script type= "text/javascript">
$(document).ready(function(){
 
	$('.sortLink').click( function() {
      var Href = $(this).find('a').attr("href"); 
      if(Href != null){
        loadPiece(Href,"#empdata");
      }
      return false;
    });

	$('.jq_prev').click( function() {
      var HrefOne = $(this).find('a').attr("href"); 
      if(HrefOne != null){
       loadPiece(HrefOne,"#empdata");
     }
       return false;
    });

    $('.jq_next').click(function() {
      var HrefNext = $(this).find('a').attr("href");
      if(HrefNext != null){ 
        loadPiece(HrefNext,"#empdata");
      }
      return false;
    });

    $('.ajaxlink').click(function() {
      var HrefLink = $(this).find('a').attr("href");
      if(HrefLink != null){  
        loadPiece(HrefLink,"#empdata");
      }
      return false;
    });

    $('.change_status').on('change',function(){
        var status = $(this).val();
        var VoucherId = $(this).attr('id');      
        var modelname = 'Vendor';
        bootbox.confirm({
          message: "Are you sure, you want to update the status of this record?",
           buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
          },
          callback: function(result) {  
            if(result == true) {
                $("#loading_image").show();
                $.ajax({
                  type: "POST",
                  url: adminUrl+'masters/change_status/',
                  data: {'data[changestatus]':{'status':status,'id':VoucherId,'modelName':modelname}},
                  dataType: 'json',
                  error:function(a,b,c) {
                    $("#loading_image").hide();
                    bootbox.alert({
                      message: 'Unable to process request. - ' + a,
                      className: "bootbox-m"
                    }); 
                  },             
                  success: function (data) {
                    $("#loading_image").hide();
                    if(data.success == true){
                      $('#successBox').hide();
                      $("#search_button").trigger("click");
                      $('.success_box').show(); 
                      $('.success_msg').html(data.message);
                                        
                    }else{
                      $('.error_box').show(); 
                      $('.error_msg').html(data.message);
                      setTimeout(function(){ window.location.href = adminUrl+'vendors'; }, 500); 
                    }
                  }
                });
            } else{
              setTimeout(function(){ window.location.href = adminUrl+'vendors'; }, 100); 
            }
          },className: "bootbox-m"
        });
  });


  $('.delete_data').on('click',function(){
    id = $(this).attr('id');
    // console.log(id);
    bootbox.confirm({
      message: " Are you sure, you want to delete this data?",
       buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn-danger'
        }
      },
      callback: function(result) {  
        if(result == true) {

            $("#loading_image").show();
            $.ajax({
                type: "DELETE",
                async: true,
                url: adminUrl+'vouchers/delete_vendors/'+id,
                dataType: 'json',
                error:function(a,b,c) {

                    $("#loading_image").hide();
                },
                success: function (data) {

                    $("#loading_image").hide();
                    $('.alert-success').hide();
                    $('.alert-danger').hide();
                    if(data.success == true) {
                         $(".success_box").show();
                         $(".success_msg").html(data.msg);
                        var url = adminUrl+'vouchers/vendors_data/';
                        loadPiece(url,'#empdata'); 
                    }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                        var url = adminUrl+'vouchers/vendors_data/';
                        loadPiece(url,'#empdata'); 
                    }
                }
            });
        }
      },className: "bootbox-m"
    });
  });

});
</script>


