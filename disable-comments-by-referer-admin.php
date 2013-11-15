<?php

function referer_blacklist_settings_init() {
	/* Settings API */
	add_settings_section(
		'referer_blacklist_setting_section',
		'Referer Blacklist for Comments',
		'referer_blacklist_section_callback_function',
		'discussion'
	);
	
	add_settings_field(
		'referer_blacklist_blocked_sites',
		'Referer Blacklist',
		'referer_blacklist_callback_function',
		'discussion',
		'referer_blacklist_setting_section'
	);
	
	register_setting( 'discussion', 'referer_blacklist_blocked_sites', 'referer_blacklist_sanitize' );

	/* Add settings link to plugin page */
	$plugin_file = 'disable-comments-by-referer/disable-comments-by-referer.php';
	add_filter( 'plugin_action_links_' . $plugin_file, 'referer_blacklist_action_links' );
}

add_action( 'admin_init', 'referer_blacklist_settings_init' );

function referer_blacklist_action_links( $links ) {
	$links[] = '<a href="'. get_admin_url(null, 'options-discussion.php#referer-blacklist') .'">Settings</a>';
	return $links;
}

function referer_blacklist_section_callback_function() {
	echo '<a name="referer-blacklist"></a>';
	echo '<p>Add hostnames to the list to disable comments when anyone lands on your page from those sites.</p>';
	echo '<p>This should be a comma-separated list of bare hostnames, ex: <code>www.reddit.com, news.ycombinator.com</code>.';
}

function referer_blacklist_callback_function() {
	$value = get_option( 'referer_blacklist_blocked_sites' );
	if ( ! $value ) { $value = ''; }
	echo '<textarea name="referer_blacklist_blocked_sites" id="referer_blacklist_blocked_sites" placeholder="www.reddit.com, news.ycombinator.com" cols="40" rows="5">'.esc_textarea( $value ).'</textarea>';
}

function referer_blacklist_sanitize( $input ) {
	$sites = $input['referer_blacklist_blocked_sites'];
	if ( ! $sites ) { return $input; }

	$sites = sanitize_text_field( $sites );
	$input['referer_blacklist_blocked_sites'] = $sites;
	return $input;
}