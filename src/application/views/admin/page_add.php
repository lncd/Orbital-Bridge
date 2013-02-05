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

	echo '<fieldset><legend>Basic Details</legend>';

	$form_title = array(
		'name'			=> 'page_title',
		'required'   	=> 'required',
		'id'			=> 'page_title',
		'value'			=> set_value('page_title'),
		'maxlength'		=> '200',
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('Page Title', 'page_title', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_title);
	echo '<span class="help-block">This is the page title, as appears in the navigation bar.</span>';
	echo '</div></div>';
	
	$form_slug = array(
		'name'			=> 'page_slug',
		'required'   	=> 'required',
		'id'			=> 'page_slug',
		'value'			=> set_value('page_slug'),
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
	
	$page_type['page'] = 'Normal Page';
	$page_type['git'] = 'GitHub Page';
	$page_type['redirect'] = 'Redirect';

	echo '<div class="control-group">';
	echo form_label('Page Type', 'page_type', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_dropdown('page_type', $page_type, set_value('page_type', 'page'), 'id="page_type"');
	echo '<span class="help-block">Should this be a normal page, take its content from the RDM GitHub repository, or redirect the user externally?</span>';
	echo '</div></div>';
	
	echo '</fieldset><fieldset><legend>Page Content</legend>';

	$form_content = array(
		'name'			=> 'page_content',
		'id'			=> 'page_content',
		'value'			=> set_value('page_content'),
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
	
	echo '</fieldset><fieldset><legend>GitHub</legend>';

	$form_git_page = array(
		'name'			=> 'page_git_page',
		'id'			=> 'page_git_page',
		'value'			=> set_value('page_git_page'),
		'maxlength'		=> '100',
		'class'			=> 'input-large'
	);

	echo '<div class="control-group">';
	echo form_label('GitHub Page', 'page_git_page', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_git_page);
	echo '<span class="help-block">If this page is taking content from GitHub, the name of the file in the repository. This file will be parsed as Markdown.</span>';
	echo '</div></div>';
	
	echo '</fieldset><fieldset><legend>Redirection</legend>';

	$form_git_page = array(
		'name'			=> 'page_redirect_uri',
		'id'			=> 'page_redirect_uri',
		'value'			=> set_value('page_redirect_uri'),
		'class'			=> 'input-xlarge'
	);

	echo '<div class="control-group">';
	echo form_label('Redirect URI', 'page_redirect_uri', array('class' => 'control-label'));
	echo '<div class="controls">';
	echo form_input($form_git_page);
	echo '<span class="help-block">If this page is a redirection, the destination to send the user to.</span>';
	echo '</div></div>';

	echo '<div class="form-actions">';
	echo '<button type="submit" class="btn btn-success"><i class = "icon-save"></i> Save Page</button>';
	echo '</div>';

	echo form_close();

	?>

	</div>
</div>