<div class="page-header">

	<h1>
		<i class="icon-dashboard"></i> Repository Overview
	</h1>

</div>

<div class="row">

	<div class="span6">
	
		<h4>Total Publications</h4>
	
		<p class="bignumber"><?php echo number_format($eprints_research_total); ?></p>
	
	</div>

	<div class="span6">
	
		<h4>Total Views</h4>
	
		<p><span class="bignumber"><?php echo number_format($eprints_views); ?></span></p>
	
	</div>

</div>

<hr>

<div class="row">

	<div class="span8">
		
		<h4>Publications by Year</h4>
		
		<div id="eprints-output-history" style="width:100%; height:300px;"></div>
		
	</div>
	
	<div class="span4">
		
		<h4>Type of Publication</h4>
		
		<div id="eprints-types" style="width:100%; height:300px;"></div>
		
	</div>

</div>

<hr>

<h4>Views by Month</h4>
		
<div id="eprints-views-history" style="width:100%; height:300px;"></div>