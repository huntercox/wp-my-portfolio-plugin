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


		// Output project description field
		$this->projectsMetaFields->project_description_textarea_field($post);

		// Output employer field
		$this->projectsMetaFields->employer_select_field($post);

		$this->projectsMetaFields->project_url_text_field($post);

		$this->projectsMetaFields->repeatable_text_fields($post);
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
		if (isset($_POST['project_description_textarea_field'])) {
			$textarea_data = sanitize_text_field($_POST['project_description_textarea_field']);
			update_post_meta($post_id, '_project_description_meta_key', $textarea_data);
		}

		if (isset($_POST['project_employer_field'])) {
			$text_data = sanitize_text_field($_POST['project_employer_field']);
			update_post_meta($post_id, '_project_employer_meta_key', $text_data);
		}

		if (isset($_POST['project_url_text_field'])) {
			$url_data = sanitize_url($_POST['project_url_text_field']);
			update_post_meta($post_id, '_project_url_meta_key', $url_data);
		}

		if (isset($_POST['project_link_status'])) {
			$text_data = sanitize_text_field($_POST['project_link_status']);
			update_post_meta($post_id, '_project_link_status_meta_key', $text_data);
		}

		// Repeatable fields
		if (isset($_POST['repeatable_text_field'])) {
			$repeatable_text_field = $_POST['repeatable_text_field'];
			update_post_meta($post_id, '_repeatable_text_field_meta_key', $repeatable_text_field);
		}
	}
}
