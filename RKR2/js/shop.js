// Функция переключения вида отображения товаров
function toggleView(view) {
    const tableView = document.getElementById('products-table-view');
    const gridView = document.getElementById('products-grid-view');
    const tableBtn = document.getElementById('table-view');
    const gridBtn = document.getElementById('grid-view');
    
    if (view === 'table') {
        tableView.style.display = 'block';
        gridView.style.display = 'none';
        tableBtn.classList.add('active');
        gridBtn.classList.remove('active');
        // Сохраняем выбор в localStorage
        localStorage.setItem('productView', 'table');
    } else {
        tableView.style.display = 'none';
        gridView.style.display = 'block';
        tableBtn.classList.remove('active');
        gridBtn.classList.add('active');
        // Сохраняем выбор в localStorage
        localStorage.setItem('productView', 'grid');
    }
}

// Восстановление выбранного вида при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('productView');
    if (savedView === 'grid') {
        toggleView('grid');
    } else {
        toggleView('table');
    }
});

