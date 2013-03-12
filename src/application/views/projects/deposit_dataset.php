<div class="page-header">

	<h1>
		<i class="icon-upload"></i> <?php echo $dataset_metadata->get_title(); ?><small> Publish to Lincoln Repository</small>
	</h1>

</div>

<p class="lead">Publishing will publicly announce the existence of your dataset on the Lincoln Repository, as well as start the process of long-term preservation of your data.</p>

<p>Usually you should only publish a dataset either at the end of a research project, or if the data is being cited in a paper. Publishing a dataset will place some restrictions on the changes you can make to the dataset in the future, such as removing your ability to delete the data. It will also generate a <a href="http://www.doi.org/">DOI</a>, which allows your dataset to be uniquely identified and located using a simple identifier.</p>

<p>Please check the information in this form and make any necessary changes, as this is the information which will be entered into the published record of the dataset.</p>

<p>If you have any questions about this process please contact a member of the research services team for advice or assistance.</p>

<hr>

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
		echo '<span class="help-block">How you wish the title of this dataset to appear.</span>';
		echo '</div></div>';

		$form_abstract = array(
			'name'			=> 'dataset_abstract',
			'required'   	=> 'required',
			'value'			=> $dataset_metadata->get_abstract(),
			'id'			=> 'dataset_abstract',
			'class'			=> 'input-block-level'
		);
	
		echo '<div class="control-group">';
		echo form_label('Description', 'dataset_abstract', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_textarea($form_abstract);
		echo '<span class="help-block">A description of this dataset and its contents..</span>';
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

		$form_type_of_data = array(
			'name'			=> 'dataset_type_of_data',
			'value'			=> $dataset_metadata->get_type_of_data(),
			'id'			=> 'dataset_type_of_data',
			'maxlength'		=> '200',
			'class'			=> 'input-xlarge'
		);
	
		echo '<div class="control-group">';
		echo form_label('Type of Data', 'dataset_type_of_data', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_type_of_data);
		echo '<span class="help-block">The type of data this dataset contains, for example "tabular", "images" or "mixed".</span>';
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
			'class'		=> 'form_width'
		);
	
		echo '<div class="control-group">';
		echo form_label('Keywords', 'dataset_keywords', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_input($form_dataset_keywords);
		echo '<span class="help-block">Keywords that describe this dataset. You can add as many keywords as you want.</span>';
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
		<button type="submit" class="btn btn-success"><i class = "icon-upload icon-white"></i> Publish Dataset</button>
		</div>';

		echo form_close();

	?>
		
	</div>
</div>