<?php
/*
Plugin Name: Theme KPM Login
Plugin URI:
Description: Theme My Login 의 스페인 라틴 아메리카 사이트 적용 플러그인입니다.
Author: 남창우
Author URI: mailto://changwoo@ivynet.co.kr
License: GPL2 or later
*/

/**
 * 우리 플러그인 최초 동작 액션
 */
add_action( 'plugins_loaded', 'tkl_init' );

/**
 * @callback
 * @action     plugins_loaded
 */
function tkl_init() {

	if ( ! defined( 'THEME_MY_LOGIN_PATH' ) ) {
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-error"><p><a href="http://www.jfarthing.com/extend/wordpress-plugins/theme-my-login/">Theme My Login 플러그인</a>이 비활성화 되어 있습니다. 논문 심사에 필요한 회원 가입과 로그인을 위해 이 플러그인을 활성화해 주세요.</p></div>';
		} );

		return;
	}

	/** 우리 플러그인의 경로를 템플릿으로 쓰도록 필터링 */
	add_filter( 'tml_template_paths', 'tkl_add_our_template' );
}


/**
 * @callback
 * @filter    tml_template_paths
 *
 * @param array $template_paths
 *
 * @return array
 */
function tkl_add_our_template( $template_paths ) {

	$our_path = __DIR__ . '/templates';

	return array_merge( array( $our_path ), $template_paths );
}


/**
 * 회원 가입 폼에서 잘못된 값이 있는지를 체크합니다.
 */
add_filter( 'registration_errors', 'tkl_registration_errors' );

/**
 * @callback
 * @filter    registration_errors
 * @see       register_new_user()
 *
 * @param WP_Error $errors
 *
 * @return WP_Error
 */
function tkl_registration_errors( $errors ) {

	if ( empty( isset( $_POST['kpm_name_kr'] ) && trim( $_POST['kpm_name_kr'] ) ) ) {
		$errors->add( 'empty_kpm_name_kr', '한글 회원 이름을 채워 주세요' );
	}

	if ( empty( isset( $_POST['kpm_name_en'] ) && trim( $_POST['kpm_name_en'] ) ) ) {
		$errors->add( 'empty_kpm_name_en', '영문 회원 이름을 채워 주세요' );
	}

	if ( empty( isset( $_POST['kpm_affiliation'] ) && trim( $_POST['kpm_affiliation'] ) ) ) {
		$errors->add( 'empty_kpm_affiliation', '소속단체를 입력해 주세요' );
	}

	if ( empty( isset( $_POST['kpm_kpm_telephone'] ) && trim( $_POST['kpm_kpm_telephone'] ) ) ) {
		$errors->add( 'empty_kpm_telephone', '유선전화 번호를 입력해 주세요' );
	}

	if ( empty( isset( $_POST['kpm_kpm_mobile_phone'] ) && trim( $_POST['kpm_kpm_mobile_phone'] ) ) ) {
		$errors->add( 'empty_kpm_mobile_phone', '이동전화 번호를 입력해 주세요' );
	}

	return $errors;
}


/**
 * 사용자 메타 값을 채워 넣습니다.
 */
add_action( 'user_register', 'tkl_user_register' );

/**
 * 프로필 업데이트 때의 훅
 */
add_action( 'profile_update', 'tkl_user_register', 10, 1 );

/**
 * 회원 가입 폼으로부터 전달된 값을 usermeta 필드로 저장합니다.
 * 각 필드의 키들은 ku-paper-manager 플러그인의 docs/data-types.md 파일을 참고하세요.
 *
 * @callback
 * @action    user_register
 * @action    profile_update
 * @see       wp_insert_user()
 * @see       https://github.com/wpkorea/ku-paper-manager/blob/master/docs/data-types.md
 *
 * @param int $user_id
 */
function tkl_user_register( $user_id ) {

	$user = get_user_by( 'id', $user_id );

	// 역할 설정
	/** @var \WP_Role|NULL $role */
	$role = get_role( 'kpm_paper_submitter' );
	if ( $role ) {
		$user->set_role( $role->name );
	}

	// 한글 이름
	if ( isset( $_POST['kpm_name_kr'] ) && ! empty( $_POST['kpm_name_kr'] ) ) {
		$sanitized = sanitize_text_field( $_POST['kpm_name_kr'] );
		update_user_meta( $user_id, 'kpm_name_kr', $sanitized );
	}

	// 영문 이름
	if ( isset( $_POST['kpm_name_en'] ) && ! empty( $_POST['kpm_name_en'] ) ) {
		$sanitized = sanitize_text_field( $_POST['kpm_name_en'] );
		update_user_meta( $user_id, 'kpm_name_en', $sanitized );
	}

	// 사용자의 로그인 이메일로부터 제출 및 심사용 이메일 별도 저장
	// 심사용 메일은 로그인 메일과 별개로 사용할 수도 있다.
	if ( isset( $_POST['alt_email'] ) && $_POST['alt_email'] == 'yes' ) {
		$sanitized = sanitize_email( $_POST['kpm_submission_email'] );
		update_user_meta( $user_id, 'kpm_submission_email', $sanitized );
	} else {

		update_user_meta( $user_id, 'kpm_submission_email', $user->user_email );
	}

	// 소속 단체
	if ( isset( $_POST['kpm_affiliation'] ) && ! empty( $_POST['kpm_affiliation'] ) ) {
		$sanitized = sanitize_text_field( $_POST['kpm_affiliation'] );
		update_user_meta( $user_id, 'kpm_affiliation', $sanitized );
	}

	// 유선 전화
	if ( isset( $_POST['kpm_telephone'] ) && ! empty( $_POST['kpm_telephone'] ) ) {
		$sanitized = sanitize_text_field( $_POST['kpm_telephone'] );
		update_user_meta( $user_id, 'kpm_telephone', $sanitized );
	}

	// 이동 전화 번호
	if ( isset( $_POST['kpm_mobile_phone'] ) && ! empty( $_POST['kpm_mobile_phone'] ) ) {
		$sanitized = sanitize_text_field( $_POST['kpm_mobile_phone'] );
		update_user_meta( $user_id, 'kpm_mobile_phone', $sanitized );
	}
}


