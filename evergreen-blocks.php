<?php
/*****************************************************************
* Plugin Name:  Evergreen Blocks
*
* Author:       Alexis Soucie (for Codeable)
* Author URI:   https://app.codeable.io/tasks/new?preferredContractor=97308
* Description:  Custom Blocks for the EverGreen Packaging & Distribution website
* Version:      1.0
*
* Text Domain:  evergreen-blocks
*****************************************************************/

/**
 * We use WordPress's init hook to make sure
 * our blocks are registered early in the loading
 * process.
 *
 * @link https://developer.wordpress.org/reference/hooks/init/
 */
function evergreen_register_acf_blocks() {
    /**
     * We register our block's with WordPress's handy
     * register_block_type();
     *
     * @link https://developer.wordpress.org/reference/functions/register_block_type/
     */
}
// Here we call our tt3child_register_acf_block() function on init.
add_action( 'init', 'evergreen_register_acf_blocks' );