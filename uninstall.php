<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
delete_post_meta_by_key('apt_meta_rating');