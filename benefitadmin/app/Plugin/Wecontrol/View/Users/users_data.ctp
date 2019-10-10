<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
              <thead>
                  <tr>
                    <th width="3%" style="text-align:center;">#</th>
                    <th class="sortLink" width="12%"><?php echo $this->Paginator->sort('User.full_name','Name'); ?></th> 
                    <th class="sortLink" width="10%"><?php echo $this->Paginator->sort('User.email','Email'); ?></th>
                    <th class="sortLink" width="7%"><?php echo $this->Paginator->sort('User.mobile','Mobile'); ?></th>
                    <th class="sortLink" width="8%"><?php echo $this->Paginator->sort('User.total_coins','Total Coins'); ?></th>
                    <th class="sortLink" width="8%"><?php echo $this->Paginator->sort('User.total_used','Used Coins'); ?></th>
                    <th class="sortLink" width="8%"><?php echo $this->Paginator->sort('User.total_steps','Total Steps'); ?></th>
                    <th class="sortLink" width="9%"><?php echo $this->Paginator->sort("User.today_steps","Today's Steps"); ?></th>
                    <th class="sortLink" width="10%"><?php echo $this->Paginator->sort("User.count","Vouchers Redeemed"); ?></th>
                    <th class="sortLink" width="8%"><?php echo $this->Paginator->sort('User.status','Status'); ?></th>
                    <th class="sortLink" width="10%"><?php echo $this->Paginator->sort('User.created','Created'); ?></th>
                    <th style="text-align:center;" width="7%">Action</th>
                  </tr>
              </thead>
              <tbody>
                <?php     
                  if(isset($user_list) && !empty($user_list)){  
                    $i = 1;        
                    foreach ($user_list as $key => $value) {   ?>
                      <tr>
                        <td align="center"><?php echo $i++; ?></td>
                        <td><?php echo ucfirst($value['User']['first_name']).' '.ucfirst($value['User']['last_name']);; ?> </td>
                        <td><?php echo $value['User']['email']; ?></td>
                        <td><?php echo $value['User']['mobile']; ?></td>
                        <td><?php echo !empty($value['Coin']['total_coins'])?$value['Coin']['total_coins']:'--'; ?></td>
                        <td><?php echo !empty($value['Coin']['total_used'])?$value['Coin']['total_used']:'--'; ?></td>
                        <td><?php echo !empty($value['Running']['total_steps'])?$value['Running']['total_steps']:'--'; ?></td>
                        <td><?php echo !empty($value['RunningHistory']['steps'])?$value['Running']['steps']:'--'; ?></td>
                        <td><?php echo !empty($value['User']['count'])?$value['User']['count']:'--'; ?></td>
                        <td><?php echo $this->Form->select('User.status',Configure::read('General.status'),array('default' => $value['User']['status'],'class'=>'form-control show-tick change_status','label'=>false,'empty' => false,'emp-id' => base64_encode( $value['User']['id'] )));?> </td> 
                        <td><?php echo date(dateTimeFormat,strtotime($value['User']['created'])); ?> </td>
                        <td align="center">         
                          <?php
                            echo $this->Html->link('<i class="material-icons">remove_red_eye</i>',array('controller'=>'users','action'=>'view_vouchers',base64_encode($value['User']['id'])),array('class' => 'btn bg-grey waves-effect btn-xs','escape'=>false,'user_id'=>$value['User']['id'],'title'=>'View Redeemed Vouchers')) ; 
                            echo '&nbsp;';
                            echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'users','action'=>'edit',base64_encode($value['User']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs','escape'=>false,'user_id'=>$value['User']['id'],'title'=>'Edit')) ; 
                            echo '&nbsp;'; 
                            echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['User']['id'],'title'=>'Delete')) ;  
                          ?>
                        </td>
                      </tr>
                      <tr class="edit_u_account_details" style="display:none;">
                        <td colspan="8"></td>
                      </tr>
                    <?php   }
                     }else{ ?>
                    <tr align="center">
                      <td colspan="10">No data found.</td>
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

    
    $('.edit_account').click(function (event){  
        var element = $(this);        
        user_id = element.attr('user_id');
          
        if($(this).parents('tr').next('tr').css('display') != 'none') {
            $(this).parents('tr').next('tr').slideUp(100);

        } else {
          
          $.ajax({
              type: "POST",
              async: true,
              url: adminUrl+'accounts/edit/'+user_id,
              dataType: 'html',
              error:function(a,b,c) {
                $('#loading_image').hide();              
                showMsg('error',a); 
              },             
              success: function(data){
                $('#loading_image').hide();
                edit_post_id = 0;
                $(".edit_u_account_details").find("td").html('&nbsp;');
                $(".edit_u_account_details").hide();
                element.parents("tr").next().find("td").html(data);
                element.parents("tr").next().show();
              }
          }); 
        }        
    });

	$('.change_status').on('change',function(){
    $("#loading_image").show();
    $('.success_box').hide(); 
    var status = $(this).val();
    var userId = $(this).attr('emp-id');
    $.ajax({
    	type: "POST",
          url: adminUrl+'users/change_status/',
          data: {'data[User]':{'status':status,'id':userId}},
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
              $('.success_msg').html(data.msg); 

              var url = adminUrl+'users/users_data/';
              loadPiece(url,'#empdata');
     		 }
        }
      });
  }); 
  
  $('.delete_data').on('click',function(){
    id = $(this).attr('id');
    bootbox.confirm({
      message: " Are you sure, you want to delete this customer?",
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
                url: adminUrl+'users/delete_user',
                 data: {'data[User]':{'id':id}},
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
                        var url = adminUrl+'users/users_data/';
                        loadPiece(url,'#empdata'); 
                    }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                        var url = adminUrl+'users/users_data/';
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