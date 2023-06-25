<?php

namespace MyPortfolio\AdminPages;

class MenuPage
{
	public function __construct()
	{
		add_action('admin_menu', [$this, 'add_portfolio_menu_page']);
	}

	public function add_portfolio_menu_page()
	{
		add_menu_page(
			'My Portfolio',
			'My Portfolio',
			'manage_options',
			'my-portfolio-menu-page',
			[$this, 'render_portfolio_menu_page']
		);
	}

	public function render_portfolio_menu_page()
	{
		// Output the HTML for the settings page here.
		echo 'This is the My Portfolio plugin <strong>MENU</strong> page.';
	}
}
