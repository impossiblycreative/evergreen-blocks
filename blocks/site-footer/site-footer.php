<?php 
    $address    = get_field( 'address', 'options' );
    $copyright  = get_field( 'copyright', 'options' );
    $credits    = get_field( 'site_credits', 'options' );
?>

<div class="site-footer twelve-columns">
    <div class="footer-left three-columns offset-3">
        <p class="company-name">
            <?php esc_html_e( 'EverGreen', 'evergreen' ); ?><br />
            <?php esc_html_e( 'Food Service Packaging and Distribution', 'evergreen' ); ?>
        </p>

        <?php if ( ! empty( $address ) ) : ?>
            <address><?php echo wp_kses_post( $address ); ?></address>
        <?php endif; ?>
    </div>

    <div class="footer-right five-columns">
        <p class="copyright"><?php esc_html_e( 'Copyright', 'evergreen' ); ?>&nbsp;&copy;&nbsp;<?php echo date( 'Y' ); ?>&nbsp;<?php echo esc_html( $copyright['copyright_credit'] ); ?></p>
        <p class="trademark"><?php echo wp_kses_post( $copyright['copyright_text'] ); ?></p>
        <p class="credits"><?php echo wp_kses_post( $credits ); ?></p>
    </div>
</div>