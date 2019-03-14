<?php

/**
 * Pagination / Numeric style
 **/
global $wp_query;
$max_num_pages = $wp_query->max_num_pages;

// do not display pagination template if we have just one page
if ( $max_num_pages <= 1 ) {
	return;
}

$paged              = get_query_var( 'paged' );
$permalinks_enabled = get_option( 'permalink_structure' ) != '';
$format             = $permalinks_enabled ? 'page/%#%/' : '&paged=%#%';
$big                = 9999999;
$base               = $permalinks_enabled && ! is_search() ? $base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) : $base = @add_query_arg( 'paged', '%#%' );
?>
<nav class="pagination-nav pt-5" aria-label="Pagination">
	<?php
	echo paginate_links( [
		'format'    => $format,
		'base'      => $base,
		'current'   => max( 1, $paged ),
		'total'     => $max_num_pages,
		'prev_text' => '<i class="fa fa-angle-left"></i>',
		'next_text' => '<i class="fa fa-angle-right"></i>',
		//'before_page_number' => '<li class="page-item"><span class="page-link" href="#">',
		//'after_page_number'  => '</span></li>',
		'type'      => 'list'
	] );
	?>
</nav>