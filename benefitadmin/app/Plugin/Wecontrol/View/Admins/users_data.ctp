 <div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                      <th width="5%" style="text-align:center;">#</th>
                      <th  class="sortLink" width="20%"><?php echo $this->Paginator->sort('Admin.first_name','Name'); ?></th> 
                      <th class="sortLink" width="17%"><?php echo $this->Paginator->sort('Admin.email','Email'); ?></th> 
                      <th class="sortLink" width="14%"><?php echo $this->Paginator->sort('Admin.status','Status'); ?></th>
                      <th class="sortLink" width="17%"><?php echo $this->Paginator->sort('Admin.created','Created'); ?></th> 
                      <th class="sortLink" width="17%"><?php echo $this->Paginator->sort('Admin.modified','Modified'); ?></th>
                      <th style="text-align:center;" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php     
                    $i =1;
                    if(isset($admin_list) && !empty($admin_list)){          
                      foreach ($admin_list as $key => $value) {   
                    ?>
                    <tr>
                      <td align="center"><?php echo $i; 
                      $i++;?></td>
                      
                      <td><?php echo ucfirst($value['Admin']['first_name'].' '.$value['Admin']['last_name']); ?> </td>
                      <td><?php echo $value['Admin']['email']; ?></td>        
                      
                       <td style="text-align:center;"><?php $test = array();
                       if($value['Admin']['id'] != 1){
                          echo $this->Form->select('Admin.status',Configure::read('General.status'),array('default' => $value['Admin']['status'],'class'=>'form-control show-tick change_status','label'=>false,'empty' => false,'id' => base64_encode( $value['Admin']['id'] )));
                        } else {
                            echo ucfirst($value['Admin']['status']);
                        }
                          ?> 
                      </td> 
                      <td><?php  echo date(dateTimeFormat,strtotime($value['Admin']['created'])); ?> </td>
                      <td><?php  echo date(dateTimeFormat,strtotime($value['Admin']['modified'])); ?> </td>


                      <!-- <td  align="center"><?php echo Inflector::humanize($value['Admin']['admin_role']); ?></td>  -->
                      <td align="center">         
                          <?php
                            echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'admins','action'=>'edit',base64_encode($value['Admin']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs','escape'=>false,'Admin_id'=>$value['Admin']['id'],'title'=>'Edit')) ; 
                            echo '&nbsp;';
                          if($value['Admin']['id'] != 1){
                            echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['Admin']['id'],'title'=>'Delete')) ; 
                          }
                           
                          ?></td>
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
        Admin_id = element.attr('Admin_id');
          
        if($(this).parents('tr').next('tr').css('display') != 'none') {
            $(this).parents('tr').next('tr').slideUp(100);

        } else {
          
          $.ajax({
              type: "POST",
              async: true,
              url: adminUrl+'accounts/edit/'+Admin_id,
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
   // $("#loading_image").show();
    var status = $(this).val();
    var adminId = $(this).attr('id');      

    bootbox.confirm({
      message: " Are you sure, you want to update the status of this record?",
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

            //$("#loading_image").show();
            $.ajax({
              type: "POST",
                  url: adminUrl+'admins/change_status/',
                  data: {'data[Admin]':{'status':status,'id':adminId,'model':'Admin'}},
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
                        $("#search_button").trigger("click"); 
                         $('.success_box').show();
                         $('.success_msg').html(data.msg);                  
                      }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                      //  setTimeout(function(){ window.location.href = adminUrl+'masters/categories'; }, 500); 
                      }
                }
              });
        } else{
          setTimeout(function(){ window.location.href = adminUrl+'admins/index'; }, 100); 
        }
      },className: "bootbox-m"
    });
  });


  $('.delete_data').on('click',function(){
    id = $(this).attr('id');
    bootbox.confirm({
      message: " Are you sure, you want to delete this user?",
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
                url: adminUrl+'admins/delete_admin/'+id,
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
                        var url = adminUrl+'admins/users_data/';
                        loadPiece(url,'#empdata'); 
                    }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.message);
                        var url = adminUrl+'admins/users_data/';
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


