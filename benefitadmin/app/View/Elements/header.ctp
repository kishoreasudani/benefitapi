<header class="rows header-wrap">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-4">
					<div class="main-logo">
						<?php echo $this->Html->image('front/main-logo.png');?>
						 
					</div>
				</div>

				<?php if($this->Session->check('Auth.FrontEndUserMindStock')){  ?>
					<div class="col-lg-6 col-md-4 col-1">
						<div class="jq_overlay"></div>
						<div class="main-menu">
							<ul>
								<li>
									<a href="news.html">News</a>
								</li>
								<li class="active">
									<a href="my-articles.html">My Articles</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-5 col-7 text-right">
						<div class="custom-dropdown-menu">
							<a href="#">
								<div class="display-flex align-center after-lu-dtl">
									<div class="user-info">
										<div class="user-name">Himanshu</div>
										<div class="user-mail">Himanshu1185@gmail.com</div>
									</div>
									<div class="profile-pic"><?php echo $this->Html->image('front/analyst1.png');?></div>
								</div>
							</a>
							<ul class="custom-dropdown-submenu">
								<li>
									<a href="#"><i class="fas fa-user"></i> Profile</a>
								</li>
								<li>
									<?php echo $this->Html->link($this->Html->image('front/logout.svg').'Logout',array('controller'=>'users','action'=>'logout'),array('class'=>'','escape'=>false)); ?>
								</li>
							</ul>
						</div>
						<div class="mobile-inner-header">
	                        <div class="mobile-inner-header-icon mobile-inner-header-icon-out">
	                            <span></span>
	                            <span></span>
	                            <span></span>
	                        </div>
	                    </div>
					</div>
				<?php  } else {  ?>
					<div class="col-lg-6 col-md-4 col-1">
						<div class="jq_overlay"></div>
						<div class="main-menu">
							<ul>
								<li>
									<a href="javascript:void(0)">Home</a>
								</li>
								<li>
									<a href="javascript:void(0)">About Us <i class="fas fa-chevron-down"></i></a>
									<ul class="sub-menu">
										<li><a href="javascript:void(0)">About 1</a></li>
										<li><a href="javascript:void(0)">About 2</a></li>
										<li><a href="javascript:void(0)">About 3</a></li>
									</ul>
								</li>
								<li>
									<a href="javascript:void(0)">Careers <i class="fas fa-chevron-down"></i></a>
								</li>
								<li>
									<a href="javascript:void(0)">Blog</a>
								</li>
								<li>
									<a href="javascript:void(0)">Contact Us</a>
								</li>
							</ul>
						</div>
					</div>
				<div class="col-lg-3 col-md-5 col-7 text-right">
					<a href="javascript:void(0);"  data-toggle="modal" data-target="#loginModal" class="small-btn login-btn jq_login">Login</a>
					<a href="javascript:void(0);"  data-toggle="modal" data-target="#registerModal" class="small-btn register-btn jq_register" type = "client">Register</a>
					<div class="mobile-inner-header">
                        <div class="mobile-inner-header-icon mobile-inner-header-icon-out">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
				</div>
				<?php } ?>
				
			</div>
		</div>
	</header>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", ".jq_login", function(e) { 
          var check_redirect_val = $('#check_redirect_val').val();
          e.preventDefault();
          Url = siteUrl +'users/login/'+'?next='+check_redirect_val;
          addNew(Url);
        });  

        $(document).on("click", ".jq_register", function(e) {          
          e.preventDefault();
          var user_type = $('.jq_register').attr('type');
          Url = siteUrl +'users/register/'+user_type;
          addNewRegister(Url);
        });       
    });    
</script>