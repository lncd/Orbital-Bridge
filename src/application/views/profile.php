<div class="page-header">

	<h1>
		<i class="icon-user"></i> My Profile
	</h1>

</div>
		
<p class="lead">Your Researcher Profile contains information about your research and publications, as well as your contact details and biography. The information is automatically generated from a number of different systems, including the Research Dashboard, Staff Profile, Lincoln Repository and CKAN.</p>

<p>You can view your public profile, as well as edit your biography and research interests using the University's Staff Directory.</p>

<p><a href="http://staff.lincoln.ac.uk/<?php echo $this->session->userdata('user_sam_id'); ?>" class="btn btn-primary"><i class="icon-chevron-right"></i> View Staff Profile</a> <a href="http://staff.lincoln.ac.uk/editor" class="btn"><i class="icon-chevron-right"></i> Edit Staff Profile</a></p>

<hr>

<?php if ($eprints_research_total !== FALSE): ?>

<h2><i class="icon-file-alt"></i> Publications</h2>

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

<p><a href="https://eprints.lincoln.ac.uk/cgi/users/home" class="btn"><i class="icon-chevron-right"></i> Manage my Publications on the Lincoln Repository</a></p>

<small><i class="icon-info-sign"></i> Views count according to Google Analytics.</small>

<?php 
endif;
?>

<?php
endif;
?>

<hr>

<h2><i class="icon-file-alt"></i> Research Data</h2>

<p><a href="https://ckan.lincoln.ac.uk" class="btn"><i class="icon-chevron-right"></i> Manage my Datasets on CKAN</a></p>

<hr>

<h2><i class="icon-external-link"></i> External Profiles</h2>

<p>As a researcher, your work might be featured in various external profiles. Here are some of the more popular that either you have told us about or that you might want to consider registering for.</p>

<div class="row">

	<div class="span6">
	
		<h4>ORCID</h4>
		
		<p>ORCID provides a persistent digital identifier that distinguishes you from every other researcher and, through integration in key research workflows such as manuscript and grant submission, supports automated linkages between you and your professional activities ensuring that your work is recognised.</p>
	
		<?php
		
		if (isset($person['result']['profile']['external_orcid_id']))
		{
			echo '<p>Your ORCID:<br><span style="font-size:1.2em;">' . $person['result']['profile']['external_orcid_id'] .'</span></p>';
			
			echo '<p><a href="http://orcid.org/' . $person['result']['profile']['external_orcid_id'] .'" class="btn"><i class="icon-external-link"></i> Visit ORCID Profile</a></p>';
		}
		else
		{
			echo '<p>You either don\'t have an ORCID ID, or we don\'t know it. You can register with ORCID, or if you are already registered you can update your Staff Profile to include your ORCID ID.</p>';
			
			echo '<p><a href="https://orcid.org/register" class="btn"><i class="icon-external-link"></i> Register for an ORCID ID</a> <a href="http://staff.lincoln.ac.uk/editor" class="btn"><i class="icon-chevron-right"></i> Edit Staff Profile</a></p>';
		}

		?>
		
	</div>
	
	<div class="span6">
	
		<h4>Google Scholar</h4>
		
		<p>Google Scholar represents what Google has been able to discover about your published works and citations. By customising your Google Scholar profile you can increase the visibility of your work on Google as well as ensure the correctness of your record.</p>
	
		<?php
		
		if (isset($person['result']['profile']['external_google_scholar_id']))
		{
			echo '<p><a href="http://scholar.google.com/citations?user=' . $person['result']['profile']['external_google_scholar_id'] .'" class="btn"><i class="icon-external-link"></i> Visit Google Scholar Profile</a></p>';
		}
		else
		{
			echo '<p>You either don\'t have a Google Scholar profile, or we don\'t know your unique identifier. You can register with Google, or if you are already registered you can update your Staff Profile to include your Google Scholar ID.</p>';
			
			echo '<p><a href="http://scholar.google.co.uk/citations" class="btn"><i class="icon-external-link"></i> Register for a Google Scholar Profile</a> <a href="http://staff.lincoln.ac.uk/editor" class="btn"><i class="icon-chevron-right"></i> Edit Staff Profile</a></p>';
		}

		?>
		
	</div>
	
</div>
<div class="row">
	
	<div class="span6">
	
		<h4>ResearcherID</h4>
		
		<p>ResearcherID provides a persistent digital identifier that distinguishes you from every other researcher and, through integration in key research workflows such as manuscript and grant submission, supports automated linkages between you and your professional activities ensuring that your work is recognised.</p>
	
		<?php
		
		if (isset($person['result']['profile']['external_researcherid']))
		{
			echo '<p>Your ResearcherID:<br><span style="font-size:1.2em;">' . $person['result']['profile']['external_researcherid'] .'</span></p>';
			
			echo '<p><a href="http://www.researcherid.com/rid/' . $person['result']['profile']['external_researcherid'] .'" class="btn"><i class="icon-external-link"></i> Visit ResearcherID Profile</a></p>';
		}
		else
		{
			echo '<p>You either don\'t have a ResearcherID, or we don\'t know it. You can register with ResearcherID, or if you are already registered you can update your Staff Profile to include your ResearcherID.</p>';
			
			echo '<p><a href="http://www.researcherid.com/SelfRegistration.action" class="btn"><i class="icon-external-link"></i> Register for a ResearcherID</a> <a href="http://staff.lincoln.ac.uk/editor" class="btn"><i class="icon-chevron-right"></i> Edit Staff Profile</a></p>';
		}

		?>
		
	</div>
	
	<div class="span6">
	
		<h4>Scopus Author ID</h4>
		
		<p>Your Scopus Author ID is a digital identifier which tries to distinguish you from other researchers and group your work together.</p>
	
		<?php
		
		if (isset($person['result']['profile']['external_scopus_author_id']))
		{
			echo '<p><a href="http://www.scopus.com/authid/detail.url?authorId=' . $person['result']['profile']['external_scopus_author_id'] .'" class="btn"><i class="icon-external-link"></i> Visit Scoups Author Profile</a></p>';
		}
		else
		{
			echo '<p>You either don\'t have a Scopus Author ID, or we don\'t know your unique identifier. If you already have a Scopus Author IDyou can update your Staff Profile to include it, but you cannot register for one yourself. Scopus Author IDs are created for you automatically if your work is published in certain journals.</p>';
			
			echo '<p><a href="http://staff.lincoln.ac.uk/editor" class="btn"><i class="icon-chevron-right"></i> Edit Staff Profile</a></p>';
		}

		?>
		
	</div>

</div>