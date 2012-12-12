<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> <?php echo $category_data->title; ?><small> Edit</small>
	</h1>

</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/page_category/' . $category_data->id, array('class' => 'form-horizontal', 'name' => 'category_pages_form'));

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

	$form_pages_list = array(
		'name'			=> 'pages_list',
		'required'   	=> 'required',
		'id'			=> 'pages_list',
		'maxlength'		=> '200',
		'type'		=> 'hidden'
	);

	echo '<div class="control-group">';
	echo '<div class="controls">';
	echo form_input($form_pages_list);
	echo '</div></div></div>';
	
	echo '<table class="table table-bordered">
	<thead>
		<tr><th>Category Pages</th><th>All pages available</th></tr>
	</thead>
	<tbody>
	<tr>
	<td>	
	<ul id="sortable1" class="connectedSortable">';
	foreach($pages as $page)
	{		
		if (isset($page_category_page_checked))
		{
			if (in_array($page->id, $page_category_page_checked))
			{
				echo '<li class="ui-state-highlight" id="' . $page->id . '">' . $page->title . '</li>';
			}
		}
	}
	
	echo '</ul>'; 
	echo '</td><td>';
	echo '<ul id="sortable2" class="connectedSortable">';
	
	foreach($pages as $page)
	{		
		if (isset($page_category_page_checked))
		{
			if ( ! in_array($page->id, $page_category_page_checked))
			{
				echo '<li class="ui-state-default" id="' . $page->id . '">' . $page->title . '</li>';
			}
		}
		else
		{
			echo '<li class="ui-state-default" id="' . $page->id . '">' . $page->title . '</li>';
		}
	}
	echo '</td></tbody></table>';
	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
	echo '</div>';

	echo form_close();

	?>	
	</div>
</div>