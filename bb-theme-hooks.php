<?php
/*
Plugin Name: Beaver Builder Theme Visual Hook Guide
Plugin URI: https://wpbeaveraddons.com/
Description: Find Beaver Builder (BB) Theme  Hooks quick and easily by seeing their actual locations inside your theme.
Version: 1.0.0
Author: Beaver Addons
Author URI: https://wpbeaveraddons.com/
License: GPLv2 or later
*/

/*
Credits:
This plugin is based on Christopher Cochran's Genesis Visual Hook Guide plugin
which is licensed under GPL V2.
You can read more about Christopher at http://christophercochran.me
*/

register_activation_hook(__FILE__, 'bbtvhg_activation_check');
function bbtvhg_activation_check() {

	    $theme_info = wp_get_theme();
		$bbtheme_flavors = array(
			'bb-theme',
			'beaver-builder-theme',
		);

        if ( ! in_array( $theme_info->Template, $bbtheme_flavors ) ) {
            deactivate_plugins( plugin_basename(__FILE__) ); // Deactivate ourself
	        wp_die('Sorry, you can\'t activate unless you have installed <a href="https://www.wpbeaverbuilder.com/wordpress-framework-theme/">Beaver Builder (BB) Theme</a>');
        }
}

add_action( 'admin_bar_menu', 'bbtvhg_admin_bar_links', 100 );
function bbtvhg_admin_bar_links() {
global $wp_admin_bar;

	if ( is_admin() )
		return;

	$wp_admin_bar->add_menu(
		array(
			'id' => 'bbthemehooks',
			'title' => __( 'BB Hook Guide', 'bbthemevisualhookguide' ),
			'href' => '',
			'position' => 0,
		)
	);
	$wp_admin_bar->add_menu(
		array(
			'id'	   => 'bbthemehooks_action',
			'parent'   => 'bbthemehooks',
			'title'    => __( 'Action Hooks', 'bbthemevisualhookguide' ),
			'href'     => add_query_arg( 'bbtheme_hooks', 'show' ),
			'position' => 10,
		)
	);
	$wp_admin_bar->add_menu(
		array(
			'id'	   => 'bbthemehooks_clear',
			'parent'   => 'bbthemehooks',
			'title'    => __( 'Clear', 'bbthemevisualhookguide' ),
			'href'     => remove_query_arg(
				array(
					'bbtheme_hooks',
					'bbtheme_filters',
					'bbtheme_markup',
				)
			),
			'position' => 10,
		)
	);

}

add_action('wp_enqueue_scripts', 'bbtvhbbtheme_hooks_stylesheet');
function bbtvhbbtheme_hooks_stylesheet() {

	 $bbtvhg_plugin_url = plugins_url() . '/bb-theme-visual-hook-guide/';

	 if ( 'show' == isset( $_GET['bbtheme_hooks'] ) )
	 	wp_enqueue_style( 'bbtvhg_styles', $bbtvhg_plugin_url . 'styles.css' );

	 if ( 'show' == isset( $_GET['bbtheme_filters'] ) )
	 	wp_enqueue_style( 'bbtvhg_styles', $bbtvhg_plugin_url . 'styles.css' );

     if ( 'show' == isset( $_GET['bbtheme_markup'] ) )
     	wp_enqueue_style( 'bbtvhbbtheme_markup_styles', $bbtvhg_plugin_url . 'markup.css' );

}


add_action('get_header', 'bbtvhg_hooker' );
function bbtvhg_hooker() {
global $bbtvhg_action_hooks;

	 if ( !('show' == isset( $_GET['bbtheme_hooks'] ) ) && !('show' == isset( $_GET['bbtheme_filters'] ) ) && !('show' == isset( $_GET['bbtheme_markup'] ) ) ) {
		 return;  // BAIL without hooking into anyhting if not displaying anything
	 }

	$bbtvhg_action_hooks = array(

			'fl_head_open' => array(
				'hook' => 'fl_head_open',
				'area' => 'Document Head',
				'description' => 'Fires after the opening <head> tag.',
				'functions' => array(),
				),
			'fl_head' => array(
				'hook' => 'fl_head',
				'area' => 'Document Head',
				'description' => 'Use this action if you need to load something after Beaver Builder styles.',
				'functions' => array(),
				),
			'fl_body_open' => array(
				'hook' => 'fl_body_open',
				'area' => 'Structural',
				'description' => 'This hook executes after the opening <body> tag',
				'functions' => array(),
				),
			'fl_page_open' => array(
				'hook' => 'fl_page_open',
				'area' => 'Structural',
				'description' => 'Fires after the opening fl-page DIV tag.',
				'functions' => array(),
				),
			'fl_before_top_bar' => array(
				'hook' => 'fl_before_top_bar',
				'area' => 'Structural',
				'description' => 'Fires before the opening top bar DIV tag.',
				'functions' => array(),
				),
			'fl_top_bar_col1_open' => array(
				'hook' => 'fl_top_bar_col1_open',
				'area' => 'Structural',
				'description' => 'Fires at the beginning of the first top bar column.',
				'functions' => array(),
				),
			'fl_top_bar_col1_close' => array(
				'hook' => 'fl_top_bar_col1_close',
				'area' => 'Structural',
				'description' => 'Fires at the end of the first top bar column.',
				'functions' => array(),
				),
			'fl_top_bar_col2_open' => array(
				'hook' => 'fl_top_bar_col2_open',
				'area' => 'Structural',
				'description' => 'Fires at the beginning of the second top bar column.',
				),
			'fl_top_bar_col2_close' => array(
				'hook' => 'fl_top_bar_col2_close',
				'area' => 'Structural',
				'description' => 'Fires at the end of the second top bar column.',
				'functions' => array(),
				),
			'fl_after_top_bar' => array(
				'hook' => 'fl_after_top_bar',
				'area' => 'Structural',
				'description' => 'Fires after the closing top bar DIV tag.',
				'functions' => array(),
				),
			'fl_before_header' => array(
				'hook' => 'fl_before_header',
				'area' => 'Structural',
				'description' => 'Fires before the opening header DIV tag.',
				'functions' => array(),
				),
			'fl_header_content_open' => array(
				'hook' => 'fl_header_content_open',
				'area' => 'Structural',
				'description' => 'Fires at the beginning of the header content section that is available in the Nav Bottom header layout.',
				'functions' => array(),
				),
			'fl_header_content_close' => array(
				'hook' => 'fl_header_content_close',
				'area' => 'Structural',
				'description' => 'Fires at the end of the header content section that is available in the Nav Bottom header layout.',
				'functions' => array(),
				),
			'fl_after_header' => array(
				'hook' => 'fl_after_header',
				'area' => 'Structural',
				'description' => 'Fires after the closing header DIV tag.',
				'functions' => array(),
				),
			'fl_before_content' => array(
				'hook' => 'fl_before_content',
				'area' => 'Loop',
				'description' => 'Fires before the opening content DIV tag.',
				'functions' => array(),
				),
			'fl_content_open' => array(
				'hook' => 'fl_content_open',
				'area' => 'Loop',
				'description' => 'Fires after the opening content DIV tag',
				'functions' => array(),
				),
			'fl_post_top_meta_open' => array(
				'hook' => 'fl_post_top_meta_open',
				'area' => 'Loop',
				'description' => 'Fires at the beginning of the top post meta section.',
				'functions' => array(),
				),
			'fl_post_top_meta_close' => array(
				'hook' => 'fl_post_top_meta_close',
				'area' => 'Loop',
				'description' => 'Fires at the end of the top post meta section.',
				'functions' => array(),
				),
			'fl_post_bottom_meta_open' => array(
				'hook' => 'fl_post_bottom_meta_open',
				'area' => 'Loop',
				'description' => 'Fires at the beginning of the bottom post meta section.',
				'functions' => array(),
				),
			'fl_post_bottom_meta_close' => array(
				'hook' => 'fl_post_bottom_meta_close',
				'area' => 'Loop',
				'description' => 'Fires at the end of the bottom post meta section.',
				'functions' => array(),
				),
			'fl_comments_open' => array(
				'hook' => 'fl_comments_open',
				'area' => 'Comment',
				'description' => 'Fires after the opening fl-comments DIV tag.',
				'functions' => array(),
				),
			'fl_comments_close' => array(
				'hook' => 'fl_comments_close',
				'area' => 'Comment',
				'description' => 'Fires before the closing fl-comments DIV tag.',
				'functions' => array(),
				),
			'fl_sidebar_open' => array(
				'hook' => 'fl_sidebar_open',
				'area' => 'Structural',
				'description' => 'Fires after the opening fl-sidebar DIV tag.',
				'functions' => array(),
				),
			'fl_sidebar_close' => array(
				'hook' => 'fl_sidebar_close',
				'area' => 'Structural',
				'description' => 'Fires before the closing fl-sidebar  DIV tag.',
				'functions' => array(),
				),
			'fl_content_close' => array(
				'hook' => 'fl_content_close',
				'area' => 'Structural',
				'description' => 'Fires before the closing content DIV tag.',
				'functions' => array(),
				),
			'fl_after_content' => array(
				'hook' => 'fl_after_content',
				'area' => 'Structural',
				'description' => 'Fires after the closing content  DIV tag.',
				'functions' => array(),
				),
			'fl_footer_wrap_open' => array(
				'hook' => 'fl_footer_wrap_open',
				'area' => 'Structural',
				'description' => 'Fires after the opening footer wrap DIV tag.',
				'functions' => array(),
				),
			'fl_before_footer_widgets' => array(
				'hook' => 'fl_before_footer_widgets',
				'area' => 'Structural',
				'description' => 'Fires before the opening footer widgets DIV tag.',
				'functions' => array(),
				),
			'fl_after_footer_widgets' => array(
				'hook' => 'fl_after_footer_widgets',
				'area' => 'Structural',
				'description' => 'Fires after the closing footer widgets DIV tag.',
				'functions' => array(),
				),
			'fl_before_footer' => array(
				'hook' => 'fl_before_footer',
				'area' => 'Structural',
				'description' => 'Fires before the opening footer DIV tag.',
				'functions' => array(),
				),
			'fl_after_footer' => array(
				'hook' => 'fl_after_footer',
				'area' => 'Structural',
				'description' => 'Fires after the closing footer DIV tag.',
				'functions' => array(),
				),
			'fl_footer_col1_open' => array(
				'hook' => 'fl_footer_col1_open',
				'area' => 'Structural',
				'description' => 'Fires at the beginning of the first footer column.',
				'functions' => array(),
				),
			'fl_footer_col1_close' => array(
				'hook' => 'fl_footer_col1_close',
				'area' => 'Structural',
				'description' => 'Fires at the end of the first footer column.',
				'functions' => array(),
				),
			'fl_footer_col2_open' => array(
				'hook' => 'fl_footer_col2_open',
				'area' => 'Structural',
				'description' => 'Fires at the beginning of the second footer column.',
				'functions' => array(),
				),
			'fl_footer_col2_close' => array(
				'hook' => 'fl_footer_col2_close',
				'area' => 'Structural',
				'description' => 'Fires at the end of the second footer column.',
				'functions' => array(),
				),
			'fl_footer_wrap_close' => array(
				'hook' => 'fl_footer_col1_open',
				'area' => 'Structural',
				'description' => 'Fires before the closing footer wrap DIV tag.',
				'functions' => array(),
				),
			'fl_page_close' => array(
				'hook' => 'fl_page_close',
				'area' => 'Structural',
				'description' => 'Fires before the closing fl-page DIV tag.',
				'functions' => array(),
				),
			'fl_body_close' => array(
				'hook' => 'fl_body_close',
				'area' => 'Structural',
				'description' => 'Fires before the closing </body> tag.',
				'functions' => array(),
				)
		);

	foreach ( $bbtvhg_action_hooks as $action )
		add_action( $action['hook'] , 'bbtvhg_action_hook' , 1 );
}

function bbtvhg_action_hook () {
global $bbtvhg_action_hooks;

	$current_action = current_filter();

	if ( 'show' == isset( $_GET['bbtheme_hooks'] ) ) {

		if ( 'Document Head' == $bbtvhg_action_hooks[$current_action]['area'] ) :

			echo "<!-- ";
				echo $current_action;
			echo " -->\n";

		else :

			echo '<div class="bbtheme_hook" title="' . $bbtvhg_action_hooks[$current_action]['description'] . '">' . $current_action . ' - ' . $bbtvhg_action_hooks[$current_action]['description']. '</div>';

		endif;
	}

}
