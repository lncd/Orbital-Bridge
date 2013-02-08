
			</div>

		</div><!--#main-->

	</div><!--#wrap-->

	<footer class="container" id="cwd-footer" role="contentinfo">

		<div class="row">

			<div class="span8">
				&copy; University of Lincoln<br>
				Orbital Bridge v0.3.4 "Cantilever" &middot; Developed by <a href="http://lncd.org">LNCD</a>
			</div>

			<div class="span2">
				<ul class="nav nav-pills nav-stacked">
					<li>
						<a href="http://support.lincoln.ac.uk/" target="_blank">ICT Support Desk</a>
					</li>
					<li>
						<a href="http://lincoln.ac.uk/home/termsconditions/" target="_blank">Policy statements</a>
					</li>
				</ul>
			</div>

			<div class="span2">	
				<ul class="nav nav-pills nav-stacked">
					<li>
						<a href="http://gateway.lincoln.ac.uk/" target="_blank">Gateway</a>
					</li>
					<li>
						<a href="http://lincoln.ac.uk/" target="_blank">www.lincoln.ac.uk</a>
					</li>
				</ul>
			</div>
		</div>
		
	</footer>

	<script type="text/javascript" src="<?php echo $_SERVER['CWD_BASE_URI']; ?>plugins.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/rapheal.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/markitup.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/markitup/markdown.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-gantt.min.js"></script>
	
	<script type="text/javascript">
		var uvOptions = {};
		(function() {
			var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
			uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/tnugwIqNLkzoCcrMYgsBXw.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
		})();
	</script>
	
	<?php
	
	if (isset($javascript))
	{
		echo '<script type="text/javascript">' . $javascript . '</script>';
	}
	
	?>

</body>
</html>