<?php
/**
 * Disable Comments by Referer
 *
 * @package   DisableCommentsByReferer
 * @author    Kat Hagan <kat@codebykat.com>
 * @license   GPL-2.0+
 * @link      http://codebykat.wordpress.com
 * @copyright 2013 Kat Hagan
 *
 * @wordpress-plugin
 * Plugin Name: Disable Comments by Referer
 * Description: Ban visitors from certain sites from viewing or adding comments.
 * Version: 0.1
 * Author: Kat Hagan
 * Author URI:  http://profiles.wordpress.org/codebykat
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*  Copyright 2013  Kat Hagan  (email : kat@codebykat.com)

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
*/

// Some code borrowed / modified from Disable Comments: http://wordpress.org/plugins/disable-comments/
class Disable_Comments_By_Referer {

	function __construct() {
		add_action( 'widgets_init', array( $this, 'disable_rc_widget' ) );
		add_action( 'wp_loaded', array( $this, 'add_filters' ) );
	}

	function disable_rc_widget() {
		unregister_widget( 'WP_Widget_Recent_Comments' );
	}

	function add_filters() {
		if ( ! is_admin() ) {
			add_filter( 'comments_template', array( $this, 'dummy_comments_template' ), 20 );
		}
	}

	function dummy_comments_template() {
		$referer = wp_get_referer();
		if ( ! $referer ) { return; }

		$host = parse_url( $referer, PHP_URL_HOST );

		$option = get_option( 'referer_blacklist_blocked_sites' );
		if ( ! $option ) { return; }

		$blocked_hosts = explode( ',', $option );
		$blocked_hosts = array_map( 'trim', $blocked_hosts );

		if ( in_array( $host, $blocked_hosts ) ) {
			// Kill the comments template. This will deal with themes that don't check comment stati properly!
			return plugin_dir_path( __FILE__ ) . 'comments-template.php';
		}
	}

}

new Disable_Comments_By_Referer();

if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'disable-comments-by-referer-admin.php' );
}