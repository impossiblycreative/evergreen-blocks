<?php 
    $custom_text    = get_field( 'display_custom_text' );
    $intro_text     = get_field( 'large_intro_text' ); 
?>

<?php if ( $custom_text ) : ?>
    <div class="large-intro archer six-columns offset-3">
        <?php echo wp_kses_post( $intro_text ); ?>
    </div>
<?php else : ?>
    <div class="large-intro archer six-columns offset-3">
        <h1><?php echo esc_html( get_the_title( get_the_ID() ) ); ?></h1>
    </div>
<?php endif; ?>