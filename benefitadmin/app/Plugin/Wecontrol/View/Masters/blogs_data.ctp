<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">                        
      <div class="body">
        <div class="table-responsive">
          <table cellspacing="0" cellpadding="0" class="table table-bordered  table-hover js-basic-example dataTable no-margin-b">
            <thead>
              <tr>
                <th width="5%" style="text-align:center;">#</th>
                <th  class="sortLink" width="20%"><?php echo $this->Paginator->sort('Blog.title','Title'); ?></th>
                <th style="text-align:center;" class="sortLink"  width="35%"><?php echo $this->Paginator->sort('Blog.summary','Summary'); ?></th>
                <th width="10%" style="text-align:center;" class="sortLink">Status</th>
                <th width="10%" class="sortLink"><?php echo $this->Paginator->sort('Blog.created','Created'); ?></th>
                <th style="text-align:center;" width="10%">Action</th>
              </tr>
            </thead>
          </table>
          <div class="body order-list-body no-padding">
            <div class="clearfix m-b-20">
              <div class="dd nestable-with-handle">
                <ol class="dd-list">
                  <?php     
                    if(isset($BlogData) && !empty($BlogData)){   
                    $i = 1;       
                    foreach ($BlogData as $key => $value) {   ?> 
                  <li class="dd-item dd3-item" data-id="<?php echo $value['Blog']['id']; ?>">
                    <div class="dd-handle dd3-handle">&nbsp;</div>
                    <div class="dd3-content">
                      <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%" class="table" style="margin-bottom:0;">
                        <tbody>
                          <tr>
                            <td align="center" width="5%">&nbsp;</td>
                            <td width="20%"><?php  echo $value['Blog']['title']; ?> </td>
                            <td width="35%"><?php echo nl2br($value['Blog']['summary']); ?> </td>   
                            <td class="text-center" width="10%">
                              <?php if($value['Blog']['status'] == "active"){ ?>
                                <a class="material-icons change_status" href="javascript:void(0)" style="color: #4CAE50; border-radius: 100%; font-size: 20px;" title="Active,Click to Inactive" id="<?php echo base64_encode($value['Blog']['id']);?>" status="inactive">fiber_manual_record</a>
                              <?php } else{ ?>
                                <a class="material-icons change_status" href="javascript:void(0)" style="color: #F44336; border-radius: 100%; font-size: 20px;" title="Inactive,Click to Active" id="<?php echo base64_encode($value['Blog']['id']);?>" status="active">fiber_manual_record</a>
                              <?php } ?>
                            </td>
                            <td width="10%"><?php  echo date(dateTimeFormat,strtotime($value['Blog']['created'])); ?> </td>
                            <td align="center" width="10%">         
                              <?php 
                              echo $this->Html->link('<i class="material-icons">remove_red_eye</i>',array('controller'=>'masters','action'=>'view_blog',base64_encode($value['Blog']['id'])),array('class' => 'btn bg-grey waves-effect btn-xs','escape'=>false,'title'=>'View')) ;
                              echo '&nbsp;&nbsp;';
                              echo $this->Html->link('<i class="material-icons">mode_edit</i>',array('controller'=>'masters','action'=>'edit_blog',base64_encode($value['Blog']['id'])),array('class' => 'btn bg-cyan waves-effect btn-xs','escape'=>false,'title'=>'Edit')); echo "&nbsp;&nbsp;";                              
                              echo $this->Html->link('<i class="material-icons">delete</i>','javascript:void(0);',array('class' => 'btn bg-red waves-effect btn-xs delete_data','escape'=>false,'id'=>$value['Blog']['id'],'title'=>'Delete')) ; 
                              ?>
                            </td>
                          </tr> 
                        </tbody>
                      </table>
                    </div>
                  </li>                   
                  <?php } }else { ?>
                    <li align="center" colspan="30">
                      No data found.
                    </li>
                  <?php } ?> 
                </ol>
              </div>
            </div>
          </div>
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

    $('.change_status').on('click',function(){
    
    $("#loading_image").show();
    var status = $(this).attr('status');
    var CategoryId = $(this).attr('id');
    var modelname = 'Blogs';
    $.ajax({
      type: "POST",
      url: adminUrl+'masters/change_status/',
      data: {'data[changestatus]':{'status':status,'id':CategoryId,'modelName':modelname}},
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
            $('.success_box').slideDown(500,function() {
            $('.success_msg').html(data.message);
            });
            $("#search_button").trigger("click");
        }
      }
    });
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
                url: adminUrl+'masters/delete_blog/'+id,
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
                        var url = adminUrl+'masters/blogs_data/';
                        loadPiece(url,'#empdata');
                    }else{
                        $('.error_box').show(); 
                        $('.error_msg').html(data.msg);
                        var url = adminUrl+'masters/blogs_data/';
                        loadPiece(url,'#empdata');
                    }
                }
            });
        }
      },className: "bootbox-m"
    });
    });
  
    $(document).on("click", ".jq_edit_Blog", function(e) {
        var id = $(this).attr('id');
        e.preventDefault();
        Url = adminUrl +'masters/edit_blog/'+id;
        addNew(Url);
    });
});

$(function () {
    $('.dd').nestable({
        maxDepth:1,  
    });     
    $('.dd').on('change', function () { 
        var url = adminUrl+'masters/change_order/'; 
        var $this = $(this);
        var serializedData = window.JSON.stringify($($this).nestable('serialize'));
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {'data[Blog]':{'serializedData':serializedData}},
            error: function(a,b,c) {
                return '';
            },
            success: function(response) {
                if(response != ''){
                var url = response;
                //window.location=url;  
                }
            }
        });
    });
});
</script>


