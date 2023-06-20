<?php

namespace MyPortfolio\AdminPages;

class PortfolioPostType
{
	public function __construct()
	{
		add_action('init', [$this, 'register_portfolio_post_type']);
	}

	public function register_portfolio_post_type()
	{
		$labels = [
			'name'               => _x('Portfolios', 'post type general name', 'your-plugin-textdomain'),
			'singular_name'      => _x('Item', 'post type singular name', 'your-plugin-textdomain'),
			'menu_name'          => _x('Portfolios', 'admin menu', 'your-plugin-textdomain'),
			'name_admin_bar'     => _x('Item', 'add new on admin bar', 'your-plugin-textdomain'),
			'add_new'            => _x('Add New', 'item', 'your-plugin-textdomain'),
			'add_new_item'       => __('Add New Item', 'your-plugin-textdomain'),
			'new_item'           => __('New Item', 'your-plugin-textdomain'),
			'edit_item'          => __('Edit Item', 'your-plugin-textdomain'),
			'view_item'          => __('View Item', 'your-plugin-textdomain'),
			'all_items'          => __('All Items', 'your-plugin-textdomain'),
			'search_items'       => __('Search Portfolios', 'your-plugin-textdomain'),
			'parent_item_colon'  => __('Parent Portfolios:', 'your-plugin-textdomain'),
			'not_found'          => __('No portfolios found.', 'your-plugin-textdomain'),
			'not_found_in_trash' => __('No portfolios found in Trash.', 'your-plugin-textdomain')
		];

		$args = [
			'labels'             => $labels,
			'description'        => __('Description.', 'your-plugin-textdomain'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'my-portfolio-menu-page',  // This makes it a subpage of your main menu
			'query_var'          => true,
			'rewrite'            => ['slug' => 'portfolio'],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments']
		];

		register_post_type('portfolio', $args);
	}
}
