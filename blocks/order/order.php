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
                    <li class="product-category-container">
                        <a class="product-category grid active" href="#" data-category="all">
                            <span class="category-name two-columns"><?php esc_html_e( 'All Products', 'evergreen' ); ?></span>
                            <span class="cross one-column">
                                <span class="cross-horizontal"></span>
                                <span class="cross-vertical"></span>
                            </span>
                        </a>
                    </li>

                    <?php foreach( $product_categories as $product_category ) : ?>
                        <li class="product-category-container">
                            <a class="product-category grid active" href="#" data-category="<?php echo esc_html( $product_category->slug ); ?>">
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
        
        <?php if ( $products->have_posts() && is_user_logged_in() ) : ?>
            <div class="product-list nine-columns" data-active-filters="all">
                <?php while ( $products->have_posts() ) : ?>
                    <?php $products->the_post(); ?>

                    <?php 
                        $product    = wc_get_product( get_the_ID() );
                        $terms      = get_the_terms( $product->get_id(), 'product_cat' );
                    ?>

                    <div class="product-listing active <?php foreach( $terms as $term ) { echo esc_html( $term->slug ); } ?>">
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
                            <button id="add-product-<?php echo get_the_ID(); ?>-to-card" class="add-to-cart-button hidden" data-product-id="<?php echo get_the_ID(); ?>"><?php esc_html_e( 'Add To Cart', 'evergreen' ) ?></button>
                        </div>
                    </div>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="product-list nine-columns" data-active-filters="all">
                <?php esc_html_e( 'You must be logged in to order.', 'evergreen' ); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    jQuery( document ).ready( function( $ ) {
        const productFilters    = $( '.product-category' );
        const products          = $( '.product-listing' );
        const decreasers        = $( '.decrease-quantity' );
        const increasers        = $( '.increase-quantity' );
        const quantities        = $( '.quantity' );
        const addToCarts        = $( '.add-to-cart-button' );

        $( productFilters ).each( function(){
            $( this ).on( 'click', function( event ){
                event.preventDefault();

                const category = $( this ).data( 'category' );

                if ( category === 'all' ) {
                    if ( $( this ).hasClass( 'active' ) ) {
                        $( this ).removeClass( 'active' );

                        $ ( productFilters ).each( function() {
                            $( this ).removeClass( 'active' );
                        } );

                        $( products ).each( function() {
                            $( this ).removeClass( 'active' );
                        } );
                    } else {
                        $( this ).addClass( 'active' );

                        $ ( productFilters ).each( function() {
                            $( this ).addClass( 'active' );
                        } );

                        $( products ).each( function() {
                            $( this ).addClass( 'active' );
                        } );
                    }
                } else {
                    $( this ).toggleClass( 'active' );

                    $( products ).each( function() {
                        if ( $( this ).hasClass( category ) ) {
                            $( this ).toggleClass( 'active' );
                        }
                    } );
                }
            } );
        } );

        // Decreases the quantity of a product by 1
        $( decreasers ).each( function() {
            $( this ).on( 'click', function( event ){
                event.preventDefault();
                
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
                event.preventDefault();
                
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

        // Handles adding to the cart
        $( addToCarts ).each( function() {
            $( this ).on( 'click', function( event ){
                const quantity      = $( this ).parent().parent().children( '.attributes' ).children( '.quantity' ).children( 'input' ).val(); 
                const productID     = $( this ).data( 'product-id' );
                const productData   = {
                    product_id: productID,
                    quantity:   quantity
                };

                if ( 'undefined' === typeof wc_add_to_cart_params ) {
                    console.log( 'ERROR: The Add to Cart params are not present.' );

                    // The add to cart params are not present.
                    return false;
                }

                jQuery.post( wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'add_to_cart' ), productData, function( response ) {
                    if ( ! response ) {
                        return;
                    }

                    // This redirects the user to the product url if for example options are needed ( in a variable product ).
                    // You can remove this if it's not the case.
                    if ( response.error && response.product_url ) {
                        window.location = response.product_url;
                        return;
                    }

                    // Remove this if you never want this action redirect.
                    if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
                        window.location = wc_add_to_cart_params.cart_url;
                        return;
                    }

                    // This is important so your theme gets a chance to update the cart quantity for example, but can be removed if not needed.
                    $( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash ] );
                } );

            } );
        } );
    } );
</script>