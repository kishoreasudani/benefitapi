 
<section class="content">
    <div class="container-fluid">
        <div class="block-header relative">
            <h2 class="text-uppercase1">
               FAQ's 
            </h2>
             <?php echo $this->Html->link('Add FAQ','javascript:void(0);',array('class' => 'btn bg-orange waves-effect pull-right btn-right-position jq_add_faq','escape'=>false)) ; ?>            
        </div>
        <?php echo $this->element('flash_message'); ?>
		         
	   	<div class="row">
	   		<div class="col-sm-12">
	   			<div class="card no-margin-b">
		   			<div class="header">
	                    <div class="row clearfix">
	                     	<?php echo $this->Form->create('Search', array('url'=>'javascript:void(0)','id' => 'serachForm'));  ?>
                                <div class="col-sm-4">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.question',array('class' => 'form-control', 'placeholder' => 'Question...','id'=>'search')); ?>                          
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">
                                        <?php echo $this->Form->text('Search.answer',array('class' => 'form-control', 'placeholder' => 'Answer...','id'=>'search')); ?>                          
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group no-margin-b	">
                                        <div class="form-line">                                        
                                        <?php echo $this->Form->select('Search.status',Configure::read('General.status'),array('empty'=>'Select Status',  'class'=>'form-control'));  ?>                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">                        			
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
<div class="modal fade" id="modal-form">
	<div class="modal-dialog">
	  <div class="modal-content">
	  	<div class="page-loader-wrapper position-abs" id="loading_image2">
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
	    <div class="modal-body">
	      
	    </div>
	  </div>
	</div>
</div> 

<script> 
$(document).ready(function(){

	var url = adminUrl+'pages/load_faq';
	loadPiece(url,'#empdata');	
	
    $("#search_button").click(function() {

	    $('#loading_image').show();
	    var search_value = $('#serachForm').serialize();
	    var url = "<?php echo $this->Html->url(array('controller'=>'pages','action'=>'load_faq'));?>"+'?q='+search_value;
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
			var url = adminUrl+'pages/load_faq';
		}else{
			$(this).attr('switchTo','grid').parent().find('i').removeClass('fa fa-bars').addClass('fa fa-th');

			var url = adminUrl+'pages/load_faq';	
		}
		loadPiece(url,'#empdata');		
	});

	function switchViewUrl(){
	
		return url = adminUrl+'pages/load_faq';	
		
	}
	$(document).on("click", ".jq_add_faq", function(e) {
        e.preventDefault();
        Url = adminUrl +'pages/add_faq/';
        addNew(Url);
    });

});
</script>

