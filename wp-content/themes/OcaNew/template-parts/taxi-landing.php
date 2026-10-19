<?php
if (!defined('ABSPATH')) exit;

$asset = get_stylesheet_directory_uri() . '/assets/images/taxi/';
$field = function ($name, $fallback) {
    if (function_exists('get_field')) {
        $value = get_field($name);
        if ($value !== null && $value !== false && $value !== '') return $value;
    }
    return $fallback;
};
$image_url = function ($value, $fallback) {
    if (is_array($value) && !empty($value['url'])) return $value['url'];
    if (is_numeric($value)) return wp_get_attachment_image_url((int) $value, 'full') ?: $fallback;
    if (is_string($value) && $value !== '') return $value;
    return $fallback;
};
$row = function ($value, $defaults) {
    return is_array($value) ? wp_parse_args($value, $defaults) : $defaults;
};

$brand = $field('taxi_brand', 'Green SM');
$phone = $field('taxi_phone', '0345 100 168');
$phone_link = preg_replace('/[^0-9+]/', '', $phone);
$email = $field('taxi_email', 'nguyenhuusang9010@gmail.com');
$hero = $image_url($field('taxi_hero_image', ''), $asset . 'hero-taxi.webp');
$intro = $image_url($field('taxi_intro_image', ''), $asset . 'charging-taxi.webp');
$premium = $asset . 'premium-fleet.webp';
$care = $asset . 'driver-care.webp';
$header_logo = $image_url($field('taxi_header_logo', ''), $asset . 'green-sm-logo-wide.png');
$footer_logo = $image_url($field('taxi_footer_logo', ''), $asset . 'green-sm-logo-wide.png');
$hero_form_shortcode = trim((string) $field('taxi_hero_form_shortcode', ''));
$intro_badge_text = preg_replace('/<br\s*\/?\s*>/i', "\n", (string) $field('taxi_intro_badge_text', "Đội xe điện\nthân thiện môi trường"));
$impact_driver = $asset . 'impact-driver-care-v2.webp';
$impact_rides = $asset . 'impact-daily-rides-v2.webp';
$impact_operations = $asset . 'impact-operations-v2.webp';
$impact_fleet = $asset . 'impact-fleet-v2.webp';
$impact_passengers = $asset . 'impact-passengers-v2.webp';
$impact_charging = $asset . 'impact-charging-network-v2.webp';

$hero_criteria = $field('taxi_hero_criteria', array(
    array('icon' => 'fa-bolt', 'title' => 'Có xe nhanh'),
    array('icon' => 'fa-tags', 'title' => 'Giá cước minh bạch'),
    array('icon' => 'fa-user-shield', 'title' => 'Tài xế tận tâm'),
    array('icon' => 'fa-leaf', 'title' => 'Xe điện sạch sẽ'),
));
$intro_checks = $field('taxi_intro_checks', array(
    array('icon' => 'fa-route', 'title' => 'Hành trình êm ái', 'description' => 'Không tiếng động cơ, không mùi xăng.'),
    array('icon' => 'fa-hand-holding-heart', 'title' => 'Dịch vụ tận tâm', 'description' => 'Tài xế chuyên nghiệp, luôn sẵn sàng hỗ trợ.'),
));
$benefits = $field('taxi_benefits_items', array(
    array('icon' => 'fa-clock', 'title' => 'Nhanh nhẹn & đúng giờ', 'description' => 'Điều phối thông minh giúp xe đến nhanh và tối ưu lộ trình.'),
    array('icon' => 'fa-user-tie', 'title' => 'Tài xế luôn sẵn sàng', 'description' => 'Được đào tạo bài bản, lịch sự và am hiểu đường phố.'),
    array('icon' => 'fa-wallet', 'title' => 'Giá cước tối ưu', 'description' => 'Chi phí hợp lý, thông báo rõ ràng trước mỗi chuyến đi.'),
    array('icon' => 'fa-spray-can-sparkles', 'title' => 'Phương tiện sạch sẽ', 'description' => 'Xe mới, vệ sinh mỗi ngày, khoang xe không mùi.'),
    array('icon' => 'fa-shield-halved', 'title' => 'An toàn & minh bạch', 'description' => 'Theo dõi hành trình và thông tin chuyến xe dễ dàng.'),
    array('icon' => 'fa-leaf', 'title' => 'Bảo vệ môi trường', 'description' => 'Xe điện không phát thải trực tiếp, giảm tiếng ồn đô thị.'),
));
$steps = $field('taxi_steps_items', array(
    array('title' => 'Nhập điểm đón', 'description' => 'Chia sẻ vị trí hoặc nhập địa chỉ bạn đang đứng.', 'image' => $hero, 'image_alt' => 'Chọn điểm đón cho chuyến taxi'),
    array('title' => 'Chọn điểm đến', 'description' => 'Nhập nơi bạn muốn đến để xem trước lộ trình.', 'image' => $intro, 'image_alt' => 'Chọn điểm đến'),
    array('title' => 'Chọn loại xe', 'description' => 'Chọn sedan tiết kiệm hoặc MPV rộng rãi cho nhóm.', 'image' => $premium, 'image_alt' => 'Lựa chọn dòng xe phù hợp'),
    array('title' => 'Xác nhận chuyến đi', 'description' => 'Kiểm tra thông tin, xác nhận và chờ tài xế đến đón.', 'image' => $care, 'image_alt' => 'Tài xế đón khách chu đáo'),
));
$fleet = $field('taxi_fleet_items', array(
    array('image' => $hero, 'badge' => 'Phổ biến', 'eyebrow' => 'LINH HOẠT MỖI NGÀY', 'title' => $brand . ' Standard', 'description' => 'Gọn gàng, thoải mái và tiết kiệm cho chuyến đi nội đô.', 'feature_1' => '4 hành khách', 'feature_1_icon' => 'fa-user-group', 'feature_2' => '2 hành lý', 'feature_2_icon' => 'fa-suitcase-rolling', 'feature_3' => '100% điện', 'feature_3_icon' => 'fa-bolt', 'cta' => 'Đặt xe Standard'),
    array('image' => $premium, 'badge' => 'Rộng rãi', 'eyebrow' => 'TRẢI NGHIỆM CAO CẤP', 'title' => $brand . ' Premium', 'description' => 'Khoang xe lớn, yên tĩnh, phù hợp gia đình và nhóm bạn.', 'feature_1' => '6 hành khách', 'feature_1_icon' => 'fa-user-group', 'feature_2' => '4 hành lý', 'feature_2_icon' => 'fa-suitcase-rolling', 'feature_3' => 'Tiện nghi cao cấp', 'feature_3_icon' => 'fa-star', 'cta' => 'Đặt xe Premium'),
));
$impact_items = $field('taxi_impact_items', array(
    array('column' => 'one', 'type' => 'stat', 'icon' => 'fa-user-tie', 'value' => '70.000+', 'text' => 'Tài xế xanh tiên phong hành trình chuyển đổi'),
    array('column' => 'one', 'type' => 'photo', 'image' => $impact_driver, 'alt' => 'Tài xế Green SM hỗ trợ hành khách lớn tuổi', 'size' => 'large'),
    array('column' => 'one', 'type' => 'stat', 'icon' => 'fa-heart', 'value' => '100+', 'text' => 'Hoạt động xanh cùng cộng đồng'),
    array('column' => 'two', 'type' => 'photo', 'image' => $impact_rides, 'alt' => 'Taxi điện Green SM vận hành trong đô thị', 'size' => 'medium'),
    array('column' => 'two', 'type' => 'stat', 'icon' => 'fa-route', 'value' => '1.000.000+', 'text' => 'Chuyến xe xanh phục vụ mỗi ngày'),
    array('column' => 'two', 'type' => 'photo', 'image' => $impact_operations, 'alt' => 'Trung tâm điều phối mạng lưới taxi điện Green SM', 'size' => 'medium'),
    array('column' => 'three', 'type' => 'photo', 'image' => $impact_fleet, 'alt' => 'Đội xe điện Green SM đa dạng', 'size' => 'short'),
    array('column' => 'three', 'type' => 'stat', 'icon' => 'fa-earth-asia', 'value' => '100 triệu++', 'text' => 'Lượt khách hàng đã sử dụng dịch vụ'),
    array('column' => 'three', 'type' => 'photo', 'image' => $impact_passengers, 'alt' => 'Gia đình trải nghiệm dịch vụ Green SM', 'size' => 'large'),
    array('column' => 'four', 'type' => 'stat', 'icon' => 'fa-map-location-dot', 'value' => '04', 'text' => 'Tỉnh thành được ' . $brand . ' phủ sóng'),
    array('column' => 'four', 'type' => 'photo', 'image' => $impact_charging, 'alt' => 'Hệ thống trạm sạc điện Green SM', 'size' => 'large'),
    array('column' => 'four', 'type' => 'stat', 'icon' => 'fa-building', 'value' => '7.000+', 'text' => 'Doanh nghiệp sử dụng dịch vụ'),
));
?>

<a class="taxi-skip" href="#taxi-content">Đi đến nội dung</a>
<header class="taxi-header" data-header>
    <div class="taxi-container taxi-header__inner">
        <a class="taxi-logo" href="#top" aria-label="<?php echo esc_attr($brand); ?> - Trang chủ">
            <img src="<?php echo esc_url($header_logo); ?>" alt="<?php echo esc_attr($brand); ?>">
        </a>
        <button class="taxi-menu-toggle" type="button" aria-expanded="false" aria-controls="taxi-nav"><span></span><span></span><span></span><span class="screen-reader-text">Mở menu</span></button>
        <nav id="taxi-nav" class="taxi-nav" aria-label="Điều hướng chính">
            <a href="#gioi-thieu"><?php echo esc_html($field('taxi_nav_intro', 'Giới thiệu')); ?></a>
            <a href="#uu-diem"><?php echo esc_html($field('taxi_nav_benefits', 'Ưu điểm')); ?></a>
            <a href="#dat-xe"><?php echo esc_html($field('taxi_nav_steps', 'Cách đặt xe')); ?></a>
            <a href="#doi-xe"><?php echo esc_html($field('taxi_nav_fleet', 'Đội xe')); ?></a>
            <a href="#lien-he"><?php echo esc_html($field('taxi_nav_contact', 'Liên hệ')); ?></a>
        </nav>
        <a class="taxi-button taxi-button--small taxi-header__cta" href="tel:<?php echo esc_attr($phone_link); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><?php echo esc_html($field('taxi_header_cta', 'Gọi ngay')); ?></a>
    </div>
</header>

<div id="top"></div>
<section class="taxi-hero" style="--hero-image:url('<?php echo esc_url($hero); ?>')">
    <div class="taxi-hero__overlay"></div>
    <div class="taxi-container taxi-hero__content" id="taxi-content">
        <div class="taxi-hero__copy taxi-reveal">
            <span class="taxi-eyebrow"><?php echo esc_html($field('taxi_hero_eyebrow', 'TAXI ĐIỆN THẾ HỆ MỚI')); ?></span>
            <h1><?php echo esc_html($field('taxi_hero_title', 'Di chuyển xanh, sống an lành')); ?></h1>
            <p><?php echo esc_html($field('taxi_hero_description', 'Đặt xe nhanh chóng, tài xế tận tâm và hành trình êm ái trên mọi cung đường.')); ?></p>
            <a class="taxi-button taxi-hero__cta" href="tel:<?php echo esc_attr($phone_link); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><?php echo esc_html($field('taxi_hero_call_label', 'Gọi đặt xe ngay')); ?></a>
        </div>
        <div class="taxi-booking taxi-reveal">
            <?php if ($hero_form_shortcode !== '') : ?>
                <div class="taxi-booking__form">
                    <?php echo do_shortcode($hero_form_shortcode); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            <?php else : ?>
                <div class="taxi-booking__criteria" aria-label="Ưu điểm dịch vụ">
                    <?php foreach ($hero_criteria as $criterion) : $criterion = $row($criterion, array('icon' => 'fa-check', 'title' => '')); ?>
                        <div class="taxi-booking__criterion"><i class="fa-solid <?php echo esc_attr($criterion['icon']); ?>" aria-hidden="true"></i><span><?php echo esc_html($criterion['title']); ?></span></div>
                    <?php endforeach; ?>
                </div>
                <a class="taxi-button" href="#lien-he"><?php echo esc_html($field('taxi_hero_cta', 'Đặt xe ngay')); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="gioi-thieu" class="taxi-section taxi-intro">
    <div class="taxi-container taxi-split">
        <figure class="taxi-media taxi-reveal"><img src="<?php echo esc_url($intro); ?>" alt="<?php echo esc_attr($field('taxi_intro_image_alt', 'Taxi điện đang sạc tại trạm')); ?>" loading="lazy"><figcaption><strong><?php echo esc_html($field('taxi_intro_badge_value', '100%')); ?></strong><span><?php echo nl2br(esc_html($intro_badge_text)); ?></span></figcaption></figure>
        <div class="taxi-copy taxi-reveal">
            <span class="taxi-kicker"><?php echo esc_html($field('taxi_intro_kicker', 'VỀ CHÚNG TÔI')); ?></span>
            <h2><?php echo esc_html($field('taxi_intro_title', 'Tiên phong di chuyển xanh')); ?></h2>
            <p><?php echo esc_html($field('taxi_intro_description', 'Mỗi chuyến đi là một lựa chọn tốt hơn cho thành phố. Đội xe điện hiện đại giúp hành trình yên tĩnh, sạch sẽ và thân thiện với môi trường.')); ?></p>
            <div class="taxi-checks"><?php $intro_default_icons = array('fa-route', 'fa-hand-holding-heart'); foreach ($intro_checks as $check_index => $check) : $check = $row($check, array('icon' => '', 'title' => '', 'description' => '')); $check_icon = !empty($check['icon']) ? $check['icon'] : ($intro_default_icons[$check_index] ?? 'fa-circle-check'); ?><div><i class="fa-solid <?php echo esc_attr($check_icon); ?>" aria-hidden="true"></i><span><strong><?php echo esc_html($check['title']); ?></strong><small><?php echo esc_html($check['description']); ?></small></span></div><?php endforeach; ?></div>
            <a class="taxi-button taxi-intro__button" href="#uu-diem"><?php echo esc_html($field('taxi_intro_link_label', 'Khám phá dịch vụ')); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<section id="uu-diem" class="taxi-section taxi-benefits">
    <div class="taxi-container">
        <div class="taxi-heading taxi-reveal"><span class="taxi-kicker"><?php echo esc_html($field('taxi_benefits_kicker', 'VÌ SAO CHỌN')); ?> <?php echo esc_html(strtoupper($brand)); ?></span><h2><?php echo esc_html($field('taxi_benefits_title', 'Mỗi chuyến đi, một trải nghiệm tốt hơn')); ?></h2><p><?php echo esc_html($field('taxi_benefits_description', 'Từ chiếc xe sạch đến cách phục vụ, mọi chi tiết đều được chăm chút để bạn an tâm trên suốt hành trình.')); ?></p></div>
        <div class="taxi-benefit-grid">
            <?php foreach ($benefits as $item) :
                $item = $row($item, array('icon' => 'fa-check', 'title' => '', 'description' => ''));
                $benefit_icon_url = '';
                if (is_array($item['icon']) && !empty($item['icon']['url'])) {
                    $benefit_icon_url = $item['icon']['url'];
                } elseif (is_numeric($item['icon'])) {
                    $benefit_icon_url = wp_get_attachment_image_url((int) $item['icon'], 'thumbnail') ?: '';
                }
            ?>
                <article class="taxi-benefit taxi-reveal">
                    <span class="taxi-benefit__icon" aria-hidden="true">
                        <?php if ($benefit_icon_url !== '') : ?>
                            <img src="<?php echo esc_url($benefit_icon_url); ?>" alt="" loading="lazy">
                        <?php else : ?>
                            <i class="fa-solid <?php echo esc_attr(is_string($item['icon']) && $item['icon'] !== '' ? $item['icon'] : 'fa-check'); ?>"></i>
                        <?php endif; ?>
                    </span>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="dat-xe" class="taxi-section taxi-steps">
    <?php $first_step = $row(reset($steps), array('image' => $hero, 'image_alt' => 'Chọn điểm đón cho chuyến taxi')); ?>
    <div class="taxi-container taxi-steps__grid">
        <div class="taxi-steps__content taxi-reveal">
            <span class="taxi-kicker"><?php echo esc_html($field('taxi_steps_kicker', 'HƯỚNG DẪN ĐẶT XE')); ?></span><h2><?php echo esc_html($field('taxi_steps_title', 'Chỉ 4 bước, xe đến tận nơi')); ?></h2><p class="taxi-steps__lead"><?php echo esc_html($field('taxi_steps_description', 'Chạm vào từng bước để xem hành trình đặt xe của bạn.')); ?></p>
            <div class="taxi-step-list" role="tablist" aria-label="Các bước đặt xe">
                <?php foreach ($steps as $index => $step) : $step = $row($step, array('title' => '', 'description' => '', 'image' => $hero, 'image_alt' => '')); $step_image = $image_url($step['image'], $hero); ?>
                    <button class="taxi-step<?php echo $index === 0 ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>" data-image="<?php echo esc_url($step_image); ?>" data-alt="<?php echo esc_attr($step['image_alt']); ?>"><b><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></b><span><strong><?php echo esc_html($step['title']); ?></strong><small><?php echo esc_html($step['description']); ?></small></span></button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="taxi-steps__visual taxi-reveal"><span class="taxi-steps__badge"><?php echo esc_html($field('taxi_steps_badge', 'Dễ dàng • Nhanh chóng')); ?></span><img src="<?php echo esc_url($image_url($first_step['image'], $hero)); ?>" alt="<?php echo esc_attr($first_step['image_alt']); ?>" data-step-image><div class="taxi-steps__progress"><span data-step-progress style="width:<?php echo esc_attr(100 / max(1, count($steps))); ?>%"></span></div></div>
    </div>
</section>

<section id="doi-xe" class="taxi-section taxi-fleet">
    <div class="taxi-container">
        <div class="taxi-heading taxi-reveal"><span class="taxi-kicker"><?php echo esc_html($field('taxi_fleet_kicker', 'ĐỘI XE CỦA CHÚNG TÔI')); ?></span><h2><?php echo esc_html($field('taxi_fleet_title', 'Chọn chiếc xe phù hợp với bạn')); ?></h2><p><?php echo esc_html($field('taxi_fleet_description', 'Tất cả đều là xe điện đời mới, sạch sẽ và được kiểm tra an toàn trước khi vận hành.')); ?></p></div>
        <div class="taxi-fleet-grid">
            <?php foreach ($fleet as $car) : $car = $row($car, array('image' => $hero, 'badge' => '', 'eyebrow' => '', 'title' => '', 'description' => '', 'feature_1' => '', 'feature_1_icon' => 'fa-check', 'feature_2' => '', 'feature_2_icon' => 'fa-check', 'feature_3' => '', 'feature_3_icon' => 'fa-check', 'cta' => 'Đặt xe')); ?>
                <article class="taxi-car-card taxi-reveal"><div class="taxi-car-card__image"><img src="<?php echo esc_url($image_url($car['image'], $hero)); ?>" alt="<?php echo esc_attr($car['title']); ?>" loading="lazy"><span><?php echo esc_html($car['badge']); ?></span></div><div class="taxi-car-card__body"><div><small><?php echo esc_html($car['eyebrow']); ?></small><h3><?php echo esc_html($car['title']); ?></h3></div><p><?php echo esc_html($car['description']); ?></p><ul><li><i class="fa-solid <?php echo esc_attr($car['feature_1_icon']); ?>"></i> <?php echo esc_html($car['feature_1']); ?></li><li><i class="fa-solid <?php echo esc_attr($car['feature_2_icon']); ?>"></i> <?php echo esc_html($car['feature_2']); ?></li><li><i class="fa-solid <?php echo esc_attr($car['feature_3_icon']); ?>"></i> <?php echo esc_html($car['feature_3']); ?></li></ul><a href="tel:<?php echo esc_attr($phone_link); ?>"><?php echo esc_html($car['cta']); ?> <i class="fa-solid fa-arrow-right"></i></a></div></article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="taxi-section taxi-impact">
    <div class="taxi-container">
        <div class="taxi-heading taxi-reveal"><span class="taxi-kicker"><?php echo esc_html($field('taxi_impact_kicker', 'NHỮNG DẤU ẤN TỰ HÀO')); ?></span><h2><?php echo esc_html($field('taxi_impact_title', 'Cảm ơn bạn đã đồng hành cùng')); ?> <?php echo esc_html($brand); ?></h2><p><?php echo esc_html($field('taxi_impact_description', 'Mỗi con số là một hành trình được tạo nên từ niềm tin của khách hàng, tài xế và cộng đồng.')); ?></p></div>
        <div class="taxi-impact-board">
            <?php foreach (array('one', 'two', 'three', 'four') as $column) : ?>
                <div class="taxi-impact-column taxi-impact-column--<?php echo esc_attr($column); ?>">
                    <?php foreach ($impact_items as $impact) : $impact = $row($impact, array('column' => 'one', 'type' => 'stat', 'icon' => 'fa-check', 'icon_image' => '', 'value' => '', 'text' => '', 'image' => $hero, 'alt' => '', 'size' => 'large')); if ($impact['column'] !== $column) continue; ?>
                        <?php if ($impact['type'] === 'photo') : $size = in_array($impact['size'], array('large', 'medium', 'short'), true) ? $impact['size'] : 'large'; ?>
                            <figure class="taxi-impact-photo taxi-impact-photo--<?php echo esc_attr($size); ?> taxi-reveal"><img src="<?php echo esc_url($image_url($impact['image'], $hero)); ?>" alt="<?php echo esc_attr($impact['alt']); ?>" loading="lazy"></figure>
                        <?php else : ?>
                            <?php $impact_icon_image = $image_url($impact['icon_image'], ''); ?>
                            <article class="taxi-stat taxi-reveal"><span class="taxi-stat__icon" aria-hidden="true"><?php if ($impact_icon_image !== '') : ?><img src="<?php echo esc_url($impact_icon_image); ?>" alt="" loading="lazy"><?php else : ?><i class="fa-solid <?php echo esc_attr($impact['icon']); ?>"></i><?php endif; ?></span><strong><?php echo esc_html($impact['value']); ?></strong><p><?php echo esc_html($impact['text']); ?></p></article>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="lien-he" class="taxi-contact">
    <div class="taxi-container taxi-contact__inner taxi-reveal">
        <div class="taxi-contact__copy">
            <span class="taxi-kicker"><?php echo esc_html($field('taxi_contact_kicker', 'SẴN SÀNG LÊN ĐƯỜNG?')); ?></span>
            <h2><?php echo esc_html($field('taxi_contact_title', 'Gọi một chuyến xe xanh ngay hôm nay')); ?></h2>
            <p><?php echo esc_html($field('taxi_contact_description', 'Chúng tôi luôn sẵn sàng đưa bạn đến nơi an toàn, thoải mái và đúng giờ.')); ?></p>
            <a class="taxi-button taxi-contact__button" href="tel:<?php echo esc_attr($phone_link); ?>"><i class="fa-solid fa-phone-volume" aria-hidden="true"></i> <?php echo esc_html(rtrim($field('taxi_contact_button', 'Gọi đặt xe'), ': ')); ?></a>
        </div>
        <figure class="taxi-contact__image">
            <img src="<?php echo esc_url($image_url($field('taxi_contact_image', ''), $care)); ?>" alt="<?php echo esc_attr($field('taxi_contact_image_alt', 'Tài xế tận tâm hỗ trợ hành khách')); ?>" loading="lazy">
            <figcaption><span aria-hidden="true"><i class="fa-solid <?php echo esc_attr($field('taxi_contact_caption_icon', 'fa-headset')); ?>"></i></span><div><strong><?php echo esc_html($field('taxi_contact_caption_title', 'Phục vụ tận tâm 24/7')); ?></strong><small><?php echo esc_html($field('taxi_contact_caption_text', 'An toàn và đúng giờ trên mọi hành trình')); ?></small></div></figcaption>
        </figure>
    </div>
</section>

<footer class="taxi-footer">
    <div class="taxi-container taxi-footer__grid">
        <div><a class="taxi-logo taxi-logo--footer" href="#top"><img src="<?php echo esc_url($footer_logo); ?>" alt="<?php echo esc_attr($brand); ?>"></a><p><?php echo esc_html($field('taxi_footer_description', 'Taxi điện hiện đại cho hành trình xanh, an toàn và trọn vẹn hơn mỗi ngày.')); ?></p><div class="taxi-social"><a href="<?php echo esc_url($field('taxi_facebook', '#')); ?>" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a><a href="<?php echo esc_url($field('taxi_tiktok', '#')); ?>" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a><a href="<?php echo esc_url($field('taxi_youtube', '#')); ?>" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a></div></div>
        <div><h3><?php echo esc_html($field('taxi_footer_explore_title', 'Khám phá')); ?></h3><a href="#gioi-thieu"><?php echo esc_html($field('taxi_footer_intro_label', 'Về chúng tôi')); ?></a><a href="#uu-diem"><?php echo esc_html($field('taxi_footer_benefits_label', 'Ưu điểm dịch vụ')); ?></a><a href="#dat-xe"><?php echo esc_html($field('taxi_footer_steps_label', 'Hướng dẫn đặt xe')); ?></a><a href="#doi-xe"><?php echo esc_html($field('taxi_footer_fleet_label', 'Đội xe')); ?></a></div>
        <div><h3><?php echo esc_html($field('taxi_footer_contact_title', 'Liên hệ')); ?></h3><a href="tel:<?php echo esc_attr($phone_link); ?>"><i class="fa-solid fa-phone"></i> <?php echo esc_html($phone); ?></a><p><i class="fa-solid fa-location-dot"></i> <?php echo esc_html($field('taxi_address', 'Sa Kỳ, Bình Châu, Quảng Ngãi')); ?></p><p><i class="fa-regular fa-clock"></i> <?php echo esc_html($field('taxi_working_hours', 'Thứ 2 - Chủ nhật: 24/7')); ?></p></div>
    </div>
    <div class="taxi-container taxi-footer__bottom"><p>© <?php echo esc_html(date('Y')); ?> <?php echo esc_html($brand); ?>. <?php echo esc_html($field('taxi_footer_copyright', 'All rights reserved.')); ?></p><div><a href="<?php echo esc_url($field('taxi_footer_terms_url', '#')); ?>"><?php echo esc_html($field('taxi_footer_terms_label', 'Điều khoản')); ?></a><a href="<?php echo esc_url($field('taxi_footer_privacy_url', '#')); ?>"><?php echo esc_html($field('taxi_footer_privacy_label', 'Chính sách bảo mật')); ?></a></div></div>
</footer>
