<?php
    /**
 * A template string of blocks.
 * Need help converting block HTML markup to an array?
 * 👉 https://happyprime.github.io/wphtml-converter/
 *
 * @link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
 */
$inner_blocks_template = array(
	array(
		'core/navigation',
	),
);
?>

<div class="site-header grid">
    <div class="site-logo-container six-columns">
        <a href="/">
            <img class="site-logo" src="<?php echo trailingslashit( plugin_dir_url( __FILE__ ) ); ?>img/site-logo.svg" width="250" />
        </a>
    </div>

    <div class="site-navigation-container six-columns">
        <!-- This should only be the Navigation block -->
        <InnerBlocks class="site-navigation five-columns" template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>" />

        <!-- Cart Icon is SEPARATE -->
        <div class="cart-icon-container one-column">
            <a href="/cart" title="Cart">
                <img class="cart-icon" src="<?php echo trailingslashit( plugin_dir_url( __FILE__ ) ); ?>img/cart-icon.svg" width="35" />
            </a>
        </div>
    </div>
</div>