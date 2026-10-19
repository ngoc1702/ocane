# Landing Page WordPress + ACF - Setup Guide

## 📋 Tổng quan

Đây là landing page WordPress chuyên nghiệp dựa trên design Edusmart, được tích hợp với Advanced Custom Fields (ACF) để quản lý nội dung dễ dàng.

## 🚀 Yêu cầu

- WordPress 5.0+
- PHP 7.4+
- Advanced Custom Fields Pro (khuyến khích) hoặc Free
- Theme: Laco

## 📁 Cấu trúc File

```
/wp-content/themes/Laco/
├── page-landing.php                 # Template chính cho landing page
├── acf-landing-config.php           # Cấu hình ACF Field Groups
├── template-parts/
│   ├── hero.php                     # Hero section
│   ├── why-choose-us.php            # Why Choose Us section
│   ├── featured-courses.php         # Featured Courses section
│   ├── testimonials.php             # Testimonials section
│   ├── cta-section.php              # Call-to-Action section
│   └── statistics.php               # Statistics section
├── assets/
│   ├── css/
│   │   └── landing.css              # Styling cho landing page
│   └── js/
│       └── landing.js               # JavaScript functionality
└── functions.php                    # Đã có sẵn (cần thêm include)
```

## 🔧 Bước 1: Cài đặt & Kích hoạt

### 1.1 Cài đặt ACF
1. Vào **Plugins** → **Add New**
2. Tìm "Advanced Custom Fields"
3. Cài đặt plugin (phiên bản Free là được)
4. Kích hoạt plugin

### 1.2 Thêm ACF Config vào functions.php

Mở file `wp-content/themes/Laco/functions.php` và thêm dòng này ở cuối:

```php
// Load ACF Landing Page Configuration
require_once get_template_directory() . '/acf-landing-config.php';
```

### 1.3 Tạo trang Landing Page

**Cách 1: Sử dụng Shortcode (Khuyến khích)**
1. Vào **Pages** → **Add New** hoặc chỉnh sửa trang hiện có
2. Đặt tên: **"Trang Chủ"** (hoặc tên khác)
3. Thêm shortcode vào content: `[landing_page]`
4. Publish trang

**Cách 2: Sử dụng Page Template**
1. Vào **Pages** → **Add New**
2. Đặt tên: **"Trang Chủ"**
3. Chọn template: **"Landing Page"** (từ dropdown "Template")
4. Publish trang

## 📝 Bước 2: Cấu hình Landing Page

### 2.1 Truy cập Settings

1. Vào **Cài đặt** → **Landing Page** (hoặc tìm "Landing Page" trong menu)
2. Bạn sẽ thấy 6 sections để fill nội dung:
   - Hero Section
   - Why Choose Us Section
   - Featured Courses Section
   - Testimonials Section
   - CTA Section
   - Statistics Section

### 2.2 Nhập Nội Dung
Sau khi publish trang, bạn sẽ thấy các section trong edit page:

- **Tiêu đề chính**: "TRUNG TÂM ANH NGỮ"
- **Tiêu đề phụ**: "EDUSMART"
- **Mô tả**: "Nơi giáo dục bạn tiếp nước từ chính phục mục đích..."
- **Hình ảnh**: Tải hình người phụ nữ
- **Nút CTA 1**: Text "ĐĂNG KÝ HỌC THỬ MIỄN PHÍ", Link (để trống)
- **Nút CTA 2**: Text "XEM VIDEO GỢI Ý", Link (để trống)

### 2.2 Why Choose Us Section

1. Nhập **Tiêu đề**: "Tại sao nên chọn"
2. Nhập **Mô tả**: "Chúng tôi mang đến một trường học tập..."
3. Click **Add Row** để thêm các lợi ích:
   - **Icon**: Upload icon (64x64px)
   - **Tiêu đề**: "GIÁO VIÊN CHẤT LƯỢNG"
   - **Mô tả**: "100% giáo viên có chứng chỉ quốc tế..."

Thêm 4 row nữa:
- GIÁO VIÊN CHẤT LƯỢNG
- LỘ TRÌNH KHOA HỌC
- PHƯƠNG PHÁP HIỆN ĐẠI
- CAM KẾT ĐẦU RA
- HỖ TRỢ TẬN TÂMM

### 2.3 Featured Courses Section

1. Nhập **Tiêu đề**: "CÁC KHÓA HỌC NỔI BẬT"
2. Nhập **Mô tả**: "Đa dạng khóa học phù hợp với mọi lứa tuổi..."
3. Click **Add Row** để thêm khóa học:
   - **Ảnh**: Upload hình khóa học
   - **Badge**: "4-12 TUỔI"
   - **Tiêu đề**: "Anh văn thiếu nhi"
   - **Mô tả**: "Giới thiệu bảng chữ cái và các từ cơ bản..."
   - **Link**: (để trống hoặc link tới trang khóa học)

Thêm 4 khóa học nữa:
- Anh văn thiếu niên (13-17 tuổi)
- Anh văn giao tiếp (18+)
- Luyện thi IELTS (All ages)
- Anh văn doanh nghiệp (All ages)

### 2.4 Testimonials Section

1. Nhập **Tiêu đề**: "HỌC VIÊN NÓI GÌ VỀ CHÚNG TÔI?"
2. Nhập **Mô tả**: "Chúng tôi mang đến..."
3. Click **Add Row** để thêm testimonials:
   - **Ảnh đại diện**: Upload avatar
   - **Tên**: "Nguyễn Hoài An"
   - **Vị trí**: "Bố mẹ học viên - Lớp K4 tháng 3"
   - **Bình luận**: "Mình rất hài lòng..."
   - **Số sao**: 5

Thêm 2-3 testimonials nữa

### 2.5 CTA Section

1. Nhập **Tiêu đề**: "SẴN SÀNG BẮT ĐẦU HÀNH TRÌNH CHINH PHỤC TIẾNG ANH?"
2. Nhập **Mô tả**: "Đăng ký hôm nay..."
3. Nhập **Nút CTA**: Text "ĐĂNG KÝ HỌC THỬ MIỄN PHÍ"
4. (Tuỳ chọn) Upload hình nền

### 2.6 Statistics Section

1. Click **Add Row** để thêm thống kê:
   - **Icon**: Upload icon
   - **Số lượng**: "10,000+"
   - **Mô tả**: "Học viên đã tham gia"

Thêm 3 thống kê nữa:
- 50+ Đạo tạo chương trình
- 95% Học viên hài lòng
- 8+ Năm kinh nghiệm giảng dạy

## 🎨 Bước 3: Tùy chỉnh Styling

Các CSS variables có thể tùy chỉnh trong `assets/css/landing.css`:

```css
:root {
    --primary-color: #5B9EF5;      /* Màu xanh chính */
    --primary-dark: #1F5BA8;       /* Màu xanh đậm */
    --text-dark: #333;             /* Màu chữ chính */
    --text-light: #666;            /* Màu chữ phụ */
    --border-color: #ddd;          /* Màu đường viền */
    --light-bg: #EEF4FD;           /* Màu nền nhạt */
}
```

## ✅ Bước 4: Kiểm thử

1. Vào trang landing page từ frontend
2. Kiểm tra các section:
   - [ ] Hero section hiển thị đúng
   - [ ] Why Choose Us cards
   - [ ] Courses carousel
   - [ ] Testimonials carousel
   - [ ] CTA section
   - [ ] Statistics
3. Test responsive (mobile, tablet, desktop)
4. Test carousel sliders

## 🔄 Bước 5: Cập nhật functions.php (nếu cần)

Nếu CSS không load, thêm code này vào `functions.php`:

```php
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'landing-page-style',
        get_template_directory_uri() . '/assets/css/landing.css',
        array(),
        '1.0.0'
    );
    
    wp_enqueue_script(
        'landing-page-script',
        get_template_directory_uri() . '/assets/js/landing.js',
        array('jquery'),
        '1.0.0',
        true
    );
});
```

## 🛠️ Xử lý sự cố

### Slider không hoạt động
- Kiểm tra jQuery có được load không
- Kiểm tra browser console có error không
- Cài đặt Font Awesome nếu cần icons

### ACF fields không xuất hiện
- Kiểm tra plugin ACF đã kích hoạt
- Kiểm tra page template đã chọn "Landing Page"
- Refresh page hoặc clear cache

### Styling không hiển thị
- Kiểm tra CSS file có được enqueue không
- Clear browser cache (Ctrl+Shift+Delete)
- Kiểm tra file path có chính xác không

## 📚 ACF Field Reference

### Hero Section
```
hero_main_title          (Text)
hero_sub_title           (Text)
hero_description         (Textarea)
hero_image               (Image)
hero_primary_button      (Link)
hero_secondary_button    (Link)
```

### Why Choose Us
```
why_choose_title         (Text)
why_choose_description   (Textarea)
why_choose_benefits      (Repeater)
  - benefit_icon         (Image)
  - benefit_title        (Text)
  - benefit_description  (Textarea)
```

### Featured Courses
```
courses_title            (Text)
courses_description      (Textarea)
featured_courses         (Repeater)
  - course_image         (Image)
  - course_badge         (Text)
  - course_title         (Text)
  - course_description   (Textarea)
  - course_link          (URL)
```

### Testimonials
```
testimonials_title       (Text)
testimonials_description (Textarea)
testimonials             (Repeater)
  - testimonial_avatar   (Image)
  - testimonial_name     (Text)
  - testimonial_position (Text)
  - testimonial_comment  (Textarea)
  - testimonial_rating   (Number 1-5)
```

### CTA Section
```
cta_title                (Text)
cta_description          (Textarea)
cta_button               (Link)
cta_background_image     (Image)
```

### Statistics
```
statistics               (Repeater)
  - stat_icon            (Image)
  - stat_number          (Text)
  - stat_description     (Text)
```

## 💡 Tips & Tricks

### 1. Tính năng Carousel
- Courses slider: Hiển thị 5 items trên desktop, 1 item trên mobile
- Testimonials slider: Auto-play với 5 giây mỗi slide
- Có thể điều chỉnh trong `landing.js`

### 2. Lazy Load
- Hình ảnh được lazy-load để tăng performance
- Sử dụng Intersection Observer API

### 3. Responsive Design
- Mobile-first approach
- Breakpoints: 1200px, 992px, 768px, 480px

### 4. SEO Optimization
- Semantic HTML
- Đúng heading hierarchy (H1, H2, H3)
- Alt text cho images

## 🚀 Deployment

### Trước khi Go Live

1. **Kiểm tra Performance**
   - Sử dụng Google PageSpeed Insights
   - Optimize images
   - Minify CSS/JS (tuỳ chọn)

2. **Kiểm tra Compatibility**
   - Test trên Chrome, Firefox, Safari, Edge
   - Test trên iOS và Android

3. **SEO Check**
   - Kiểm tra meta description
   - Kiểm tra keywords
   - Kiểm tra structured data

4. **Backup Database**
   - Export database
   - Export file theme

## 📞 Support

Nếu cần hỗ trợ:
1. Kiểm tra lại các bước trên
2. Xem browser console (F12)
3. Kiểm tra WordPress debug log
4. Contact theme developer

---

**Phiên bản:** 1.0  
**Ngày cập nhật:** 2026-04-28  
**Hỗ trợ:** PHP 7.4+, WordPress 5.0+
