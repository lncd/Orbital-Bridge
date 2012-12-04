<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> <?php echo $category_data->title; ?><small> Edit</small>
	</h1>

</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/category/' . $category_data->id, array('class' => 'form-horizontal'));

	$form_title = array(
		'name'			=> 'category_title',
		'required'   	=> 'required',
		'id'			=> 'category_title',
		'placeholder'	=> $category_data->title,
		'value'			=> set_value('category_title', $category_data->title),
		'maxlength'		=> '200',
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('category Title', 'category_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_title);
	echo '</div></div>';

	$form_slug = array(
		'name'			=> 'category_slug',
		'required'   	=> 'required',
		'id'			=> 'category_slug',
		'placeholder'	=> $category_data->slug,
		'value'			=> set_value('category_slug', $category_data->slug),
		'maxlength'		=> '200',
		'class'			=> 'input-mini'
	);

	echo '<div class="control-group">';
	echo form_label('category Slug', 'category_slug', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo '<div class = "input-prepend"><span class="add-on">' . site_url('category') . '/</span>';
	echo form_input($form_slug);
	echo '</div></div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>