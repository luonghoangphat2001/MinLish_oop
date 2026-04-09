# Test Plan: MinLish - Sprint 1 & 2

## 1. Mục đích và Phạm vi
Tài liệu này xác định các kịch bản kiểm thử thủ công (manual test cases) cho các tính năng cốt lõi của ứng dụng MinLish được phát triển trong Sprint 1 và 2. Đảm bảo toàn bộ luồng người dùng (user flow) hoạt động trơn tru trước khi release.

## 2. Môi trường & Dữ liệu Test
- **Môi trường:** Localhost / Môi trường Staging (nếu có).
- **Dữ liệu chuẩn bị:** - Đảm bảo database đã được migrate mới nhất.
  - Chạy lệnh seeder từ Task T09 để có dữ liệu mẫu: `php artisan db:seed`

---

## 3. Kịch bản Kiểm thử chi tiết (Test Cases)

### 3.1. Module Xác thực & Tài khoản (Auth)
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái (Pass/Fail) |
|:---|:---|:---|:---|:---|
| `AUTH_01` | Đăng ký tài khoản mới | 1. Truy cập trang Đăng ký.<br>2. Nhập tên, email hợp lệ và mật khẩu.<br>3. Bấm Submit. | Đăng ký thành công, tự động đăng nhập và chuyển hướng vào Dashboard. | Pass |
| `AUTH_02` | Đăng nhập tài khoản | 1. Truy cập trang Đăng nhập.<br>2. Nhập email và mật khẩu đúng.<br>3. Bấm Đăng nhập. | Đăng nhập thành công, hiển thị Dashboard. | Pass |
| `AUTH_03` | Đăng xuất | 1. Từ trang bất kỳ khi đang đăng nhập.<br>2. Bấm nút Đăng xuất. | Hệ thống xóa session, chuyển hướng về trang chủ hoặc trang đăng nhập. | Pass |
| `AUTH_04` | Cập nhật hồ sơ (Profile) | 1. Vào trang Hồ sơ cá nhân.<br>2. Đổi tên hiển thị hoặc email.<br>3. Bấm Lưu. | Cập nhật thành công, thông tin mới hiển thị đúng trên toàn hệ thống. | Pass |

### 3.2. Module Quản lý Từ vựng (Vocabulary)
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái (Pass/Fail) |
|:---|:---|:---|:---|:---|
| `VOCAB_01` | Tạo Vocabulary Set mới | 1. Vào mục Bộ từ vựng > Thêm mới.<br>2. Nhập Tên bộ từ và Mô tả.<br>3. Bấm Lưu. | Bộ từ vựng mới xuất hiện trong danh sách. | Pass |
| `VOCAB_02` | Chỉnh sửa từ vựng | 1. Bấm nút Sửa ở một từ vựng bất kỳ.<br>2. Thay đổi nội dung (ví dụ: sửa nghĩa).<br>3. Bấm Lưu. | Nội dung của từ được cập nhật đúng với thông tin vừa sửa. | Pass |
| `VOCAB_03` | Xóa từ vựng | 1. Bấm nút Xóa ở một từ vựng.<br>2. Bấm Xác nhận (nếu có popup). | Từ vựng biến mất khỏi danh sách. | Fail ( Chưa có chức năng xoá từ vựng) |

### 3.3. Module Học tập (Learning Session)
*Yêu cầu tiên quyết: Đã hoàn thành T16 để có full user flow.*

| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái (Pass/Fail) |
|:---|:---|:---|:---|:---|
| `LEARN_01` | Khởi tạo phiên học | 1. Từ Dashboard, bấm "Bắt đầu học ngay". | Hệ thống load thành công giao diện Learning Session, hiển thị Flashcard đầu tiên, đếm đúng tổng số từ. | Pass |
| `LEARN_02` | Tương tác lật Flashcard | 1. Click trực tiếp vào thẻ Flashcard đang hiện mặt từ vựng. | Thẻ lật mặt mượt mà, hiển thị Nghĩa, Phiên âm, các Nút đánh giá. | Pass |
| `LEARN_03` | Đánh giá từ vựng (SRS) | 1. Bấm 1 trong 4 nút: Lại / Khó / Tốt / Dễ. | Chuyển ngay sang từ tiếp theo. Record được ghi nhận ngầm vào bảng `study_logs`. | Pass |
| `LEARN_04` | Màn hình kết quả cuối phiên | 1. Hoàn thành đánh giá từ cuối cùng trong Queue. | Hiển thị màn hình chúc mừng. Thống kê chính xác: số từ đã học, và phân bổ rating. | Pass |

### 3.4. Module Kế hoạch hàng ngày (Daily Plan)
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái (Pass/Fail) |
|:---|:---|:---|:---|:---|
| `DAILY_01` | Hiển thị số lượng từ Queue | 1. Đăng nhập và xem bảng thông báo trên Dashboard. | Hiển thị chính xác con số phân loại: Từ mới (New) và Từ cần ôn tập (Review) cho ngày hôm nay. | Pass |

---

## 4. Hướng dẫn Báo cáo lỗi (Report Bugs)
Nếu kịch bản nào có kết quả thực tế không khớp với kết quả mong đợi (Trạng thái = Fail), vui lòng mở Issue trên GitHub tuân thủ định dạng sau:

1. **Title:** `[Tên Module] - Mô tả ngắn gọn lỗi` (Ví dụ: `[Learn] Bấm lật Flashcard không phản hồi`)
2. **Labels:** Bắt buộc gắn label `bug` và 1 label `priority` (`priority: high`, `priority: medium`, hoặc `priority: low`).
3. **Description:**
   - **Môi trường:** (Ví dụ: Windows 11, Chrome, Màn hình Learning Session)
   - **Steps to reproduce:** Ghi lại chính xác từng bước click chuột để gây ra lỗi.
   - **Expected Result:** (Lấy từ bảng trên).
   - **Actual Result:** Mô tả lỗi đang xảy ra, đính kèm hình ảnh screenshot hoặc video quay màn hình nếu có.