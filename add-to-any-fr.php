<?php
/*
Plugin Name: Add to Any: Subscribe Button
Plugin URI: http://www.addtoany.com/
Description: Lets readers subscribe to your blog using any feed reader.
Version: .2
Author: MicroPat
Author URI: http://www.addtoany.com/contact/
*/

class Add_to_Any_Subscribe_Widget {

  	// static init callback
	function init() {
	// Check for the required plugin functions. This will prevent fatal
	// errors occurring when you deactivate the dynamic-sidebar plugin.
	if ( !function_exists('register_sidebar_widget') )
	  return;
	
	$widget = new Add_to_Any_Subscribe_Widget();
	
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget('Add to Any Subscribe', array($widget,'display'));
	}


	function display() {
		$options = get_option('widget_at_subscribe');
		$title = $options['title'];
		$feedurl = urlencode($options['feedurl']);
		?>
		<div style="text-align:center"><a href="http://www.addtoany.com/?sitename=<? bloginfo('name'); ?>&amp;siteurl=<? bloginfo('siteurl'); ?>&amp;linkname=<? $title; ?>&amp;linkurl=<? echo $feedurl; ?>&amp;type=feed"><img src="http://www.addtoany.com/add-sub.gif" width="110" height="17" border="0" title="Add to any service" alt="Add to any service"/></a></div>
		<?
	}
	
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', array('Add_to_Any_Subscribe_Widget','init'));



?>
