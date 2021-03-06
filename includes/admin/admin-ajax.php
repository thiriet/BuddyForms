<?php

/*
 * Get the post type taxonomies to load the new created form element select
 *
 *
 */
function buddyforms_post_types_taxonomies() {

	if ( ! isset( $_POST['post_type'] ) ) {
		echo 'false';
		die();
	}

	$post_type             = $_POST['post_type'];
	$buddyforms_taxonomies = buddyforms_taxonomies( $post_type );

	$tmp = '';
	foreach ( $buddyforms_taxonomies as $name => $label ) {
		$tmp .= '<option value="' . $name . '">' . $label . '</option>';
	}

	echo $tmp;
	die();

}

add_action( 'wp_ajax_buddyforms_post_types_taxonomies', 'buddyforms_post_types_taxonomies' );


function buddyforms_update_taxonomy_default() {

	if ( ! isset( $_POST['taxonomy'] ) || $_POST['taxonomy'] == 'none' ) {
		$tmp = '<option value="none">First you need to select a Taxonomy to select the Taxonomy defaults</option>';
		echo $tmp;
		die();
	}

	$taxonomy = $_POST['taxonomy'];

	$args = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false,
		'fields'     => 'id=>name',
	);

	$terms = get_terms( $taxonomy, $args );

	$tmp = '<option value="none">none</option>';
	foreach ( $terms as $key => $term_name ) {
		$tmp .= '<option value="' . $key . '">' . $term_name . '</option>';
	}

	echo $tmp;

	die();

}

add_action( 'wp_ajax_buddyforms_update_taxonomy_default', 'buddyforms_update_taxonomy_default' );

function buddyforms_form_template() {
	global $post, $buddyform;


	$post->post_type = 'buddyforms';


	switch ( $_POST['template'] ) {
		case 'contact' :
			$buddyform = json_decode( '{"form_fields":{"92f6e0cb6b":{"type":"user_first","slug":"user_first","name":"First Name","description":"","validation_error_message":"This field is required."},"8ead289ca0":{"type":"user_last","slug":"user_last","name":"Last Name","description":"","validation_error_message":"This field is required."},"87e0afb2d7":{"type":"user_email","slug":"user_email","name":"eMail","description":"","required":["required"],"validation_error_message":"This field is required."},"210ef7d8a8":{"type":"subject","slug":"subject","name":"Subject","description":"","required":["required"],"validation_error_message":"This field is required.","validation_minlength":"0","validation_maxlength":"0"},"0a256db3cb":{"type":"message","slug":"message","name":"Message","description":"","required":["required"],"validation_error_message":"This field is required.","validation_minlength":"0","validation_maxlength":"0"}},"form_type":"contact","after_submit":"display_message","after_submission_page":"none","after_submission_url":"","after_submit_message_text":"Your Message has been Submitted Successfully","post_type":"bf_submissions","status":"publish","comment_status":"open","singular_name":"","attached_page":"none","edit_link":"all","list_posts_option":"list_all_form","list_posts_style":"list","public_submit":["public_submit"],"public_submit_login":"above","registration":{"activation_page":"none","activation_message_from_subject":"User Account Activation Mail","activation_message_text":"Hi [user_login],\r\n\t\t\tGreat to see you come on board! Just one small step left to make your registration complete.\r\n\t\t\t<br>\r\n\t\t\t<b>Click the link below to activate your account.<\/b>\r\n\t\t\t<br>\r\n\t\t\t[activation_link]\r\n\t\t\t<br><br>\r\n\t\t\t[blog_title]\r\n\t\t","activation_message_from_name":"[blog_title]","activation_message_from_email":"[admin_email]","new_user_role":"subscriber"},"moderation_logic":"default","moderation":{"label_submit":"Submit","label_save":"Save","label_review":"Submit for moderation","label_new_draft":"Create new Draft","label_no_edit":"This Post is waiting for approval and can not be changed until it gets approved"},"name":"ssaSAS","slug":""}', true );
			break;
		case 'registration' :
			$buddyform = json_decode( '{"form_fields":{"a40912e1a5":{"type":"user_login","slug":"user_login","name":"Username","description":"","required":["required"],"validation_error_message":"This field is required."},"82abe39ed2":{"type":"user_email","slug":"user_email","name":"eMail","description":"","required":["required"],"validation_error_message":"This field is required."},"611dc33cb2":{"type":"user_pass","slug":"user_pass","name":"Password","description":"","required":["required"],"validation_error_message":"This field is required."}},"form_type":"registration","after_submit":"display_message","after_submission_page":"none","after_submission_url":"","after_submit_message_text":"User Registration Successful! Please check your eMail Inbox and click the activation link to activate your account.","post_type":"bf_submissions","status":"publish","comment_status":"open","singular_name":"","attached_page":"none","edit_link":"all","list_posts_option":"list_all_form","list_posts_style":"list","public_submit":["public_submit"],"public_submit_login":"above","registration":{"activation_page":"none","activation_message_from_subject":"User Account Activation Mail","activation_message_text":"Hi [user_login],\r\n\r\nGreat to see you come on board! Just one small step left to make your registration complete.\r\n<br>\r\n<b>Click the link below to activate your account.<\/b>\r\n<br>\r\n[activation_link]\r\n<br><br>\r\n[blog_title]","activation_message_from_name":"[blog_title]","activation_message_from_email":"dfg@dfg.fr","new_user_role":"author"},"moderation_logic":"default","moderation":{"label_submit":"Submit","label_save":"Save","label_review":"Submit for moderation","label_new_draft":"Create new Draft","label_no_edit":"This Post is waiting for approval and can not be changed until it gets approved"},"name":"Auto Draft","slug":""}', true );
			break;
		case 'post' :
			$buddyform = json_decode( '{"form_fields":{"51836a88da":{"type":"title","slug":"buddyforms_form_title","name":"Title","description":"","validation_error_message":"This field is required.","validation_minlength":"0","validation_maxlength":"","custom_class":""},"27ff0af6c6":{"type":"content","slug":"buddyforms_form_content","name":"Content","description":"","validation_error_message":"This field is required.","validation_minlength":"0","validation_maxlength":"0","custom_class":""}},"form_type":"post","after_submit":"display_message","after_submission_page":"none","after_submission_url":"","after_submit_message_text":"Your Message has been Submitted Successfully","post_type":"post","status":"publish","comment_status":"open","singular_name":"","attached_page":"none","edit_link":"all","list_posts_option":"list_all_form","list_posts_style":"list","mail_submissions":{"03aa1b8b80":{"mail_trigger_id":"03aa1b8b80","mail_from_name":"eMail Notification","mail_to_address":"","mail_from":"mail@sven-lehnert.de","mail_to_cc_address":"","mail_to_bcc_address":"","mail_subject":"Form Submission Notification","mail_body":""}},"public_submit":["public_submit"],"public_submit_login":"above","registration":{"activation_page":"none","activation_message_from_subject":"User Account Activation Mail","activation_message_text":"Hi [user_login],\r\n\t\t\tGreat to see you come on board! Just one small step left to make your registration complete.\r\n\t\t\t<br>\r\n\t\t\t<b>Click the link below to activate your account.<\/b>\r\n\t\t\t<br>\r\n\t\t\t[activation_link]\r\n\t\t\t<br><br>\r\n\t\t\t[blog_title]\r\n\t\t","activation_message_from_name":"[blog_title]","activation_message_from_email":"[admin_email]","new_user_role":"subscriber"},"name":"Posts","slug":""}', true );
			break;
		default :
			$buddyform = json_decode( apply_filters( 'buddyforms_templates_json', $buddyform ) );
			break;
	}

	ob_start();
	buddyforms_metabox_form_elements( $post, $buddyform );
	$formbuilder = ob_get_clean();


	// Add the form elements to the form builder
	$json['formbuilder'] = $formbuilder;

	// Unset the form fields
	unset( $buddyform['form_fields'] );
	unset( $buddyform['mail_submissions'] );

	// Add the form setup to the json
	$json['form_setup'] = $buddyform;


	echo json_encode( $json );
	die();
}

add_action( 'wp_ajax_buddyforms_form_template', 'buddyforms_form_template' );


function buddyforms_new_page() {

	if ( ! is_admin() ) {
		return;
	}

	// Check if a title is entered
	if ( empty( $_POST['page_name'] ) ) {
		$json['error'] = 'Please enter a name';
		echo json_encode( $json );
		die();
	}

	// Create post object
	$new_page = array(
		'post_title'   => wp_strip_all_tags( $_POST['page_name'] ),
		'post_content' => '',
		'post_status'  => 'publish',
		'post_type'    => 'page'
	);

	// Insert the post into the database
	$new_page = wp_insert_post( $new_page );

	// Check if page creation worked successfully
	if ( is_wp_error( $new_page ) ) {
		$json['error'] = $new_page;
	} else {
		$json['id']   = $new_page;
		$json['name'] = wp_strip_all_tags( $_POST['page_name'] );
	}

	echo json_encode( $json );
	die();

}

add_action( 'wp_ajax_buddyforms_new_page', 'buddyforms_new_page' );


function buddyforms_url_builder() {
	global $post;
	$page_id   = $_POST['attached_page'];
	$form_slug = $_POST['form_slug'];
	$post      = get_post( $page_id );

	if ( isset( $post->post_name ) ) {
		$json['permalink'] = get_permalink( $page_id );
		$json['form_slug'] = $form_slug;
		echo json_encode( $json );
		die();
	}
	echo json_encode( 'none' );
	die();


}

add_action( 'wp_ajax_buddyforms_url_builder', 'buddyforms_url_builder' );