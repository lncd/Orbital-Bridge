<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> <?php echo $page_data->title; ?>
	</h1>

</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/page/' . $page_data->id, array('class' => 'form-horizontal'));

	$form_title = array(
		'name'			=> 'page_title',
		//'required'   	=> 'required',
		'id'			=> 'page_title',
		'placeholder'	=> $page_data->title,
		'value'			=> set_value('page_title', $page_data->title),
		'maxlength'		=> '200',
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('Page Title', 'page_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_title);
	echo '</div></div>';

	$form_content = array(
		'name'			=> 'page_content',
		'required'   	=> 'required',
		'id'			=> 'page_content',
		'placeholder'	=> $page_data->content,
		'value'			=> set_value('page_content', $page_data->content),
		'rows'			=> '5',
		'class'			=> 'input-block-level'
	);

	echo '<div class="control-group">';
	echo form_label('Page Content', 'page_content', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_textarea($form_content);
	echo '</div></div>';

	$form_slug = array(
		'name'			=> 'page_slug',
		'required'   	=> 'required',
		'id'			=> 'page_slug',
		'placeholder'	=> $page_data->slug,
		'value'			=> set_value('page_slug', $page_data->slug),
		'maxlength'		=> '200',
		'class'			=> 'input-mini'
	);

	echo '<div class="control-group">';
	echo form_label('Page Slug', 'page_slug', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo '<div class = "input-prepend"><span class="add-on">' . site_url('page') . '/</span>';
	echo form_input($form_slug);
	echo '</div></div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>