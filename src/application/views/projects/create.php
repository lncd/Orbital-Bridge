<div class="page-header">

	<h1>
		<i class="icon-plus"></i> Add an Unfunded Research Project
	</h1>

</div>

<div class="row">
	
	<div class="span12">
	
	<?php
	
		echo validation_errors();
	
		echo form_open('projects/create', array('class' => 'form-horizontal'));
	
		$form_title = array(
			'name'			=> 'project_title',
			'required'   	=> 'required',
			'id'			=> 'project_title',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Title', 'project_title', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_title);
		echo '<span class="help-block">This title will be used in various places to refer to your research project. It should be short, but descriptive.</span>';
		echo '</div></div>';
	
		$form_description = array(
			'name'			=> 'project_description',
			'id'			=> 'project_description',
			'rows'			=> '10',
			'class'			=> 'input-block-level',
			'style'			=> 'width:100%;'
		);
	
		echo '<div class="control-group">';
		echo form_label('Description', 'project_description', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_textarea($form_description);
		echo '<span class="help-block">The project description is shown alongside the project in places such as the Research Directory.</span>';
		echo '</div></div>';
			
		$form_website = array(
			'name'			=> 'project_website',
			'id'			=> 'project_website',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Website', 'project_website', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_website);
		echo '<span class="help-block">If the project has one, a website where people can find out more.</span>';
		echo '</div></div>';
		
		$form_start_date = array(
			'name'			=> 'project_start_date',
			'required'   	=> 'required',
			'id'			=> 'project_start_date',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge datepicker'
		);
	
		echo '<div class="control-group">';
		echo form_label('Start Date', 'project_start_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_start_date);
		echo '<span class="help-block">The date on which work started (or will start) on this project.</span>';
		echo '</div></div>';
		
		$form_end_date = array(
			'name'			=> 'project_end_date',
			'id'			=> 'project_end_date',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge datepicker'
		);
	
		echo '<div class="control-group">';
		echo form_label('End Date', 'project_end_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_end_date);
		echo '<span class="help-block">Optionally (if known), the date on which work on this project will finish.</span>';
		echo '</div></div>';
	
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
		echo '</div>';
	
		echo form_close();

	?>
		
	</div>
</div>