<div class="page_404">
     <h2>404!</h2>
     <?php echo $this->html->image('front/404.png',array('width'=>'80')); ?>
     <p style="margin-top:30px;">Sorry! The page you're looking for cannot be found.</p> 
     <a href="<?php echo Configure::read('SiteSettings.siteUrl'); ?>">Back to Home</a>
</div>