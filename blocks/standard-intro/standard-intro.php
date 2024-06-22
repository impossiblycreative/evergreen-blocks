<?php $intro_text = get_field( 'intro_text' ); ?>

<?php if ( ! empty( $intro_text ) ) : ?>
    <?php if ( is_account_page() ) : ?>
        <?php if ( is_user_logged_in() ) : ?>
            <div class="standard-intro nine-columns archer">
                <?php echo wp_kses_post( $intro_text ); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>