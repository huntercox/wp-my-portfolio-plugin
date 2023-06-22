<?php

namespace MyPortfolio\Projects;

class ProjectsMetaFields
{
	public function __construct()
	{
		add_action('init', [$this, 'register_meta_fields']);
	}

	public function register_meta_fields()
	{
		register_meta('post', 'project_url', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);
		register_meta('post', 'project_color_field', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);

		register_meta('post', 'project_text_field', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);
	}

	// Add the field output methods from the ProjectsDisplay class here
	public function color_select_field($post)
	{
		// Color select field
		$color_value = get_post_meta($post->ID, '_project_color_meta_key', true);
		$red = selected($color_value, 'red', false);
		$blue = selected($color_value, 'blue', false);
		$green = selected($color_value, 'green', false);

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
	}

	public function text_input_field($post)
	{
		// Text field
		$text_value = get_post_meta($post->ID, '_project_text_meta_key', true);
		$text_value = esc_attr($text_value);

		echo <<<HTML
		<div class="project-meta-field field--text-input">
			<label for="project_text_field">
				Text Field: <br/>
				<input type="text" id="project_text_field" name="project_text_field" value="$text_value">
			</label>
		</div>
HTML;
	}
}
