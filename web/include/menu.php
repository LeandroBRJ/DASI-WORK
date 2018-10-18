<div id="menu">
    <span class="title">Chapitre 10 - POO</span>
    <ul>
    	<li><a href="<?php echo $this->url(); ?>">Index</a>
    	<li><a href="<?php echo $this->url('/index/info', array('http_param1' => 'http_valeur1')); ?>">Info</a>
    	<li><a href="<?php echo $this->url('/index2'); ?>">404</a>
    </ul>
</div>