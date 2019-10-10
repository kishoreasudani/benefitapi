 <?php
    global $thisObj;
    $thisObj = $this;
    function menuClass( $menu_name ){
        global $thisObj;

        if( is_array( $menu_name ) ) {
            return ( in_array($this->request->params['controller'], $menu_name) )?'active':'';
        } else if( is_string( $menu_name ) ){
            return ( $thisObj->request->params['controller'] == $menu_name )?'active':'';
        } else {
            return '';
        }
    }

    function subMenuClass( $menu_name , $submenu_name ){
        global $thisObj;
        if( is_array( $submenu_name ) ) {
         
            return ( $thisObj->request->params['controller'] == $menu_name && in_array( $thisObj->request->params['action'], $submenu_name ) )?'active':'';
        } else if( is_string( $submenu_name ) ) {
           
            return ( $thisObj->request->params['controller'] == $menu_name && $thisObj->request->params['action'] == $submenu_name )?'active':'';
        }
    }
   
    $controller = $this->request->controller;
    $action = $this->request->action;
    $notifications = '';
    if($controller == 'notifications' && in_array($action,array('send_notifications', 'index', 'notification_data', 'add_notification', 'user_notifications', 'user_notifications_data'))){
        $notifications = 'active';
    }
    
    
   
?>
<section>       
    <aside id="leftsidebar" class="sidebar">        
        <div class="user-info">
            <div class="image">
            <?php echo $this->Html->image('wecontrol/BeneFit-logo.png',array('width'=>'150px;'))?>                   
            </div>
           <button type="button" id="btn-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i></button>
        </div>        
        <div class="menu">
            <ul class="list">               
                <?php 
                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">home</i><span>Dashboard</span>',
                            array('controller' => 'dashboard', 'action' => 'index'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('dashboard', 'index')),'title'=>'Dashboard')
                    );
                    
                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">collections_bookmark</i><span>Vouchers</span>',
                            array('controller' => 'vouchers', 'action' => 'index'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('vouchers', array('index','add_voucher','edit_voucher', 'vouchers_data', 'view_voucher'))),'title'=>'Vouchers')
                    );

                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">mail_outline</i><span>Email Templates</span>',
                            array('controller' => 'masters', 'action' => 'email_templates'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('masters', array('email_templates', 'email_templates_data', 'add_template', 'edit_template', 'view_template'))),'title'=>'Email Templates')
                    );

                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">speaker_notes</i><span>Blogs</span>',
                            array('controller' => 'masters', 'action' => 'blogs'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('masters', array('blogs', 'blogs_data', 'add_blog', 'edit_blog', 'view_blog'))),'title'=>'Blogs')
                    );

                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">account_circle</i><span>Notifications</span>',
                            array('controller' => 'notifications', 'action' => 'index'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('notifications', array('send_notifications', 'index', 'notification_data', 'add_notification'))),'title'=>'Notifications')
                    );
                ?>
                
                

                <?php

                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">pages</i><span>Static Pages</span>',
                            array('controller' => 'pages', 'action' => 'static_page'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('pages', array('static_page','add_page','edit_page','view_page'))),'title'=>'Static Pages')
                    );

                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">question_answer</i><span>FAQs</span>',
                            array('controller' => 'pages', 'action' => 'faqs'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('pages', array('faqs'))),'title'=>'FAQs')
                    );

                    echo $this->Html->tag('li',
    					$this->Html->link('<i class="material-icons">people</i><span>Users</span>',
    						array('controller' => 'users', 'action' => 'index'),
    						array( 'escape' => false)
    					), array('class'=> sprintf('%s', subMenuClass('users', array('index','add','edit','view_vouchers'))),'title'=>'Users')
                    );

                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">person</i><span>Admins</span>',
                            array('controller' => 'admins', 'action' => 'index'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('admins', array('index','add','edit'))),'title'=>'Admins')
                    );  

                    echo $this->Html->tag('li',
                        $this->Html->link('<i class="material-icons">settings</i><span>Settings</span>',
                            array('controller' => 'pages', 'action' => 'setting'),
                            array( 'escape' => false)
                        ), array('class'=> sprintf('%s', subMenuClass('pages', array('setting'))),'title'=>'Static Pages')
                    );                    
                ?>
            
                <li><a href="javascript:void(0);">&nbsp;</a></li>  
            </ul>
        </div>
        <div class="legal">
            <div class="copyright">
               <a >Admin  - <?php echo projectTitle;?>   </a>
            </div>
        </div>
    </aside>          
</section>  
<script type="text/javascript">
     $("#btn-menu-toggle").on('click', function(event) {
      $("body").toggleClass("sidebar-collaps");
      $('.ml-menu').hide();
    });
    $(".menu-toggle").on('click', function(event) {

      $("body").removeClass("sidebar-collaps");
    });
</script>