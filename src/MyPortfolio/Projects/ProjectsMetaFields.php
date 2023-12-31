<?php

namespace MyPortfolio\Projects;

class ProjectsMetaFields
{
	public function __construct()
	{
		add_action('init', [$this, 'register_meta_fields']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
	}
	public function enqueue_admin_scripts()
	{
		wp_enqueue_script('contributions-repeater',  MY_PORTFOLIO_PLUGIN_DIR_URL . 'assets/js/contributions-repeater.js', array('jquery'), '1.0.0', true);
	}
	public function register_meta_fields()
	{
		register_meta('project', 'project_description_textarea_field', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);

		// Project Employer
		register_meta('project', 'project_employer_field', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);


		// Project URL
		register_meta('project', 'project_url_text_field', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);
		// Project Link Status
		register_meta('project', 'project_link_status', [
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			}
		]);

		// Repeater fields
		register_meta('project', 'contributions_repeater', [
			'show_in_rest' => [
				'schema' => [
					'type'  => 'array',
					'items' => [
						'type' => 'string',
					],
				],
			],
			'single' => true,
			'type' => 'array',
			'auth_callback' => function () {
				return current_user_can('edit_posts');
			},
			'sanitize_callback' => function ($meta_value, $meta_key, $object_type) {
				return array_map('sanitize_text_field', $meta_value);
			}
		]);

		// Project Date
		register_meta('project', 'project_date_field', [
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


	public function project_url_text_field($post)
	{
		// Project URL: text field
		$url_value = get_post_meta($post->ID, '_project_url_meta_key', true);
		$url_value = esc_attr($url_value);
		$link_status = get_post_meta($post->ID, '_project_link_status_meta_key', true);

		$live_link_selected = checked('live-link', $link_status, false);
		$archived_selected = checked('archived', $link_status, false);

		echo <<<HTML
			<div class="project-meta-field field--text-input">
				<label for="project_url_text_field">
					Project URL: <br/>
					<input type="text" id="project_url_text_field" name="project_url_text_field" value="$url_value" style="width: 100%;" />
				</label>
				<fieldset>
					<label>
						<input type="radio" name="project_link_status" value="live-link" $live_link_selected>
						Live Link
					</label>
					<label>
						<input type="radio" name="project_link_status" value="archived" $archived_selected>
						Archived
					</label>
				</fieldset>
			</div>
		HTML;
	}


	public function contributions_repeater($post)
	{
		$contributions_fields = get_post_meta($post->ID, '_contributions_repeater_meta_key', true);


		if ($contributions_fields) {

			echo <<<HTML
			<div class="repeatable-field-data">
				<h4>Project Contributions</h4>
				<table>
					<thead></thead>
						<tr>
							<th>Contribution</th>
						</tr>
					</thead>
					<tbody>
			HTML;

			if ($contributions_fields) {
				foreach ($contributions_fields as $field) {
					$field_value = esc_html($field);
					echo <<<HTML
					<tr>
						<td>$field_value</td>
					</tr>
				HTML;
				}
			}
			echo <<<HTML
						</tr>
					</tbody>
				</table>
				<hr>
				<p>Use the button below to add more fields.</p>
			</div>
			HTML;
		}
		echo <<<HTML
		<div id="repeatable-fieldset-one-wrapper">
		<ul id="repeatable-fieldset-one">
		HTML;
		if ($contributions_fields) {
			$i = 0;
			foreach ($contributions_fields as $field) {
				$i++;
				$field_value = esc_attr($field);
				echo <<<HTML
				<li class="added-$i" style="display: flex;">
					<textarea name="contributions_repeater[]" value="$field_value" style="width: 100%;" rows="3">$field_value</textarea>
					<button class="remove-row button">Remove</button>
				</li>
				HTML;
			}
		} else {
			echo <<<HTML
			<li class="default">
				<textarea name="contributions_repeater[]" value="" style="width: 100%;" rows="3"></textarea>
				<button class="remove-row button">Remove</button>
			</li>
			HTML;
		}
		echo <<<HTML
			<li style="display: none;" class="empty-row">
				<textarea name="contributions_repeater[]" value="" style="width: 100%;" rows="3"></textarea>
				<button class="remove-row button">Remove</button>
			</li>
		</ul>
		<p>Click the blue "Update" button to save your value, or click "Add another" to create another input for before saving.</p>
		<button id="add-row" class="button">Add Contribution</button>
		</div>
		HTML;
	}

	public function project_date_field($post)
	{
		// Project Date: text field
		$date_value = get_post_meta($post->ID, '_project_date_meta_key', true);
		$date_value = esc_attr($date_value);

		echo <<<HTML
		<div class="project-meta-field field--text-input">
			<label for="project_date_field">
				Project Date: <br/>
				<input type="text" id="project_date_field" name="project_date_field" value="$date_value" style="width: 100%;" />
			</label>
		</div>
		HTML;
	}
}
