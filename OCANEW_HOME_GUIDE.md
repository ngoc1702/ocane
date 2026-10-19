# Trang chủ LDP OcaNew

1. Bật theme **OCANEW**, plugin **Advanced Custom Fields** (bản Free hoặc Pro).
2. Tạo/chỉnh sửa một Trang, chọn template **OcaNew – Trang chủ LDP**, lưu trang để hiện nhóm **OcaNew — Cấu hình trang chủ LDP**.
3. Trong tab **Header**, tải logo và ảnh thay icon cho Việt Nam, Email, Hỗ trợ khách hàng, Tài liệu. Chỉnh chữ và liên kết tại từng mục; xóa chữ để ẩn mục. Icon mặc định xuất hiện khi chưa tải ảnh. PNG/WebP nền trong suốt, icon trắng phù hợp thanh xanh đậm.
4. Vào **Giao diện → Menu**, tạo menu và gán vị trí **OcaNew — Menu trang chủ LDP**. Thêm sáu mục theo ảnh mẫu và chọn trang/URL thật. Menu mặc định chỉ là các đường dẫn gợi ý, cần tạo trang đích hoặc gán menu trước khi sử dụng.
5. Tab **Banner** cho phép thay riêng **Ảnh nền banner** và **Ảnh bên phải (đã xóa nền)**. Dùng ảnh nền ngang khoảng 1920 × 800px, ảnh bên phải PNG/WebP trong suốt cao từ 900px. Không tự xóa nền ảnh. Sửa dòng chữ nhỏ, tiêu đề chính, tiêu đề nhấn, mô tả, chữ nút và URL tại đây. Nút chỉ xuất hiện khi có cả chữ và URL. Xóa nội dung trường chữ để ẩn phần tương ứng. Nội dung LDP bên dưới nhập bằng trình soạn thảo trang.
6. Vào **Cài đặt → Đọc → Một trang tĩnh**, chọn trang vừa tạo làm **Trang chủ**, lưu.

Template dùng header riêng và các hook `wp_head`, `wp_body_open`, `wp_footer` của WordPress. Không hiển thị header/footer widget của Genesis. Logo chữ chỉ là phương án tạm; tải logo thương hiệu thật để khớp ảnh mẫu.

Khung nội dung header và landing tối đa **1280px**, có khoảng đệm trên màn hình nhỏ. Nền banner trải hết màn hình, chữ/ảnh nằm trong khung 1280px. Hai màu thương hiệu: xanh navy `#132C47` và vàng `#C6A365`, khai báo tại đầu `assets/css/landing.css` bằng `--oca-primary`, `--oca-accent`; chiều rộng dùng `--oca-container`. Ảnh bên phải dùng `object-fit: contain`, ảnh nền dùng `cover`. Trên điện thoại banner xếp chữ trên, ảnh dưới.

Các file chính: `page-home-landing.php`, `template-parts/home-header.php`, `custom/acf-home-landing.php`, `assets/css/landing.css`, `assets/js/landing.js` trong theme OcaNew. Cấu hình ACF được đăng ký bằng PHP, không cần import JSON. Chưa tự đổi cấu hình trang chủ trong database.
