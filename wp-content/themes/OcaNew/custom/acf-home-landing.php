<?php
/** Homepage landing configuration. Uses fields available in ACF Free and Pro. */
if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', function () {
    register_nav_menu('oca_landing', 'OcaNew — Menu trang chủ LDP');
});

add_action('wp_enqueue_scripts', function () {
    if (!is_page_template('page-home-landing.php')) {
        return;
    }
    foreach (array('css', 'js') as $extension) {
        $relative = '/assets/' . $extension . '/landing.' . $extension;
        $version = filemtime(get_stylesheet_directory() . $relative);
        $url = get_stylesheet_directory_uri() . $relative;
        if ('css' === $extension) {
            wp_enqueue_style('oca-home-landing', $url, array(), $version);
        } else {
            wp_enqueue_script('oca-home-landing', $url, array(), $version, true);
        }
    }
}, 130);

function oca_home_field($name, $default = '') {
    $value = function_exists('get_field') ? get_field($name) : null;
    return null === $value || false === $value || '' === $value ? $default : $value;
}

function oca_home_text($name, $default = '') {
    $value = function_exists('get_field') ? get_field($name) : null;
    return is_string($value) ? $value : $default;
}

function oca_home_preparation_steps() {
    return array(
        array('title' => 'Cho bột vào ly', 'description' => 'Cho lượng bột OcaNew nut theo hướng dẫn trên bao bì vào ly sạch.'),
        array('title' => 'Thêm nước ấm', 'description' => 'Thêm nước theo lượng và nhiệt độ được hướng dẫn trên bao bì.'),
        array('title' => 'Khuấy đều', 'description' => 'Khuấy nhẹ cho bột tan đều hoàn toàn.'),
        array('title' => 'Thưởng thức', 'description' => 'Thưởng thức ly dinh dưỡng sau khi pha.'),
    );
}

function oca_home_top_items() {
    return array(
        'location' => array('label' => 'Việt Nam', 'url' => '', 'path' => 'M12 22s8-7 8-14a8 8 0 1 0-16 0c0 7 8 14 8 14Z M12 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6'),
        'email' => array('label' => 'contact@ocanew.vn', 'url' => 'mailto:contact@ocanew.vn', 'path' => 'M3 5h18v14H3Z M3 5l9 8 9-8'),
        'support' => array('label' => 'Hỗ trợ khách hàng', 'url' => '', 'path' => 'M5 14v-3a7 7 0 0 1 14 0v3 M5 11H3v7h4v-7Z M19 11h2v7h-4v-7Z M19 18v3h-7'),
        'document' => array('label' => 'Tài liệu', 'url' => '', 'path' => 'M5 2h9l5 5v15H5Z M14 2v6h5 M8 12h8 M8 16h8'),
    );
}

add_action('acf/init', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    $fields = array(
        array('key' => 'field_oca_header_tab', 'label' => 'Header', 'type' => 'tab'),
        array('key' => 'field_oca_home_logo', 'name' => 'oca_home_logo', 'label' => 'Ảnh logo', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'library' => 'all', 'instructions' => 'Tải logo nền trong suốt. Để trống sẽ hiện chữ OcaNew nut.'),
    );
    foreach (oca_home_top_items() as $key => $item) {
        $prefix = 'oca_top_' . $key;
        $fields[] = array(
            'key' => 'field_' . $prefix, 'name' => $prefix, 'label' => $item['label'], 'type' => 'group', 'layout' => 'block',
            'sub_fields' => array(
                array('key' => 'field_' . $prefix . '_icon', 'name' => 'icon', 'label' => 'Ảnh thay icon', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'thumbnail', 'library' => 'all', 'instructions' => 'Nên dùng PNG/WebP nền trong suốt, icon màu trắng. Để trống dùng icon mặc định.', 'wrapper' => array('width' => '25')),
                array('key' => 'field_' . $prefix . '_label', 'name' => 'label', 'label' => 'Nội dung', 'type' => 'text', 'default_value' => $item['label'], 'instructions' => 'Xóa nội dung để ẩn mục này.', 'wrapper' => array('width' => '35')),
                array('key' => 'field_' . $prefix . '_url', 'name' => 'url', 'label' => 'Liên kết', 'type' => 'text', 'default_value' => $item['url'], 'instructions' => 'Nhập URL, mailto: hoặc tel:. Để trống nếu chỉ hiển thị chữ.', 'wrapper' => array('width' => '40')),
            ),
        );
    }
    $fields[] = array('key' => 'field_oca_menu_help', 'label' => 'Menu điều hướng', 'type' => 'message', 'message' => 'Vào Giao diện → Menu, tạo menu và gán vào “OcaNew — Menu trang chủ LDP”. Hỗ trợ menu con. Khi chưa gán sẽ hiển thị 6 mục như ảnh mẫu.');
    $fields[] = array('key' => 'field_oca_banner_tab', 'label' => 'Banner', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_home_banner', 'name' => 'oca_home_banner', 'label' => 'Ảnh nền banner', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Dùng nền sáng, ảnh ngang khoảng 1920 × 800px. Ảnh phủ kín nền nên có thể bị cắt ở hai cạnh trên điện thoại. Để trống sẽ dùng nền bếp kem–gỗ có ánh sáng tự nhiên, được tạo riêng cho OcaNew.');
    $fields[] = array('key' => 'field_oca_hero_image', 'name' => 'oca_hero_image', 'label' => 'Ảnh bên phải (đã xóa nền)', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Tải PNG/WebP có nền trong suốt, khuyến nghị cao từ 900px. Hiển thị nguyên ảnh, không cắt. Trường này không tự xóa nền ảnh.');
    $fields[] = array('key' => 'field_oca_hero_eyebrow', 'name' => 'oca_hero_eyebrow', 'label' => 'Dòng chữ nhỏ', 'type' => 'text', 'default_value' => 'OCANEW NUT');
    $fields[] = array('key' => 'field_oca_hero_title', 'name' => 'oca_hero_title', 'label' => 'Tiêu đề chính', 'type' => 'text', 'default_value' => 'Dinh dưỡng mỗi ngày,');
    $fields[] = array('key' => 'field_oca_hero_highlight', 'name' => 'oca_hero_highlight', 'label' => 'Dòng tiêu đề màu nhấn', 'type' => 'text', 'default_value' => 'trọn vẹn yêu thương.');
    $fields[] = array('key' => 'field_oca_hero_description', 'name' => 'oca_hero_description', 'label' => 'Mô tả banner', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Cùng OcaNew nut tìm hiểu và lựa chọn sản phẩm dinh dưỡng phù hợp cho bạn và gia đình.');
    $fields[] = array('key' => 'field_oca_hero_button', 'name' => 'oca_hero_button', 'label' => 'Chữ trên nút', 'type' => 'text', 'default_value' => 'Khám phá sản phẩm', 'instructions' => 'Nút chỉ hiện khi có cả chữ và liên kết.');
    $fields[] = array('key' => 'field_oca_home_banner_link', 'name' => 'oca_home_banner_link', 'label' => 'Liên kết nút banner', 'type' => 'url');
    $fields[] = array('key' => 'field_oca_about_tab', 'label' => 'Về chúng tôi', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_about_image', 'name' => 'oca_about_image', 'label' => 'Ảnh giới thiệu bên phải', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 1200 × 800px. Để trống sẽ dùng ảnh sản phẩm của banner trên nền bếp hiện có.');
    $fields[] = array('key' => 'field_oca_about_title', 'name' => 'oca_about_title', 'label' => 'Tiêu đề section', 'type' => 'text', 'default_value' => 'Về OcaNew nut');
    $fields[] = array('key' => 'field_oca_about_subtitle', 'name' => 'oca_about_subtitle', 'label' => 'Tiêu đề giới thiệu', 'type' => 'textarea', 'rows' => 2, 'default_value' => "Dinh dưỡng từ thiên nhiên\nCho cuộc sống tốt đẹp hơn");
    $fields[] = array('key' => 'field_oca_about_description', 'name' => 'oca_about_description', 'label' => 'Nội dung giới thiệu', 'type' => 'textarea', 'rows' => 5, 'default_value' => 'OcaNew nut đồng hành cùng bạn trong việc tìm hiểu và lựa chọn sản phẩm dinh dưỡng phù hợp cho gia đình. Khám phá câu chuyện thương hiệu, thông tin sản phẩm và những giá trị mà OcaNew nut hướng đến.');
    $fields[] = array('key' => 'field_oca_about_button', 'name' => 'oca_about_button', 'label' => 'Chữ trên nút', 'type' => 'text', 'default_value' => 'Tìm hiểu thêm');
    $fields[] = array('key' => 'field_oca_about_link', 'name' => 'oca_about_link', 'label' => 'Liên kết tìm hiểu thêm', 'type' => 'link', 'return_format' => 'array', 'instructions' => 'Chọn trang giới thiệu hoặc nhập URL. Nút hiển thị khi có cả liên kết và chữ trên nút.');
    $fields[] = array('key' => 'field_oca_preparation_tab', 'label' => 'Quy trình pha', 'type' => 'tab');
    $fields[] = array('key' => 'field_oca_preparation_background', 'name' => 'oca_preparation_background', 'label' => 'Ảnh nền quy trình', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 1920 × 700px. Để trống dùng màu xanh chủ đạo.');
    $fields[] = array('key' => 'field_oca_preparation_overlay', 'name' => 'oca_preparation_overlay', 'label' => 'Độ phủ xanh trên ảnh nền', 'type' => 'range', 'min' => 0, 'max' => 100, 'step' => 5, 'default_value' => 75, 'append' => '%', 'instructions' => 'Tăng để chữ trắng dễ đọc trên nền nhiều chi tiết.');
    $fields[] = array('key' => 'field_oca_preparation_eyebrow', 'name' => 'oca_preparation_eyebrow', 'label' => 'Dòng chữ nhỏ', 'type' => 'text', 'default_value' => 'Quy trình pha OcaNew');
    $fields[] = array('key' => 'field_oca_preparation_title', 'name' => 'oca_preparation_title', 'label' => 'Tiêu đề quy trình', 'type' => 'text', 'default_value' => '4 bước đơn giản cho ly dinh dưỡng thơm ngon');
    foreach (oca_home_preparation_steps() as $index => $step) {
        $prefix = 'oca_preparation_step_' . ($index + 1);
        $fields[] = array(
            'key' => 'field_' . $prefix, 'name' => $prefix, 'label' => 'Bước ' . ($index + 1), 'type' => 'group', 'layout' => 'block',
            'sub_fields' => array(
                array('key' => 'field_' . $prefix . '_image', 'name' => 'image', 'label' => 'Ảnh minh họa', 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all', 'instructions' => 'Ảnh ngang khoảng 800 × 450px.', 'wrapper' => array('width' => '30')),
                array('key' => 'field_' . $prefix . '_title', 'name' => 'title', 'label' => 'Tên bước', 'type' => 'text', 'default_value' => $step['title'], 'wrapper' => array('width' => '30')),
                array('key' => 'field_' . $prefix . '_description', 'name' => 'description', 'label' => 'Nội dung', 'type' => 'textarea', 'rows' => 3, 'default_value' => $step['description'], 'wrapper' => array('width' => '40')),
            ),
        );
    }
    acf_add_local_field_group(array(
        'key' => 'group_oca_home_landing', 'title' => 'OcaNew — Cấu hình trang chủ LDP', 'fields' => $fields,
        'location' => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-home-landing.php'))),
        'position' => 'normal', 'style' => 'default', 'active' => true,
    ));
});

function oca_home_default_menu() {
    $items = array('' => 'Trang chủ', 'san-pham' => 'Sản phẩm', 'thanh-phan' => 'Thành phần', 've-ocanew-nut' => 'Về OcaNew nut', 'kien-thuc-dinh-duong' => 'Kiến thức dinh dưỡng', 'cau-hoi-thuong-gap' => 'Câu hỏi thường gặp');
    echo '<ul class="oca-menu">';
    foreach ($items as $slug => $label) {
        $page = $slug ? get_page_by_path($slug) : null;
        $url = $page ? get_permalink($page) : home_url($slug ? '/' . $slug . '/' : '/');
        $current = '' === $slug ? ' class="current-menu-item"' : '';
        echo '<li' . $current . '><a href="' . esc_url($url) . '"' . ('' === $slug ? ' aria-current="page"' : '') . '>' . esc_html($label) . '</a></li>';
    }
    echo '</ul>';
}
