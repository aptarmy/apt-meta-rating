<?php
/*
Plugin Name: APT Post Star Rating
Description: Display star-rating for specified post.
Author: Mr.Pakpoom Tiwakornkit
Version: 1.0
*/
/**
 * Rating star for post. include this file to add metabox and save meta data to database.
 * use this code to show meta rating "apt_post_rating();"
 */

/**
 * Function to add metabox
 */
function apt_metabox_rating_register() {
	add_meta_box( 'apt_meta_rating', __( 'Post Rating', 'apt' ), 'apt_metabox_rating_form', 'post', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'apt_metabox_rating_register' );

/**
 * Call back function
 */
function apt_metabox_rating_form( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'apt_nonce' ); // For security check. Read WP document for more infomation.
    $apt_stored_meta = get_post_meta( $post->ID );
    ?>
 
    <p>
        <label for="apt_meta_rating" ><?php _e( 'Rate your post by draging range here.', 'apt' )?></label>
        <input type="range" min="0" max="100" step="1" name="apt_meta_rating" onchange="apt_meta_rating_output.value=value" value="<?php if ( isset ( $apt_stored_meta['apt_meta_rating'] ) ) echo $apt_stored_meta['apt_meta_rating'][0]; ?>" />
		<output id="apt_meta_rating_output"><?php if ( isset ( $apt_stored_meta['apt_meta_rating'] ) ) echo $apt_stored_meta['apt_meta_rating'][0]; ?></output>
    </p>
 
    <?php
}

/**
 * Saves the custom meta input
 */
function apt_metabox_rating_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'apt_nonce' ] ) && wp_verify_nonce( $_POST[ 'apt_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'apt_meta_rating' ] ) ) {
        update_post_meta( $post_id, 'apt_meta_rating', sanitize_text_field( $_POST[ 'apt_meta_rating' ] ) );
    }
}
add_action( 'save_post', 'apt_metabox_rating_save' );


if (!function_exists('apt_meta_rating_get')):
	/**
	 * Display post star rating using metadata(metabox)
	 * This function should be used within the loop.
	 * the HTML structure will be...
	 * meta.rating > meta-rating-background > meta-rating-color
	 */
	function apt_meta_rating_get(){
		$meta_value = get_post_meta( get_the_ID(), 'apt_meta_rating', true );
		if( !empty( $meta_value ) ) {
		?>
			<div class="meta-rating">
				<span class="meta-rating-background">
					<span class="meta-rating-color"></span>
				</span>
			</div>
			<style>
				.meta-rating {
					font-size: 1em;
					height: 1em;
					width: 5em;
					position: relative;
					font-family: 'Genericons';
				}
				.meta-rating-background {
					color: wheat;
					position: absolute;
					display: inline-block;
				}
				.meta-rating-background:after {
					content: "\f512\f512\f512\f512\f512";
				}
				.meta-rating-color {
					width: <?php echo $meta_value; ?>%;
					color: red;
					overflow: hidden;
					position: absolute;
					display: inline-block;
				}
				.meta-rating-color:after {
					content: "\f512\f512\f512\f512\f512";
				}
			</style>
		<?php
		}

	}
endif;
/**
 * To display meta data added to a post use this code in the loop
 */
//$meta_value = get_post_meta( get_the_ID(), 'apt_meta_rating', true );
//if( !empty( $meta_value ) ) {
//	echo $meta_value;
//}

/**
 * To delete all post meta values spacified by key, use this code
 */
//delete_post_meta_by_key('apt_meta_rating');
