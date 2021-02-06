<?php
/*
 *	Name: jInclude
 * 	Description: This func use include extra theme file
 */
function jInclude($name = NULL){ 
	if($name != NULL){
		$dir  = dirname(__FILE__).'/';
		$file = 'helper/'.$name.'.php';

		// Check if file exist or not
		if (file_exists($dir.$file)) { 
			require_once($file);
		}
	}
}

/*
 *	Name: jStyle
 * 	Description: Load dynamic style
 */
function jStyle(){

	// Default
	$name = jView();
	if(strpos(jView(), 'product') !== false){
		$name = substr(jView(),0,7);
		if(strpos(jView(), 'business') !== false){
			$name = substr(jView(),9,7);
		}
	}

	// Bind file name
	$file = get_bloginfo('template_url').'/toolsets/css/'.AGENT.'-'.$name.'.css';
	echo $file;
}