# Test Plan: MinLish - Sprint 3

## 1. Mục đích và Phạm vi
Kiểm thử các tính năng nâng cao của Sprint 3 bao gồm: Import/Export dữ liệu Excel, độ chính xác của Dashboard thống kê, hệ thống gửi Email thông báo và tính năng Clone bộ từ vựng. Đồng thời verify lại các bugs đã được fix từ đợt test T27 (Sprint 1 & 2).

## 2. Kịch bản Kiểm thử chi tiết (Test Cases)

### 2.1. Module Import/Export Excel
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái |
|:---|:---|:---|:---|:---|
| `EXCEL_01` | Import file hợp lệ | 1. Upload file Excel đúng định dạng (có đủ cột required).<br>2. Bấm Import. | Hệ thống báo thành công, toàn bộ từ vựng trong file được thêm vào DB. | |
| `EXCEL_02` | Import file thiếu cột | 1. Upload file Excel bị xóa mất cột bắt buộc (VD: cột Word hoặc Meaning).<br>2. Bấm Import. | Hệ thống báo lỗi rõ ràng dòng nào/cột nào bị thiếu, KHÔNG import dữ liệu rác vào DB. | |
| `EXCEL_03` | Import file rỗng | 1. Upload file Excel không có dòng dữ liệu nào.<br>2. Bấm Import. | Hệ thống báo lỗi "File không có dữ liệu". | |
| `EXCEL_04` | Export bộ từ vựng | 1. Vào một bộ từ vựng hiện có.<br>2. Bấm Export/Tải xuống.<br>3. Mở file tải về bằng Excel/Google Sheets. | File tải xuống thành công định dạng `.xlsx` hoặc `.csv`. Nội dung trong file khớp 100% với danh sách từ hiển thị trên web. | |

### 2.2. Module Thống kê (Dashboard)
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái |
|:---|:---|:---|:---|:---|
| `DASH_01` | Tính chính xác của Stats | 1. Học thử 1 phiên Flashcard (khoảng 5 từ).<br>2. Ra ngoài Dashboard kiểm tra số liệu "Tổng số từ đã học". | Con số hiển thị trên Dashboard tăng lên đúng bằng số từ vừa học. | |
| `DASH_02` | Biểu đồ Activity Chart | 1. Xem biểu đồ hoạt động trên Dashboard. | Biểu đồ hiển thị đúng dữ liệu của ngày hôm nay (cột chart cao lên tương ứng số từ đã học). | |

### 2.3. Module Email Notification
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái |
|:---|:---|:---|:---|:---|
| `MAIL_01` | Kiểm tra luồng gửi mail | 1. Kích hoạt một hành động có gửi mail (VD: Đăng ký tài khoản, hoặc Quên mật khẩu).<br>2. Mở Mailtrap hoặc check file `storage/logs/laravel.log`. | Email được render đúng template, tiêu đề và nội dung chính xác. Nhận được ngay lập tức. | |

### 2.4. Module Public Browse & Clone
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái |
|:---|:---|:---|:---|:---|
| `CLONE_01` | Deep Copy bộ từ vựng | 1. Đăng nhập User A, vào mục Public tìm bộ từ của User B.<br>2. Bấm "Clone/Lưu về máy".<br>3. Vào bộ từ vừa clone, xóa thử 1 từ. | User A sở hữu một bản sao độc lập (Deep Copy). Việc xóa từ ở bản sao của User A KHÔNG làm mất từ ở bộ gốc của User B. | |

### 2.5. Re-test Bugs từ T27
| ID | Kịch bản kiểm thử | Các bước thực hiện | Kết quả mong đợi | Trạng thái |
|:---|:---|:---|:---|:---|
| `RETEST_01` | Verify Bug #... | 1. Xem lại danh sách các Issue đã đóng ở đợt T27.<br>2. Làm lại đúng các bước gây ra lỗi trước đó. | Lỗi không còn xuất hiện. Tính năng hoạt động bình thường. | |