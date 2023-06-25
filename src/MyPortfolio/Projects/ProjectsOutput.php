<?php

namespace MyPortfolio\Projects;

class ProjectsOutput
{

	private $projectsMetaFields;
	public function __construct(ProjectsMetaFields $projectsMetaFields)
	{

		$this->projectsMetaFields = $projectsMetaFields;
	}

	// I need to create a function that access the meta fields I have saved in the database and allows me to output each of them on the front end. I will need to create a function for each meta field I want to output.
	public function output_project_employer_field($post_id)
	{
		// Get the project employer field data
		$project_employer_field = get_post_meta($post_id, 'project_employer_field', true);

		// If it isn't empty, output the field
		if (!empty($project_employer_field)) {
			echo '<p><strong>Employer: </strong>' . $project_employer_field . '</p>';
		}
	}
}
