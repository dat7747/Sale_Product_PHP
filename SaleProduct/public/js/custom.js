document.addEventListener('DOMContentLoaded', function() {
    console.log('Trang đã tải hoàn tất.');

    const searchForm = document.querySelector('form');
    searchForm.addEventListener('submit', function(e) {
    });

    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            card.classList.add('shadow-xl');
        });
        card.addEventListener('mouseleave', function() {
            card.classList.remove('shadow-xl');
        });
    });
});
