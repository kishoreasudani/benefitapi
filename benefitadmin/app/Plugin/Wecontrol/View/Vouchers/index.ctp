<section class="content content-custom">
	 <?php echo $this->element('flash_message'); ?>  
    <div class="container-fluid">
        <div class="block-header relative rows">
            <h2 class="text-uppercase">
				Vouchers 
				<div class="pull-right">
					<?php 
		           if($vendor_id!='' && $vendor_id>0){
					  echo $this->Html->link('Add Bulk Voucher','javascript:void(0)',array('class' => 'btn bg-orange waves-effect margin-left15 pull-right','escape'=>false,'id'=>'add_bulk_voucher')) ;  
				   }

					echo $this->Html->link('Add Voucher',array('controller'=>'vouchers','action'=>'add_voucher/'.base64_encode($vendor_id)),array('class' => 'btn bg-orange waves-effect  pull-right','escape'=>false)) ; 
		            ?>  

		            <button type="button" class="btn btn-danger margin-right15 pull-right deleteMultiple" id="deleteMultiple">Delete Multiple</button>  
            		<div style="color: red;display: none; text-align: left; text-transform: none;
				    padding-top: 6px;clear: both;font-size: 13px;" id="displaySelectedError">Please select at least one data for delete </div>   
				    
		        </div>
                    
            </h2> 



        </div>   
       	
	   	<div class="row">

	   		 <div class="col-sm-12" id="addBulkVoucherformdata" style="display: none;">
                <div class="row clearfix">
			        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			            <div class="card">
			                <div class="header">
			                    <h2>
			                        Add Bulk Vouchers
			                    </h2>
			                </div>
			                <div class="body">
			                    <?php echo $this->Form->create('Voucher',array('url' => 'javascript:void(0)' , 'novalidate' => true,'id' => 'BulkVoucherAddForm', 'enctype' => "multipart/form-data")) ;?>                        
			                    <div class="row">
			                        <div class="col-md-6">
			                        	<div class="form-group"> 
			                              <div class="rows fileUpload btn btn-primary">
                                            <span class="rows upload_button pull-left">Upload Csv file</span>
                                            <?php echo $this->Form->file('Voucher.csvFile', array('class'=>'upload jq_file_upload')); ?>
                                          </div>
                                          <span id="csvError" style="color: red"> </span>
                                        </div>
                                      <?php  

                                         $filepath = Configure::read('SiteSettings.Absolute.VoucherImage').'benefit-Add-bulk-vouchers.csv'; 

                                      echo $this->Html->link('Download Sample file',$filepath,array('class' => 'btn bg-orange waves-effect margin-left15 m-t-15','escape'=>false,'id'=>'add_bulk_voucher')) ;?>
			                        </div>
			                        <div class="col-md-6">
			                              <button type="submit" class="btn btn-primary waves-effect align-center jq_add_bulk_voucher">Submit</button>
			                            
			                        </div>
			                    </div>
			               <?php echo $this->Form->end(); ?>
			           </div>
			           </div>
                    </div>
                 </div>
	   		 </div>
	   		<div class="col-sm-12">
	   			<div class="card no-margin-b">
		   			<div class="header">
	                    <div class="row clearfix">
	                     	<?php echo $this->Form->create('Search', array('url'=>'javascript:void(0)','id' => 'serachForm'));  ?>
                                <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.name',array('class' => 'form-control', 'placeholder' => 'Name')); ?>                                            
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-sm-3">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.code',array('class' => 'form-control', 'placeholder' => 'Code','id'=>'budget')); ?>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">                                        
                                        <?php echo $this->Form->select('Search.status',Configure::read('General.status'),array('empty'=>'Select Status',  'class'=>'form-control SearchValStatus'));  ?>                                           
                                        </div>
                                    </div>
                                </div>


                                 <div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">  

                                        	<?php echo $this->Form->select('Search.vendor',$vendorsList,array('empty'=>'Select Vendor',  'class'=>'form-control SearchValVendor','value'=>$vendor_id));  ?>                                           
                                        </div>
                                     </div>
                                  </div>


                                <div class="col-sm-2 m-t-10">
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

	var url = adminUrl+'vouchers/vouchers_data/'+'<?php echo $vendor_id; ?>';
	loadPiece(url,'#empdata');	

    $("#search_button").click(function() {
	    var search_string = $("#search_string").val();
		$('#loading_image').show();
	    var search_value = $('#serachForm').serialize();
	    var url = "<?php echo $this->Html->url(array('controller'=>'vouchers','action'=>'vouchers_data'));?>"+'?q='+search_value;
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
			var url = adminUrl+'vouchers/vouchers_data';
		}else{
			$(this).attr('switchTo','grid').parent().find('i').removeClass('fa fa-bars').addClass('fa fa-th');

			var url = adminUrl+'vouchers/vouchers_data';	
		}
		loadPiece(url,'#empdata',changeStatus);		
	});

	function switchViewUrl(){
		return url = adminUrl+'vouchers/vouchers_data';	
		
	}

	$("#add_bulk_voucher").click(function () {
        $("#addBulkVoucherformdata").toggle()
    });


   var vendor_id = "<?php echo base64_encode($vendor_id); ?>";
	$(".jq_add_bulk_voucher").click( function() {
        $("#loading_image").show();
        $('#csvError').html('');
        var ajaxOptions = {
        url         : adminUrl+'vouchers/add_bulk_voucher/'+vendor_id,
        resetForm   : false,
        dataType    : 'json',
        success     : ajaxSuccess
        };
        $( '#BulkVoucherAddForm' ).ajaxForm( ajaxOptions );
        $( '#BulkVoucherAddForm' ).on('submit',function() {
        $("#loading_image").show();
        });
        function ajaxSuccess( data , responseCode , xhr ) {  

            if(data.success == false){
               var errors  = data.message;
               $('#csvError').html(errors);
               $("#loading_image").hide();
            }else if(data.success == true){
               $(".success_box").show();
               $(".success_msg").html(data.message);
               $("#addBulkVoucherformdata").toggle()
               $("#BulkVoucherAddForm").trigger("reset");
             	var url = adminUrl+'vouchers/vendors_data';
	            loadPiece(url,'#empdata');
            
                setTimeout(function(){ window.location.href = adminUrl+'vouchers/index/'+vendor_id; }, 300);      
            } 
        }
    });



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
				                url: adminUrl+'vouchers/delete_multiple_vouchers',
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
				                        var url = adminUrl+'vouchers/index/'+vendor_id;
				                         location.href=url;
				                         // loadPiece(url,'#empdata'); 

				                    }else{
				                        $('.error_box').show(); 
				                        $('.error_msg').html(data.msg);
				                        var url = adminUrl+'vouchers/index/'+vendor_id;
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

