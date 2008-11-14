<?php
/*
Plugin Name: Add to Any: Subscribe Button
Plugin URI: http://www.addtoany.com/buttons/
Description: Lets readers subscribe to your blog using any feed reader.  [<a href="widgets.php">Settings</a> - on the Widgets page]
Version: .9.5.4
Author: Add to Any
Author URI: http://www.addtoany.com/contact/
*/


if( !isset($A2A_javascript) )
	$A2A_javascript = '';
if( !isset($A2A_locale) )
	$A2A_locale = '';


function A2A_SUBSCRIBE_textdomain() {
		load_plugin_textdomain('add-to-any-subscribe',
			PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)),
			dirname(plugin_basename(__FILE__)));
}
add_action('init', 'A2A_SUBSCRIBE_textdomain');

		
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
		register_widget_control('Add to Any Subscribe', 'A2A_SUBSCRIBE_options_widget', 450);
	}


	function display( $args = false ) {
		
		if( $args )
			extract( $args );
		
		$feedname		= ($feedname) ? $feedname : get_bloginfo('name');
		$feedname_enc	= rawurlencode( $feedname );
		$feedurl		= ($feedurl) ? $feedurl : get_bloginfo('rss2_url');
		$feedurl_enc 	= rawurlencode( $feedurl );

		if( !get_option('A2A_SUBSCRIBE_button') ) {
			$button_fname	= 'subscribe_120_16.gif';
			$button_width	= ' width="120"';
			$button_height	= ' height="16"';
			$button_src		= trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/'.$button_fname;
		} else if( get_option('A2A_SUBSCRIBE_button') == 'CUSTOM' ) {
			$button_src		= get_option('A2A_SUBSCRIBE_button_custom');
			$button_width	= '';
			$button_height	= '';
		} else if( get_option('A2A_SUBSCRIBE_button') == 'TEXT' ) {
			$button_text	= get_option('A2A_SUBSCRIBE_button_text');
		} else {
			$button_attrs	= explode( '|', get_option('A2A_SUBSCRIBE_button') );
			$button_fname	= $button_attrs[0];
			$button_width	= ' width="'.$button_attrs[1].'"';
			$button_height	= ' height="'.$button_attrs[2].'"';
			$button_src		= trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/'.$button_fname;
		}
		if( $button_text ) {
			$button			= $button_text;
		} else
			$button			= '<img src="'.$button_src.'"'.$button_width.$button_height.' alt="Subscribe"/>';
		
		echo $before_widget; ?>

        <a class="a2a_dd addtoany_subscribe" href="http://www.addtoany.com/subscribe?linkname=<?php echo $feedname_enc; ?>&amp;linkurl=<?php echo $feedurl_enc; ?>"><?php echo $button; ?></a>
        <?php echo $after_widget;
		
		global $A2A_javascript, $A2A_SUBSCRIBE_external_script_called;
		if( $A2A_javascript == '' || !$A2A_SUBSCRIBE_external_script_called ) {
			$external_script_call = '</script><script type="text/javascript" src="http://static.addtoany.com/menu/feed.js"></script>';
			$A2A_SUBSCRIBE_external_script_called = true;
		}
		else
			$external_script_call = 'a2a_init("feed");</script>';
		$A2A_javascript .= '<script type="text/javascript">' . "\n"
			. A2A_menu_locale()
			. 'a2a_linkname="' . js_escape($feedname) . '";' . "\n"
			. 'a2a_linkurl="' . $feedurl . '";' . "\n"
			. ((get_option('A2A_SUBSCRIBE_onclick')=='1') ? 'a2a_onclick=1;' . "\n" : '')
			. ((get_option('A2A_SUBSCRIBE_hide_embeds')=='-1') ? 'a2a_hide_embeds=0;' . "\n" : '')
			. ((get_option('A2A_SUBSCRIBE_show_title')=='1') ? 'a2a_show_title=1;' . "\n" : '')
			. stripslashes(get_option('A2A_SUBSCRIBE_additional_js_variables')) . "\n"
			. $external_script_call . "\n\n";
		
		remove_action('wp_footer', 'A2A_menu_javascript');
		add_action('wp_footer', 'A2A_menu_javascript');
		
	}
	
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', array('Add_to_Any_Subscribe_Widget','init'), 99);


if (!function_exists('A2A_menu_javascript')) {
	function A2A_menu_javascript() {
		global $A2A_javascript;
		echo $A2A_javascript;
	}
}

if (!function_exists('A2A_menu_locale')) {
	function A2A_menu_locale() {
		global $A2A_locale;
		if( $A2A_locale != '' ) return false;
		$A2A_locale = 'a2a_localize = {
	Share: "' . __("Share", "add-to-any") . '",
	Save: "' . __("Save", "add-to-any") . '",
	Subscribe: "' . __("Subscribe", "add-to-any") . '",
	Email: "' . __("E-mail") . '",
    Bookmark: "' . __("Bookmark") . '",
	ShowAll: "' . __("Show all", "add-to-any") . '",
	ShowLess: "' . __("Show less", "add-to-any") . '",
	FindServices: "' . __("Find service(s)", "add-to-any") . '",
	FindAnyServiceToAddTo: "' . __("Instantly find any service to add to", "add-to-any") . '",
	PoweredBy: "' . __("Powered by", "add-to-any") . '",
	ShareViaEmail: "' . __("Share via e-mail", "add-to-any") . '",
	SubscribeViaEmail: "' . __("Subscribe via e-mail", "add-to-any") . '",
	BookmarkInYourBrowser: "' . __("Bookmark in your browser", "add-to-any") . '",
	BookmarkInstructions: "' . __("Press Ctrl+D or Cmd+D to bookmark this page", "add-to-any") . '",
	AddToYourFavorites: "' . __("Add to your favorites", "add-to-any") . '",
	SendFromWebOrProgram: "' . __("Send from any e-mail address or e-mail program") . '",
    EmailProgram: "' . __("E-mail program") . '"
};
';
		return $A2A_locale;
	}
}


function A2A_SUBSCRIBE_button_css() {
	?><style type="text/css">.addtoany_subscribe img{border:0;}</style>
<?php
}
add_action('wp_head', 'A2A_SUBSCRIBE_button_css');




/*************************************************
		OPTIONS  ( Design > Widgets )
*************************************************/


// This function outputs the options control panel under the admin screen.
function A2A_SUBSCRIBE_options_widget() {
	
	if( $_POST[ 'A2A_SUBSCRIBE_submit_hidden' ] == 'Y' ) {

		update_option( 'A2A_SUBSCRIBE_button', $_POST['A2A_SUBSCRIBE_button'] );
		update_option( 'A2A_SUBSCRIBE_button_custom', $_POST['A2A_SUBSCRIBE_button_custom'] );
		update_option( 'A2A_SUBSCRIBE_button_text', $_POST['A2A_SUBSCRIBE_button_text'] );
		
    }

	
	// Which is checked
	$subscribe_16_16 		= ( get_option('A2A_SUBSCRIBE_button')=='subscribe_16_16.png|16|16' ) ? ' checked="checked" ' : ' ';
	$subscribe_120_16 		= ( !get_option('A2A_SUBSCRIBE_button') || get_option('A2A_SUBSCRIBE_button')=='subscribe_120_16.gif|120|16' ) ? ' checked="checked" ' : ' ';
	$subscribe_171_16 		= ( get_option('A2A_SUBSCRIBE_button')=='subscribe_171_16.gif|171|16' ) ? ' checked="checked" ' : ' ';
	$subscribe_256_24 		= ( get_option('A2A_SUBSCRIBE_button')=='subscribe_256_24.gif|256|24' ) ? ' checked="checked" ' : ' ';
	$subscribe_custom 		= ( get_option('A2A_SUBSCRIBE_button')=='CUSTOM' ) ? ' checked="checked" ' : ' ';
	$subscribe_text 		= ( get_option('A2A_SUBSCRIBE_button')=='TEXT' ) ? ' checked="checked" ' : ' ';
	
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
        	<input class="radio" type="radio"<?php echo $subscribe_custom; ?> name="A2A_SUBSCRIBE_button" value="CUSTOM" style="vertical-align:middle" />
			<? _e("Image URL"); ?>:
        </label>
        <input class="widefat" name="A2A_SUBSCRIBE_button_custom" type="text" onclick="e=document.getElementsByName('A2A_SUBSCRIBE_button');e[e.length-2].checked=true" style="vertical-align:middle;width:256px"
        	value="<?php echo get_option('A2A_SUBSCRIBE_button_custom'); ?>" /> 
	</p>
    <p>
    	<label>
        	<input class="radio" type="radio"<?php echo $subscribe_text; ?> name="A2A_SUBSCRIBE_button" value="TEXT" style="vertical-align:middle" />
			<? _e("Text only"); ?>:
        </label>
        <input class="widefat" name="A2A_SUBSCRIBE_button_text" type="text" onclick="e=document.getElementsByName('A2A_SUBSCRIBE_button');e[e.length-1].checked=true" style="vertical-align:middle;width:256px"
        	value="<?php echo get_option('A2A_SUBSCRIBE_button_text'); ?>" /> 
	</p>
    <p>
    	<a href="options-general.php?page=add-to-any-subscribe.php"><? _e("More Settings", "add-to-any-subscribe"); ?>...</a>
	</p>
	<?php
	
}




/************************************************
		OPTIONS  ( Settings > Subscribe Button )
*************************************************/


function A2A_SUBSCRIBE_options_page() {

    if( $_POST[ 'A2A_SUBSCRIBE_submit_hidden' ] == 'Y' ) {

		update_option( 'A2A_SUBSCRIBE_hide_embeds', ($_POST['A2A_SUBSCRIBE_hide_embeds']=='1') ? '1':'-1' );
		update_option( 'A2A_SUBSCRIBE_show_title', ($_POST['A2A_SUBSCRIBE_show_title']=='1') ? '1':'-1' );
		update_option( 'A2A_SUBSCRIBE_onclick', ($_POST['A2A_SUBSCRIBE_onclick']=='1') ? '1':'-1' );
		update_option( 'A2A_SUBSCRIBE_button', $_POST['A2A_SUBSCRIBE_button'] );
		update_option( 'A2A_SUBSCRIBE_button_custom', $_POST['A2A_SUBSCRIBE_button_custom'] );
		update_option( 'A2A_SUBSCRIBE_button_text', ( trim($_POST['A2A_SUBSCRIBE_button_text']) != '' ) ? $_POST['A2A_SUBSCRIBE_button_text'] : "Subscribe" );
		update_option( 'A2A_SUBSCRIBE_additional_js_variables', trim($_POST['A2A_SUBSCRIBE_additional_js_variables']) );
		
		?>
    	<div class="updated fade"><p><strong><?php _e('Settings saved.'); ?></strong></p></div>
		<?php
		
    }

    ?>
    
    <div class="wrap">

	<h2><?php _e( 'Add to Any: Subscribe ', 'add-to-any-subscribe' ) . _e( 'Settings' ); ?></h2>

    <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    
	<?php wp_nonce_field('update-options'); ?>
    
    	<input type="hidden" name="A2A_SUBSCRIBE_submit_hidden" value="Y">
    
        <table class="form-table">
        	<tr valign="top">
            <th scope="row"><? _e("Button", "add-to-any-subscribe"); ?></th>
            <td><fieldset>
            	<label>
                	<input name="A2A_SUBSCRIBE_button" value="subscribe_16_16.png|16|16" type="radio"<?php if(get_option('A2A_SUBSCRIBE_button')=='subscribe_16_16.png|16|16') echo ' checked="checked"'; ?>
                    	 style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_16_16.png'; ?>" width="16" height="16" border="0" style="padding:9px;vertical-align:middle" alt="+ Subscribe" title="+ Subscribe"
                    	onclick="this.parentNode.firstChild.checked=true"/>
                </label><br>
                <label>
                	<input name="A2A_SUBSCRIBE_button" value="subscribe_120_16.gif|120|16" type="radio"<?php if( !get_option('A2A_SUBSCRIBE_button') || get_option('A2A_SUBSCRIBE_button' )=='subscribe_120_16.gif|120|16') echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_120_16.gif'; ?>" width="120" height="16" border="0" style="padding:9px;vertical-align:middle"
                    	onclick="this.parentNode.firstChild.checked=true"/>
                </label><br>
                <label>
                	<input name="A2A_SUBSCRIBE_button" value="subscribe_171_16.gif|171|16" type="radio"<?php if(get_option('A2A_SUBSCRIBE_button')=='subscribe_171_16.gif|171|16') echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_171_16.gif'; ?>" width="171" height="16" border="0" style="padding:9px;vertical-align:middle"
                    	onclick="this.parentNode.firstChild.checked=true"/>
                </label><br>
                <label>
                	<input name="A2A_SUBSCRIBE_button" value="subscribe_256_24.gif|256|24" type="radio"<?php if(get_option('A2A_SUBSCRIBE_button')=='subscribe_256_24.gif|256|24') echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
                    <img src="<?php echo trailingslashit(get_option('siteurl')).PLUGINDIR.'/add-to-any-subscribe/subscribe_256_24.gif'; ?>" width="256" height="24" border="0" style="padding:9px;vertical-align:middle"
                    	onclick="this.parentNode.firstChild.checked=true"/>
				</label><br>
                <label>
                	<input name="A2A_SUBSCRIBE_button" value="CUSTOM" type="radio"<?php if( get_option('A2A_SUBSCRIBE_button') == 'CUSTOM' ) echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
					<span style="margin:0 9px;vertical-align:middle"><? _e("Image URL"); ?>:</span>
				</label>
  				<input name="A2A_SUBSCRIBE_button_custom" type="text" class="code" size="50" onclick="e=document.getElementsByName('A2A_SUBSCRIBE_button');e[e.length-2].checked=true" style="vertical-align:middle"
                	value="<?php echo get_option('A2A_SUBSCRIBE_button_custom'); ?>" /><br>
				<label>
                	<input name="A2A_SUBSCRIBE_button" value="TEXT" type="radio"<?php if( get_option('A2A_SUBSCRIBE_button') == 'TEXT' ) echo ' checked="checked"'; ?>
                    	style="margin:9px 0;vertical-align:middle">
					<span style="margin:0 9px;vertical-align:middle"><? _e("Text only"); ?>:</span>
				</label>
                <input name="A2A_SUBSCRIBE_button_text" type="text" class="code" size="50" onclick="e=document.getElementsByName('A2A_SUBSCRIBE_button');e[e.length-1].checked=true" style="vertical-align:middle"
                	value="<?php echo ( trim(get_option('A2A_SUBSCRIBE_button_text')) != '' ) ? get_option('A2A_SUBSCRIBE_button_text') : "Subscribe"; ?>" />
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><? _e("Button Placement", "add-to-any-subscribe"); ?></th>
            <td><fieldset>
            	<? _e("If you are using a widget-ready theme, you can use the <a href=\"widgets.php\">widgets page</a> to place the button where you want in your sidebar.", "add-to-any-subscribe"); ?>
                <p><a href="widgets.php" class="button-secondary"><? _e("Open Widgets Panel", "add-to-any-subscribe"); ?></a></p>
                <p><? _e("Alternatively, you can place the following code in <a href=\"theme-editor.php\">your template pages</a> (within <code>sidebar.php</code>, <code>index.php</code>, <code>single.php</code>, and/or <code>page.php</code>)", "add-to-any-subscribe"); ?>:<br/>
                <code>&lt;?php if( class_exists('Add_to_Any_Subscribe_Widget') ) { Add_to_Any_Subscribe_Widget::display(); } ?&gt;</code></p>
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><? _e("Menu Style", "add-to-any-subscribe"); ?></th>
            <td><fieldset>
                    	<? _e("Using Add to Any's Menu Styler, you can customize the colors of your Subscribe menu! When you're done, be sure to paste the generated code in the <a href=\"#\" onclick=\"document.getElementById('A2A_SUBSCRIBE_additional_js_variables').focus();return false\">Additional Options</a> box below.", "add-to-any-subscribe"); ?>
                    <p>
                		<a href="http://www.addtoany.com/buttons/subscribe/menu_style/wordpress" class="button-secondary" title="<? _e("Open the Add to Any Menu Styler in a new window", "add-to-any-subscribe"); ?>" target="_blank"
                        	onclick="document.getElementById('A2A_SUBSCRIBE_additional_js_variables').focus();
                            	document.getElementById('A2A_SUBSCRIBE_menu_styler_note').style.display='';"><? _e("Open Menu Styler", "add-to-any-subscribe"); ?></a>
					</p>
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><? _e("Menu Options", "add-to-any-subscribe"); ?></th>
            <td><fieldset>
            	<label>
                	<input name="A2A_SUBSCRIBE_hide_embeds" 
                        type="checkbox"<?php if(get_option('A2A_SUBSCRIBE_hide_embeds')!='-1') echo ' checked="checked"'; ?> value="1"/>
                	<? _e("Hide embedded objects (Flash, video, etc.) that intersect with the menu when displayed", "add-to-any-subscribe"); ?>
                </label><br />
                <label>
                	<input name="A2A_SUBSCRIBE_show_title" 
                        type="checkbox"<?php if(get_option('A2A_SUBSCRIBE_show_title')=='1') echo ' checked="checked"'; ?> value="1"/>
                	<? _e("Show the title of this blog within the menu", "add-to-any-subscribe"); ?>
                </label><br />
				<label>
                	<input name="A2A_SUBSCRIBE_onclick" 
                        type="checkbox"<?php if(get_option('A2A_SUBSCRIBE_onclick')=='1') echo ' checked="checked"'; ?> value="1"/>
                	<? _e("Only show the menu when the user clicks the Subscribe button", "add-to-any-subscribe"); ?>
                </label>
            </fieldset></td>
            </tr>
            <tr valign="top">
            <th scope="row"><? _e("Additional Options", "add-to-any-subscribe"); ?></th>
            <td><fieldset>
            		<p id="A2A_SUBSCRIBE_menu_styler_note" style="display:none">
                        <label for="A2A_SUBSCRIBE_additional_js_variables">
                            <strong><? _e("Paste the code from Add to Any's Menu Styler in the box below!", "add-to-any-subscribe"); ?></strong>
                        </label>
                    </p>
                    <label for="A2A_SUBSCRIBE_additional_js_variables">
                    	<? _e("Below you can set special JavaScript variables to apply to your Subscribe menu.", "add-to-any-subscribe"); ?>
                    	<? _e("Advanced users might want to check out the code generated by Add to Any's general <a href=\"http://www.addtoany.com/buttons/subscribe\">Subscribe button generator</a>.", "add-to-any-subscribe"); ?>
					</label>
                    <p>
                		<textarea name="A2A_SUBSCRIBE_additional_js_variables" id="A2A_SUBSCRIBE_additional_js_variables" class="code" style="width: 98%; font-size: 12px;" rows="5" cols="50"><?php echo stripslashes(get_option('A2A_SUBSCRIBE_additional_js_variables')); ?></textarea>
					</p>
                    <?php if( get_option('A2A_SUBSCRIBE_additional_js_variables')!='' ) { ?>
                    <label for="A2A_SUBSCRIBE_additional_js_variables"><? _e("<strong>Note</strong>: If you're adding new code, be careful not to accidentally overwrite any previous code.", "add-to-any-subscribe"); ?></label>
                    <?php } ?>
            </fieldset></td>
            </tr>
        </table>
        
        <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Save Changes', 'add-to-any-subscribe' ) ?>" />
        </p>
    
    </form>
    </div>

<?php
 
}

function A2A_SUBSCRIBE_add_menu_link() {
	if( current_user_can('manage_options') ) {
		add_options_page(
			'Add to Any: '. __("Subscribe", "add-to-any-subscribe") . " " . __("Settings")
			, __("Subscribe Buttons", "add-to-any-subscribe")
			, 8 
			, basename(__FILE__)
			, 'A2A_SUBSCRIBE_options_page'
		);
	}
}

add_action('admin_menu', 'A2A_SUBSCRIBE_add_menu_link');

?>
