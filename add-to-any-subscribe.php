<?php
/*
Plugin Name: Add to Any: Subscribe Button
Plugin URI: http://www.addtoany.com/buttons/
Description: Lets readers subscribe to your blog using any feed reader.
Version: .6
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
		$sitename		= get_bloginfo('name');
		$sitename_enc	= rawurlencode( $sitename );
		$feedurl		= get_bloginfo('rss2_url');
		$feedurl_enc 	= rawurlencode( $feedurl );
		?>
        <a name="a2a_dd" onmouseover="a2a_show_dropdown(this)" onmouseout="a2a_onMouseOut_delay()" href="http://www.addtoany.com/subscribe?linkname=<?=$sitename_enc?>&amp;linkurl=<?=$feedurl_enc?>"><img src="<?=trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_120_16.gif'?>" width="120" height="16" border="0" alt="Subscribe"/></a>
        <script type="text/javascript">a2a_linkname="<?=str_replace('"', '\\"', $sitename)?>";a2a_linkurl="<?=$feedurl?>";</script>
		<script type="text/javascript" src="http://www.addtoany.com/js.dropdown.js?type=feed"></script>
		<?
	}
	
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', array('Add_to_Any_Subscribe_Widget','init'));



?>
