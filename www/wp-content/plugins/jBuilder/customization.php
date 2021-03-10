<?php

function jCompose($index){
	
	// Default
	$args['taxonomy'] = array();
	$args['post'] = array();
	$args['page'] = array();

	/* 
	 * Exmample USE
	 * Noted: b = Blog, n = Name, s = Slug, r = Re-Write, i = icon
	 * ===========================================
	 * 
	 *  // For POST
	 *	$args['post'] = array(
	 *		array( 
	 *			 'b' => 1, 
	 *			 'n' => 'News/Press Release', 
	 *			 's' => 'news-press-release', 
					 'i' => 'news-press-release'
	 *			 'r' => 'news-press-release' 
	 *		)
	 *	);	
	 *
	 *  // For Page
	 *	$args['page'] = array(
	 *		array( 
	 *			'b' => 1, 
	 *			'n' => 'Generals', 
	 *			's' => 'general', 
	 *			'r' => false, 
	 *			'c' => array(
	 *				 array( 'n' => 'Home', 's' => 'home' )
	 *			) 
	 *		)
	 *	);
	 */

	/* $args['page'] = array(
		array( 'b' => 1, 'n' => 'Invoice', 's' => 'Invoice', 'r' => false, 'i' => false)
	);
  */

	$args[$index] = isset($args[$index])?$args[$index]:array();
	return $args[$index];
}
/* code this one for add function menu */
function jComposeMenu(){
		
	$args = array(	
		'mainMenu' => __( 'Main Menu' ),	
		'quickLinkMenu' => __( 'Quick Link' ),	
	);
	
	$args = isset($args) ? $args : array();
	return $args;
}