<?php
function buddyforms_permissions_unregistered_screen() {
	global $post, $buddyform;

	$form_slug = $post->post_name;

	$form_setup = array();

	if(!$buddyform){
		$buddyform = get_post_meta( get_the_ID(), '_buddyforms_options', true );
	}

	echo '<h4>' . __('Unregistered User', 'buddyforms') . '</h4><br>';

	$public_submit = !isset( $buddyform['public_submit'] ) ? '' : 'public_submit';
	$form_setup[] = new Element_Checkbox( '<b>' . __( 'Public Submittable', 'buddyforms' ) . '</b>', "buddyforms_options[public_submit]", array( 'public_submit' => __( 'This Form is accessible for unregistered users', 'buddyforms' ) ), array( 'value' => $public_submit, 'shortDesc' => 'Please use the CAPTCHA form element if this option is enabled to make sure you site is save.' ) );

	$public_submit_login = isset( $buddyform['public_submit_login'] ) ? $buddyform['public_submit_login'] : 'above';
	$form_setup[] = new Element_Select( '<b>' . __( 'Enable Login on the form', 'buddyforms' ) . '</b>', "buddyforms_options[public_submit_login]", array( 'none' => __( 'None', 'buddyforms' ), 'above' => __( 'Above the Form', 'buddyforms' ), 'under' => __( 'Under the Form', 'buddyforms' ) ), array( 'value' => $public_submit_login, 'shortDesc' => 'Give your existing customers the choice to login. Just place a login form above or under the form. The Login Form is only visible for logged of user.' ) );

	$public_submit_create_account = !isset( $buddyform['public_submit_create_account'] ) ? '' : 'public_submit_create_account';
	$form_setup[] = new Element_Checkbox( '<b>' . __( 'Create an account?', 'buddyforms' ) . '</b>', "buddyforms_options[public_submit_create_account]", array( 'public_submit_create_account' => __( 'Create account during submission', 'buddyforms' ) ), array( 'value' => $public_submit_create_account, 'shortDesc' => 'Create a new user during form submission' ) );

	$public_submit_username_from_email = !isset( $buddyform['public_submit_username_from_email'] ) ? '' : 'public_submit_username_from_email';
	$form_setup[] = new Element_Checkbox( '<b>' . __( 'Automatically generate username from eMail', 'buddyforms' ) . '</b>', "buddyforms_options[public_submit_username_from_email]", array( 'public_submit_username_from_email' => __( 'Generate Username from eMail', 'buddyforms' ) ), array( 'value' => $public_submit_username_from_email, 'shortDesc' => 'This option only works with the eMail Form Element added to the Form. Please make sure you have the User eMail form element added to the form.' ) );


	?>
	<div class="fields_header">
		<table class="wp-list-table widefat posts striped">
			<tbody id="the-list">
			<?php
			if ( isset( $form_setup ) ) {
				foreach ( $form_setup as $key => $field ) { ?>
					<tr id="row_form_title">
						<th scope="row">
							<label for="role_role"><?php echo $field->getLabel() ?></label>
						</th>
						<td>
							<?php echo $field->render() ?>
							<p class="description"><?php echo $field->getShortDesc() ?></p>
						</td>
					</tr>
					<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>

	<?php


}

function buddyforms_permissions_screen() {
	global $post, $buddyform;

	$form_slug = $post->post_name;

	$form_setup = array();

	if(!$buddyform){
		$buddyform = get_post_meta( get_the_ID(), '_buddyforms_options', true );
	}


	echo '<br><br><div class="bf-roles-main-desc">
			<h4>' . __('Logged in User', 'buddyforms') . '</h4><br>
			<p>' . __( 'Control who can create, edit and delete content that is created from this form for each user role. If you want to create additional custom user roles, we recommend the Members plugin.', 'buddyforms' ) . '</p>
			</div>';

		foreach ( get_editable_roles() as $role_name => $role_info ):

			$default_roles[ 'create' ] = '';
			$default_roles[ 'edit' ]   = '';
			$default_roles[ 'delete' ] = '';

			$form_user_role = array();

			foreach ( $role_info['capabilities'] as $capability => $_ ):

				$capability_array = explode( '_', $capability );

				if ( $capability_array[0] == 'buddyforms' ) {

					if ( $capability_array[1] == $form_slug ) {

						$form_user_role[ $capability_array[2] ] = $capability_array[2];
						//$default_roles[ $capability_array[2] ]  = '';

					}
				}


			endforeach;


			if($role_name == 'administrator'){

//				foreach($default_roles as $role_n_a => $role_a)
//					$form_user_role[$role_n_a] = $role_n_a;

				$form_setup[] = new Element_Checkbox( '<b>' . $role_name . '</b>', 'buddyforms_roles[' . $role_name . ']', $default_roles, array(
					'value'     => $form_user_role,
					'inline'    => true,
					'style'     => 'margin-right: 60px;',
					'shortDesc' => 'Admin rights can not get changed'
				) );

			} else {
				$form_setup[] = new Element_Checkbox( '<b>' . $role_name . '</b>', 'buddyforms_roles[' . $role_name . ']', $default_roles, array(
					'value'  => $form_user_role,
					'inline' => true,
					'style'  => 'margin-right: 60px;'
				) );

			}

		endforeach;
			?>
			<div class="fields_header">
				<table class="wp-list-table widefat posts striped bf_permissions">
					<thead>
						<tr>
							<th class="field_label"><?php _e('Role', 'buddyforms') ?></th>
							<th class="field_name"><?php _e('Create - Edit - Delete', 'buddyforms') ?><a style="float: right;" href="#" class="bf_check_all"><?php _e( 'Check all', 'buddyforms' ) ?></a></th>
						</tr>
					</thead>
					<tbody id="the-list">
					<?php
					if ( isset( $form_setup ) ) {
						foreach ( $form_setup as $key => $field ) {

							$type  = $field->getAttribute( 'type' );

							if($type == 'html'){
								echo '<tr id="table_row_' . $field_id . '_' . $key . '" class="' . $class . '"><td colspan="2">';
								$field->render();
								echo '</td></tr>';
							} else { ?>
								<tr id="row_form_title">
									<th scope="row">
										<label for="role_role"><?php echo $field->getLabel() ?></label>
									</th>
									<td>
										<?php echo $field->render() ?>
										<p class="description"><?php echo $field->getShortDesc() ?></p>
									</td>
								</tr>
							<?php }
						}
					}
					?>
					</tbody>
				</table>
			</div>
			<?php

}

function buddyforms_form_setup_nav_li_permission(){ ?>
	<li class="permission_nav"><a class="permission bf_hide_if_post_type_none"
		href="#permission"
		data-toggle="tab"><?php _e( 'Permission', 'buddyforms' ); ?></a>
	</li><?php
}
add_action('buddyforms_form_setup_nav_li_last', 'buddyforms_form_setup_nav_li_permission');

function buddyforms_form_setup_tab_pane_permission(){
	global $post; ?>
	<div class="tab-pane fade in" id="permission">
		<div class="buddyforms_accordion_permission">
			<?php buddyforms_permissions_unregistered_screen() ?>
			<?php buddyforms_permissions_screen(); ?>
		</div>
	</div><?php
}
add_action('buddyforms_form_setup_tab_pane_last', 'buddyforms_form_setup_tab_pane_permission');