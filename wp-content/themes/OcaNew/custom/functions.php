<?php

// Bật HTML5
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Thêm metabox
if (file_exists(__DIR__ . '/metabox.php')) {
    include __DIR__ . '/metabox.php';
}

// Thêm ACF Landing Page Configuration
if (file_exists(__DIR__ . '/acf-taxi-landing.php')) {
    include __DIR__ . '/acf-taxi-landing.php';
}
require_once __DIR__ . '/acf-home-landing.php';

// Thêm caiajs
if (file_exists(__DIR__ . '/js/caiajs.php')) {
    include __DIR__ . '/js/caiajs.php';
}

// Thêm jquery
add_action('wp_enqueue_scripts', 'caia_add_scripts_homes');
function caia_add_scripts_homes(){
	wp_enqueue_script('caia-slick', CHILD_URL.'/custom/js/slick.js', array('jquery'));
}

function add_swiper_webcomponent_script() {
    echo '<script type="module">
      import "https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js";
    </script>';
}
add_action('wp_footer', 'add_swiper_webcomponent_script');


add_action('wp_enqueue_scripts', 'custom_override_style', 100);
function custom_override_style() {
    // Đảm bảo đúng với theme con
    $style_path = get_stylesheet_directory() . '/style.css';
    $version = file_exists($style_path) ? filemtime($style_path) : time();

    // Handle thực tế (cập nhật lại nếu bạn tìm thấy tên khác sau bước kiểm tra)
    $handle = 'caia';

    // Gỡ bỏ và thêm lại
    wp_dequeue_style($handle);
    wp_deregister_style($handle);
    wp_enqueue_style($handle, get_stylesheet_uri(), array(), $version);
}

add_action('wp_enqueue_scripts', 'caia_enqueue_taxi_landing_assets', 120);
function caia_enqueue_taxi_landing_assets() {
    $is_landing = is_page_template('page-landing.php');

    if (!$is_landing && is_singular()) {
        $post = get_post();
        $is_landing = $post && has_shortcode($post->post_content, 'landing_page');
    }

    if (!$is_landing) {
        return;
    }

    $css_path = get_stylesheet_directory() . '/assets/css/landing.css';
    $js_path  = get_stylesheet_directory() . '/assets/js/landing.js';

    if (file_exists($css_path)) {
        wp_enqueue_style('taxi-landing', get_stylesheet_directory_uri() . '/assets/css/landing.css', array(), filemtime($css_path));
    }

    if (file_exists($js_path)) {
        wp_enqueue_script(
            'taxi-landing',
            get_stylesheet_directory_uri() . '/assets/js/landing.js',
            array('jquery'),
            filemtime($js_path),
            true
        );
    }
}
// Use OcaNew artwork as fallback; WordPress Site Icon remains editable in CMS.
add_action('wp_head', 'caia_ocanew_favicon', 99);
add_action('admin_head', 'caia_ocanew_favicon', 99);
add_action('login_head', 'caia_ocanew_favicon', 99);
function caia_ocanew_favicon() {
    echo '<meta name="theme-color" content="#1765ad">' . "\n";
    if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
        return;
    }

    $icon_dir = get_stylesheet_directory_uri() . '/assets/images/branding/';
    ?>
    <link rel="icon" type="image/x-icon" href="<?php echo esc_url($icon_dir . 'favicon-nut.ico'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url($icon_dir . 'favicon-nut-32.png'); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url($icon_dir . 'favicon-nut-192.png'); ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo esc_url($icon_dir . 'favicon-nut-512.png'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url($icon_dir . 'favicon-nut-180.png'); ?>">
    <?php
}

add_filter('upload_mimes', 'caia_mime_types', 1, 1);
function caia_mime_types($mime_types){  
	$mime_types['svg'] = 'image/svg+xml';
	$mime_types['webp'] = 'image/webp';
	return $mime_types;
}

add_filter( 'wp_check_filetype_and_ext', 'caia_disable_real_mime_check', 10, 4 );
function caia_disable_real_mime_check( $data, $file, $filename, $mimes ) {
	$wp_filetype = wp_check_filetype( $filename, $mimes );
	$ext = $wp_filetype['ext'];
	$type = $wp_filetype['type'];
	$proper_filename = $data['proper_filename'];
	return compact( 'ext', 'type', 'proper_filename' );
}

// Xóa các kích thước mặc định trong Wordpress
add_filter( 'intermediate_image_sizes_advanced', 'prefix_remove_default_images' );
function prefix_remove_default_images( $sizes ){
	unset( $sizes['medium']);
	unset( $sizes['large']);
	unset( $sizes['medium_large']);
	unset( $sizes['1536x1536']);
	unset( $sizes['2048x2048']);
	return $sizes;
}

// Ẩn hiển thị các kích thước ảnh mặc định
add_filter( 'intermediate_image_sizes', function( $sizes ){
    return array_filter( $sizes, function( $val ){
        return 'medium' !== $val && 'medium_large' !== $val && 'large' !== $val && '1536x1536' !== $val && '2048x2048' !== $val;
    });
});

// Đặt kích thước mặc định cho website
update_option( 'thumbnail_size_w', 750 );
update_option( 'thumbnail_size_h', 395 );

// Thêm kích thước ảnh sản phẩm
add_image_size('product-image',640,640,true);
add_image_size('product-avatar',300,300,true);

add_filter( 'image_size_names_choose', 'caia_custom_sizes' );
function caia_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
		'product-image' => __( 'Kích thước 640x640' ),
    ));
}

// Bỏ toàn bộ thẻ H4 khỏi tiêu đề widget
add_filter( 'genesis_register_widget_area_defaults', 'caia_change_all_widget_titles' );
function caia_change_all_widget_titles( $defaults ) { 
	$defaults['before_title'] = '<div class="widget-title widgettitle">';
	$defaults['after_title'] = "</div>";
	return $defaults;
}

// Thêm thẻ đóng mở cho tiêu đề của widget
add_filter( 'widget_title', 'caia_add_html_widget_title' );
function caia_add_html_widget_title( $title ) {	
	$title = str_replace( '[span]', '<span>', $title );
	$title = str_replace( '[/span]', '</span>', $title );	
	return $title;
}

// Thêm font
add_action('wp_head','caia_add_font_website');
function caia_add_font_website(){
	?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

<?php
}

// add_action( 'genesis_header', function() {
//     if ( is_active_sidebar( 'header-menusub' ) ) {
//         echo '<div class="header-menusub-widget-area"><div class="wrap">';
//         dynamic_sidebar( 'header-menusub' );
//         echo '</div></div>';
//     }
// }, 1 ); 

genesis_register_sidebar( 
	array(
		'id'			=> 'nhantuvan',
		'name'			=> 'Toàn bộ - Nhận tư vấn',
	)
);

genesis_register_sidebar( 
	array(
		'id'			=> 'content-bfooter',
		'name'			=> 'Toàn bộ - Nội dung trước chân trang',
	)
);

genesis_register_sidebar( 
	array(
		'id'			=> 'content-footer',
		'name'			=> 'Toàn bộ - Nội dung chân trang',
	)
);

genesis_register_sidebar( 
	array(
		'id'			=> 'content-fix',
		'name'			=> 'Toàn bộ - Nội dung cố định',
	)
);

add_action('genesis_before_header','caia_add_contactus');
function caia_add_contactus(){
	if( is_active_sidebar( 'nhantuvan' ) ){
		echo '<div class="nhantuvan section"><div class="wrap">';
			dynamic_sidebar( 'Toàn bộ - Nhận tư vấn' );
		echo '</div></div>';
	}
}


remove_action('genesis_footer','genesis_do_footer');
add_action('genesis_footer','caia_add_content_footer');
function caia_add_content_footer(){
	if( is_active_sidebar( 'content-footer' ) ){
		dynamic_sidebar( 'Toàn bộ - Nội dung chân trang' );		
	}
}

add_action('genesis_before_footer','caia_add_content_after_footer',8);
function caia_add_content_after_footer(){
	echo '<div data-aos="fade-up" class="content-contact section"><div class="wrap">';
		dynamic_sidebar( 'Toàn bộ - Liên hệ tư vấn' );
	echo '</div></div>';
}

add_action('genesis_before_footer','caia_add_content_after_footer2');
function caia_add_content_after_footer2(){
	echo '<div class="before_footer section"><div class="wrap"><div class="wrap-section">';

		dynamic_sidebar( 'Toàn bộ - Nội dung trước chân trang' );
	echo '</div></div></div>';
}

add_action('genesis_after_footer','caia_add_content_fix');
function caia_add_content_fix(){
	if( is_active_sidebar( 'content-fix' ) ){
		echo '<div class="content-fix">';
			dynamic_sidebar( 'Toàn bộ - Nội dung cố định' );		
		echo '</div>';
	}
}


add_action( 'genesis_before', function() {
	// Xóa sidebar mặc định của Genesis trước khi render
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
});

add_action( 'genesis_sidebar', function() {

	if ( is_singular( 'post' ) ) {
		genesis_widget_area(
			'sidebar',
			[ 'before' => '<aside class="sidebar primary-sidebar widget-area">', 'after' => '</aside>' ]
		);

	// Các trang khác, trừ sản phẩm
	} elseif ( ! is_singular( 'product' ) ) {
		genesis_widget_area(
			'sidebar',
			[ 'before' => '<aside class="sidebar primary-sidebar widget-area">', 'after' => '</aside>' ]
		);
	}
});

// Chỉnh hiển thị nút Next Page và Previous Page trong phân trang
add_filter ( 'genesis_next_link_text' , 'caia_next_page_link' );
function caia_next_page_link( $text ) {
    return '&#x000BB;';
}

add_filter ( 'genesis_prev_link_text' , 'caia_previous_page_link' );
function caia_previous_page_link( $text ) {
    return '&#x000AB;';
}

// Thay đổi vị trí breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
// add_action( 'genesis_after_header', 'genesis_do_breadcrumbs',9);

// Tùy biến breadcrumbs trong Genesis
// ✅ Shortcode hiển thị breadcrumb tùy chỉnh
function my_custom_breadcrumb_shortcode() {
    // Thiết lập tham số breadcrumb
    $args = array(
        'home' => '<span class="home">Trang chủ</span>',
        'sep'  => '<span aria-label="breadcrumb separator" class="label"> » </span>',
        'list_sep' => ', ',
        'prefix' => '<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList"><div class="wrap"><div class="thanhdieuhuong">',
        'suffix' => '</div></div></div>',
        'heirarchial_attachments' => true,
        'heirarchial_categories'  => true,
        'labels' => array(
            'prefix' => '',
            'author' => '',
            'category' => '',
            'tag' => '',
            'date' => '',
            'search' => '',
            'tax' => '',
            'post_type' => '',
            '404' => '',
        ),
    );

    // Nếu bạn dùng Genesis
    if ( function_exists( 'genesis_breadcrumb' ) ) {
        ob_start();
        genesis_breadcrumb( $args );
        return ob_get_clean();
    }

    // Nếu không có Genesis, bạn có thể thay bằng breadcrumb tĩnh hoặc plugin khác
    return '<div class="breadcrumb"><a href="/">Trang chủ</a> » ...</div>';
}
add_shortcode( 'breadcrumb', 'my_custom_breadcrumb_shortcode' );



// Thiết kế lại form comment
add_filter( 'comment_form_defaults', 'rayno_comment_form_args' );
function rayno_comment_form_args($defaults) {
	global $user_identity, $id;
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );
	$author = '<div class="popup-comment"><div class="box-comment"><span class="close-popup-comment">✕</span><p>Bạn vui lòng điền thêm thông tin!</p><p class="comment-form-author">' .
	          '<input id="author" name="author" type="text" class="author" placeholder="Họ và tên" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . '/>' .
	          '</p>';
	$email = '<p class="comment-form-email">' .
	         '<input id="email" name="email" type="text" class="email" placeholder="Email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
	         '</p>';
	$comment_field = '<p class="comment-form-comment">' .
	                 '<textarea id="comment" name="comment" cols="45" rows="8" class="form" tabindex="4" aria-required="true" placeholder="Nội dung bình luận"></textarea>' .
	                 '</p>';
	$args = array(
		'fields' => array(
		'author' => $author,
		'email'  => $email,
		),
		'comment_field'        => $comment_field,
		'title_reply'          => __( 'Bình luận của bạn', 'genesis' ),
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
	);
	$args = wp_parse_args( $args, $defaults );
	return apply_filters( 'raynoblog_comment_form_args', $args, $user_identity, $id, $commenter, $req, $aria_req );
}

// Sửa nút comment
add_filter( 'comment_form_defaults', 'caia_change_submit_comment' );
function caia_change_submit_comment( $defaults ){
    $defaults['label_submit'] = 'Gửi đi';
    return $defaults;
}

// Sửa chữ comment
add_filter( 'genesis_title_comments', 'caia_title_comments' );
function caia_title_comments() {
	echo '';
}

// Thay đổi chữ says
add_filter('comment_author_says_text', 'caia_change_says');
function caia_change_says($args){
	$args = 'đã bình luận';
	return $args;
}

// Sửa thẻ h4 ý kiến của bạn
add_filter( 'comment_form_defaults', 'caia_custom_reply_title' );
function caia_custom_reply_title( $defaults ){
	$defaults['title_reply_before'] = '<p id="reply-title" class="comment-reply-title">';
	$defaults['title_reply_after'] = '</p>';
	return $defaults;
}

// Thêm nút comment
add_action( 'comment_form_logged_in_after', 'additional_fields',1 );
add_action( 'comment_form_after_fields', 'additional_fields',1 );
function additional_fields (){
	if(!is_user_logged_in()){
		echo '<p class="comment-form-phone"><input id="author" name="phone" type="text" size="30" tabindex="4" placeholder="Số điện thoại"/></p>
		<p><input name="actionsubmit" type="hidden" value="1" /><input id="submit-commnent" name="submit-commnent" type="submit" value="Hoàn tất" /></p></div></div>';
	}
}

// Lưu nội dung comment 
add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ){
	if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') )
	$phone = wp_filter_nohtml_kses($_POST['phone']);
	add_comment_meta( $comment_id, 'phone', $phone );
}

// Add the filter to check if the comment meta data has been filled or not
add_filter( 'preprocess_comment', 'verify_comment_meta_data', 1, 1 );
function verify_comment_meta_data( $commentdata ){
	$commentdata['phone'] = ( ! empty ( $_POST['phone'] ) ) ? sanitize_text_field( $_POST['phone'] ) : false;
	if ( ! $commentdata['phone'] && ! is_admin() ){
		wp_die( __( '<p>Lỗi: Vui lòng điền số điện thoại</p><a href="javascript:history.back()">« Quay lại</a>' ) );
	}	
    return $commentdata;
}

// Thêm nút trong trang quản trị 
add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
function extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Thông tin số điện thoại khách hàng' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}
 
function extend_comment_meta_box ( $comment ){
    $phone = get_comment_meta( $comment->comment_ID, 'phone', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?><p><label for="phone"><?php _e( 'Số điện thoại' ); ?></label><input type="text" name="phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat" /></p><?php
}

// Cập nhật khi thay đổi 
add_action( 'edit_comment', 'extend_comment_edit_metafields' );
function extend_comment_edit_metafields( $comment_id ){
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;
	if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != '') ) : 
	$phone = wp_filter_nohtml_kses($_POST['phone']);
	update_comment_meta( $comment_id, 'phone', $phone );
	else :
	delete_comment_meta( $comment_id, 'phone');
	endif;
}

//Thêm cột số điện thoại trong admin
add_filter( 'manage_edit-comments_columns', 'myplugin_comment_columns' );
function myplugin_comment_columns( $columns ){
	return array_merge( $columns, array(
		'phone' => __( 'Số điện thoại' ),
	) );
}

add_filter( 'manage_comments_custom_column', 'myplugin_comment_column', 10, 2 );
function myplugin_comment_column( $column, $comment_ID ){
	switch ( $column ) {
		case 'phone':
			if ( $meta = get_comment_meta( $comment_ID, $column , true ) ) {
				echo $meta;
			} else {
				echo '-';
			}
		break;
	}
}

add_action('admin_head', 'my_column_width');
function my_column_width() {
    echo '<style type="text/css">';
    echo 'th#phone {width: 15%;}';
    echo '</style>';
}







// Mobile
if (wp_is_mobile() ){
	// remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
	// wp_enqueue_style( 'style-mobile', CHILD_URL.'/style-mobile.css' );

}


function add_fontawesome_to_theme() {
    wp_enqueue_style(
        'font-awesome', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', 
        array(), 
        '6.5.0'
    );
}
add_action('wp_enqueue_scripts', 'add_fontawesome_to_theme');


