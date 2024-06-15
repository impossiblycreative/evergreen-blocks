<?php
    $inner_blocks_template = array(
        array(
            'evergreen/sidebar-intro',
            'evergreen/standard-intro',
        ),
    );
?>

<InnerBlocks class="intro-text grid" template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>" />