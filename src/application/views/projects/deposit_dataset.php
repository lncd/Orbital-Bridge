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

		$form_publication_date = array(
			'name'			=> 'dataset_publication_date',
			'required'   	=> 'required',
			'value'			=> date("Y-m-d", $dataset_metadata->get_publication_date()),
			'id'			=> 'dataset_publication_date',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge datepicker'
		);
	
		echo '<div class="control-group">';
		echo form_label('Publication date', 'dataset_publication_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_publication_date);
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
		
		$form_contributor = array(
			'name'			=> 'dataset_contributor',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_contributor(),
			'id'			=> 'dataset_contributor',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Contributor', 'dataset_contributor', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_contributor);
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
		
		
		$form_language = array(
			'name'			=> 'dataset_language',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_language(),
			'id'			=> 'dataset_language',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Language', 'dataset_language', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_language);
		echo '</div></div>';	
		
		$form_size = array(
			'name'			=> 'dataset_size',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_size(),
			'id'			=> 'dataset_size',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Size', 'dataset_size', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_size);
		echo '</div></div>';	
		
		$form_format = array(
			'name'			=> 'dataset_format',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_format(),
			'id'			=> 'dataset_format',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Format', 'dataset_format', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_format);
		echo '</div></div>';	
		
		$form_version = array(
			'name'			=> 'dataset_version',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_version(),
			'id'			=> 'dataset_version',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Version', 'dataset_version', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_version);
		echo '</div></div>';
				
		echo'
		<div class="form-actions">
		<button type="submit" class="btn btn-success"><i class = "icon-upload icon-white"></i> Deposit Dataset</button>
		</div>';

		echo form_close();

	?>
		
	</div>
</div>