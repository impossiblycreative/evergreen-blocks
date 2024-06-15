<div class="ordering grid">
    <h2 class="section-title archer offset-3"><?php esc_html_e( 'Order', 'evergreen' ); ?></h2>

    <div class="order-headers twelve-columns grid">
        <div class="order-header filters-header three-columns">
            <?php esc_html_e( 'Select Category', 'evergreen' ); ?>
        </div>

        <div class="order-header product-header three-columns">
            <?php esc_html_e( 'Product', 'evergreen' ); ?>
        </div>

        <div class="order-header product-attributes-header five-columns">
            <div class="two-columns">
                <?php esc_html_e( 'Size', 'evergreen' ); ?>
            </div>
            <div class="two-columns">
                <?php esc_html_e( 'Count', 'evergreen' ); ?>
            </div>
            <div class="one-column">
                <?php esc_html_e( 'Qty', 'evergreen' ); ?>
            </div>
        </div>

        <div class="order-header product-header one-column">
        </div>
    </div>

    <div class="order-body twelve-columns grid">
        <div class="ordering-filters three-columns">
            <?php 
                $product_category_args = array(
                    'taxonomy'  => 'product_cat',
                    'orderby'   => 'name',
                );

                $product_categories = get_categories( $product_category_args );
            ?>

            <?php if ( ! empty( $product_categories ) ) : ?>
                <ul class="product-categories">
                    <?php foreach( $product_categories as $product_category ) : ?>
                        <li class="product-category-container">
                            <a class="product-category grid" href="#">
                                <span class="category-name two-columns"><?php echo esc_html( $product_category->name ); ?></span>
                                <span class="cross one-column">
                                    <span class="cross-horizontal"></span>
                                    <span class="cross-vertical"></span>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php 
            $product_args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
            );

            $products = new WP_Query( $product_args );
        ?>
        
        <?php if ( $products->have_posts() ) : ?>
            <div class="product-list nine-columns">
                <?php while ( $products->have_posts() ) : ?>
                    <?php $products->the_post(); ?>

                    <?php $product = wc_get_product( get_the_ID() ); ?>

                    <div class="product-listing">
                        <div class="name-description three-columns">
                            <span class="product-sku"><?php echo esc_html( $product->get_sku() ); ?></span>
                            <span class="product-name"><?php echo esc_html( $product->get_name() ); ?></span>
                            <span class="product-description"><?php echo esc_html( $product->get_short_description() ); ?></span>
                        </div>

                        <div class="attributes five-columns">
                            <div class="size two-columns">
                                <span><?php echo esc_html( $product->get_attribute( 'Size' ) ); ?></span>
                            </div>

                            <div class="count two-columns">
                                <span><?php echo esc_html( $product->get_attribute( 'Count' ) ); ?></span>
                            </div>

                            <div class="quantity one-column">
                                <a class="decrease-quantity" href="#">-</a>
                                <input type="number" id="product-<?php echo get_the_ID(); ?>-quantity" name="quantity" min="0" max="100" />
                                <a class="increase-quantity" href="#">+</a>
                            </div>
                        </div>

                        <div class="add-to-cart-container">
                            <a id="add-product-<?php echo get_the_ID(); ?>-to-card" class="add-to-cart-button hidden" href="#"><?php esc_html_e( 'Add To Cart', 'evergreen' ) ?></a>
                        </div>
                    </div>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    jQuery( document ).ready( function( $ ) {
        const productFilters    = $( '.product-category' );
        const decreasers        = $( '.decrease-quantity' );
        const increasers        = $( '.increase-quantity' );
        const quantities        = $( '.quantity' );
        const addToCarts        = $( '.add-to-cart-button' );

        $( productFilters ).each( function(){
            $( this ).on( 'click', function( event ){
                $( this ).toggleClass( 'active' );
            } );
        } );

        // Decreases the quantity of a product by 1
        $( decreasers ).each( function() {
            $( this ).on( 'click', function( event ){
                
                let quantityField = $( event.target ).siblings( 'input' );
                let quantityValue = parseInt( $( quantityField ).val() );
                
                if ( quantityValue > 1 ) {
                    $( quantityField ).val( parseInt( quantityValue ) - 1);
                } else {
                    $( quantityField ).val( 0 );
                    $( event.target ).parent().parent().next( '.add-to-cart-container' ).children( '.add-to-cart-button' ).addClass( 'hidden' ); 
                }
            } );
        } );

        // Increases the quantity of a product by 1
        $( increasers ).each( function() {
            $( this ).on( 'click', function( event ){
                
                let quantityField = $( event.target ).siblings( 'input' );
                let quantityValue = parseInt( $( quantityField ).val() );
                
                if ( quantityValue > 0 ) {
                    $( quantityField ).val( parseInt( quantityValue ) + 1);
                    $( event.target ).parent().parent().next( '.add-to-cart-container' ).children( '.add-to-cart-button' ).removeClass( 'hidden' ); 
                } else {
                    $( quantityField ).val( 1 );
                    $( event.target ).parent().parent().next( '.add-to-cart-container' ).children( '.add-to-cart-button' ).removeClass( 'hidden' ); 
                }
            } );
        } );

        // Toggles the visibility of the Add to Cart button based on quantity
        $( quantities ).each( function(){
            $( this ).on( 'change', function( event ) {
                if ( $( event.target ).val() > 0 ) {
                    $( event.target ).parent().parent().next( '.add-to-cart-container' ).children( '.add-to-cart-button' ).removeClass( 'hidden' ); 
                } else {
                    $( event.target ).parent().parent().next( '.add-to-cart-container' ).children( '.add-to-cart-button' ).addClass( 'hidden' ); 
                }
            } );
        } );

        $( addToCarts ).each( function() {
            $( this ).on( 'click', function( event ){
                console.log( 'add to cart' );
            } );
        } );
    } );
</script>