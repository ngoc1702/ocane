<?php
if (!defined('ABSPATH')) {
    exit;
}
$title = oca_home_text('oca_improvement_title', 'Cải tiến diện mạo OcaNew nut');
$description = oca_home_text('oca_improvement_description', 'Khám phá sự thay đổi từ mẫu cũ đến mẫu mới của OcaNew nut.');
?>
<section id="cai-tien" class="oca-improvement" aria-label="<?php echo esc_attr($title ?: 'Cải tiến sản phẩm'); ?>">
    <div class="oca-container">
        <div class="oca-improvement__heading">
            <?php if ($title) : ?><h2 class="oca-section-title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($description) : ?><p><?php echo nl2br(esc_html($description)); ?></p><?php endif; ?>
        </div>
        <div class="oca-improvement__comparison">
            <?php foreach (array('old' => 'Mẫu cũ', 'new' => 'Mẫu mới') as $key => $default_label) :
                $image = absint(oca_home_field('oca_improvement_' . $key . '_image'));
                $label = oca_home_text('oca_improvement_' . $key . '_label', $default_label);
                ?>
                <figure class="oca-improvement__sample oca-improvement__sample--<?php echo esc_attr($key); ?>">
                    <div class="oca-improvement__media<?php echo $image ? '' : ' oca-improvement__media--empty'; ?>">
                        <?php if ($image) : ?>
                            <?php echo wp_get_attachment_image($image, 'full', false, array('class' => 'oca-improvement__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 90vw, (max-width: 1320px) 40vw, 520px')); ?>
                        <?php else : ?>
                            <svg class="oca-improvement__placeholder" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="8" y="10" width="48" height="44" rx="5"/><circle cx="23" cy="24" r="5"/><path d="m9 45 15-12 10 8 9-13 13 17"/></svg>
                        <?php endif; ?>
                    </div>
                    <?php if ($label) : ?><figcaption><?php echo esc_html($label); ?></figcaption><?php endif; ?>
                </figure>
                <?php if ('old' === $key) : ?>
                    <div class="oca-improvement__transition" aria-hidden="true">
                        <svg viewBox="0 0 120 64" fill="none" focusable="false" stroke-linecap="round" stroke-linejoin="round">
                            <path class="oca-improvement__arrow-line" d="M5 32H112"/>
                            <path class="oca-improvement__arrow-head" d="m98 20 14 12-14 12"/>
                        </svg>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
