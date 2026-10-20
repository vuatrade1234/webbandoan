# DANH SÁCH CÔNG VIỆC CẦN LÀM (TODO LIST)

## 1. KHU VỰC KHÁCH HÀNG (USER / CLIENT)
- [x] **1. Tự chọn ngày sinh cho khách hàng mới**:
  - Giao diện đăng ký (`KhachHang/web/register.php` & `user_registration_script.php`): Đã bổ sung trường chọn ngày sinh và lưu chính xác vào CSDL.
- [x] **2. Bỏ phần tìm kiếm trong thanh banner**:
  - `KhachHang/web/Layout_KhachHang_Header.php`: Đã gỡ bỏ ô tìm kiếm trong banner header.
- [x] **3. Bổ sung nút tiến/lùi cho phần phân trang**:
  - `index.php` & `HienThiTatCaSanPham.php`: Đã bổ sung đầy đủ nút `« Trước` và `Sau »`.
- [x] **4. Bỏ mục Quy cách đóng gói**:
  - `details.php`: Đã ẩn phần chọn "Quy cách đóng gói" trên giao diện người dùng, tự động giữ giá chuẩn khi thêm vào giỏ.
- [x] **5. Giang: Khắc phục lỗi áp voucher nhưng không trừ tiền**:
  - `cart2.php`, `oder.php`, `voucher_helper.php`: Đã đảm bảo số tiền giảm giá và tổng tiền thanh toán sau giảm được tính toán, hiển thị và trừ đồng bộ.
- [x] **6. Thêm mục cho khách hàng đánh giá**:
  - `details.php`: Đã tạo bảng `danhgia`, thêm form gửi nhận xét và số sao đánh giá sản phẩm, hiển thị bình luận tức thì.
- [x] **7. Minh: Sửa lỗi không hiện ảnh người dùng ở phía Admin & Khách hàng**:
  - Đồng bộ thư mục lưu avatar giữa `KhachHang/web/imgKH/` và `Images/ImgCustomer/`, bổ sung fallback tự động chống lỗi vỡ ảnh.
- [x] **8. Thêm chức năng đặt lại đơn trong lịch sử đơn hàng**:
  - `history_Cart.php`: Đã thêm nút "🔄 Đặt lại đơn" chuyển nhanh toàn bộ món trong đơn cũ vào lại giỏ hàng.
- [x] **9. Khắc phục lỗi chi tiết sản phẩm không hiện nhà cung cấp**:
  - `details.php`: Đã bổ sung câu lệnh LEFT JOIN `nhacungcap` và `thuonghieu`, hiển thị badge Nhà cung cấp và Thương hiệu nổi bật.
- [x] **10. Nghĩa: Khắc phục lỗi danh mục sản phẩm không hoạt động**:
  - `HienThiLoaiGiay.php`: Đã sửa lỗi mất món đầu tiên khi fetch dữ liệu, lấy đúng tên danh mục và hiển thị sản phẩm chính xác.
- [x] **11. Thêm nút lọc thương hiệu**:
  - `HienThiTatCaSanPham.php`: Đã bổ sung dropdown và logic lọc theo Thương hiệu (`MaTH`).
- [x] **12. Lan Phương: Tìm kiếm hình ảnh sản phẩm theo dữ liệu hiện có**:
  - Đã cập nhật `index.php`, `details.php`, `HienThiTatCaSanPham.php` ưu tiên load hình ảnh thực tế từ `Images/ImgProducts/` thay vì dùng ảnh tĩnh mặc định.

---

## 2. KHU VỰC ADMIN (QUẢN TRỊ VIÊN)
- [x] **13. Kiểm tra đồng bộ các tính năng sau khi sửa**:
  - Đồng bộ hiển thị avatar người dùng ở cả Admin và User.
- [x] **14. Thêm, sửa, xóa thương hiệu (Brand)**:
  - `Admin/Function/Brands/Handle.php`: Hoàn thiện xử lý xóa thương hiệu mà không làm mất sản phẩm (cập nhật MaTH về NULL an toàn).
- [x] **15. Xử lý vấn đề sản phẩm không có thương hiệu**:
  - `Admin/Function/Products/Products_Page.php` & `Handle.php`: Cho phép sản phẩm có thương hiệu trống / "Không có thương hiệu", hỗ trợ LEFT JOIN không bị ẩn món ăn.
- [x] **16. Khắc phục lỗi khi thêm hình ảnh sản phẩm mới**:
  - `Admin/Function/Products/Handle.php`: Đã tối ưu đường dẫn thư mục upload `Images/ImgProducts/` và mở rộng định dạng hỗ trợ.
- [x] **17. Sửa mã giảm giá: Bỏ số đơn thành công tối đa/tối thiểu**:
  - `Admin/Function/Voucher/`: Đã gỡ bỏ các trường và input số đơn tối đa/tối thiểu cả trên giao diện và backend.
- [x] **18. Sửa lỗi ngày tháng trong mã giảm giá**:
  - `Admin/Function/Voucher/Handle.php`: Đã validate chặn trường hợp ngày kết thúc trước ngày bắt đầu, thông báo lỗi rõ ràng.
- [x] **19. Bổ sung thống kê lượt bán và doanh thu**:
  - `Admin/Function/Statistical/Statistical_Page.php`: Bổ sung 3 thẻ KPI tổng quan (Doanh thu, Lượt bán, Đơn hàng) và bảng Top 5 món ăn bán chạy nhất.
- [x] **20. Bỏ tính năng thêm người dùng**:
  - `Admin/Function/Customer/admin_khachhang.php`: Đã gỡ bỏ nút và modal thêm người dùng thủ công trong Admin.

---

## 3. CHỨC NĂNG BỔ SUNG
- [x] **21. Vòng quay random món ăn phong cách mở hòm CS:GO**:
  - Tạo trang [mohom_csgo.php](file:///c:/xampp/htdocs/FoodStore/FoodStore/KhachHang/web/mohom_csgo.php) với thanh cuộn ngang mượt mà, phân cấp độ hiếm theo màu CS:GO, âm thanh tick trượt và modal chúc mừng trúng món kèm nút đặt hàng ngay. Đã gắn link trực tiếp trên thanh menu chính của header.
