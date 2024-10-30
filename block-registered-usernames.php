<?php
/**
 * Plugin Name: Block Registered Usernames in Comments
 * Description: You want to block comment nicknames and email adresses of registered users? This plugin solves this problem once and for all.
 * Plugin URI:  https://marc.tv
 * Version:     2.3
 * Author: Marc Tönsing
 * Author URI: https://marc.tv
 * Text Domain: block-registered-usernames
 * Domain Path: /languages
 * GitHub Plugin URI: mtoensing/block-registered-usernames
 */

function marctv_bru_display_error() {
	wp_die( '<strong>' . __( 'Publishing of comment failed.', 'block-registered-usernames' ) . '</strong><p>' . __( 'You tried to use a comment author name, nickname or an email address that is already registered.', 'block-registered-usernames' ) . ' <a href="' . wp_login_url() . '">' . __( 'Forgot to login?', 'block-registered-usernames' ) . '</a></p>', '', array( 'back_link' => true ) );
}

function marctv_additional_comment_validation( $comment_data ) {

	if ( ! is_user_logged_in() ) {

		$users            = get_users();
		$comment_username = strtolower( $comment_data["comment_author"] );
		$comment_email    = strtolower( $comment_data["comment_author_email"] );

		foreach ( $users as $user ) {

			if ( strtolower( $user->user_nicename ) == $comment_username ) {
				marctv_bru_display_error();
			}

			if ( strtolower( $user->display_name ) == $comment_username ) {
				marctv_bru_display_error();
			}

			if ( strtolower( $user->user_email ) == $comment_email ) {
				marctv_bru_display_error();
			}
		}

	}

	return $comment_data;

}

add_filter( 'preprocess_comment', 'marctv_additional_comment_validation' );

?>
