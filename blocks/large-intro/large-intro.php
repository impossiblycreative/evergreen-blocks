<?php 
    $custom_text    = get_field( 'display_custom_text' );
    $intro_text     = get_field( 'large_intro_text' ); 
?>

<?php if ( $custom_text ) : ?>
    <div class="large-intro archer grid">
        <?php echo wp_kses_post( $intro_text ); ?>
    </div>
<?php else : ?>
    <?php if ( is_page() ) : ?>
        <div class="large-intro archer grid">
    <?php else : ?>
        <div class="large-intro archer grid">
    <?php endif; ?>
        <?php if ( is_account_page() ) : ?>
            <?php if ( is_user_logged_in() ) : ?>
                <h1 class="offset-3"><?php echo esc_html_e( 'Account Profile', 'evergreen' ); ?></h1>
            <?php else : ?>
                <h1 class="offset-3"><?php echo esc_html_e( 'Sign in', 'evergreen' ); ?></h1>
            <?php endif; ?>            
        <?php else : ?>
            <h1 class="offset-3"><?php echo esc_html( get_the_title( get_the_ID() ) ); ?></h1>
        <?php endif; ?>
    </div>

    
    <?php if ( is_account_page() && ! is_user_logged_in() ) : ?>
        <div class="large-intro archer grid">
            <h1 class="offset-3">Register</h1>
        </div>
    <?php endif; ?>
<?php endif; ?>