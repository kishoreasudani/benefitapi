 <div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                      <th width="5%" style="text-align:center;">#</th>
                      <th  class="sortLink" width="15%"><?php echo $this->Paginator->sort('Voucher.name','Name'); ?></th> 
                      <th  class="sortLink" width="15%"><?php echo $this->Paginator->sort('Voucher.code','Code'); ?></th> 
                      <th  class="sortLink" width="15%">Redeemptions</th>
                      <th class="sortLink" width="15%" style="text-align:center;"><?php echo $this->Paginator->sort('Voucher.status','Status'); ?></th>
                      <th class="sortLink" width="15%" style="text-align:center;"><?php echo $this->Paginator->sort('Voucher.created','Created'); ?></th>
                      <th class="sortLink" width="15%" style="text-align:center;"><?php echo $this->Paginator->sort('Voucher.modified','Modified'); ?></th>                      
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
                      <td><?php echo $value['Voucher']['name'] ?> </td>
                      <td><?php echo ucwords($value['Voucher']['code']); ?> </td>
                      <td><?php echo $value['Voucher']['count'] ?> </td>
                      <td><?php echo $this->Form->select('Voucher.status',Configure::read('General.status'),array('default' => $value['Voucher']['status'],'class'=>'form-control show-tick change_status','label'=>false,'empty' => false,'id' => base64_encode( $value['Voucher']['id'] )));?></td> 
                      <td align="center"><?php   echo date(dateFormat,strtotime($value['Voucher']['created'])); ?> </td>
                      <td align="center"><?php   echo date(dateFormat,strtotime($value['Voucher']['modified'])); ?> </td> 
                      <td align="center">         
                        <?php 
                        echo $this->Html->link('<i class="material-icons">remove_red_eye</i>',array('controller'=>'vouchers','action'=>'view_voucher',base64_encode($value['Voucher']['id'])),array('class' => 'btn bg-grey waves-effect btn-xs','escape'=>false,'title'=>'View Voucher')) ; 
                        echo "&nbsp;&nbsp;";
                        echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'vouchers','action'=>'edit_voucher',base64_encode($value['Voucher']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs','escape'=>false,'title'=>'Edit Voucher')); 
                        echo "&nbsp;&nbsp;";
                        echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['Voucher']['id'],'title'=>'Delete')) ; 
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
    var modelname = 'Voucher';
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
                  setTimeout(function(){ window.location.href = adminUrl+'vouchers'; }, 500); 
                }
              }
            });
        } else{
          setTimeout(function(){ window.location.href = adminUrl+'vouchers'; }, 100); 
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
                url: adminUrl+'vouchers/delete_voucher/'+id,
                dataType: 'json',
                error:function(a,b,c) {

                    $("#loading_image").hide();
                },
                success: function (data) {

                    $("#loading_image").hide();
                    $('.alert-success').hide();
                    $('.alert-danger').hide();
                    if(data.success == true) {
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                        var url = adminUrl+'vouchers/vouchers_data/';
                        loadPiece(url,'#empdata'); 
                    }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                        var url = adminUrl+'vouchers/vouchers_data/';
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


