// Đảm bảo code chạy khi giao diện đã load xong
document.addEventListener('DOMContentLoaded', function() {
    // Chỉ chạy trên trang chi tiết tour
    if(document.getElementById('calc_price')) {
        const basePriceText = document.getElementById('calc_price').innerText.replace(/\./g, '');
        const basePrice = parseInt(basePriceText);
        
        // Lấy số khách tối đa từ input max (nếu có, ở đây giả sử truyền tạm từ HTML)
        const maxQty = 20; 
        let currentQty = 1;

        function formatCurrency(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Gắn sự kiện cho nút tăng giảm
        window.changeQty = function(amount) {
            let newQty = currentQty + amount;
            if (newQty >= 1 && newQty <= maxQty) {
                currentQty = newQty;
                document.getElementById('qty_display').innerText = currentQty;
                document.getElementById('soluong_input').value = currentQty;
                document.getElementById('calc_qty').innerText = currentQty;
                
                let total = basePrice * currentQty;
                let formattedTotal = formatCurrency(total) + " VNĐ";
                document.getElementById('calc_subtotal').innerText = formattedTotal;
                document.getElementById('calc_total').innerText = formattedTotal;
            } else if (newQty > maxQty) {
                Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Đã vượt quá số lượng khách tối đa của tour này!'});
            }
        };

        // Gắn sự kiện trái tim
        window.addToFavorite = function(maTour) {
            const heartIcon = document.getElementById('heart_icon');
            if (heartIcon.classList.contains('fa-regular')) {
                heartIcon.classList.remove('fa-regular');
                heartIcon.classList.add('fa-solid', 'text-danger');
                Swal.fire({
                    icon: 'success',
                    title: 'Đã lưu tour!',
                    text: 'Tour này đã được thêm vào Danh sách yêu thích của bạn.',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                heartIcon.classList.add('fa-regular');
                heartIcon.classList.remove('fa-solid', 'text-danger');
            }
        };
    }
});