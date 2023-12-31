<?php

namespace MyPortfolio\Projects;

use WP_REST_Response;

class ProjectsPostType
{

	public function __construct()
	{
		// REST API
		add_action('rest_api_init', [$this, 'register_api_endpoints']);

		// Register the Project post type
		add_action('init', [$this, 'register_project_post_type']);

		// Add Projects Menu page
		add_action('admin_menu', [$this, 'add_projects_menu_page']);

		// Add CSS to Admin pages
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
	}

	public function register_project_post_type()
	{
		$labels = [
			'name'               => _x('Projects', 'post type general name', 'hsc-my-portfolio'),
			'singular_name'      => _x('Project', 'post type singular name', 'hsc-my-portfolio'),
			'menu_name'          => _x('Projects', 'admin menu', 'hsc-my-portfolio'),
			'name_admin_bar'     => _x('Project', 'add new on admin bar', 'hsc-my-portfolio'),
			'add_new'            => _x('Add New', 'item', 'hsc-my-portfolio'),
			'add_new_item'       => __('Add New Project', 'hsc-my-portfolio'),
			'new_item'           => __('New Project', 'hsc-my-portfolio'),
			'edit_item'          => __('Edit Project', 'hsc-my-portfolio'),
			'view_item'          => __('View Project', 'hsc-my-portfolio'),
			'all_items'          => __('All Projects', 'hsc-my-portfolio'),
			'search_items'       => __('Search Projects', 'hsc-my-portfolio'),
			'parent_item_colon'  => __('Parent Projects:', 'hsc-my-portfolio'),
			'not_found'          => __('No projects found.', 'hsc-my-portfolio'),
			'not_found_in_trash' => __('No projects found in Trash.', 'hsc-my-portfolio')
		];

		$args = [
			'labels'             => $labels,
			'description'        => __('Description.', 'hsc-my-portfolio'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'my-portfolio-projects-page',
			'query_var'          => true,
			'rewrite'            => ['slug' => 'project'],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => ['title'],
			'show_in_graphql' => true, // This makes the post type available in GraphQL
			'graphql_single_name' => 'project', // name used to reference a single instance of the post type
			'graphql_plural_name' => 'projects', // name used to reference multiple instances of the post type
		];

		register_post_type('project', $args);
	}

	public function add_projects_menu_page()
	{
		add_menu_page(
			'My Projects',
			'Projects',
			'manage_options',
			'my-portfolio-projects-page',
			'', //callback
			'dashicons-format-gallery'
		);
	}

	public function enqueue_admin_scripts()
	{
		wp_enqueue_style('hsc-my-portfolio-admin--projects', MY_PORTFOLIO_PLUGIN_DIR_URL . 'assets/css/admin--projects.css', '1.0.0');
	}

	public function register_api_endpoints()
	{
		// Check if expose_api is checked
		if (get_option('expose_api') !== 'on') {
			return;
		}

		register_rest_route('myportfolio/v1', '/projects', [
			'methods' => 'GET',
			'callback' => [$this, 'get_projects'],
		]);
	}

	public function get_projects()
	{

		$args = [
			'post_type' => 'project',
			'posts_per_page' => -1,
		];
		$posts = get_posts($args);

		$data = [];
		foreach ($posts as $post) {
			$description_value = get_post_meta($post->ID, '_project_description_meta_key', true);
			$employer_value = get_post_meta($post->ID, '_project_employer_meta_key', true);

			$data[] = [
				'id' => $post->ID,
				'title' => $post->post_title,
				'description' => $description_value,
				'employer' => $employer_value,
			];
		}
		return new WP_REST_Response($data, 200);
	}
}
