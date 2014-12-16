<?php
/*
Plugin Name: App Release
Plugin URI: http://www.phiresearchlab.org/
Description: Declares a plugin that will create a custom post type for releasing mobile apps.
Version: 0.1
Author: Greg Ledbetter
Author URI: http://www.phiresearchlab.org/
License: Apache License 2.0
*/

add_action( 'init', 'create_app_release' );
add_action( 'admin_init', 'app_release_admin' );
add_action( 'save_post', 'add_app_release_fields', 10, 2 );

function create_app_release() {
    register_post_type( 'app_releases',
        array(
            'labels' => array(
                'name' => 'App Releases',
                'singular_name' => 'App Release',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New App Release',
                'edit' => 'Edit',
                'edit_item' => 'Edit App Release',
                'new_item' => 'New App Release',
                'view' => 'View',
                'view_item' => 'View App Release',
                'search_items' => 'Search App Releases',
                'not_found' => 'No App Releases found',
                'not_found_in_trash' => 'No App Releases found in Trash',
                'parent' => 'Parent App Release'
            ),

            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );
}

function app_release_admin() {
    add_meta_box( 'app_release_meta_box',
        'App Release Details',
        'display_app_release_meta_box',
        'app_releases', 'normal', 'high'
    );
}

function add_app_release_fields( $app_release_id, $app_release ) {

    // if post type is an app release
    if ( $app_release->post_type == 'app_releases' ) {

        // store data in post meta table if present in post data
        if ( isset( $_POST['app_name_input'] ) && $_POST['app_name_input'] != '' ) {
            update_post_meta( $app_release_id, 'app_name', $_POST['app_name_input'] );
        }
        if ( isset( $_POST['release_notes_input'] ) && $_POST['release_notes_input'] != '' ) {
            update_post_meta( $app_release_id, 'release_notes', $_POST['release_notes_input'] );
        }
    }
}

function display_app_release_meta_box( $app_release ) {

    // get current name of the app and release notes
    $app_name = esc_html( get_post_meta( $app_release->ID, 'app_name', true ) );
    $release_notes = esc_html( get_post_meta( $app_release->ID, 'release_notes', true ) );

    ?>
    <table>
        <tr>
            <td style="width: 100%">App Name</td>
            <td><input type="text" size="20" name="app_name_input" value="<?php echo $app_name; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Release Notes</td>
            <td><input type="text" size="20" name="release_notes_input" value="<?php echo $release_notes; ?>" /></td>
        </tr>
     </table>
<?php
}
?>
