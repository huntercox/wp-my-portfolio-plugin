<?php

namespace MyPortfolio\Projects;

class ProjectsAPIHandler
{
	public function __construct()
	{
		// Add a filter that applies our custom function to 'the_content' for the 'projects' page
		add_filter('the_content', [$this, 'render_project_list']);
	}

	public function render_project_list($content)
	{
		// We only want to modify the content for the 'projects' page
		if (is_page('projects')) {
			// Fetch projects from the API
			$response = wp_remote_get('http://plugin-testing.local/wp-json/myportfolio/v1/projects');

			// Check for errors
			if (is_wp_error($response)) {
				return '<p>Error fetching projects.</p>';
			}

			// Parse the API response
			$projects = json_decode(wp_remote_retrieve_body($response), true);

			// Check for errors
			if (empty($projects)) {
				return '<p>No projects found.</p>';
			}

			// Generate the HTML for the project list
			$projectListHtml = '<ul>';
			foreach ($projects as $project) {
				$projectListHtml .= '<li>' . esc_html($project['title']) . '</li>'; // replace 'name' with the actual name field key
			}
			$projectListHtml .= '</ul>';

			// Return the HTML
			return $content . $projectListHtml;
		}

		// For other pages, return the content unchanged
		return $content;
	}
}
