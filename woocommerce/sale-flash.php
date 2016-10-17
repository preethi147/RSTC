<?php
/**
 * Single Product Sale Flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php
if (!$product->is_in_stock()) {

	echo '<span class="product-label label-out">' . esc_html(__('Out Stock', 'ri-quartz')) . '</span>';

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

	echo '<span class="product-label label-free">' . esc_html(__('Free', 'ri-quartz')) . '</span>';

} else {

	$postdate = get_the_time('Y-m-d');            // Post date
	$postdatestamp = strtotime($postdate);            // Timestamped post date
	$newness = 20;    // Newness in days
	if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp) { // If the product was published within the newness time frame display the new badge
		echo '<span class="product-label label-new">' . esc_html(__('New', 'ri-quartz')) . '</span>';
	}

}
?>


