<div class="page-header">

	<h1>
		<i class="icon-cogs"></i><?php echo $project->title; ?><small> Delete</small>
	</h1>

</div>

<div class="alert alert-warning">You are about to delete the project <b><?php echo $project->title; ?></b>. To confirm this action, enter the project title and press 'Delete'.</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('project/' . $project->id . '/delete', array('class' => 'form-horizontal'));

	$form_title = array(
		'name'			=> 'project_title',
		'required'   	=> 'required',
		'id'			=> 'project_title',
		'placeholder'	=> $project->title,
		'maxlength'		=> '200',
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('Project Title', 'project_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_title);
	echo '</div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-danger"><i class = "icon-ok icon-white"></i> Delete</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>