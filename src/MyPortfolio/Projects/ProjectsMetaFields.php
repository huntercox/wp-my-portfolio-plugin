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

		register_meta('post', 'project_description_textarea_field', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);

		register_meta('post', 'project_employer_field', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);
	}

	public function project_description_textarea_field($post)
	{
		// Project Description: textarea field
		$textarea_value = get_post_meta($post->ID, '_project_description_meta_key', true);
		$textarea_value = esc_attr($textarea_value);

		echo <<<HTML
		<div class="project-meta-field field--text-input">
			<label for="project_description_textarea_field">
				Text Field: <br/>
				<textarea type="text" id="project_description_textarea_field" name="project_description_textarea_field" value="$textarea_value" style="width: 100%;" rows="8">$textarea_value</textarea>
			</label>
		</div>
		HTML;
	}

	public function employer_select_field($post)
	{
		// Employer select field
		$employer_value = get_post_meta($post->ID, '_project_employer_meta_key', true);
		$employer_value = esc_attr($employer_value);
		$snap_creative = selected($employer_value, 'snap-creative', false);
		$irongate_creative = selected($employer_value, 'irongate-creative', false);
		$collective_alternative = selected($employer_value, 'collective-alternative', false);
		$freelance = selected($employer_value, 'freelance', false);
		$datacrunch_corp = selected($employer_value, 'datacrunch-corp', false);
		$fineview_marketing = selected($employer_value, 'fineview-marketing', false);
		$torchlight_hire = selected($employer_value, 'torchlight-hire', false);


		echo <<<HTML
		<div class="project-meta-field field--employer-select">
			<label for="project_employer_field">
				Employer: <br/>
				<select id="project_employer_field" name="project_employer_field">
					<option value="snap-creative" $snap_creative>Snap Creative</option>
					<option value="irongate-creative" $irongate_creative>Irongate Creative</option>
					<option value="collective-alternative" $collective_alternative>Collective Alternative</option>
					<option value="freelance" $freelance>Freelance</option>
					<option value="datacrunch-corp" $datacrunch_corp>DataCrunch Corp</option>
					<option value="fineview-marketing" $fineview_marketing>FineView Marketing</option>
					<option value="torchlight-hire" $torchlight_hire>Torchlight Hire</option>
				</select>
			</label>
		</div>
		HTML;
	}
}
