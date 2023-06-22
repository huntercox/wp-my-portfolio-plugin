<?php

namespace MyPortfolio\Projects;

use MyPortfolio\Projects\ProjectsMetaFields;

class ProjectsDisplay
{
	private $projectsMetaFields;
	public function __construct(ProjectsMetaFields $projectsMetaFields)
	{

		$this->projectsMetaFields = $projectsMetaFields;


		// The 'add_meta_boxes' action hook allows you to add meta boxes to the post editing screen.
		add_action('add_meta_boxes', [$this, 'add_custom_meta_boxes']);

		// The 'save_post' action hook allows you to save custom field data when a post is saved.
		add_action('save_post', [$this, 'save_custom_meta_data']);
	}

	public function add_custom_meta_boxes()
	{
		// This function generates a custom meta box.

		// The 'add_meta_box' function adds a meta box to one or several screens.
		// This function takes six parameters:
		// 1) HTML 'id' attribute of the edit screen section
		// 2) Title of the edit screen section
		// 3) Callback function that prints out the HTML for the edit screen section
		// 4) The type of Write screen on which to show the edit screen section
		// 5) The part of the page where the edit screen section should be shown
		// 6) The priority within the context where the boxes should show
		add_meta_box(
			'project_details', // HTML 'id' attribute of the edit screen section
			'Project Details', // Title of the edit screen section
			[$this, 'project_details_callback'], // Callback function
			'project', // The type of Write screen
			'normal', // Part of the page where the box should display
			'high' // Priority
		);
	}

	public function project_details_callback($post)
	{
		// This function outputs the HTML for the meta box.

		// The 'wp_nonce_field' function generates a nonce field.
		// Nonces are used to verify that the requested action is coming from the correct screen.
		wp_nonce_field('project_details_save_data', 'project_details_meta_box_nonce');

		// Retrieve existing values from the database

		$textarea_value = get_post_meta($post->ID, '_project_textarea_meta_key', true);


		// Output color field
		$this->projectsMetaFields->color_select_field($post);

		// Output text field
		$this->projectsMetaFields->text_input_field($post);
	}

	public function save_custom_meta_data($post_id)
	{
		// This function saves the data entered into the form fields.

		// Check if our nonce is set and verify that the nonce is valid.
		if (
			!isset($_POST['project_details_meta_box_nonce']) ||
			!wp_verify_nonce($_POST['project_details_meta_box_nonce'], 'project_details_save_data')
		) {
			return;
		}

		// Check the user's permissions.
		if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return;
			}
		} else {
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
		}

		// Sanitize and save form field data
		if (isset($_POST['project_color_field'])) {
			$color_data = sanitize_text_field($_POST['project_color_field']);
			update_post_meta($post_id, '_project_color_meta_key', $color_data);
		}

		if (isset($_POST['project_text_field'])) {
			$text_data = sanitize_text_field($_POST['project_text_field']);
			update_post_meta($post_id, '_project_text_meta_key', $text_data);
		}
	}
}
