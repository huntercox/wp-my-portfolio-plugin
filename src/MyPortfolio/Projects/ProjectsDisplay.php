<?php

namespace MyPortfolio\Projects;

class ProjectsDisplay
{
	public function __construct()
	{
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
		$color_value = get_post_meta($post->ID, '_project_color_meta_key', true);
		$text_value = get_post_meta($post->ID, '_project_text_meta_key', true);
		$textarea_value = get_post_meta($post->ID, '_project_textarea_meta_key', true);
		$checkbox_value = get_post_meta($post->ID, '_project_checkbox_meta_key', true);
		$radio_value = get_post_meta($post->ID, '_project_radio_meta_key', true);

		// Color select field
		echo <<<HTML

		<div class="project-meta-field field--color-select">
		<label for="project_color_field">Color:</label>
		<select id="project_color_field" name="project_color_field">
		<option value="red">Red</option>
		<option value="blue">Blue</option>
		<option value="green">Green</option>
		</select>
		</div>
HTML;
		// Text field
		$text_value = esc_attr($text_value);

		echo <<<HTML
		<div class="project-meta-field field--text-input">
			<label for="project_text_field">
				Text Field: <br/>
				<input type="text" id="project_text_field" name="project_text_field" value="$text_value">
			</label>
		</div>
HTML;

		// Textarea field
		$textarea_value = esc_textarea($textarea_value);
		echo <<<HTML
		<div class="project-meta-field field--textarea">
			<label for="project_textarea_field">
				Textarea Field: <br/>
				<textarea id="project_textarea_field" name="project_textarea_field">$textarea_value</textarea>
			</label>
		</div>
HTML;


		// Checkbox field
		$checkbox_value = checked($checkbox_value, 'yes', false);
		echo <<<HTML
		<div class="project-meta-field field--checkboxes">
			<label for="project_checkbox_field">
				Checkbox Field: <br/>
				<input type="checkbox" id="project_checkbox_field" name="project_checkbox_field" value="yes" $checkbox_value>
			</label>
		</div>
HTML;


		// Radio field
		$radio_option1 = checked($radio_value, 'option1', false);
		$radio_option2 = checked($radio_value, 'option2', false);

		echo <<<HTML
		<div class="project-meta-field field--radio-btns">
			<fieldset>
			Radio Fields: <br/>
				<label>
					<input type="radio" id="project_radio_field_1" name="project_radio_field" value="option1" $radio_option1>
					Option 1
				</label>
				<label>
					<input type="radio" id="project_radio_field_2" name="project_radio_field" value="option2" $radio_option2>
					Option 2
				</label>
			</fieldset>
		</div>
HTML;
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

		/*  */

		// Sanitize and save form field data
		if (isset($_POST['project_color_field'])) {
			$color_data = sanitize_text_field($_POST['project_color_field']);
			update_post_meta($post_id, '_project_color_meta_key', $color_data);
		}

		if (isset($_POST['project_text_field'])) {
			$text_data = sanitize_text_field($_POST['project_text_field']);
			update_post_meta($post_id, '_project_text_meta_key', $text_data);
		}

		if (isset($_POST['project_textarea_field'])) {
			$textarea_data = sanitize_textarea_field($_POST['project_textarea_field']);
			update_post_meta($post_id, '_project_textarea_meta_key', $textarea_data);
		}

		if (isset($_POST['project_checkbox_field'])) {
			$checkbox_data = $_POST['project_checkbox_field'] === 'yes' ? 'yes' : 'no';
			update_post_meta($post_id, '_project_checkbox_meta_key', $checkbox_data);
		}

		if (isset($_POST['project_radio_field'])) {
			$radio_data = sanitize_text_field($_POST['project_radio_field']);
			update_post_meta($post_id, '_project_radio_meta_key', $radio_data);
		}
	}
}
