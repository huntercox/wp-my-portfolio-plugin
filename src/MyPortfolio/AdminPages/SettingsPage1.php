<?php

namespace MyPortfolio\AdminPages;

class SettingsPage1
{
	public function __construct()
	{
		add_action('admin_menu', [$this, 'add_settings_page']);
	}
	public function add_settings_page()
	{
		add_submenu_page(
			'my-portfolio-menu-page',  // Parent menu slug
			'My Portfolio Settings 1', // Page title
			'My Portfolio 1',          // Menu title
			'manage_options',          // Capability
			'my-portfolio-settings-1', // Menu slug
			[$this, 'render_settings_page'] // Callback function
		);
	}

	public function render_settings_page()
	{
		// Output the HTML for the settings page here.
		echo 'This is the My Portfolio settings page 1.';
	}
}
