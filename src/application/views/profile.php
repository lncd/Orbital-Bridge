<div class="page-header">

	<h1>
		<i class="icon-user"></i> My Profile
	</h1>

</div>
		
<p class="lead">Your Staff Profile contains information about your research and publications, as well as your contact details and biography. The information is automatically generated from a number of different systems, including the Research Dashboard, Staff Profile and ePrints.</p>

<p>You can view your public profile, edit your biography and research interests using the University's Blogs platform, or manage your publications using the University's ePrints system.</p>

<p><a href="http://staff.lincoln.ac.uk/<?php echo $this->session->userdata('user_sam'); ?>" class="btn btn-primary"><i class="icon-chevron-right"></i> View my Staff Profile</a> <a href="http://blogs.lincoln.ac.uk/<?php echo $this->session->userdata('user_sam'); ?>" class="btn"><i class="icon-chevron-right"></i> Edit my Staff Profile on Blogs</a> <a href="https://eprints.lincoln.ac.uk/cgi/users/home" class="btn"><i class="icon-chevron-right"></i> Manage my Publications on ePrints</a></p>

<hr>

<?php if ($eprints_research_total !== FALSE): ?>

<h2><i class="icon-dashboard"></i> Research Overview</h2>

<div class="alert alert-info">
	<strong>Note:</strong> This data is currently based on a best guess, and may not be entirely accurate. We will be improving the accuracy of this data over the course of the Orbital project. This data is collected from the University's ePrints repository, and is not collected in real-time. There may be a delay in new publications appearing.
</div>

<div class="row">

	<div class="span4">
	
		<h4>Total Publications</h4>
	
		<p class="bignumber"><?php echo number_format($eprints_research_total); ?></p>
	
	</div>

	<div class="span4">
	
		<h4>Total Views</h4>
	
		<p><span class="bignumber"><?php echo number_format($eprints_views); ?></span></p>
	
	</div>
	
	<div class="span4">
	
		<h4>Views This Month</h4>
	
		<p><span class="bignumber"><?php echo number_format($eprints_views_month); ?></span><span class="subnumber"> (<?php echo number_format($eprints_views_month_prev); ?> last month)</span></p>
	
	</div>

</div>

<hr>

<?php if($eprints_years OR $eprints_types): ?>

<div class="row">

	<div class="span8">
		
		<h4>Publications by Year</h4>
		
		<?php if ($eprints_years): ?>
		<div id="eprints-output-history" style="width:100%; height:250px;"></div>
		<?php else: ?>
		<p>There isn't enough data available to display your publication history.</p>
		<?php endif; ?>
		
	</div>
	
	<div class="span4">
		
		<h4>Type of Publication</h4>
		
		<?php if ($eprints_types): ?>
		<div id="eprints-types" style="width:100%; height:250px;"></div>
		<?php else: ?>
		<p>There isn't enough data available to display the types of publications you have in ePrints.</p>
		<?php endif; ?>
		
	</div>

</div>

<?php 
endif;
?>

<?php
endif;
?>