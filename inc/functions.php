<?php

namespace MyPortfolio;

function output_project_employer($project_id)
{
	$id = $project_id;

	$employer = get_post_meta($id, '_project_employer_meta_key', true);

	if ($employer) {
		echo <<<HTML
		<div class="project-employer">
			<h3>Employer</h3>
			<p>$employer</p>
		HTML;
	}
}

function output_all_projects()
{

	// check if post type "project" exists
	// if it does, get all posts of type "project"

	if (!post_type_exists('project')) {
		return;
	}

	$args = array(
		'post_type' => 'project',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'orderby' => 'menu_order'
	);

	$projects = new \WP_Query($args);

	if ($projects->have_posts()) {
		while ($projects->have_posts()) {
			$projects->the_post();
			$id = get_the_ID();
			$employer = get_post_meta($id, '_project_employer_meta_key', true);
			$employer = esc_attr($employer);
			$employer = esc_html($employer);
			$employer = wp_kses_post($employer);
			$employer = wp_kses($employer, array(
				'p' => array(
					'class' => array()
				),
				'strong' => array(),
				'em' => array(),
				'br' => array(),
				'ul' => array(),
				'li' => array(),
				'a' => array(
					'href' => array(),
					'title' => array()
				)
			));

			$employer = apply_filters('the_content', $employer);

			echo <<<HTML
			<div class="project-employer">
				<h3>Employer</h3>
				$employer
			</div>
			HTML;
		}
	}
	wp_reset_postdata();
}
