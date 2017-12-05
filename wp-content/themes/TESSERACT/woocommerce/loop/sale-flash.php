<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    global $post, $product;
    if ( ! $product->is_in_stock() ) return;
    $sale_price = get_post_meta( $product->id, '_price', true);
    $regular_price = get_post_meta( $product->id, '_regular_price', true);
    if (empty($regular_price)){ //then this is a variable product
        $available_variations = $product->get_available_variations();
        $variation_id=$available_variations[0]['variation_id'];
        $variation= new WC_Product_Variation( $variation_id );
        $regular_price = $variation ->regular_price;
        $sale_price = $variation ->sale_price;
    }
    $sale = ceil(( ($regular_price - $sale_price) / $regular_price ) * 100);
?>
<?php if ( !empty( $regular_price ) && !empty( $sale_price ) && $regular_price > $sale_price ) : ?>
    <?php 
    	$sale_tag_bck  = (get_theme_mod('tesseract_woocommerce_salebgcolor')) ? get_theme_mod('tesseract_woocommerce_salebgcolor') : '#77a464';
    	$sale_tag_txt  = (get_theme_mod('tesseract_woocommerce_saletextcolor')) ? get_theme_mod('tesseract_woocommerce_saletextcolor') : '#fff';

    	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale" style="background-color:'.$sale_tag_bck.'; color:'.$sale_tag_txt.';">Sale</span>', $post, $product );
    ?>
<?php endif; ?>