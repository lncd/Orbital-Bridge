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

		$form_abstract = array(
			'name'			=> 'dataset_abstract',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_abstract(),
			'id'			=> 'dataset_abstract',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Abstract', 'dataset_abstract', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_abstract);
		echo '</div></div>';

		$form_uri_slug = array(
			'name'			=> 'dataset_uri_slug',
			'value'			=> $dataset_metadata->get_uri_slug(),
			'id'			=> 'dataset_uri_slug',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Official URI', 'dataset_uri_slug', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_uri_slug);
		echo '</div></div>';

		$form_creators = array(
			'name'			=> 'dataset_creators',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_creators()[0]->first_name . ' ' . $dataset_metadata->get_creators()[0]->last_name,
			'id'			=> 'dataset_creators',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Creator', 'dataset_creators', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_creators);
		echo '</div></div>';

		$form_contributor = array(
			'name'			=> 'dataset_contributor',
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

		$form_publisher = array(
			'name'			=> 'dataset_publisher',
			'id'			=> 'dataset_publisher',
			'required'   	=> 'required',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Publisher', 'dataset_publisher', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_publisher);
		echo '</div></div>';

		$pub_date = $dataset_metadata->get_publication_date();
		if ($pub_date === '' OR $pub_date == NULL)
		{
			$pub_date = time();
		}

		$form_publication_date = array(
			'name'			=> 'dataset_publication_date',
			'required'   	=> 'required',
			'value'			=> date("Y-m-d", $pub_date),
			'id'			=> 'dataset_publication_date',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge datepicker'
		);
	
		echo '<div class="control-group">';
		echo form_label('Publication date', 'dataset_publication_date', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_publication_date);
		echo '<span class="help-block">If the project does not have a publication data, this will default to the current date.</span>';
		echo '</div></div>';

		$form_date = array(
			'name'			=> 'dataset_date',
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
		
		$form_type_of_data = array(
			'name'			=> 'dataset_type_of_data',
			'value'			=> $dataset_metadata->get_type_of_data(),
			'id'			=> 'dataset_type_of_data',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Type of data', 'dataset_type_of_data', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_type_of_data);
		echo '</div></div>';
		
		if ($dataset_metadata->get_keywords() === NULL OR $dataset_metadata->get_keywords() === array())
		{
			$keywords = array();
		}
		else
		{
			$keywords = $dataset_metadata->get_keywords();
		}
		
		$form_dataset_keywords = array(
			'name'			=> 'dataset_keywords',
			'id'			=> 'dataset_keywords',
			'value'			=> implode(',', $dataset_metadata->get_keywords()),
			'maxlength'		=> '200',
			'class'		=> 'form_width'
		);
	
		echo '<div class="control-group">';
		echo form_label('Keywords', 'dataset_keywords', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_dataset_keywords);
		echo '</div></div>';
		
		if ($dataset_metadata->get_subjects() === NULL OR $dataset_metadata->get_subjects() === array())
		{
			$subjects = array();
		}
		else
		{
			$subjects = $dataset_metadata->get_subjects();
		}
		
		$form_dataset_subjects = array(
			'name'			=> 'dataset_subjects',
			'required'   	=> 'required',
			'id'			=> 'dataset_subjects',
			'value'			=> implode(',', $subjects),
			'maxlength'		=> '200',
			'class'			=> 'form_width'
		);
	
		echo '<div class="control-group">';
		echo form_label('Subjects', 'dataset_subjects', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_dataset_subjects);
		echo '<span class="help-block">These are JACS codes.</span>';
		echo '</div></div>';
		
		$form_divisions = array(
			'name'			=> 'dataset_divisions',
			'value'			=> $dataset_metadata->get_divisions(),
			'id'			=> 'dataset_divisions',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Divisions', 'dataset_divisions', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_divisions);
		echo '</div></div>';
		
		$metadata_visibility['show'] = 'Show';
		$metadata_visibility['hide'] = 'Hide';
	
		echo '<div class="control-group">';
		echo form_label('Metadata visibility', 'dataset_metadata_visibility', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_dropdown('dataset_metadata_visibility', $metadata_visibility, 'id="dataset_metadata_visibility" class="span4"');
		echo '</div></div>';

		$form_metadata_visibility = array(
			'name'			=> 'dataset_metadata_visibility',
			'id'			=> 'dataset_metadata_visibility',
			'required'   	=> 'required',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);

				
		echo'
		<div class="form-actions">
		<button type="submit" class="btn btn-success"><i class = "icon-upload icon-white"></i> Deposit Dataset</button>
		</div>';

		echo form_close();

	?>
		
	</div>
</div>