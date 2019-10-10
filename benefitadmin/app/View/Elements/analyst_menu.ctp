<?php $controller = $this->request->controller;
  $action = $this->request->action;
   $home = $all_request = $my_customer = $review =  ''; 

   	if($controller == 'analysts' && in_array($action,array('index'))){
        $home = 'active';
    } else if($controller == 'analysts' && in_array($action,array('all_requests'))){
        $all_request = 'active';
    } else if($controller == 'analysts' && in_array($action,array('my_customers'))){
        $my_customer = 'active';
    } else if($controller == 'analysts' && in_array($action,array('reviews'))){
        $review = 'active';
    }  ?>
<a href="javascript:void(0);" class="analyst-mobile-menu"><i class="fas fa-bars"></i> Menu</a>
	<div class="find-analyst-left sidebar-page-left">
		<ul class="sidebar-menu">
			<li class="<?php echo $home;?>">
				<?php echo $this->Html->link('Home',array('controller'=>'analysts','action'=>'index'),array('class'=>'','escape'=>false)); ?>
			</li>
			<li class="<?php echo $all_request;?>">
				<?php echo $this->Html->link('All Requests',array('controller'=>'analysts','action'=>'all_requests'),array('class'=>'','escape'=>false)); ?>
			</li>
			<li class="<?php echo $my_customer;?>">
				<?php echo $this->Html->link('My Customers',array('controller'=>'analysts','action'=>'my_customers'),array('class'=>'','escape'=>false)); ?>
			</li>
			<li class="<?php echo $review;?>">
				<?php echo $this->Html->link('Reviews',array('controller'=>'analysts','action'=>'reviews'),array('class'=>'','escape'=>false)); ?>
			</li>
		</ul>
	</div>