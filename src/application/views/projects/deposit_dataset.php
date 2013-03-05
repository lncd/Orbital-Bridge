<div class="page-header">

	<h1>
		<i class="icon-pencil"></i> <?php echo $dataset_metadata->get_title(); ?><small> Edit</small>
	</h1>

</div>

<div class="row">
	
	<div class="span12">
	
	<?php 
		echo validation_errors();
	
		echo form_open('dataset/' . $dataset_id . '/deposit', array('class' => 'form-horizontal'));

		$form_title = array(
			'name'			=> 'dataset_title',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_title(),
			'id'			=> 'dataset_title',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Title', 'dataset_title', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_title);
		echo '</div></div>';

		$form_uri_slug = array(
			'name'			=> 'dataset_uri_slug',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_uri_slug(),
			'id'			=> 'dataset_uri_slug',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('URI SLUG', 'dataset_uri_slug', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_uri_slug);
		echo '</div></div>';

		$form_creator = array(
			'name'			=> 'dataset_creator',
			'required'   	=> 'required',
			'value'			=> implode(',', $dataset_metadata->get_creators()),
			'id'			=> 'dataset_creator',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Creator(s)', 'dataset_creator', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_creator);
		echo '</div></div>';
		
		$credit['author'] = 'Author';
		$credit['contributor'] = 'Contributor';
		$credit['maintainer'] = 'Maintainer';
		$credit['none'] = 'No Credit';
	
		echo '<div class="control-group">';
		echo form_label('Dataset Credit', 'dataset_credit', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('dataset_credit', $credit, 'id="dataset-credit" class="span4"');
		echo '</div></div>';

		$form_publisher = array(
			'name'			=> 'dataset_publisher',
			'id'			=> 'dataset_publisher',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Publisher', 'dataset_publisher', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_publisher);
		echo '</div></div>';

		$form_date = array(
			'name'			=> 'dataset_date',
			'required'   	=> 'required',
			'value'			=> date("Y-m-d", $dataset_metadata->get_date()),
			'id'			=> 'dataset_date',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge datepicker'
		);
	
		echo '<div class="control-group">';
		echo form_label('Date', 'dataset_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_date);
		echo '</div></div>';
		
		
		$form_metadata_visibility = array(
			'name'			=> 'dataset_metadata_visibility',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_metadata_visibility(),
			'id'			=> 'dataset_metadata_visibility',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Metadata visibility', 'dataset_metadata_visibility', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_metadata_visibility);
		echo '</div></div>';
		
		
		$form_is_published = array(
			'name'			=> 'dataset_is_published',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_is_published(),
			'id'			=> 'dataset_is_published',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Published?', 'dataset_is_published', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_is_published);
		echo '</div></div>';		
		
		echo'
		<div class="form-actions">
		<button type="submit" class="btn btn-success"><i class = "icon-upload icon-white"></i> Deposit Dataset</button>
		</div>';

		echo form_close();

	?>
		
	</div>
</div>