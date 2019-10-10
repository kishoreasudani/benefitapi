 <!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a> 
            <a href="javascript:void(0);" class="bars"></a>
            <?php echo $this->Html->link('Admin - '.projectTitle,array('controller'=>'dashboard','action'=>'index'),array('class'=>'navbar-brand','escape'=>false))?>
            <a class="navbar-brand m-navbar-brand" href="index.html">
                <?php echo $this->Html->image('wecontrol/mobile-logo.png',array('controller'=>'pages','action'=>''),array('escape'=>false))?> 
            </a>
        </div>
        <div class="pull-right d-flex">
            <!-- <div class="switch panel-switch-btn top-switch-box">
                
                <label>DEV<input type="checkbox" id="realtime" class="db_type">
                <span class="lever switch-col-cyan"></span>LIVE</label>
            </div> -->
            <div class="user-info user-info-custom">
                <div class="info-container" >
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if($this->Session->check('Auth.Admin')){

                        ?>
                        
                        <div>
                            <?php echo ucwords($userDetails['Admin']['first_name'].' '.$userDetails['Admin']['last_name']);}?>
                            <div class="email"><?php if($this->Session->check('Auth.Admin.email')){
                                echo $userDetails['Admin']['email'];
                            }?></div>
                        </div>
                    </div>
                    <div class="btn-group user-helper-dropdown" style="bottom: 10px;">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <?php echo $this->Html->link('<i class="material-icons">person</i>Profile',array('controller'=>'admins','action'=>'edit_profile'),array('escape'=>false))?> 
                            </li>
                            <li class="divider"></li>
                            <li><?php echo $this->Html->link('<i class="material-icons">lock</i>Change Password',array('controller'=>'admins','action'=>'change_password'),array('escape'=>false))?> </li>
                            <li class="divider"></li>
                            <li><?php echo $this->Html->link('<i class="material-icons">exit_to_app</i>Sign Out',array('controller'=>'admins','action'=>'logout'),array('escape'=>false))?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>