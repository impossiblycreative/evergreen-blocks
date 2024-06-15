<?php $intro_text = get_field( 'intro_text' ); ?>

<?php if ( ! empty( $intro_text ) ) : ?>
    <div class="sidebar-intro three-columns archer">
        <?php echo wp_kses_post( $intro_text ); ?>
    </div>
<?php endif; ?>