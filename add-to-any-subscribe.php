<?php
/*
Plugin Name: Add to Any: Subscribe Button
Plugin URI: http://www.addtoany.com/buttons/
Description: Lets readers subscribe to your blog using any feed reader.  [<a href="widgets.php">Settings</a> - on the Widgets page]
Version: .9
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
		
		//Registering the control form.
		register_widget_control('Add to Any Subscribe', 'A2A_SUBSCRIBE_options_page', 450);
	}


	function display() {
		$sitename		= get_bloginfo('name');
		$sitename_enc	= rawurlencode( $sitename );
		$feedurl		= get_bloginfo('rss2_url');
		$feedurl_enc 	= rawurlencode( $feedurl );

		if( !get_option('A2A_SUBSCRIBE_button') ) {
			$button_fname	= 'subscribe_120_16.gif';
			$button_width	= '120';
			$button_height	= "16";
		} else {
			$button_attrs	= explode( '|', get_option('A2A_SUBSCRIBE_button') );
			$button_fname	= $button_attrs[0];
			$button_width	= $button_attrs[1];
			$button_height	= $button_attrs[2];
		}
		$button			= '<img style="margin-left:20px" src="'.trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/'.$button_fname.'" width="'.$button_width.'" height="'.$button_height.'" border="0" alt="Subscribe"/>';
		
		?>
        <a name="a2a_dd" onmouseover="a2a_show_dropdown(this)" onmouseout="a2a_onMouseOut_delay()" href="http://www.addtoany.com/subscribe?linkname=<?php echo $sitename_enc; ?>&amp;linkurl=<?php echo $feedurl_enc; ?>"><?php echo $button; ?></a>
        <script type="text/javascript">
			a2a_linkname="<?php echo str_replace('"', '\\"', $sitename); ?>";
			a2a_linkurl="<?php echo $feedurl; ?>";
            <?php echo (get_option('A2A_SUBSCRIBE_hide_embeds')=='-1') ? 'a2a_hide_embeds=0;' : ''; ?>
			<?php echo (get_option('A2A_SUBSCRIBE_show_title')=='1') ? 'a2a_show_title=1;' : ''; ?>
		</script>
		<script type="text/javascript" src="http://www.addtoany.com/menu/feed.js"></script>
		<?php
	}
	
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', array('Add_to_Any_Subscribe_Widget','init'));







/*****************************
		OPTIONS
******************************/


// This function outputs the options control panel under the admin screen.
function A2A_SUBSCRIBE_options_page() {
	
	if( $_POST[ 'A2A_SUBSCRIBE_submit_hidden' ] == 'Y' ) {

		update_option( 'A2A_SUBSCRIBE_button', $_POST['A2A_SUBSCRIBE_button'] );
		update_option( 'A2A_SUBSCRIBE_hide_embeds', ($_POST['A2A_SUBSCRIBE_hide_embeds']=='1') ? '1':'-1' );
		update_option( 'A2A_SUBSCRIBE_show_title', ($_POST['A2A_SUBSCRIBE_show_title']=='1') ? '1':'-1' );
		
    }

	
	// Which is checked
	$subscribe_16_16 		= ( get_option('A2A_SUBSCRIBE_button')=='subscribe_16_16.png|16|16' ) ? ' checked="checked" ' : ' ';
	$subscribe_120_16 		= ( !get_option('A2A_SUBSCRIBE_button') || get_option('A2A_SUBSCRIBE_button')=='subscribe_120_16.gif|120|16' ) ? ' checked="checked" ' : ' ';
	$subscribe_171_16 		= ( get_option('A2A_SUBSCRIBE_button')=='subscribe_171_16.gif|171|16' ) ? ' checked="checked" ' : ' ';
	$subscribe_256_24 		= ( get_option('A2A_SUBSCRIBE_button')=='subscribe_256_24.gif|256|24' ) ? ' checked="checked" ' : ' ';
	$subscribe_hide_embeds 	= ( get_option('A2A_SUBSCRIBE_hide_embeds')!='-1' ) ? ' checked="checked" ' : ' ';
	$subscribe_show_title 	= ( get_option('A2A_SUBSCRIBE_show_title')=='1' ) ? ' checked="checked" ' : ' ';
	
	?>
    <input type="hidden" id="A2A_SUBSCRIBE_submit_hidden" name="A2A_SUBSCRIBE_submit_hidden" value="Y" />
    <p>
    	<label>
        	<input class="radio" type="radio"<?php echo $subscribe_16_16; ?> name="A2A_SUBSCRIBE_button" value="subscribe_16_16.png|16|16" />
    		<img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_16_16.png'; ?>" width="16" height="16" border="0" />
		</label>
	</p>
    <p>
    	<label>
        	<input class="radio" type="radio"<?php echo $subscribe_120_16; ?> name="A2A_SUBSCRIBE_button" value="subscribe_120_16.gif|120|16" />
    		<img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_120_16.gif'; ?>" width="120" height="16" border="0" />
		</label>
	</p>
    <p>
    	<label>
        	<input class="radio" type="radio"<?php echo $subscribe_171_16; ?> name="A2A_SUBSCRIBE_button" value="subscribe_171_16.gif|171|16" />
    		<img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_171_16.gif'; ?>" width="171" height="16" border="0" />
		</label>
	</p>
    <p>
    	<label>
        	<input class="radio" type="radio"<?php echo $subscribe_256_24; ?> name="A2A_SUBSCRIBE_button" value="subscribe_256_24.gif|256|24" />
    		<img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_256_24.gif'; ?>" width="256" height="24" border="0" />
		</label>
	</p>
    <p>
    	<label>
            <input name="A2A_SUBSCRIBE_hide_embeds" type="checkbox"<?php echo $subscribe_hide_embeds; ?>value="1"/>
            Hide embedded objects (Flash, video, etc.) when the menu is displayed
        </label>
	</p>
    <p>
        <label>
            <input name="A2A_SUBSCRIBE_show_title" type="checkbox"<?php echo $subscribe_show_title; ?>value="1"/>
            Show the title of the post within the menu
        </label>
	</p>
	<?php
	
}

?>
