<?php
remove_role('author');
remove_role('subscriber');
remove_role('contributor');
add_filter( 'show_admin_bar', '__return_false' );
add_filter( 'use_block_editor_for_post', '__return_false', 10 ); // Disable the Gutenberg WordPress Editor
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
remove_action( 'wp_head', 'wp_generator' ); // Remove WP generator (Version)
remove_action( 'wp_head', 'wp_resource_hints', 2 ); // Remove dns-prefetch
remove_action( 'wp_head', 'wp_shortlink_wp_head'); // Remove shortlink
remove_action( 'wp_head', 'rsd_link' ); // Remove EditURI
remove_action( 'wp_head', 'wlwmanifest_link' ); // Remove wlwmanifest
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 ); // Remove WP-JSON
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 ); // oEmbed Discovery
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // Remove EMOJI script
remove_action( 'wp_print_styles', 'print_emoji_styles' ); // Remove EMOJI style

/*
 * Name: Remove dashboard widgets
 * Version: 1.0
 * Copyright: Jonathan Christoper
 * Last update: Oct 01, 2020 
 */
add_action( 'admin_init', 'remove_dashboard_meta' ); 
function remove_dashboard_meta() {
	
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	
}


/*
 * Name: jAdmin
 * Version: 1.0
 * Copyright: Jonathan Christoper (CF)
 * Last update: Oct 01, 2020 
 */
function jAdmin(){
    if(is_admin()){
        wp_deregister_style( 'jAdmin' );
        wp_register_style( 'jAdmin', plugins_url( 'toolsets/admin/css/admin.css', dirname(__FILE__) ) );
        wp_enqueue_style( 'jAdmin' );
    }
}


/*
 * Name: jAdminFooter
 * Version: 1.0
 * Copyright: Jonathan Christoper (CF)
 * Last update: Oct 01, 2020 
 */
add_filter( 'update_footer', 'jAdminFooter', 9999 );
function jAdminFooter(){

	$wp_version = ''; // default value is null
	if( current_user_can( 'manage_options' ) ) { $wp_version = "CMS WordPress [V".get_bloginfo('version')."]"; } // For admin only
	return $wp_version; 

}

/*
 * Name: jAdminBar
 * Version: 1.0
 * Copyright: Jonathan Christoper (CF)
 * Last update: Oct 01, 2020 
 */
add_filter( 'admin_bar_menu', 'jAdminBar', 25 );
function jAdminBar( $wp_admin_bar ) {
	$my_account = $wp_admin_bar->get_node('my-account');
	$newtext = str_replace( 'Howdy,', 'Welcome,', $my_account->title );
	$wp_admin_bar->add_node( 
		array(
			'id' => 'my-account',
			'title' => $newtext,
		) 
	);
}



/*
 * Name: jAdminColorSchemes
 * Version: 1.0
 * Copyright: Jonathan Christoper (CF)
 * Last update: Oct 01, 2020 
 */
add_action( 'admin_init', 'jAdminColorSchemes' );
function jAdminColorSchemes() {
    wp_admin_css_color( 'fresh', __( 'Legacy' ), '', [ '#004E85', '#265F97', '#3C4B64', '#BFD0E0' ]); // Legacy
    wp_admin_css_color( 'dracula', __( 'Dracula' ), '', [ '#272C33', '#30384B', '#86939E', '#212121' ] ); // Dragula
    wp_admin_css_color( 'regency', __( 'Regency' ), '', [ '#634832', '#77583e', '#2b2622', '#ECE0D1' ] ); // Regency
}


/*
 * Name: jLoginRedirect
 * Version: 1.0
 * Copyright: Jonathan Christoper (JC)
 * Last update: Oct 01, 2020 
 */
add_filter('login_redirect', 'jLoginRedirect');
function jLoginRedirect() {
    return admin_url().'profile.php';
}


/*
 * Name: jMenus
 * Version: 1.0
 * Copyright: Jonathan Christoper (JC)
 * Last update: Oct 01, 2020 
 */
function jMenus() {
	if(function_exists('jComposeMenu')): 
		$menus = jComposeMenu();
		if($menus):
			register_nav_menus( $menus );
		endif;
	endif;
}


/*
 * Name: jPostPage
 * Version: 1.0
 * Copyright: Jonathan Christoper (CF)
 * Last update: Oct 01, 2018 
 */
function jPostPage(){
	
	// Blog ID
	$blog = get_current_blog_id();

	// Check function before execute
	if(function_exists('jCompose')):
		
		// Register POST
		$po = jCompose('post');
		foreach($po as $va):
			if($blog == $va['b']):
				if(function_exists('register_post_type')):
					register_post_type( 'p-'.$va['s'], 
						array(
							'labels' 		  => array(
								'name' 		  => __( $va['n'] ),
								'menu_name'   => __( $va['n'] ),
								'all_items'   => __( $va['n'] ),
							),
							'public' 		  => true,
							'show_in_menu'	  => 'edit.php',
							'menu_position'   => 100,
							'menu_icon' 	  => isset($va['i']) ? $va['i'] : '',
							'supports' 		  => array( "title", "editor", "author", "page-attributes" ),
							'capability_type' => "post",
							'with_front' 	  => false,
							'has_archive'     => false,
							'description'	  => isset($va['d']) ? $va['d'] : '',
							'rewrite' 		  => array("slug"=>(isset($va['r'])? $va['r']:'')),
							'page_url'		  => isset($va['p']) ? $va['p'] : $va['r'],
							'template'	  	  => isset($va['t']) ? $va['t'] : '',
							'group'	  	  	  => isset($va['g']) ? $va['g'] : ''
						)
					);
				endif;
				if(isset($va['c'])):
					foreach($va['c'] as $sv): 
						if(function_exists('register_post_type')):
							register_post_type( 'p-'.$sv['s'], 
								array(
									'labels' 		  => array(
										'name' 		  => __( $sv['n'] ),
										'menu_name'   => __( $sv['n'] ),
										'all_items'   => __( $sv['n'] ),
									),
									'public' 		  => true,
									'show_in_menu'	  => 'edit.php?post_type=p-'.$va['s'],
									'supports' 		  => array( "title", "editor", "author", "page-attributes" ),
									'capability_type' => "post",
									'with_front' 	  => false,
									'has_archive'     => true,
									'description'	  => $sv['d'],
									'rewrite' 		  => array( "slug"=>$sv['s'].(isset($sv['r'])?'/'.$sv['r']:'') ),
									'page_url'		  => isset($va['p']) ? $va['p'] : '',
								)
							);
						endif;
					endforeach;
				endif;
			endif;
		endforeach;
		
		// Register PAGE
		$nu = 0;
		$pa = jCompose('page');
		foreach($pa as $va): $nu++;
			if($blog == $va['b']):
				if(!isset($va['x'])):
					if(function_exists('acf_add_options_page')):
						acf_add_options_page(array(		
							'title'		=> $va['n'],
							'menu_slug'	=> 'o-'.$va['s'],
							'icon_url'	=> isset($va['i']) ? $va['i'] : '',
							'redirect'	=> isset($va['r']) ? $va['r'] : true,
							'position'	=> isset($va['p']) ? $va['p'] : ((90+$nu)-1),
						));	
					endif;
					if(isset($va['c'])):
						if(function_exists('acf_add_options_sub_page')):	
							foreach($va['c'] as $sv):
								acf_add_options_sub_page(array(
									'page_title' 	=> $sv['n'],
									'menu_slug'		=> 'o-'.$sv['s'],
									'parent_slug' 	=> 'o-'.$va['s'],
								));
							endforeach;
						endif;
					endif;
				else:
					if(function_exists('acf_add_options_sub_page')):	
						acf_add_options_sub_page(array(
							'page_title' 	=> $va['n'],
							'parent_slug' 	=> $va['x'],
							'menu_slug'		=> 'o-'.$va['s'],
						));
					endif;
				endif;
			endif;
		endforeach;	
	   
    
        // Register Taxonomy
		$ta = jCompose('taxonomy');
		foreach($ta as $va):
            $args = array(
                'labels' => array(
                    'name' => __( $va['l'] ),
                    'menu_name' => __( $va['l'] ),
                ),
                'hierarchical' => false,
                'rewrite' => array( 'slug' => $va['r'] ),
                'show_admin_column' => true,
				'exclude_from_search' => true,
            );	
            register_taxonomy( $va['n'], $va['p'], $args );
		endforeach;
    
	endif;
}


/*
 * Name: jView
 * Version: 1.0
 * Copyright: Jonathan Christoper (CF)
 * Last update: Oct 01, 2018 
 */
function jView($args=array()){
		
	global $post;
	$id         = $post->ID;
	$parents    = $post->post_parent;
	$name	    = $post->post_name;
	
	if(is_page()): 

		if($parents != 0): 
			
			// Top-level parent Pages
			$ancestors 	 = get_post_ancestors( $id );
			$ancestorsid = $ancestors ? $ancestors[count($ancestors)-1]: $id;
		
			// Name of Top-level parent Pages
			$parentname = wp_basename(get_permalink($ancestorsid));
			$childname  = wp_basename(get_permalink());
			$name 		= $parentname.'-'.$name;

		endif; 

	elseif(is_404()):

		$name = "404";

	else: 

		// If user specific template of each post type
		$obj = get_post_type_object( $post->post_type );
		if($obj->template != ''){
			return $obj->template;
		}
		
		// return post type name
		$name = (is_single()?substr(get_post_type(),2) : (is_tax()? substr(get_queried_object()->taxonomy,4): (is_search()?'search':''))); 
		

	endif; 
	
	return $name;
}


/*
 * Name: jAgent
 * Version: 1.0
 * Copyright: Jonathan Christoper (CF)
 * Last update: Oct 01, 2018 
 */
function jAgent($plateform='s'){
	$detect = new Mobile_Detect;
	return (($detect->isMobile()&&!$detect->isTablet()&&$plateform=='m')?'mobi':'desk'); 
}


/*
 * Name: REMOVE JQUERY FROM OTHER PLUGIN EMBED
 * Version: 1.0
 * Copyright: Jonathan Christoper
 * Last update: Oct 01, 2018 
 */
function jRemoveJquery() {
    if (!is_admin() && $GLOBALS['pagenow'] != 'wp-login.php') {
       wp_deregister_script('jquery');
       wp_register_script('jquery', false);
    }
}