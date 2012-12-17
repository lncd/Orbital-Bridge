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
		'value'			=> set_value('category_title', $category_data->title),
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
		'value'			=> set_value('category_icon', $category_data->icon),
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
		'value'			=> set_value('category_slug', $category_data->slug),
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
		'checked'		=> (bool) $category_data->active
	);

	echo '<div class="control-group">';
	echo form_label('Active?', 'category_active', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_checkbox($form_active);
	echo '<span class="help-block">Should this category be visible in the navigation bar?</span>';
	echo '</div></div>';
	
	?>
	
	<h3>Pages</h3>
	
	<p>You can add available pages to this category and change the order of pages within the category by dragging and dropping.</p>

	<div class="row">
		<div class="span6">
		
		<?php
		
		echo '<h4>In Category</h4>
		<ul id="sortable1" class="connectedSortable sortable_item">';
		
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
		
		?>
		
		</div>
		<div class="span6">
		
		<?php
		echo '<h4>Available</h4>
		<ul id="sortable2" class="connectedSortable sortable_item">';
		
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
		
		echo '</ul>';
		
		?>
		
		</div>
	</div>
	
	<?php
	
	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-ok icon-white"></i> Save Details</button>';
	echo '</div>';

	echo form_close();

	?>
	
	</div>
</div>