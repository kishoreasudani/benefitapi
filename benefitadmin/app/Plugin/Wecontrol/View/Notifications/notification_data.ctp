 <div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                      <th width="5%" style="text-align:center;">#</th>
                      <th class="sortLink" width="20%"><?php echo $this->Paginator->sort('UserNotification.message','Message'); ?></th> 
                      <th class="sortLink" width="15%"><?php echo $this->Paginator->sort('UserNotification.sender','Sender'); ?></th> 
                      <th class="sortLink" width="15%"><?php echo $this->Paginator->sort('UserNotification.receiver','Receiver'); ?></th>
                      <th class="sortLink" width="15%"><?php echo $this->Paginator->sort('UserNotification.read_status','Read Status'); ?></th> 
                      <th class="sortLink" width="15%" style="text-align:center;"><?php echo $this->Paginator->sort('UserNotification.created','Created'); ?></th>                     
                      <th style="text-align:center;" width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php     
                    if(isset($notification_data) && !empty($notification_data)){   
                    $i = 1;       
                      foreach ($notification_data as $key => $value) {   
                    ?>
                    <tr>
                      <td align="center"><?php echo $i++; ?></td>
                      <td><?php echo $value['UserNotification']['message'] ?> </td>
                      <td><?php echo ucwords($value['Admin']['first_name']).' '.ucwords($value['Admin']['last_name']); ?> </td> 
                      <td><?php echo ucwords($value['User']['first_name']).' '.ucwords($value['User']['last_name']); ?></td> 
                      <td><?php echo ucwords(!empty($value['UserNotification']['read_status'])?$value['UserNotification']['read_status']:'--'); ?></td>
                      <td align="center"><?php   echo date(dateTimeFormat,strtotime($value['UserNotification']['created'])); ?> </td>
                      <td align="center">         
                        <?php 
                        //echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'masters','action'=>'edit_template',base64_encode($value['NotifyTemplate']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs','escape'=>false,'title'=>'Edit')); echo "&nbsp;&nbsp;";
                        //echo $this->Html->link('<i class="material-icons">remove_red_eye</i>',array('controller'=>'masters','action'=>'view_template',base64_encode($value['NotifyTemplate']['id'])),array('class' => 'btn bg-grey waves-effect btn-xs','escape'=>false,'title'=>'View Template')) ; 
                        // echo "&nbsp;&nbsp;";
                        echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['UserNotification']['id'],'title'=>'Delete')) ; 
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

  $('.delete_data').on('click',function(){
    id = $(this).attr('id');
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
                url: adminUrl+'notifications/delete_notification',
                 data: {'data[UserNotification]':{'id':id}},
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
                        $('.error_msg').html(data.message);
                        var url = adminUrl+'notifications/notification_data/';
                        loadPiece(url,'#empdata'); 
                    }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.message);
                        var url = adminUrl+'notifications/notification_data/';
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


