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
      <input type="hidden" name="from" value="profile"/>
      <input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>"/>
    </p>

	  <?php do_action( 'profile_personal_options', $profileuser ); ?>

    <table class="tml-form-table" style="width: 100%">
      <tr class="tml-user-login-wrap">
        <th><label for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label></th>
        <td>
          <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text"/>
          <span class="description"><?php _e( 'Usernames cannot be changed.', 'theme-my-login' ); ?></span></td>
      </tr>

      <tr class="tml-nickname-wrap">
        <th><label for="nickname"><?php _e( 'Nickname', 'theme-my-login' ); ?>
            <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
        <td>
          <input type="text" name="nickname" id="nickname" class="input" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text"/>
        </td>
      </tr>

      <tr class="tml-user-email-wrap">
        <th><label for="email">논문 제출 및 심사용 이메일
            <span class="description"><?php _e( '(required)', 'theme-my-login' ); ?></span></label></th>
        <td>
          <input type="text" name="email" id="email" class="input" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text"/>
        </td>
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

      <tr class="pass1-wrap">
        <th>
          <label for="pass1_custom"><?php _e( 'New Password', 'theme-my-login' ); ?></label>
        </th>
        <td>
          <input autocomplete="off" name="pass1" id="pass1_custom" class="input" size="20" value="" type="password" />
        </td>
      </tr>
      <tr class="pass2-wrap">
        <th>
          <label for="pass2_custom"><?php _e( 'Confirm Password', 'theme-my-login' ); ?></label>
        </th>
        <td>
          <input autocomplete="off" name="pass2" id="pass2_custom" class="input" size="20" value="" type="password" />
        </td>
      </tr>

      <tr class="kpm_name_kr-wrap">
        <th><label for="kpm_name_kr">회원 이름 (한글)</label></th>
        <td>
          <input type="text" name="kpm_name_kr" id="kpm_name_kr" class="input" value="<?php echo esc_attr( $profileuser->kpm_name_kr ); ?>" class="regular-text"/>
        </td>
      </tr>

      <tr class="kpm_name_en-wrap">
        <th><label for="kpm_name_en">회원 이름 (영문)</label></th>
        <td>
          <input type="text" name="kpm_name_en" id="kpm_name_en" class="input" value="<?php echo esc_attr( $profileuser->kpm_name_en ); ?>" class="regular-text"/>
        </td>
      </tr>

      <tr class="kpm_affiliation-wrap">
        <th><label for="kpm_affiliation_en">소속 단체</label></th>
        <td>
          <input type="text" name="kpm_affiliation" id="kpm_affiliation" class="input" value="<?php echo esc_attr( $profileuser->kpm_affiliation ); ?>" class="regular-text"/>
        </td>
      </tr>

      <tr class="kpm_telephone-wrap">
        <th><label for="kpm_telephone">유선 전화 번호</label></th>
        <td>
          <input type="text" name="kpm_telephone" id="kpm_telephone" class="input" value="<?php echo esc_attr( $profileuser->kpm_telephone ); ?>" class="regular-text"/>
        </td>
      </tr>

      <tr class="kpm_mobile_phone-wrap">
        <th><label for="kpm_mobile_phone">이동 전화 번호</label></th>
        <td>
          <input type="text" name="kpm_mobile_phone" id="kpm_mobile_phone" class="input" value="<?php echo esc_attr( $profileuser->kpm_mobile_phone ); ?>" class="regular-text"/>
        </td>
      </tr>

    </table>

	  <?php do_action( 'show_user_profile', $profileuser ); ?>

    <p class="tml-submit-wrap">
      <input type="hidden" name="action" value="profile"/>
      <input type="hidden" name="instance" value="<?php $template->the_instance(); ?>"/>
      <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>"/>
      <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" id="submit"/>
    </p>
  </form>
</div>
