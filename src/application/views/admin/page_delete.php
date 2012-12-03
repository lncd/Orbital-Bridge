<div class="page-header">

	<h1>
		<i class="icon-cogs"></i><?php echo $page_data->title; ?><small> Delete</small>
	</h1>

</div>

<div class="alert alert-warning">You are about to delete the page <b><?php echo $page_data->title; ?></b>. To confirm this action, enter the page title and press 'Delete'.</div>

<div class="row">

	<div class="span12">

	<?php
	
	echo validation_errors();

	echo form_open('admin/delete_page/' . $page_data->id, array('class' => 'form-horizontal'));

	$form_title = array(
		'name'			=> 'page_title',
		'required'   	=> 'required',
		'id'			=> 'page_title',
		'placeholder'	=> $page_data->title,
		'maxlength'		=> '200',
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('Page Title', 'page_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_title);
	echo '</div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-danger"><i class = "icon-ok icon-white"></i> Delete</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>