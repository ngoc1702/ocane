<?php
if (!defined('ABSPATH')) {
    exit;
}
$title = oca_home_text('oca_ingredients_title', 'Tinh túy từ những thành phần tự nhiên');
$description = oca_home_text('oca_ingredients_description', 'Khám phá 5 thành phần tạo nên hương vị đặc trưng của OcaNew nut.');
$center_image = absint(oca_home_field('oca_ingredients_center_image'));
?>
<section id="thanh-phan" class="oca-ingredients" aria-label="<?php echo esc_attr($title ?: 'Thành phần OcaNew nut'); ?>">
    <div class="oca-container">
        <div class="oca-ingredients__heading">
            <?php if ($title) : ?><h2 class="oca-section-title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($description) : ?><p class="oca-ingredients__description"><?php echo nl2br(esc_html($description)); ?></p><?php endif; ?>
        </div>
        <div class="oca-ingredients__orbit">
            <svg class="oca-ingredients__connection" viewBox="0 0 1280 790" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path d="M640 110 C776.7 110.8 988.3 140 1070 190 C1151.7 240 1150 336.7 1130 410 C1110 483.3 1035 583.3 950 630 C865 676.7 730 691.7 620 690 C510 688.3 371.7 668.3 290 620 C208.3 571.7 136.7 472.5 130 400 C123.3 327.5 165 233.3 250 185 C335 136.7 503.3 109.2 640 110Z"/></svg>
            <?php if ($center_image) : ?>
                <div class="oca-ingredients__center">
                    <?php echo wp_get_attachment_image($center_image, 'large', false, array('class' => 'oca-ingredients__center-image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 90vw, 360px')); ?>
                </div>
            <?php endif; ?>
            <ul class="oca-ingredients__list">
                <?php foreach (oca_home_ingredients() as $index => $defaults) :
                    $value = oca_home_field('oca_ingredient_' . ($index + 1), array());
                    $ingredient = is_array($value) ? wp_parse_args($value, $defaults) : $defaults;
                    $image = !empty($ingredient['image']) ? absint($ingredient['image']) : 0;
                    ?>
                    <li class="oca-ingredients__node oca-ingredients__node--<?php echo esc_attr($defaults['slug']); ?>">
                        <div class="oca-ingredients__media">
                            <?php if ($image) : ?>
                                <?php echo wp_get_attachment_image($image, 'large', false, array('class' => 'oca-ingredients__image', 'loading' => 'lazy', 'sizes' => '(max-width: 760px) 42vw, 240px')); ?>
                            <?php else : ?>
                                <img class="oca-ingredients__image" src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/ingredients/' . $defaults['slug'] . '.webp'); ?>" alt="<?php echo esc_attr($ingredient['title']); ?>" width="600" height="800" loading="lazy" decoding="async">
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($ingredient['title']) || !empty($ingredient['description'])) : ?>
                            <div class="oca-ingredients__caption">
                                <?php if (!empty($ingredient['title'])) : ?><h3><?php echo esc_html($ingredient['title']); ?></h3><?php endif; ?>
                                <?php if (!empty($ingredient['description'])) : ?><p><?php echo nl2br(esc_html($ingredient['description'])); ?></p><?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
