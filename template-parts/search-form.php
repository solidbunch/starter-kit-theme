<?php
/**
 * Search form template part
 **/
?>
<form class="search-form" action="<?php echo get_site_url(); ?>" method="get">
	<input class="s" type="text" name="s" value=""
	       placeholder="<?php esc_html_e( 'Search...', 'fruitfulblanktextdomain' ); ?>"/>
</form>
