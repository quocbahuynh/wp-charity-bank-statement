# Charity Bank Statement - WordPress Plugin

**Charity Bank Statement** là một plugin WordPress dành riêng cho các tổ chức thiện nguyện được MB BANK xác nhận  giúp hiển thị sao kê giao dịch ngân hàng của tổ chức từ thiện một cách minh bạch và chuyên nghiệp lên Website. Plugin cho phép người dùng tìm kiếm, lọc và phân trang danh sách giao dịch từ MB ngân hàng.

![Charity Bank Statement là plugin WordPress dành cho tổ chức thiện nguyện được MB BANK xác nhận, giúp hiển thị sao kê giao dịch minh bạch trên website  Hỗ trợ tìm kiếm, lọc và phân trang giao dịch](https://github.com/user-attachments/assets/9a2efaea-3c7b-481a-801b-e6fb86e619d4)


## 🚀 Tính năng chính

✅ Hiển thị sao kê giao dịch từ thiện trực tiếp trên website.  
✅ Tìm kiếm và lọc theo từ khóa, ngày tháng.  
✅ Phân trang để hiển thị danh sách giao dịch dài.  
✅ Giao diện thân thiện, dễ sử dụng.  
✅ Tích hợp API ngân hàng linh hoạt.  

## 🍃 Live Demo
- **Website**: [https://thiennguyenminhphuoc.com/tai-chinh/](https://thiennguyenminhphuoc.com/tai-chinh/)  

## 📥 Cài đặt

1. **Tải plugin**
   - Clone repository này hoặc tải file ZIP về.
   - Giải nén và tải lên thư mục `/wp-content/plugins/` của WordPress.
   - Hoặc cài đặt trực tiếp qua giao diện quản trị WordPress.

2. **Kích hoạt plugin**
   - Vào **Plugins** → **Charity Bank Statement** → **Activate**.

3. **Cấu hình API ngân hàng**
   - Truy cập **Cài đặt** → **Charity Bank Statement**.
   - Nhập ID tài khoản ngân hàng từ thiện.
   - Lưu cài đặt.

## 📝 Hướng dẫn sử dụng

### Hiển thị sao kê trên trang web

Sử dụng shortcode sau trong bài viết hoặc trang:
```html
[transactions_display]
```

### Lọc giao dịch theo ngày và từ khóa
- Sử dụng ô tìm kiếm và bộ lọc ngày để thu hẹp danh sách giao dịch.

## 📌 API Configuration

- Plugin sử dụng API từ hệ thống ngân hàng của bạn.
- Mặc định sử dụng URL: `https://apiv2.thiennguyen.app/api/v2/report/{bank_id}/transactions`
- `{bank_id}` sẽ được thay thế bằng ID ngân hàng mà người dùng nhập trong phần cài đặt.

## 🔧 Developer Notes

- Plugin sử dụng **AJAX** để tải dữ liệu mà không cần refresh trang.
- Dữ liệu được hiển thị dưới dạng bảng với thiết kế Bootstrap.
- Hỗ trợ thêm CSS tùy chỉnh để phù hợp với giao diện website.

## 🤝 Đóng góp & Hỗ trợ

Nếu bạn có bất kỳ đề xuất hoặc lỗi nào, vui lòng mở **issue** hoặc gửi **pull request**.

### 📧 Liên hệ
- **Tác giả**: Huỳnh Bá Quốc  
- **Email**: [quochbcontact@gmail.com](mailto:quochbcontact@gmail.com)  
- **Website**: [quochuynh.website](https://www.quochuynh.website/)  

Cảm ơn bạn đã sử dụng **Charity Bank Statement**! 🙌

