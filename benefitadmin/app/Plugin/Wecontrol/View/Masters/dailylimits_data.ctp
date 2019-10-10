<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
          <table cellspacing="0" cellpadding="0" class="table table-bordered  table-hover js-basic-example dataTable no-margin-b">
            <thead>
              <tr>
                <th width="5%" style="text-align:center;">#</th>
                <th class="sortLink" width="20%"><?php echo $this->Paginator->sort('DailyLimit.limit','Limit'); ?></th>
                <th class="sortLink"  width="25%"><?php echo $this->Paginator->sort('DailyLimit.effective_date','Effective Date'); ?></th>
                <th class="sortLink"  width="25%"><?php echo $this->Paginator->sort('DailyLimit.end_date','End Date'); ?></th>
                <th width="15%" class="sortLink"><?php echo $this->Paginator->sort('DailyLimit.created','Created'); ?></th>
                <th style="text-align:center;" width="10%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php     
                if(isset($DailyLimitData) && !empty($DailyLimitData)){   
                  $i = 1;       
                  foreach ($DailyLimitData as $key => $value) {   ?>        
                    <tr>
                      <td align="center" width="5%"><?php echo $i; $i++;?></td>
                      <td width="20%"><?php  echo $value['DailyLimit']['limit']; ?> </td>   
                      <td width="10%"><?php  echo date(dateFormat,strtotime($value['DailyLimit']['effective_date'])); ?> </td>
                      <td width="10%">
                      <?php if(isset($value['DailyLimit']['end_date']) && !empty($value['DailyLimit']['end_date'])){
                        echo date(dateFormat,strtotime($value['DailyLimit']['end_date']));
                        } else{ echo '--';}?>
                      </td>
                      <td width="10%"><?php  echo date(dateTimeFormat,strtotime($value['DailyLimit']['created'])); ?> </td>
                      <td align="center" width="10%">         
                       <?php       
                        echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['DailyLimit']['id'],'title'=>'Delete')) ; 
                        ?>
                      </td>
                    </tr>
                    <tr class="edit_u_account_details" style="display:none;">
                      <td colspan="6"></td>
                    </tr>
                  <?php } 
                }else { ?>
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
      message: " Are you sure, you want to delete this record?",
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
                url: adminUrl+'masters/delete_limit/'+id,
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
                        var url = adminUrl+'masters/dailylimits_data/';
                        loadPiece(url,'#empdata');
                    }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                        var url = adminUrl+'masters/dailylimits_data/';
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


