<div class="page-header">

	<h1>
		<i class="icon-pencil"></i> <?php echo $project->title; ?><small> Edit</small>
	</h1>

</div>

<div class="row">
	
	<div class="span12">
	
	<?php
		echo validation_errors();
	
		echo form_open('project/' . $project_id . '/edit', array('class' => 'form-horizontal'));
	
		$form_title = array(
			'name'			=> 'project_title',
			'required'   	=> 'required',
			'value'			=> $project->title,
			'id'			=> 'project_title',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Title', 'project_title', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_title);
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
		
		$form_project_lead = array(
			'name'			=> 'project_lead',
			'id'			=> 'project_lead',
			'value'			=> $project->project_lead->sam_id,
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Project Lead', 'project_lead', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_project_lead);
		echo '<span class="help-block">Enter the username of the person you want to add.</span>';
		echo '</div></div>';
		
		if ($project->funded)
		{
			$funded = 'funded';
		}
		else
		{
			$funded = 'unfunded';
		}
		$form_project_type = array(
			'name'		=> 'project_type',
			'id'		=> 'project_type',
			'value'		=> $funded
		);
	
		$project_type['funded'] = 'Funded';
		$project_type['unfunded'] = 'No funding';
	
		echo '<div class="control-group">';
		echo form_label('Project type', 'project_type', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('project_type', $project_type, set_value('project_type', $funded), 'id="project_type" class="span4"');
		echo '</div></div>';
		
		echo '<div id="funding_div"';
		
		if ( ! $project->funded)
		{
			echo 'style="display:none">';
		}
		else
		{
			echo'>';
		}
		if (isset($project->funding->currency->id))
		{
			$currency_id = $project->funding->currency->id;
		}
		else
		{
			$currency_id = NULL;
		}
		$form_project_funding_currency = array(
			'name'		=> 'project_funding_currency',
			'id'		=> 'project_funding_currency',
			'value'		=> $currency_id
		);

		$funding_type['1'] = '&pound; (Sterling)';
	
		echo '<div class="control-group">';
		echo form_label('Funding Currency', 'project_funding_currency', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('project_funding_currency', $funding_type, set_value('project_funding_currency', $currency_id), 'id="project_funding_currency" class="span4"');
		echo '</div></div>';
	
	
		if (isset($project->funding->amount))
		{
			$funding_amount = $project->funding->amount;
		}
		else
		{
			$funding_amount = NULL;
		}
	
		$form_funding_amount = array(
			'name'			=> 'project_funding_amount',
			'id'			=> 'project_funding_amount',
			'value'			=> $funding_amount,
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Funding Amount', 'project_funding_amount', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_funding_amount);
		echo '</div></div>';
	
		echo '</div>';
	
		$form_start_date = array(
			'name'			=> 'project_start_date',
			'required'   	=> 'required',
			'id'			=> 'project_start_date',
			'value'			=> date('Y-m-d', $project->start_date_unix),
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge datepicker'
		);
	
		echo '<div class="control-group">';
		echo form_label('Start Date', 'project_start_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_start_date);
		echo '</div></div>';
		
		if (isset($project->end_date_unix))
		{
			$end_date = date('Y-m-d', $project->end_date_unix);
		}
		else
		{
			$end_date = NULL;
		}
		
		$form_end_date = array(
			'name'			=> 'project_end_date',
			'id'			=> 'project_end_date',
			'value'			=> $end_date	,
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
</div>