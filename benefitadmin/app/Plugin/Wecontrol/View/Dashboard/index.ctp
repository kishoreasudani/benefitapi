<?php
    // echo $this->Html->css(array('wecontrol/morris.css'));
    // echo $this->Html->script("wecontrol/morris.js");
    // echo $this->Html->script("wecontrol/morrisjs/morris.js");
    echo $this->Html->css(array('wecontrol/morris.css'));
    echo $this->Html->script("wecontrol/jquery.flot.js");
    echo $this->Html->script("wecontrol/jquery.flot.resize.js");
    echo $this->Html->script("wecontrol/jquery.flot.pie.js");
    echo $this->Html->script("wecontrol/jquery.flot.categories.js");
    echo $this->Html->script("wecontrol/jquery.flot.time.js");
    
?>
<section class="content content-custom">
    <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <div class="row">
                        <div class="col-xs-8">
                            <h2>Active Users</h2>
                        </div>
                        <div class="col-xs-4">
                            <?php echo $this->Form->select('City',$city,array('empty'=>'Select City', 'class'=>'form-control activeusers-select show-tick jq_select_box'));?>
                        </div>
                    </div>
                </div>
                <div class="body">
                    <div id="pie_chart1" class="flot-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Voucher Redeemptions</h2>
                </div>
                <div class="body">
                    <div id="pie_chart2" class="flot-chart"></div>
                </div>
            </div>
        </div>
    </div> 
    <div class="block-header relative">
        <h2 class="text-uppercase">
			Registered Users
        </h2>          
    </div> 
    <div class="row clearfix dashboard-list">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person</i>
                </div>
                <div class="content">
                    <div class="text">TODAY'S</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo $users['today_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">THIS WEEK'S</div>
                    <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $users['this_week_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">group</i>
                </div>
                <div class="content">
                    <div class="text">THIS MONTH"S</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?php echo $users['this_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people_outline</i>
                </div>
                <div class="content">
                    <div class="text">LAST SIX MONTH'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $users['6_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-grey hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">group_add</i>
                </div>
                <div class="content">
                    <div class="text">THIS YEAR'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $users['this_year_users'];?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-header relative">
        <h2 class="text-uppercase">
			Vouchers Redeemed
        </h2>          
    </div> 
    <div class="row clearfix dashboard-list">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">radio_button_unchecked</i>
                </div>
                <div class="content">
                    <div class="text">TODAY'S</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo $vouchers['today_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">radio_button_checked</i>
                </div>
                <div class="content">
                    <div class="text">THIS WEEK'S</div>
                    <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $vouchers['this_week_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">star_border</i>
                </div>
                <div class="content">
                    <div class="text">THIS MONTH"S</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?php echo $vouchers['this_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">star_half</i>
                </div>
                <div class="content">
                    <div class="text">LAST SIX MONTH'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $vouchers['6_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-grey hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">star</i>
                </div>
                <div class="content">
                    <div class="text">THIS YEAR'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $vouchers['this_year_users'];?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-header relative">
        <h2 class="text-uppercase">
			Average Steps
        </h2>          
    </div> 
    <div class="row clearfix dashboard-list">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">arrow_right</i>
                </div>
                <div class="content">
                    <div class="text">TODAY'S</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo $steps['today_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">chevron_right</i>
                </div>
                <div class="content">
                    <div class="text">THIS WEEK'S</div>
                    <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $steps['this_week_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">arrow_forward_ios</i>
                </div>
                <div class="content">
                    <div class="text">THIS MONTH"S</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?php echo $steps['this_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">arrow_forward</i>
                </div>
                <div class="content">
                    <div class="text">LAST SIX MONTH'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $steps['6_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-grey hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">last_page</i>
                </div>
                <div class="content">
                    <div class="text">THIS YEAR'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $steps['this_year_users'];?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-header relative">
        <h2 class="text-uppercase">
			Average Points Redeemed
        </h2>          
    </div> 
    <div class="row clearfix dashboard-list">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">border_bottom</i>
                </div>
                <div class="content">
                    <div class="text">TODAY'S</div>
                    <div class="number" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo $coins['today_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">border_top</i>
                </div>
                <div class="content">
                    <div class="text">THIS WEEK'S</div>
                    <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $coins['this_week_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">border_right</i>
                </div>
                <div class="content">
                    <div class="text">THIS MONTH"S</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?php echo $coins['this_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">border_left</i>
                </div>
                <div class="content">
                    <div class="text">LAST SIX MONTH'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $coins['6_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-grey hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">border_outer</i>
                </div>
                <div class="content">
                    <div class="text">THIS YEAR'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $coins['this_year_users'];?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-header relative">
        <h2 class="text-uppercase">
			Active Users
        </h2>          
    </div> 
    <div class="row clearfix dashboard-list">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person</i>
                </div>
                <div class="content">
                    <div class="text">TODAY'S</div>
                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo $active_users['today_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">THIS WEEK'S</div>
                    <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $active_users['this_week_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">group</i>
                </div>
                <div class="content">
                    <div class="text">THIS MONTH"S</div>
                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?php echo $active_users['this_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people_outline</i>
                </div>
                <div class="content">
                    <div class="text">LAST SIX MONTH'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $active_users['6_month_users'];?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-grey hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">group_add</i>
                </div>
                <div class="content">
                    <div class="text">THIS YEAR'S</div>
                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"><?php echo $active_users['this_year_users'];?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>RECENT USERS</h2>
                </div>
               <!--  <a href="#modal-form" class="pull-right btn btn-primary jq_add_new"> <i class="fa fa-cloud-upload text"></i> <span class="text">Upload File</span> </a> -->
                
                <div class="body">
                    <div class="row">
                    <div class="dashboard-task-block">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="30%">NAME</th>
                                    <th width="30%">EMAIL</th>
                                    <th width="30%">CREATED</th> 
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                $i = 1;
                                if(isset($usersListing) && !empty($usersListing)){ 
                                    foreach ($usersListing as $k1 => $v1) {  ?>
                                        
                                <tr>
                                    <td  class="text-left"><?php echo $i++; ?></td>
                                    <td  class="text-left"><?php echo ucfirst($v1['User']['first_name']); ?></td>
                                    <td  class="text-left"><?php echo $v1['User']['email']; ?></td>
                                    <td  class="text-left"><?php echo date(dateTimeFormat,strtotime($v1['User']['created'])); ?></td>
                                </tr>

                                <?php } } else { ?>
                                <tr><td colspan="4" class="text-left">No  recent user found.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12">
                            <?php 
                            if(count($usersListing) > 1 ){
                                echo $this->Html->link('View All',array('controller'=>'users','action'=>'/'),array('class'=>'btn bg-green waves-effect pull-right'));
                            }
                             ?>
                             
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>RECENT VOUCHERS</h2>
                </div>
               <!--  <a href="#modal-form" class="pull-right btn btn-primary jq_add_new"> <i class="fa fa-cloud-upload text"></i> <span class="text">Upload File</span> </a> -->
                
                <div class="body">
                    <div class="row">
                    <div class="dashboard-task-block">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="30%">NAME</th>
                                    <th width="30%">CODE</th>
                                    <th width="30%">CREATED</th> 
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                $i = 1;
                                if(isset($vouchersListing) && !empty($vouchersListing)){ 
                                    foreach ($vouchersListing as $k1 => $v1) {  ?>
                                        
                                <tr>
                                    <td  class="text-left"><?php echo $i++; ?></td>
                                    <td  class="text-left"><?php echo ucfirst($v1['Voucher']['name']); ?></td>
                                    <td  class="text-left"><?php echo $v1['Voucher']['code']; ?></td>
                                    <td  class="text-left"><?php echo date(dateTimeFormat,strtotime($v1['Voucher']['created'])); ?></td>
                                </tr>

                                <?php } } else { ?>
                                <tr><td colspan="4" class="text-left">No  recent user found.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12">
                            <?php 
                            if(count($vouchersListing) > 1 ){
                                echo $this->Html->link('View All',array('controller'=>'vouchers','action'=>'/'),array('class'=>'btn bg-green waves-effect pull-right'));
                            }
                             ?>
                             
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> 
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>RECENT BLOGS</h2>
                </div>
               <!--  <a href="#modal-form" class="pull-right btn btn-primary jq_add_new"> <i class="fa fa-cloud-upload text"></i> <span class="text">Upload File</span> </a> -->
                
                <div class="body">
                    <div class="row">
                    <div class="dashboard-task-block">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="20%">TITLE</th>
                                    <th width="40%">SUMMARY</th>
                                    <th width="30%">PUBLISH DATE</th> 
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                $i = 1;
                                if(isset($blogsListing) && !empty($blogsListing)){ 
                                    foreach ($blogsListing as $k1 => $v1) {  ?>
                                        
                                <tr>
                                    <td  class="text-left"><?php echo $i++; ?></td>
                                    <td  class="text-left"><?php echo ucfirst($v1['Blog']['title']); ?></td>
                                    <td  class="text-left"><?php echo $v1['Blog']['summary']; ?></td>
                                    <td  class="text-left"><?php echo date(dateTimeFormat,strtotime($v1['Blog']['publish_date'])); ?></td>
                                </tr>

                                <?php } } else { ?>
                                <tr><td colspan="4" class="text-left">No  recent user found.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12">
                            <?php 
                            if(count($blogsListing) > 1 ){
                                echo $this->Html->link('View All',array('controller'=>'masters','action'=>'blogs'),array('class'=>'btn bg-green waves-effect pull-right'));
                            }
                             ?>
                             
                        </div>
                        </div>
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
<script type="text/javascript">
    $(document).ready(function(){ 

        selectVal = $('#City :selected').val(); 
    
        $.ajax({
            type:'POST',
            url:adminUrl+'Dashboard/getChartData/',
            data:null,
            dataType:'json',
            error:function(){
                //hideLoader();
                //alert("Server is unable to process request.");
            },
            success:function(result){
                //hideLoader();         
                if(result.success == true) {
                    pieChartFn(result);
                    console.log(result);
                    $('#jq_bu_score').html(result.activeusers);
                    
                }else{                  
                    $('#pie_chart1').html(result.activeusers);
                }
            }
        });
        
        //PIE CHART ==========================================================================================
        <?php $permitted_chars = '0123456789FDEABC'; ?>
        var pieChartData1 = [];
        <?php for($i=0; $i<5; $i++){?>
            pieChartData1["<?php echo $i;?>"] = {
                label: "<?php echo $userVoucherList[$i]['voucher']; ?>",
                data: "<?php echo $userVoucherList[$i]['count'];?>",
                color: "#<?php echo substr(str_shuffle($permitted_chars), 0, 6); ?>"
            }
        <?php } ?>
        $.plot('#pie_chart2', pieChartData1, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        });
        function labelFormatter(label, series) {
            return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
        }
        //====================================================================================================

        $( ".jq_select_box" ).change(function() {
			$("#loading_image").show();
			var selectVal = $(this).val();
			$.ajax({
				type:'POST',
				url:adminUrl+'dashboard/getChartData/'+selectVal,
				data:{},
				dataType:'json',
				error:function(){
					$('#loading_image').hide();
			        alert("Server is unable to process request.1");
				},
				success:function(result){
					$('#loading_image').hide();
					if(result.success == true) {
						pieChartFn(result);

						//$('#jq_bu_score').text(result.graphData.bu);
					}else{					
						$('#pie_chart1').html(noData);
					}
				}
			});
			
		});

    });
    function pieChartFn(data){  
        
		//PIE CHART ==========================================================================================
        var pieChartData = [], pieChartSeries = 2;
        var pieChartColors = ['#E91E63', '#03A9F4'];
        var pieChartDatas = [data.activeusers, data.totalusers-data.activeusers];
        console.log(pieChartDatas);
        for (var i = 0; i < pieChartSeries; i++) {
            if(i == '0'){
                pieChartData[0] = {
                    label: 'Active Users',
                    data: pieChartDatas[0],
                    color: pieChartColors[0]
                }
            }
            if(i == '1'){
                pieChartData[1] = {
                    label: 'Inactive Users',
                    data: pieChartDatas[1],
                    color: pieChartColors[1]
                }
            }
        }
        $.plot('#pie_chart1', pieChartData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 3 / 4,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        });
        function labelFormatter(label, series) {
            return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
        }
        //====================================================================================================
	}

	
</script>