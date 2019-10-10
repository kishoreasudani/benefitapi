<!-- It will append the data on static_page -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover js-basic-example dataTable">
                <thead>
                    <tr>
                      <th width="5%" style="text-align:center;">#</th>
                      <th class="sortLink" width="25%"><?php echo $this->Paginator->sort('Page.title','Title'); ?></th> 
                      <th width="20%" class="sortLink" style="text-align:center;"><?php echo $this->Paginator->sort('Page.status','Status'); ?></th>
                       <th width="20%" class="sortLink" style="text-align:center;"><?php echo $this->Paginator->sort('Page.modified','Modified'); ?></th>
                      <th style="text-align:center;"  width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php     
                    if(isset($PageData) && !empty($PageData)){      
                      $i = 1;    
                      foreach ($PageData as $key => $value) {   
                    ?>
                    <tr>
                      <td align="center"><?php echo $i++; ?> </td>
                      <td><?php  echo $value['Page']['title']; ?> </td> 
                      <td><?php $test = array();
                          if($value['Page']['id'] != 1){
                            echo $this->Form->select('Page.status',Configure::read('General.status'),array('default' => $value['Page']['status'],'class'=>'form-control show-tick change_status','label'=>false,'empty' => false,'id' => base64_encode( $value['Page']['id'] )));
                          } else {
                              echo ucfirst($value['Page']['status']);
                          }
                          ?> 
                      </td>
                      <td style="text-align:center;"><?php  echo date(dateTimeFormat,strtotime($value['Page']['modified'])); ?> </td>
                      <td align="center">         
                        <?php 
                          echo $this->Html->link('<i class="material-icons">remove_red_eye</i>',array('controller'=>'pages','action'=>'view_page',base64_encode($value['Page']['id'])),array('class' => 'btn bg-grey waves-effect btn-xs','escape'=>false,'title'=>'View Page')) ; 
                          echo '&nbsp;&nbsp;';
                          echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'pages','action'=>'edit_page',base64_encode($value['Page']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs jq_edit_page','escape'=>false,'title'=>'Edit Page','id'=>$value['Page']['id'])) ;
                        ?>
                      </td>
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

 $('.change_status').on('change',function(){
    var status = $(this).val();
    var pageId = $(this).attr('id');      

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
            $.ajax({
              type: "POST",
                  url: adminUrl+'pages/change_status/',
                  data: {'data[Page]':{'status':status,'id':pageId,'model':'Page'}},
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
                      }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                        setTimeout(function(){ window.location.href = adminUrl+'masters/categories'; }, 500); 
                      }
                }
              });
        } else{
          setTimeout(function(){ window.location.href = adminUrl+'pages/static_page'; }, 100); 
        }
      },className: "bootbox-m"
    });
  });

  
})
</script>