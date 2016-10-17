
<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce_loop, $product_column, $enable_carousel, $product_filter, $product_style, $countdown, $products_layout;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

$_column = $woocommerce_loop['columns'];
if($product_column){
	$_column = $product_column;
}

// Extra post classes
$classes = array();
if (0 == ($woocommerce_loop['loop'] - 1) % $_column || 1 == $_column)
	$classes[] = 'first';
if (0 == $woocommerce_loop['loop'] % $_column)
	$classes[] = 'last';
$class_col = $class_style = '';
switch ($product_column) {
	case 1:
		$class_col .= 'col-sm-12 col-md-12 ';
		break;
	case 2:
		$class_col .= 'col-sm-6 col-md-6 ';
		break;
	case 3:
		$class_col .= 'col-sm-4 col-md-4 ';
		break;
	case 4:
		$class_col .= 'col-sm-3 col-md-3 ';
		break;
	case 6:
		$class_col .= 'col-sm-2 col-md-2 ';
		break;
}
if($enable_carousel != 'products_grid' || $product_filter != 1) {
	$class_col .= 'rit-item-carousel';
}
if($product_style == 'mini'){
	$class_col .= ' product-mini';
} else {
	$class_col .= ' product-nomal product-vc';
}
$classes[] = $class_col;
$classes[] = 'product';
if($product_filter == 1){
	$classes[] = 'animated fadeInUp';
}
?>
<li <?php post_class( $classes ); ?>>
	<div class="product-inner">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="feature-image">
			<?php

			$image_html = $percent = "";

			if (!$product->is_in_stock()) {

				echo '<span class="product-label label-out">' . esc_html(__( 'Out Stock', 'ri-quartz' )) . '</span>';

			} else if ($product->is_on_sale()) {
				if(get_theme_mod('rit_woo_label_sale', 'percent') == 'percent'){
					if(get_post_meta( get_the_ID(), '_sale_price', true)){
						$saleprice = get_post_meta( get_the_ID(), '_sale_price', true);
						$rprice = get_post_meta( get_the_ID(), '_regular_price', true);
						$percent = 100 - floor(($saleprice * 100) / $rprice);
						echo apply_filters('woocommerce_sale_flash', '<span class="product-label label-sale">-'.esc_attr($percent).'%</span>', $post, $product);
					} else {
						echo apply_filters('woocommerce_sale_flash', '<span class="product-label label-sale">'.esc_attr('Sale', 'ri-quartz').'</span>', $post, $product);
					}
				}
			} else if (!$product->get_price()) {
				echo '<span class="product-label label-free">' . esc_html(__( 'Free', 'ri-quartz' )) . '</span>';
			}

			$postdate 		= get_the_time( 'Y-m-d' );			// Post date
			$postdatestamp 	= strtotime( $postdate );			// Timestamped post date
			$newness 		= 30; 	// Newness in days

			if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
				echo '<span class="product-label label-new">' . esc_html(__( 'New', 'ri-quartz' )) . '</span>';
			}

			if ( has_post_thumbnail() ) {
				$image_html = wp_get_attachment_image( get_post_thumbnail_id(), 'shop_catalog' );
			}
			?>

			<a href="<?php esc_url(the_permalink()); ?>">

				<?php

				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {

					$attachment_ids = $product->get_gallery_attachment_ids();

					$img_count = 0;

					if ($attachment_ids) {

						echo '<div class="product-image front-image">' . wp_kses($image_html, array('img' => array('width' => array(), 'height' => array(), 'src' => array(), 'alt' => array(), 'class' => array()))) . '</div>';

						foreach ( $attachment_ids as $attachment_id ) {

							if ( get_post_meta( $attachment_id, '_woocommerce_exclude_image', true ) )
								continue;

							echo '<div class="product-image back-image">' . wp_kses(wp_get_attachment_image( $attachment_id, 'shop_catalog' ), array('img' => array('width' => array(), 'height' => array(), 'src' => array(), 'alt' => array(), 'class' => array()))) . '</div>';

							$img_count++;

							if ($img_count == 1) break;

						}

					} else {

						echo '<div class="product-image front-image">' . wp_kses($image_html, array('img' => array('width' => array(), 'height' => array(), 'src' => array(), 'alt' => array(), 'class' => array()))) . '</div>';
						echo '<div class="product-image back-image">' . wp_kses($image_html, array('img' => array('width' => array(), 'height' => array(), 'src' => array(), 'alt' => array(), 'class' => array()))) . '</div>';

					}

				} else {

					$attachments = get_posts( array(
						'post_type' 	=> 'attachment',
						'numberposts' 	=> -1,
						'post_status' 	=> null,
						'post_parent' 	=> $post->ID,
						'post__not_in'	=> array( get_post_thumbnail_id() ),
						'post_mime_type'=> 'image',
						'orderby'		=> 'menu_order',
						'order'			=> 'ASC'
					) );

					$img_count = 0;

					if ($attachments) {

						$loop = 0;
						$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

						foreach ( $attachments as $key => $attachment ) {

							if ( get_post_meta( $attachment->ID, '_woocommerce_exclude_image', true ) == 1 )
								continue;

							echo '<div class="product-image">' . wp_kses(wp_get_attachment_image( $attachment_id, 'shop_catalog' ), array('img' => array('width' => array(), 'height' => array(), 'src' => array(), 'alt' => array(), 'class' => array()))) . '</div>';

							$img_count++;

							if ($img_count == 1) break;

						}

					} else {

						echo '<div class="product-image front-image">' . wp_kses($image_html, array('img' => array('width' => array(), 'height' => array(), 'src' => array(), 'alt' => array(), 'class' => array()))) . '</div>';
						echo '<div class="product-image back-image">' . wp_kses($image_html, array('img' => array('width' => array(), 'height' => array(), 'src' => array(), 'alt' => array(), 'class' => array()))) . '</div>';

					}

				}
				?>
			</a>
			<div class="shop-actions clearfix">
				<?php
						echo ri_quartz_add_quick_view_button();
				?>
			</div>
		</div>

		<div class="product-details al-center">
			<div class="product-details-inner">
			<h3><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>
			<?php
			$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
			do_action( 'woocommerce_after_shop_loop_item_title' );
			echo '<div class="product-action-bottom">';
			do_action( 'woocommerce_after_shop_loop_item' );
			echo ri_quartz_wishlist_button();
			echo ri_quartz_add_compare();
			echo '</div>';
			?>
			</div>
		</div>
		<?php
		if($countdown == '1') {
			$current_date = date('Y-m-d');
			$sale_price_dates_from = ($date = get_post_meta(get_the_ID(), '_sale_price_dates_from', true)) ? date_i18n('Y-m-d', $date) : '';
			$sale_price_dates_to = ($date = get_post_meta(get_the_ID(), '_sale_price_dates_to', true)) ? date_i18n('Y-m-d', $date) : '';

			if ($sale_price_dates_to != '' && $sale_price_dates_from <= $current_date) {
				$array_date = explode('-', $sale_price_dates_to);
				?>
				<div class="deal-countdown al-center"><?php echo ($products_layout != 'layout-3') ? esc_html__('Expires in:', 'ri-quartz') : ''; ?><span
						class="countdown <?php echo esc_attr($products_layout); ?>"
						data-date="<?php echo esc_attr($array_date[0]); ?>/<?php echo esc_attr($array_date[1]); ?>/<?php echo esc_attr($array_date[2]); ?>"></span>
				</div>
				<?php
			}
		}
		?>
	</div>
</li>
