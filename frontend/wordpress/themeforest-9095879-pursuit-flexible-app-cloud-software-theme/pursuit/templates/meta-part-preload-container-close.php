<?php
//-----------------------------------------------------
// Preloader, Section, Container Close
//-----------------------------------------------------
?>
<?php echo $inner_container_close;?>    
</section>
</div>

<?php
//-----------------------------------------------------
// backstretch for mobile support
//-----------------------------------------------------
if ($background_js > ""){ ?>
	<script>
	jQuery(document).ready(function($) {
		if (Modernizr.touch) {
			<?php echo $background_js;  ?>
		}
	});
	</script>
<?php } ?>