<?php
/**
 * Search form template part
 **/
?>

<form action="<?php echo get_site_url(); ?>" method="get">
	<div class="input-group mb-3">
		<input class="form-control" type="search" placeholder="Search" aria-label="Search" name="s">
		<div class="input-group-append">
			<button class="btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
	</div>
</form>

