document.getElementById('search').addEventListener('input', function() {
    const searchQuery = this.value.trim(); // Lấy giá trị tìm kiếm và loại bỏ khoảng trắng

    // Kiểm tra xem người dùng có nhập gì không
    if (searchQuery.length === 0) {
        // Nếu không có gì, làm sạch bảng sản phẩm
        document.getElementById('productTable').innerHTML = '';
        return; // Dừng lại nếu không có truy vấn tìm kiếm
    }

    // Gửi yêu cầu AJAX tới server
    fetch(`/sanpham/search?query=${encodeURIComponent(searchQuery)}`)
        .then(response => {
            console.log('Response status:', response.status);
            
            // Kiểm tra xem phản hồi có phải là JSON không
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.json();
        })
        .then(data => {
            const tableBody = document.getElementById('productTable');
            tableBody.innerHTML = ''; // Xóa nội dung bảng trước khi cập nhật

            // Cập nhật bảng với các sản phẩm tìm thấy
            if (data.length === 0) {
                const noResultsRow = `
                    <tr>
                        <td colspan="7" class="text-center px-4 py-2">Không tìm thấy sản phẩm nào.</td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', noResultsRow);
                return;
            }

            data.forEach(sanpham => {
                const row = `
                    <tr class="border-b hover:bg-gray-100 transition duration-200">
                        <td class="px-4 py-2">${sanpham.TenSanPham}</td>
                        <td class="px-4 py-2">${sanpham.loaiSanPham ? sanpham.loaiSanPham.TenLoaiSanPham : 'Chưa có'}</td>
                        <td class="px-4 py-2">${sanpham.Gia.toLocaleString('vi-VN')} VND</td>
                        <td class="px-4 py-2">${sanpham.ThuongHieu || 'Chưa có'}</td>
                        <td class="px-4 py-2">${sanpham.NgaySanXuat || 'Chưa có'}</td>
                        <td class="px-4 py-2">${sanpham.BaoHanh || 'Chưa có'} tháng</td>
                        <td class="px-4 py-2 text-center flex justify-center space-x-2">
                            <a href="/sanpham/${sanpham.SanPhamID}/edit" class="text-blue-600 hover:text-blue-800 transition">Sửa</a>
                            <form action="/sanpham/${sanpham.SanPhamID}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" style="display:inline;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">Xóa</button>
                            </form>
                            <button 
                                onclick="showDiscountModal('${sanpham.SanPhamID}')" 
                                class="text-yellow-600 hover:text-yellow-800 transition">
                                Giảm Giá
                            </button>
                        </td>
                    </tr>
                `;
                
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        })
        .catch(error => {
            console.error('Lỗi tìm kiếm:', error);
            alert('Có lỗi xảy ra. Vui lòng kiểm tra console để biết thêm chi tiết.');
        });
});


document.getElementById('discountForm').addEventListener('submit', function(e) {
    const discountStart = document.getElementById('discountStart').value;
    const discountExpiry = document.getElementById('discountExpiry').value;
    const today = new Date().toISOString().split('T')[0]; // Lấy ngày hiện tại

    // Kiểm tra nếu ngày bắt đầu lớn hơn ngày kết thúc
    if (discountStart > discountExpiry) {
        e.preventDefault(); // Ngăn không cho form submit
        alert('Ngày bắt đầu không thể lớn hơn ngày kết thúc!');
        return;
    }

    // Kiểm tra nếu ngày kết thúc nhỏ hơn ngày hiện tại
    if (discountExpiry < today) {
        e.preventDefault(); // Ngăn không cho form submit
        alert('Ngày kết thúc không thể nhỏ hơn ngày hiện tại!');
        return;
    }
});

// Hiển thị modal giảm giá
function showDiscountModal(productId) {
    const modal = document.getElementById('discountModal');
    modal.classList.remove('hidden');

    // Đặt action động cho form
    const form = document.getElementById('discountForm');
    form.action = `/sanpham/${productId}/discount`;
}

// Đóng modal giảm giá
function closeDiscountModal() {
    const modal = document.getElementById('discountModal');
    modal.classList.add('hidden');
}

function showDiscountListModal() {
    document.getElementById('discountListModal').classList.remove('hidden');
}

function closeDiscountListModal() {
    document.getElementById('discountListModal').classList.add('hidden');
}

function showDiscountModal(sanphamId) {
    document.getElementById('discountForm').action = '/sanpham/' + sanphamId + '/discount'; // Cập nhật action cho form
    document.getElementById('discountModal').classList.remove('hidden');
}

function closeDiscountModal() {
    document.getElementById('discountModal').classList.add('hidden');
}
