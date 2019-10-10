 <div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                      <th width="5%" style="text-align:center;">#</th>
                      <th  class="sortLink" width="23%"><?php echo $this->Paginator->sort('NotifyTemplate.title','Title'); ?></th> 
                       <th  class="sortLink" width="20%"><?php echo $this->Paginator->sort('NotifyTemplate.subject','Subject'); ?></th> 
                      <th class="sortLink" width="19%" style="text-align:center;"><?php echo $this->Paginator->sort('NotifyTemplate.status','Status'); ?></th>
                      <th class="sortLink" width="19%" style="text-align:center;"><?php echo $this->Paginator->sort('NotifyTemplate.modified','Modified'); ?></th>                     
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
                      <td><?php echo $value['NotifyTemplate']['title'] ?> </td>
                      <td><?php echo ucwords($value['NotifyTemplate']['subject']); ?> </td> 
                      <td><?php echo $this->Form->select('NotifyTemplate.status',Configure::read('General.status'),array('default' => $value['NotifyTemplate']['status'],'class'=>'form-control show-tick change_status','label'=>false,'empty' => false,'id' => base64_encode( $value['NotifyTemplate']['id'] )));?></td> 
                      <td align="center"><?php   echo date(dateTimeFormat,strtotime($value['NotifyTemplate']['modified'])); ?> </td>
                      <td align="center">         
                        <?php 
                        echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'masters','action'=>'edit_template',base64_encode($value['NotifyTemplate']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs','escape'=>false,'title'=>'Edit')); echo "&nbsp;&nbsp;";
                        echo $this->Html->link('<i class="material-icons">remove_red_eye</i>',array('controller'=>'masters','action'=>'view_template',base64_encode($value['NotifyTemplate']['id'])),array('class' => 'btn bg-grey waves-effect btn-xs','escape'=>false,'title'=>'View Template')) ; 
                        // echo "&nbsp;&nbsp;";
                        // echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['NotifyTemplate']['id'],'title'=>'Delete')) ; 
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

  $('.edit_account').click(function (event){  
    var element = $(this);        
    Category_id = element.attr('Category_id');        
    if($(this).parents('tr').next('tr').css('display') != 'none') {
      $(this).parents('tr').next('tr').slideUp(100);
    } else {      
      $.ajax({
        type: "POST",
        async: true,
        url: adminUrl+'accounts/edit/'+Category_id,
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
    var status = $(this).val();
    var NotifyTemplateId = $(this).attr('id');      
    var modelname = 'NotifyTemplate';
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
            data: {'data[changestatus]':{'status':status,'id':NotifyTemplateId,'modelName':modelname}},
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
                setTimeout(function(){ window.location.href = adminUrl+'masters/email_templates'; }, 500); 
              }
            }
          });
        } else{
          setTimeout(function(){ window.location.href = adminUrl+'masters/email_templates'; }, 100); 
        }
      },className: "bootbox-m"
    });
  });

});
</script>


