<?php
/*
Plugin Name: Auto Delete Product Images
Plugin URI: http:/github.com/yoscibacco/auto-delete-product-images
Description: Automatically delete WooCommerce images when a product is deleted.
Version: 0.1
Author: Can Bacco
Author URI: http:/github.com/yoscibacco/
Update URI: http:/github.com/yoscibacco/auto-delete-product-images
GitHub Plugin URI: yoscibacco/auto-delete-product-images
GitHub Branch: main
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action( 'before_delete_post', 'delete_product_images', 10, 1 );

function delete_product_images( $post_id ) {
    $product = wc_get_product( $post_id );

    if ( ! $product ) {
        return;
    }

    $featured_image_id = $product->get_image_id();
    $image_galleries_id = $product->get_gallery_image_ids();

    if ( ! empty( $featured_image_id ) ) {
        wp_delete_post( $featured_image_id );
    }

    if ( ! empty( $image_galleries_id ) ) {
        foreach ( $image_galleries_id as $single_image_id ) {
            wp_delete_post( $single_image_id );
        }
    }
}