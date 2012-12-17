<div class="category-header">

	<h1>
		<i class="icon-cogs"></i> Category<small> Add</small>
	</h1>

</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/add_category/', array('class' => 'form-horizontal'));

	$form_title = array(
		'name'			=> 'category_title',
		'required'   	=> 'required',
		'id'			=> 'category_title',
		'maxlength'		=> '200',
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('Category Title', 'category_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_title);
	echo '<span class="help-block">This is the title of the category, as it will appear on the navigation bar.</span>';
	echo '</div></div>';
	
	$form_icon = array(
		'name'			=> 'category_icon',
		'required'   	=> 'required',
		'id'			=> 'category_icon',
		'maxlength'		=> '200',
		'class'			=> 'input-medium'
	);

	echo '<div class="control-group">';
	echo form_label('Category Icon', 'category_icon', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_icon);
	echo '<span class="help-block">The icon which will be used to represent this category. Valid icons are those in the <a href="http://fortawesome.github.com/Font-Awesome/">Font Awesome</a> collection.</span>';
	echo '</div></div>';

	$form_slug = array(
		'name'			=> 'category_slug',
		'required'   	=> 'required',
		'id'			=> 'category_slug',
		'maxlength'		=> '200',
		'class'			=> 'input-medium'
	);

	echo '<div class="control-group">';
	echo form_label('Category URL', 'category_slug', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo '<div class = "input-prepend"><span class="add-on">' . site_url('category') . '/</span>';
	echo form_input($form_slug);
	echo '</div>';
	echo '<span class="help-block">The category URL is used to direct people to a list of all the category pages.</span>';
	echo '</div></div>';

	$form_pages_list = array(
		'name'			=> 'pages_list',
		'required'   	=> 'required',
		'id'			=> 'pages_list',
		'maxlength'		=> '200',
		'type'			=> 'hidden'
	);
	
	echo form_input($form_pages_list);
	
	$form_active = array(
		'name'			=> 'category_active',
		'id'			=> 'category_active',
		'value'			=> 'active',
		'checked'		=> (bool) FALSE
	);

	echo '<div class="control-group">';
	echo form_label('Active?', 'category_active', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_checkbox($form_active);
	echo '<span class="help-block">Should this category be visible in the navigation bar?</span>';
	echo '</div></div>';
	
	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>