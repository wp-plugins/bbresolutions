<?php

namespace bbResolutions;

add_action( 'template_redirect', 'bbResolutions\topic_actions_handler', 11 );

/**
 * @return void
 * @since 0.1
 */
function topic_actions_handler() {

	if ( ! isset( $_POST['bbr_action'] ) ) {
		return FALSE;
	}

	if ( 'bbr_update_topic_resolution' !== $_POST['bbr_action'] ) {
		return FALSE;
	}

	if ( ! isset( $_POST['bbr_nonce'] ) ) {
		return FALSE;
	}

	if ( ! wp_verify_nonce( $_POST['bbr_nonce'], 'bbr_topic_resolution' ) ) {
		return FALSE;
	}

	if ( ! isset( $_POST['bbr_topic_id'] ) ) {
		return FALSE;
	}

	$topic_id = intval( $_POST['bbr_topic_id'] );

	if ( ! $topic_id || ! bbp_is_topic( $topic_id ) ) {
		return FALSE;
	}

	if ( ! current_user_can( 'edit_topic', $topic_id ) ) {
		return FALSE;
	}

	if ( ! isset( $_POST['bbr_topic_resolution'] ) ) {
		return FALSE;
	}

	if ( ! empty( $_POST['bbr_topic_resolution'] ) ) {
		update_topic_resolution( $topic_id, $_POST['bbr_topic_resolution'] );
	} else {
		delete_topic_resolution( $topic_id );
	}

    // Redirect to the topic page.
    wp_safe_redirect( bbp_get_topic_permalink( $topic_id ) );

    // For good measure
    exit();

}