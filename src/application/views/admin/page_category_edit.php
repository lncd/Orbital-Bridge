<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> <?php echo $category_data->title; ?><small> Edit</small>
	</h1>

</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/page_category/' . $category_data->id, array('class' => 'form-horizontal'));

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

	foreach($pages as $page)
	{
		$checked = "";
		if (isset($page_category_page_checked))
		{
			if (in_array($page->id, $page_category_page_checked))
			{
				$checked = "checked";
			}
		}
		$form_pages = array(
			'name'			=> 'pages[]',
			'id'			=> 'page_' . $page->id,
			'value'			=> $page->id,
			'checked'		=> $checked
		);
	
		echo '<div class="control-group">';
		echo form_label($page->title, 'page_' . $page->id, array('class' => 'control-label'));
		echo '<div class="controls">';
		echo form_checkbox($form_pages);
		echo '</div></div>';
	}

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>