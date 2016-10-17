<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $product_column, $enable_carousel, $slider_details;
$rit_woo_column = get_theme_mod('rit_woo_column', '3');
if(isset($_GET['woo_column'])){
	$rit_woo_column = $_GET['woo_column'];
}

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = $rit_woo_column;
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes ='';
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes.= 'item-first clear-left ';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes.= 'item-last ';

$woo_column = $woocommerce_loop['columns'];
$class_col = '';
switch ($woo_column) {
	case 1:
		$class_col .= 'col-sm-12 col-md-12';
		break;
	case 2:
		$class_col .= 'col-sm-6 col-md-6';
		break;
	case 3:
		$class_col .= 'col-sm-4 col-md-4';
		break;
	case 4:
		$class_col .= 'col-sm-3 col-md-3';
		break;
	case 6:
		$class_col .= 'col-sm-2 col-md-2';
		break;
}
if($slider_details != 1){
	$classes.= $class_col;
} else {
	$classes.= 'rit-item-carousel';
}
$classes.= ' product-' . $woocommerce_loop['columns'] . '-columns product-category product';
?>
<li <?php wc_product_cat_class($classes); ?>>
	<div class="product-inner">
	<?php do_action( 'woocommerce_before_subcategory', $category );
		/**
		 * woocommerce_before_subcategory_title hook
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */
		do_action( 'woocommerce_before_subcategory_title', $category );
		do_action( 'woocommerce_after_subcategory', $category ); ?>
		<h3>
			<a href="<?php echo esc_url(get_term_link( $category->slug, 'product_cat' )); ?>">
			<?php
			echo esc_html($category->name);
			if ( $category->count > 0 )
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html($category->count) . ')</mark>', $category );
			?>
			</a>
		</h3>
		<?php
		/**
		 * woocommerce_after_subcategory_title hook
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );
		?>
		</div>
</li>
