<?php
/**
 * Search form template part
 **/
?>

<form class="form-inline" action="<?php echo get_site_url(); ?>" method="get">
	<div class="input-group">
		<input class="form-control" type="search" placeholder="Search" aria-label="Search" name="s">
		<div class="input-group-append">
			<button class="btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
	</div>
</form>