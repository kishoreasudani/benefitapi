<section class="content content-custom">
    <div class="container-fluid">
        <div class="block-header relative rows">
            <h2 class="text-uppercase">
				Push Notifications

				<div class="pull-right">
				<?php   
				echo $this->Html->link('Send Notification',array('controller'=>'notifications','action'=>'send_notifications'),array('class' => 'btn bg-orange waves-effect pull-right margin-left15','escape'=>false)) ; 
	            ?>
				<?php   
				echo $this->Html->link('Add Notification',array('controller'=>'notifications','action'=>'add_notification'),array('class' => 'btn bg-orange waves-effect pull-right ','escape'=>false)) ; 
	            ?> 
	             <button type="button" class="btn btn-danger margin-right15 pull-right deleteMultiple" id="deleteMultiple">Delete Multiple</button> 

	    		<div style="color: red;display: none; text-align: left; text-transform: none;
			    padding-top: 6px;clear: both;font-size: 13px;" id="displaySelectedError">Please select at least one data for delete </div>   
			</div>

            </h2>  
        </div>   
        <?php echo $this->element('flash_message'); ?>  	
	   	<div class="row">
	   		<div class="col-sm-12">
	   			<div class="card no-margin-b">
		   			<div class="header">
	                    <div class="row clearfix">
	                     	<?php echo $this->Form->create('Search', array('url'=>'javascript:void(0)','id' => 'serachForm'));  ?>
                                <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('title',array('class' => 'form-control', 'placeholder' => 'Message')); ?>                                            
                                        </div>
                                    </div>
                                </div>

								<div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.sender',array('class' => 'form-control', 'placeholder' => 'Sender Name','id'=>'budget')); ?>                                            
                                        </div>
                                    </div>
                                </div>
								
                                <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.receiver',array('class' => 'form-control', 'placeholder' => 'Receiver Name','id'=>'budget')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                                             
                                <div class="col-sm-3 m-t-10">
                                    <button type="button" class="btn bg-green waves-effect" id="search_button">Search</button>
                                    <button type="button" class="btn btn-primary waves-effect reset_data">Reset</button>                                    
                                </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
	                </div>
	            </div>
	   		</div>
	   	</div>

	   	
		<div class="row">
			<div class="col-sm-12">				 	
				<div class="table-light" id="empdata">
		  		</div>
		  		<div class="page-loader-wrapper position-abs" id="loading_image">
			        <div class="loader">
			            <div class="preloader">
			                <div class="spinner-layer pl-teal">
			                    <div class="circle-clipper left">
			                        <div class="circle"></div>
			                    </div>
			                    <div class="circle-clipper right">
			                        <div class="circle"></div>
			                    </div>
			                </div>
			            </div>
			            <p>Please wait...</p>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</section>

<script> 
$(document).ready(function(){

	var url = adminUrl+'notifications/notification_data';
	loadPiece(url,'#empdata');	

    $("#search_button").click(function() {
	    var search_string = $("#search_string").val();
	       $('#loading_image').show();
	    var search_value = $('#serachForm').serialize();
	  	
	    var url = "<?php echo $this->Html->url(array('controller'=>'notifications','action'=>'notification_data'));?>"+'?q='+search_value;
     	loadPiece(url,"#empdata");    
    });

	$(".reset_data").click(function(){
		$( '#serachForm' ).each(function(){
			this.reset();
		});
		var url = switchViewUrl();
		loadPiece(url+'/reset',"#empdata");      
    });

	$('#viewSwitch').click(function(){
		var switchTo = $(this).attr('switchTo');
		if(switchTo == 'grid'){
			$(this).attr('switchTo','list').parent().find('i').removeClass('fa fa-th').addClass('fa fa-bars');	
			var url = adminUrl+'notifications/notification_data';
		}else{
			$(this).attr('switchTo','grid').parent().find('i').removeClass('fa fa-bars').addClass('fa fa-th');

			var url = adminUrl+'notifications/notification_data';	
		}
		loadPiece(url,'#empdata',changeStatus);		
	});

	function switchViewUrl(){
	
		return url = adminUrl+'notifications/notification_data';	
		
	}



	  /* multiple delete */

      $('body').on('click', '#selectall', function(e) {
           $("input:checkbox[class=select_delete_data]").prop('checked',this.checked);
       });

     // if all checkbox are selected, check the selectall checkbox

     $('body').on('click', '.select_delete_data', function(e) {

        if($(".select_delete_data").length == $(".select_delete_data:checked").length) {
          
              $("#selectall").prop('checked',this.checked);
          } else {
            $("#selectall").prop('checked', false);
          }
      });


     $(".deleteMultiple").click(function(){
	     	$("#displaySelectedError").hide();  
			var selectedData = [];
			$. each($("input:checkbox[class=select_delete_data]:checked"), function(){
			   selectedData. push($(this). val());
			});

			if(selectedData!='' && selectedData.length>0 ){
				  bootbox.confirm({
				      message: " Are you sure, you want to delete these data?",
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
				                async: true,
				                url: adminUrl+'notifications/delete_multiple_notification',
				                dataType: 'json',
				                data: {deleteData:selectedData},
				                error:function(a,b,c) {
				                    $("#loading_image").hide();
				                },
				                success: function (data) {
				                    $('.alert-success').hide();
				                    $('.alert-danger').hide();
				                    if(data.success == true) {
				                         $(".success_box").show();
				                         $(".success_msg").html(data.msg);
				                        var url = adminUrl+'notifications';
				                         location.href=url;
				                         // loadPiece(url,'#empdata'); 

				                    }else{
				                        $('.error_box').show(); 
				                        $('.error_msg').html(data.msg);
				                        var url = adminUrl+'notifications';
				                        //loadPiece(url,'#empdata'); 

				                         location.href=url;
				                    }
				                }
				            });
				        }
				      },className: "bootbox-m"
				    });
			}else{
	            $("#displaySelectedError").show();  
			}	   
     });

});
</script>

