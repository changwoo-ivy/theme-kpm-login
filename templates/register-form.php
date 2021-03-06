<?php
/**
 * @var \Theme_My_Login_Template $template
 * @var \Theme_My_Login $theme_my_login
 */

/* theme **KPM** login's register form */
?>

<div class="tml tml-register" id="theme-my-login<?php $template->the_instance(); ?>">

	<?php $template->the_action_template_message( 'register' ); ?>
	<?php $template->the_errors(); ?>

    <form name="registerform" id="registerform<?php $template->the_instance(); ?>"
          action="<?php $template->the_action_url( 'register', 'login_post' ); ?>" method="post">

      <article id="tos-text">
        <?php
            $post = get_page_by_path('tos');
            if( ! $post ) {
                echo '회원 약관 페이지가 없습니다. 페이지를 만든 후 페이지 슬러그를 \'tos\'로 설정해 주세요.';
            } else {
                echo wpautop(wptexturize($post->post_content));
            }
        ?>
      </article>
        <p class="tml-user-agreement-wrap">
            <label for="kpm_user_agreement">
                <input type="checkbox" name="kpm_user_agreement" id="kpm_user_agreement" value="yes">약관에 동의합니다
            </label>
        </p>

		<?php if ( 'email' != $theme_my_login->get_option( 'login_type' ) ) : ?>
            <p class="tml-user-login-wrap">
                <label for="user_login<?php $template->the_instance(); ?>">로그인 ID</label>
                <input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input"
                       value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20"/>
            </p>
		<?php endif; ?>

        <p class="tml-user-email-wrap">
            <label for="user_email<?php $template->the_instance(); ?>">가입용 이메일</label>
            <input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input"
                   value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20"/>
            <label for="alt_email">
                <input type="checkbox" id="alt_email" name="alt_email"
                       value="yes" <?php echo $template->the_posted_value( 'alt_email' ) == 'yes' ? 'checked' : ''; ?>/>
                선택: 논문 제출 및 심사용 이메일을 별도로 사용.
            </label>
        </p>

        <p id="alt-email-group" style="display:none;">
            <label for="kpm_submission_email">논문 제출 및 심사용 이메일</label>
            <input type="text" name="kpm_submission_email" id="kpm_submission_email" class="input"
                   value="<?php $template->the_posted_value( 'kpm_submission_email' ); ?>" size="20"/>
        </p>

		<?php do_action( 'register_form' ); ?>

        <p class="kpm_name_kr-wrap">
            <label for="kpm_name_kr">회원 이름 (한글)</label>
            <input type="text" id="kpm_name_kr" name="kpm_name_kr" class="input"
                   value="<?php $template->the_posted_value( 'kpm_name_kr' ); ?>">
        </p>

        <p class="kpm_name_en-wrap">
            <label for="kpm_name_en">회원 이름 (영문)</label>
            <input type="text" id="kpm_name_en" name="kpm_name_en" class="input"
                   value="<?php $template->the_posted_value( 'kpm_name_en' ); ?>">
        </p>

        <p class="kpm_affiliation-wrap">
            <label for="kpm_affiliation">소속 단체</label>
            <input type="text" id="kpm_affiliation" name="kpm_affiliation" class="input"
                   value="<?php $template->the_posted_value( 'kpm_affiliation' ); ?>">
        </p>

        <p class="kpm_telephone-wrap">
            <label for="kpm_telephone">유선 전화 번호</label>
            <input type="text" id="kpm_telephone" name="kpm_telephone" class="input"
                   value="<?php $template->the_posted_value( 'kpm_telephone' ); ?>">
        </p>

        <p class="kpm_mobile_phone-wrap">
            <label for="kpm_mobile_phone">이동 전화 번호</label>
            <input type="text" id="kpm_mobile_phone" name="kpm_mobile_phone" class="input"
                   value="<?php $template->the_posted_value( 'kpm_mobile_phone' ); ?>">
        </p>

        <p class="tml-registration-confirmation" id="reg_passmail<?php $template->the_instance(); ?>">
			<?php echo apply_filters( 'tml_register_passmail_template_message', __( 'Registration confirmation will be e-mailed to you.', 'theme-my-login' ) ); ?>
        </p>

        <p class="tml-submit-wrap">
            <input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>"
                   value="<?php esc_attr_e( 'Register', 'theme-my-login' ); ?>"/>
            <input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>"/>
            <input type="hidden" name="instance" value="<?php $template->the_instance(); ?>"/>
            <input type="hidden" name="action" value="register"/>
        </p>

    </form>
	<?php $template->the_action_links( array( 'register' => false ) ); ?>
</div>

<script>
    (function ($) {
        $(document).ready(function () {
            $('input#alt_email').click(function () {
                if ($(this).is(':checked')) {
                    $('#alt-email-group').fadeIn(1000);
                }
                else {
                    $('#alt-email-group').hide();
                }
            });
        });
    })(jQuery);
</script>
