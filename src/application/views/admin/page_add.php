<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> Page<small> Add</small>
	</h1>

</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/add_page/', array('class' => 'form-horizontal'));

	$form_title = array(
		'name'			=> 'page_title',
		'required'   	=> 'required',
		'id'			=> 'page_title',
		'value'			=> set_value('page_title', ''),
		'maxlength'		=> '200',
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('Page Title', 'page_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_title);
	echo '<span class="help-block">This is the page title, as appears in the navigation bar.</span>';
	echo '</div></div>';

	$form_content = array(
		'name'			=> 'page_content',
		'required'   	=> 'required',
		'id'			=> 'page_content',
		'value'			=> set_value('page_content', ''),
		'rows'			=> '10',
		'class'			=> 'input-block-level',
		'style'			=> 'width:100%;'
	);

	echo '<div class="control-group">';
	echo form_label('Page Content', 'page_content', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_textarea($form_content);
	echo '<span class="help-block">You can use Markdown to add formatting to this page.</span>';
	echo '</div></div>';

	$form_slug = array(
		'name'			=> 'page_slug',
		'required'   	=> 'required',
		'id'			=> 'page_slug',
		'value'			=> set_value('page_slug', ''),
		'maxlength'		=> '200',
		'class'			=> 'input-medium'
	);

	echo '<div class="control-group">';
	echo form_label('Page URL', 'page_slug', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo '<div class = "input-prepend"><span class="add-on">' . site_url() . '</span>';
	echo form_input($form_slug);
	echo '</div>';
	echo '<span class="help-block">The page URL is used to view the page.</span>';
	echo '</div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>