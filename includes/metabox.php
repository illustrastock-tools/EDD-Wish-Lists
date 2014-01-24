<?php
/**
 * Admin metabox
 *
 * @since 1.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Metabox
 *
 * @since 1.0
*/
function edd_wl_add_meta_box() {
	if ( current_user_can( 'view_shop_reports' ) || current_user_can( 'edit_product', get_the_ID() ) ) {
		add_meta_box( 
			'edd_wish_list_products', 
			sprintf( __( '%1$s', 'edd' ), edd_get_label_plural() ), 
			'edd_wl_items_in_list_meta_box', 
			'edd_wish_list', 
			'normal', 
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'edd_wl_add_meta_box' );

/**
 * Show the items in each list
 *
 * @since 1.0
 * @return void
 */
function edd_wl_items_in_list_meta_box() {

	$items = get_post_meta( get_the_ID(), 'edd_wish_list', true );

	if ( $items ) {
		foreach ( $items as $item ) {
			$item_option 		= ! empty( $item['options'] ) ? '<span class="edd-wish-list-item-title-option">' . edd_get_cart_item_price_name( $item ) . '</span>' : '';

			echo '<a href="' . admin_url( 'post.php?post=' . $item['id'] . '&action=edit' ) . '">' . get_the_title( $item['id'] ) . '</a>' . ' &ndash; ' . $item_option . ' &ndash; ' . edd_cart_item_price( $item['id'], $item['options'] ) .  '<br/>';
		}
	} else {
		_e( 'No items have been added yet', 'edd-wish-lists' );
	}

}