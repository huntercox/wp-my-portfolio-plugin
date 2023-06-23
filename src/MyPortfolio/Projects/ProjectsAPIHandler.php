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
				// return '<p>Error fetching projects.</p>';
				return '<p>' . $response->get_error_message() . '</p>';
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
				$project_id = $project['id'];
				$project_title = $project['title'];
				$project_description = $project['description'];
				$project_employer = $project['employer'];


				$projectListHtml .= '<li><h3>Project</h3>';

				if (!empty($project_id)) {
					$projectListHtml .= '<span><strong>ID: </strong>' . esc_html($project_id) . '</span>';
				}
				if (!empty($project_title)) {
					$projectListHtml .= '<span><strong>Title: </strong>' . esc_html($project_title) . '</span>';
				}
				if (!empty($project_description)) {
					$projectListHtml .= '<p><strong>Description: </strong>' . esc_html($project_description) . '</p>';
				}
				if (!empty($project_employer)) {
					$projectListHtml .= '<span><strong>Employer: </strong>' . esc_html($project_employer) . '</span>';
				}

				$projectListHtml .= '</li>';
			}
			$projectListHtml .= '</ul>';

			// Return the HTML
			return $content . $projectListHtml;
		}

		// For other pages, return the content unchanged
		return $content;
	}
}
