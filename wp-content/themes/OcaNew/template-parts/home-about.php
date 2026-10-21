<?php
if (!defined('ABSPATH')) {
    exit;
}
$title = oca_home_text('oca_about_title', 'Về OcaNew nut');
$description = oca_home_text('oca_about_description', 'OcaNew nut đồng hành cùng bạn trong việc tìm hiểu và lựa chọn sản phẩm dinh dưỡng phù hợp cho gia đình. Khám phá câu chuyện thương hiệu, thông tin sản phẩm và những giá trị mà OcaNew nut hướng đến.');
$image = absint(oca_home_field('oca_about_image'));
$product = absint(oca_home_field('oca_hero_image'));
$certificates = array();
for ($index = 1; $index <= 3; $index++) {
    $certificate = absint(oca_home_field('oca_about_certificate_' . $index));
    if ($certificate) {
        $certificates[] = $certificate;
    }
}
?>
<section id="ve-chung-toi" class="oca-about" aria-label="<?php echo esc_attr($title ?: 'Giới thiệu OcaNew nut'); ?>">
    <div class="oca-container oca-about__inner">
        <div class="oca-about__copy">
            <?php if ($title) : ?><h2 class="oca-section-title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($description) : ?><div class="oca-about__description"><?php echo wpautop(esc_html($description)); ?></div><?php endif; ?>
            <?php if ($certificates) : ?>
                <ul class="oca-about__certificates" aria-label="Tiêu chuẩn và chứng nhận">
                    <?php foreach ($certificates as $certificate) : ?>
                        <li><?php echo wp_get_attachment_image($certificate, 'medium', false, array('class' => 'oca-about__certificate', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 28vw, 170px')); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php if ($image || $product) : ?>
            <div class="oca-about__visual">
                <?php echo wp_get_attachment_image($image ?: $product, 'full', false, array('class' => 'oca-about__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, (max-width: 1320px) 56vw, 720px')); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
