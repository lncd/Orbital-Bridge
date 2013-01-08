<div class="page-header">

	<h1>
		<i class="icon-plus"></i> Create an Unfunded Research Project
	</h1>

</div>

<div class="row">
	
	<div class="span12">
	
	<?php
	
		echo validation_errors();
	
		echo form_open('projects/create_unfunded', array('class' => 'form-horizontal'));
	
		$form_title = array(
			'name'			=> 'project_title',
			'required'   	=> 'required',
			'id'			=> 'project_title',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Project Title', 'project_title', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_title);
		echo '<span class="help-block">This is the project title, as appears in the navigation bar.</span>';
		echo '</div></div>';
	
		$form_description = array(
			'name'			=> 'project_description',
			'required'   	=> 'required',
			'id'			=> 'project_description',
			'rows'			=> '10',
			'class'			=> 'input-block-level',
			'style'			=> 'width:100%;'
		);
	
		echo '<div class="control-group">';
		echo form_label('Project Description', 'project_description', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_textarea($form_description);
		echo '<span class="help-block">You can use Markdown to add formatting to this project.</span>';
		echo '</div></div>';
	
	
		$form_start_date = array(
			'name'			=> 'project_start_date',
			'required'   	=> 'required',
			'id'			=> 'project_start_date',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Project Start Date', 'project_start_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_start_date);
		echo '</div></div>';
		
		$form_end_date = array(
			'name'			=> 'project_end_date',
			'id'			=> 'project_end_date',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Project End Date', 'project_end_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_end_date);
		echo '</div></div>';
	
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
		echo '</div>';
	
		echo form_close();

	?>
		
	</div>
			
</div>