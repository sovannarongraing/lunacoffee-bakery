<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="author" content="GGearGroup">
		<meta http-equiv="X-UA-Compatible" content="IE=8; IE=9" /> 	
		<?php 
			define("AGENT", jAgent('m'));
			$type		= ((is_page()||is_archive()||is_search()||is_404())?'page':'post');
			$base		= 'platform/'.AGENT.'/'.AGENT.'-';
			$path		= 'platform/'.AGENT.'/views/'.$type.'/'.substr(AGENT, 0, 1).'v-'.$type.'-';
			$viewport 	= 'width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,shrink-to-fit=no';
		?>
		<meta name="viewport" content="<?php _e($viewport); ?>"/>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/toolsets/css/<?php _e(AGENT); ?>-default.css"/>
		<?php wp_head(); ?>       
	</head>
	<body class="preload">
        
		<div class="wrap">
			<div class="jheader">
				<?php get_template_part($base.'header'); ?>
			</div>
		</div>
		<div class="wrap">
			<div class="jcontent">
				<?php get_template_part($path.jView()); ?>
			</div>
		</div>
		<div class="wrap">
			<div class="jfooter">
				<?php get_template_part($base.'footer'); ?>
				<div id="clickmeup"></div>
			</div> <!-- .footer -->           
		</div> <!-- .wrapper -->
		<?php 
			wp_reset_query();
			get_template_part($base.'sconfig');
			wp_footer(); 
		?>         
	</body>
</html>	