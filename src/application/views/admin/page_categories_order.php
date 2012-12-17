<div class="page-header">

	<h1>
		<i class="icon-cogs"></i> Categories<small> Order</small>
	</h1>

</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/order_page_categories/', array('class' => 'form-horizontal', 'name' => 'category_pages_form'));

	

	$form_pages_list = array(
		'name'			=> 'pages_list',
		'required'   	=> 'required',
		'id'			=> 'pages_list',
		'maxlength'		=> '200',
		'type'			=> 'hidden'
	);
	
	echo form_input($form_pages_list);
	
	?>
	
	
	<p>You can reorder categories by dragging and dropping.</p>

	<div class="row">
		<div class="span6">

		<?php
		
		echo '<h4>Categories</h4>
		<ul id="sortable1" class="connectedSortable">';
		
		foreach($categories as $category)
		{		
			echo '<li class="ui-state-highlight" id="' . $category->id . '">' . $category->title . '</li>';	
		}
		
		echo '</ul>';
		
		?>
		
		</div>
		<div class="span6">
				
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