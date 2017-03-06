<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		<p>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		</p>

		

		<?php do_action( 'profile_personal_options', $profileuser ); ?>


		<table class="tml-form-table" style="width: 100%">
		<tr class="tml-user-login-wrap">
			<th><label for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label></th>
			<td><input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Usernames cannot be changed.', 'theme-my-login' ); ?></span></td>
		</tr>

		<tr class="tml-nickname-wrap">
			<th><label for="nickname"><?php _e( 'Nickname', 'theme-my-login' ); ?> <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
			<td><input type="text" name="nickname" id="nickname" class="input" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
		</tr>

		<tr class="tml-user-email-wrap">
			<th><label for="email">논문 제출 및 심사용 이메일 <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
			<td><input type="text" name="email" id="email" class="input"  value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" /></td>
			<?php
			$new_email = get_option( $current_user->ID . '_new_email' );
			if ( $new_email && $new_email['newemail'] != $current_user->user_email ) : ?>
			<div class="updated inline">
			<p><?php
				printf(
					__( 'There is a pending change of your e-mail to %1$s. <a href="%2$s">Cancel</a>', 'theme-my-login' ),
					'<code>' . $new_email['newemail'] . '</code>',
					esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
			); ?></p>
			</div>
			<?php endif; ?>
		</tr>

		<tr class="kpm_name_kr-wrap">
			<th><label for="kpm_name_kr">회원 이름 (한글)</label></th>
			<td><input type="text" name="kpm_name_kr" id="kpm_name_kr" class="input" value="<?php echo esc_attr( $profileuser->kpm_name_kr ); ?>" class="regular-text" /></td>
		</tr>

		<tr class="kpm_name_en-wrap">
			<th><label for="kpm_name_en">회원 이름 (영문)</label></th>
			<td><input type="text" name="kpm_name_en" id="kpm_name_en" class="input" value="<?php echo esc_attr( $profileuser->kpm_name_en ); ?>" class="regular-text" /></td>
		</tr>

		<tr class="kpm_affiliation-wrap">
			<th><label for="kpm_affiliation_en">소속 단체</label></th>
			<td><input type="text" name="kpm_affiliation" id="kpm_affiliation" class="input" value="<?php echo esc_attr( $profileuser->kpm_affiliation ); ?>" class="regular-text" /></td>
		</tr>

		<tr class="kpm_telephone-wrap">
			<th><label for="kpm_telephone">유선 전화 번호</label></th>
			<td><input type="text" name="kpm_telephone" id="kpm_telephone" class="input" value="<?php echo esc_attr( $profileuser->kpm_telephone ); ?>" class="regular-text" /></td>
		</tr>

		<tr class="kpm_mobile_phone-wrap">
			<th><label for="kpm_mobile_phone">이동 전화 번호</label></th>
			<td><input type="text" name="kpm_mobile_phone" id="kpm_mobile_phone" class="input" value="<?php echo esc_attr( $profileuser->kpm_mobile_phone ); ?>" class="regular-text" /></td>
		</tr>

		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>
		
		<tr id="password" class="user-pass1-wrap">
			<th><label for="pass1"><?php _e( 'New Password', 'theme-my-login' ); ?></label></th>
			<td>
				<input class="hidden" value=" " /><!-- #24364 workaround -->
				<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
				<div class="wp-pwd hide-if-js">
					<span class="password-input-wrapper">
						<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
					</span>
					<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
					<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', 'theme-my-login' ); ?>">
						<span class="dashicons dashicons-hidden"></span>
						<span class="text"><?php _e( 'Hide', 'theme-my-login' ); ?></span>
					</button>
					<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', 'theme-my-login' ); ?>">
						<span class="text"><?php _e( 'Cancel', 'theme-my-login' ); ?></span>
					</button>
				</div>
			</td>
		</tr>
		<tr class="user-pass2-wrap hide-if-js">
			<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password', 'theme-my-login' ); ?></label></th>
			<td>
			<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
			<p class="description"><?php _e( 'Type your new password again.', 'theme-my-login' ); ?></p>
			</td>
		</tr>
		<tr class="pw-weak">
			<th><?php _e( 'Confirm Password', 'theme-my-login' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="pw_weak" class="pw-checkbox" />
					<?php _e( 'Confirm use of weak password', 'theme-my-login' ); ?>
				</label>
			</td>
		</tr>
		<?php endif; ?>

		</table>

		<?php do_action( 'show_user_profile', $profileuser ); ?>

		<p class="tml-submit-wrap">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" id="submit" />
		</p>
	</form>
</div>
