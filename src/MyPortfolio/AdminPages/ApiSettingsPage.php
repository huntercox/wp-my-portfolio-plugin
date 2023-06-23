<?php

namespace MyPortfolio\AdminPages;

class ApiSettingsPage
{
	public function __construct()
	{
		add_action('admin_menu', [$this, 'add_api_settings_page']);
		add_action('admin_init', [$this, 'setup_settings_sections_and_fields']);
	}

	public function add_api_settings_page()
	{
		add_submenu_page(
			'my-portfolio-menu-page',
			'API Settings',
			'API Settings',
			'manage_options',
			'my-portfolio-api-settings',
			[$this, 'render_api_settings_page']
		);
	}

	public function render_api_settings_page()
	{
?>
		<div class="wrap">
			<h1>API Settings</h1>
			<form method="POST" action="options.php">
				<?php
				settings_fields('api_settings');
				do_settings_sections('api_settings');
				submit_button();
				?>
			</form>
		</div>
	<?php
	}

	public function setup_settings_sections_and_fields()
	{
		add_settings_section('api_settings_section', 'API Settings Section', null, 'api_settings');

		add_settings_field(
			'expose_api',
			'Project Details',
			[$this, 'render_expose_api_field'],
			'api_settings',
			'api_settings_section'
		);

		register_setting('api_settings', 'expose_api', [$this, 'sanitize_checkbox']);
	}

	public function render_expose_api_field()
	{
		// get the value of the setting we've registered with register_setting()
		$setting = get_option('expose_api');
	?>
		<label for="expose_api">
			Expose API
			<input type="checkbox" name="expose_api" value="on" <?php checked($setting, 'on'); ?> />
		</label>
		<?php
		if ($setting === 'on') {
			$url = get_site_url() . '/wp-json/myportfolio/v1/projects';
		?>
			<a href="<?php echo esc_url($url); ?>" target="_blank">View Endpoint</a>
		<?php
		} else {
			// no link
		}
		?>

<?php
	}

	public function sanitize_checkbox($input)
	{
		// if checkbox is set to 'on', return 'on'. Otherwise, return 'off'
		return isset($input) && $input === 'on' ? 'on' : 'off';
	}
}
