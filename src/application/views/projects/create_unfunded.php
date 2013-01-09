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
		echo form_label('Title', 'project_title', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_title);
		echo '</div></div>';
	
	
		$form_lead = array(
			'name'			=> 'project_lead',
			'required'   	=> 'required',
			'id'			=> 'project_lead',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Lead', 'project_lead', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_lead);
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
		echo '<span class="help-block">You can use Markdown to add formatting to this project.</span>';
		echo '</div></div>';
		
	
		$form_project_type = array(
			'name'		=> 'project_type',
			'id'		=> 'project_type',
			'value'		=> 'public'
		);
	
		$project_type['funded'] = 'Funded';
		$project_type['unfunded'] = 'No funding';
	
		echo '<div class="control-group">';
		echo form_label('Project type', 'project_type', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('project_type', $project_type, set_value('project_type', 'unfunded'), 'id="project_type" class="span4"');
		echo '</div></div>';
		
		$form_project_funding_currency = array(
			'name'		=> 'project_funding_currency',
			'id'		=> 'project_funding_currency',
			'value'		=> '1'
		);

		$funding_type['1'] = '&pound; (Sterling)';
	
		echo '<div class="control-group">';
		echo form_label('Funding Currency', 'project_funding_currency', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('project_funding_currency', $funding_type, set_value('project_funding_currency', '1'), 'id="project_funding_currency" class="span4"');
		echo '</div></div>';
	
		$form_funding_amount = array(
			'name'			=> 'project_funding_amount',
			'id'			=> 'project_funding_amount',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Funding Amount', 'project_funding_amount', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_funding_amount);
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
		echo '</div></div>';
	
		echo '<div class="form-actions">';
		echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
		echo '</div>';
	
		echo form_close();

	?>
		
	</div>
			
	<script>
		$(document).ready(function() {
			$(".datepicker").datepicker({ dateFormat: "yy-mm-dd" });
		});
	</script>

</div>