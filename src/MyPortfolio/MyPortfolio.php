<?php

namespace MyPortfolio;

use MyPortfolio\AdminPages\MenuPage;
use MyPortfolio\AdminPages\ApiSettingsPage;
use MyPortfolio\Projects\ProjectsPostType;
use MyPortfolio\Projects\ProjectsDisplay;

class MyPortfolio
{
	public function __construct()
	{
		new MenuPage();
		new ApiSettingsPage();
		new ProjectsPostType();
		new ProjectsDisplay();

		add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
	}

	public function enqueue_styles()
	{
		wp_enqueue_style('hsc-my-portfolio', MY_PORTFOLIO_PLUGIN_DIR_URL . 'assets/css/my-portfolio-styles.css', '1.0.0');
	}

	public function enqueue_admin_scripts()
	{
		wp_enqueue_script('hsc-my-portfolio-admin', MY_PORTFOLIO_PLUGIN_DIR_URL . 'assets/js/my-portfolio-admin.js', ['jquery'], '1.0.0', true);
	}
}
