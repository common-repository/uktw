<?php
/*
Plugin Name: UK Theatre Web
Plugin URI: https://www.uktw.co.uk/wp/
Description: UK Theatre Web
Author: R M J Iles
Version: 0.3
Author URI: https://www.uktw.co.uk
License: GPL2
*/
/*  Copyright 2012  Robert Iles  (email : info@uktw.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	NOTE: The data and images that this software accesses from the 
	UK Theatre Web database may not be stored, redistributed or modified
	and is intended soley for direct display to users.
	
	NOTE: Access to the UK Theatre Web api, interface or any utility
	residing on the UK Theatre Web servers is only available for use 
	for this module. To use them from derivatives of this module, or
	any other system, please contact the author.
*/
//==============================================================================
//
// This section produces an installable plug-in and the "settings" menu item for it
//
function uktw_admin_actions(){
	add_options_page("UKTW Settings", "UKTW Settings", 'manage_options', "UKTWSettings", "uktw_admin_settings");
}
function uktw_admin_settings(){
	if( $_POST['uktw_hidden'] == 'Y' ) {
		//Form data sent
		$uktwaffiliate = sanitize_user( $_POST['uktw_affiliate'], true );
		update_option( 'uktw_affiliate', $uktwaffiliate );
		?>
		<div class="updated"><p><strong><?php _e( 'Options saved.' ); ?></strong></p></div>
		<?php
	} else {
		//Normal page display
		$uktwaffiliate = get_option( 'uktw_affiliate' );
	}	
	echo( "<div class=\"wrap\">" );
	echo( "<h2>" . __( 'UKTW Options' ) . "</h2>" );
	?>
	<form name="uktw_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="uktw_hidden" value="Y">
	<?php    echo "<h4>" . __( 'UKTW Settings' ) . "</h4>"; ?>
	<p><?php _e("Affiliate: " ); ?><input type="text" name="uktw_affiliate" value="<?php echo $uktwaffiliate; ?>" size="20"><?php _e(" e.g.: joeblow" ); ?></p>
	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options') ?>" />
	</p>
</form>
	<?php
	// include admin code here
	echo("</div>");
}
add_action('admin_menu', 'uktw_admin_actions');
//==============================================================================
//
// This section produces a draggable widget with options in admin and on screen
//
add_action( 'widgets_init', 'uktw_load_widgets' );
function uktw_load_widgets() {
	register_widget( 'UKTW_Widget' );
}
class UKTW_Widget extends WP_Widget {
	function UKTW_Widget() {
		$widget_ops = array( 'classname' => 'uktw', 'description' => __('An example UKTW widget', 'uktw') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'uktw-widget' );
		$this->WP_Widget( 'uktw-widget', __('UKTW Widget', 'uktw'), $widget_ops, $control_ops );
	}
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title'] );
		$qtix = $instance['qtix'];
		$content = $instance['content'];
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$affiliate = get_option( 'uktw_affiliate' );
		if( $affiliate != "" ) { $afftag = "afftag=" . urlencode( $affiliate ) . "&"; } else { $afftag = ""; }
		if ( $content == "toplondon" ){
			$info=wp_remote_get('https://www.uktw.co.uk/modpop_wp.php?act=TOPL');
			_e("<div align='center'>".$info['body']."</div>");
		} elseif ( $content == "topregional" ){
			$info=wp_remote_get('https://www.uktw.co.uk/modpop_wp.php?act=TOPR');
			_e("<div align='center'>".$info['body']."</div>");
		} elseif ( $content == "single" && $qtix ){
			$info=wp_remote_get('https://www.uktw.co.uk/modpop_wp.php?act='.$content.'&qtix='.$qtix);
			_e("<div align='center'>".$info['body']."<br/>Details coming soon ...</div>");
		} elseif ( $content == "search" && $qtix ){
			?>
			<form method="post" target="uktw" action="https://www.uktw.co.uk/search/" >
			<input type="hidden" name="action" value="search" />
			<input type="hidden" name="afftag" value="<?php __( $affiliate ); ?>" />
			<table style="border:1px solid silver;padding:2px;"><tr>
			<td valign="middle"><input type="text" name="what" style="width:120px;" /></td>
			<td valign="middle"><input type="submit" value="Search" /></td></tr></table></form>
			<?php
		}
		echo $after_widget;
	}
	function update( $new_instance, $old_instance) {        
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['qtix'] = strip_tags( $new_instance['qtix'] );
		$instance['content'] = $new_instance['content'];
		return $instance;
	}
	function form( $instance ) {
		$defaults = array( 'title' => __('UK Theatre Web'), 'qtix' => __('L327', 'uktw'), 'content' => 'toplondon' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Widget Title:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Format: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Content:'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'single' == $instance['content'] ) echo 'selected="selected"'; ?> value="single">Single Show/Venue/Tour (Qtix)</option>
				<option <?php if ( 'toplondon' == $instance['content'] ) echo 'selected="selected"'; ?> value="toplondon">Top London Shows</option>
				<option <?php if ( 'topregional' == $instance['content'] ) echo 'selected="selected"'; ?> value="topregional">Top Regional Shows</option>
				<option <?php if ( 'search' == $instance['content'] ) echo 'selected="selected"'; ?> value="search">Search box</option>
			</select>
		</p>
		<!-- Your Name: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'qtix' ); ?>"><?php _e('Qtix/Key/Town:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'qtix' ); ?>" name="<?php echo $this->get_field_name( 'qtix' ); ?>" value="<?php echo $instance['qtix']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
//==============================================================================
//
// This section handles the shortcode
//
function uktw_shortcode ( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'qtix' => '',
		'format' => '', // search, title, bio, image, ??
		'key' => '', // search key
		), $atts ) );
	$text="";
	if( $content =='' ){
		if( $atts['qtix'] != ""){
			$info=wp_remote_get('https://www.uktw.co.uk/modpop_wp.php?act=SCTI&qtix='.$atts['qtix']);
			$inner=$info['body'];
		}else{
			$inner="UK Theatre Web";
		}
	} else {
		$inner = $content;
	}
	$affiliate = urlencode(get_option( 'uktw_affiliate' ));
	if( $affiliate != "" ) {$affiliate="afftag=$affiliate&";}
	switch(strtolower($atts['format'])) {
		case 'title' :
			$text.="<a href=\"http://qtix.info/".$atts['qtix']."/\" target=\"uktw\">$inner</a>";
			break;
		case 'image' :
			$info=wp_remote_get('https://www.uktw.co.uk/modpop_wp.php?act=SCIM&qtix='.$atts['qtix']);
			$inner="<img src=\"".$info['body']."\" width=\"100\" height=\"150\" border=\"0\" alt=\"$inner\" />";
			$text.="<a href=\"http://qtix.info/".$atts['qtix']."/\" target=\"uktw\">$inner</a>";
			break;
		case 'bio' :
			$text.="<a href=\"https://www.uktw.co.uk/biog/".urlencode($inner)."\" target=\"uktw\">$inner</a>";
			break;
		case 'search' :
			if( $atts['key'] != "" ){ $key = $atts['key']; }else{ $key = $inner; }
			$text.="<a href=\"https://www.uktw.co.uk/search/?$affiliate"."action=search&what=".urlencode($key)."\" target=\"uktw\">$inner</a>";
			break;
		case 'town' :
			if( $atts['key'] != "" ){ $key = $atts['key']; }else{ $key = $inner; }
			$text.="<a href=\"https://www.uktw.co.uk/search/?$affiliate"."action=search&place=".urlencode($key)."\" target=\"uktw\">$inner</a>";
			break;
		default:
			$text.=$inner;
			break;
	}
	return $text;
}
add_shortcode( 'uktw', 'uktw_shortcode' );
//==============================================================================
//
// This section makes template tags available
//
function uktw_qtix_tag( $qtix, $content = "title" ) {
	$text = "";
	$qtix = strtoupper( trim( $qtix ) );
	if( preg_match( "/^[LTSV][0-9]+$/", $qtix ) ){
		if( $content == "title" ){
			$info = wp_remote_get( 'https://www.uktw.co.uk/modpop_wp.php?act=SCTI&qtix=' . $atts['qtix'] );
			$text = $info['body'];
		}elseif( $content == "link" ){
			$text = "http://qtix.info/$qtix/";
		}
	}
	return $text;
}
