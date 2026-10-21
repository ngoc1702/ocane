<?php
if (!defined('ABSPATH')) {
    exit;
}
$title = oca_home_text('oca_faq_title', 'Hỏi đáp cùng OcaNew nut');
$description = oca_home_text('oca_faq_description', 'Giải đáp những câu hỏi thường gặp về thành phần, cách pha, bảo quản và bao bì sản phẩm OcaNew nut.');
$image = absint(oca_home_field('oca_faq_image'));
$product = absint(oca_home_field('oca_hero_image'));
?>
<section id="cau-hoi-thuong-gap" class="oca-faq" aria-label="<?php echo esc_attr($title ?: 'Hỏi đáp OcaNew nut'); ?>">
    <div class="oca-container">
        <div class="oca-faq__heading">
            <?php if ($title) : ?><h2 class="oca-section-title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($description) : ?><p><?php echo nl2br(esc_html($description)); ?></p><?php endif; ?>
        </div>
        <div class="oca-faq__inner<?php echo $image || $product ? '' : ' oca-faq__inner--text-only'; ?>">
            <div class="oca-faq__list">
                <?php foreach (oca_home_faqs() as $index => $defaults) :
                    $value = oca_home_field('oca_faq_' . ($index + 1), array());
                    $faq = is_array($value) ? wp_parse_args($value, $defaults) : $defaults;
                    if (empty($faq['question']) || empty($faq['answer'])) {
                        continue;
                    }
                    ?>
                    <details class="oca-faq__item" name="oca-home-faq">
                        <summary><span class="oca-faq__icon" aria-hidden="true"></span><span><?php echo esc_html($faq['question']); ?></span></summary>
                        <div class="oca-faq__answer"><?php echo wpautop(esc_html($faq['answer'])); ?></div>
                    </details>
                <?php endforeach; ?>
            </div>
            <?php if ($image || $product) : ?>
                <div class="oca-faq__visual<?php echo $image ? '' : ' oca-faq__visual--product'; ?>">
                    <?php echo wp_get_attachment_image($image ?: $product, 'large', false, array('class' => 'oca-faq__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 100vw, (max-width: 1320px) 50vw, 660px')); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
