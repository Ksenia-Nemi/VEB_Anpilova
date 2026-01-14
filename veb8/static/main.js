// main.js
let currentSearchQuery = '';
let autocompleteTimeout;

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    initializeSearch();
    downloadData(1);
    
    // Обработчики пагинации
    document.querySelector('.pagination').addEventListener('click', pageBtnHandler);
    document.querySelector('.per-page-btn').addEventListener('change', perPageBtnHandler);
});

// Инициализация поиска
function initializeSearch() {
    const searchForm = document.getElementById('searchForm');
    const searchField = document.getElementById('searchField');
    const searchBtn = document.querySelector('.search-btn');
    const autocompleteContainer = document.getElementById('autocompleteContainer');
    
    // Фокус на поле поиска при загрузке
    searchField.focus();
    
    // Обработчик ввода в поисковую строку
    searchField.addEventListener('input', function() {
        const query = this.value.trim();
        currentSearchQuery = query;
        
        // Показываем/скрываем автодополнение
        if (query.length >= 1) {
            clearTimeout(autocompleteTimeout);
            autocompleteTimeout = setTimeout(() => {
                fetchAutocompleteSuggestions(query);
            }, 300);
        } else {
            autocompleteContainer.style.display = 'none';
        }
    });
    
    // Обработчик отправки формы (поиск)
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch(searchField.value.trim());
    });
    
    // Обработчик клика по кнопке поиска
    searchBtn.addEventListener('click', function() {
        performSearch(searchField.value.trim());
    });
    
    // Обработчик клика вне поля поиска (скрываем автодополнение)
    document.addEventListener('click', function(e) {
        if (!searchForm.contains(e.target)) {
            autocompleteContainer.style.display = 'none';
        }
    });
    
    // Обработчик клавиш в поле поиска
    searchField.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            performSearch(this.value.trim());
        }
    });
}

// Выполнение поиска
function performSearch(query) {
    const autocompleteContainer = document.getElementById('autocompleteContainer');
    autocompleteContainer.style.display = 'none';
    
    // Анимация кнопки поиска
    const searchBtn = document.querySelector('.search-btn');
    searchBtn.style.transform = 'scale(0.95)';
    setTimeout(() => {
        searchBtn.style.transform = '';
    }, 150);
    
    // Выполняем поиск
    downloadData(1, query);
}

// Загрузка автодополнения
function fetchAutocompleteSuggestions(query) {
    const autocompleteContainer = document.getElementById('autocompleteContainer');
    
    if (!query) {
        autocompleteContainer.style.display = 'none';
        return;
    }
    
    const url = `http://cat-facts-api.std-900.ist.mospolytech.ru/autocomplete?q=${encodeURIComponent(query)}`;
    
    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(suggestions => {
            displayAutocompleteSuggestions(suggestions);
        })
        .catch(error => {
            console.error('Autocomplete error:', error);
            autocompleteContainer.style.display = 'none';
        });
}

// Отображение автодополнения
function displayAutocompleteSuggestions(suggestions) {
    const autocompleteContainer = document.getElementById('autocompleteContainer');
    const searchField = document.getElementById('searchField');
    
    if (!suggestions || suggestions.length === 0) {
        autocompleteContainer.style.display = 'none';
        return;
    }
    
    autocompleteContainer.innerHTML = '';
    
    // Ограничиваем до 10 подсказок
    suggestions.slice(0, 10).forEach(suggestion => {
        const item = document.createElement('div');
        item.className = 'autocomplete-item';
        
        // Выделяем совпадения
        const lowerSuggestion = suggestion.toLowerCase();
        const lowerQuery = searchField.value.toLowerCase();
        const index = lowerSuggestion.indexOf(lowerQuery);
        
        if (index !== -1) {
            const before = suggestion.substring(0, index);
            const match = suggestion.substring(index, index + searchField.value.length);
            const after = suggestion.substring(index + searchField.value.length);
            item.innerHTML = `${before}<strong>${match}</strong>${after}`;
        } else {
            item.textContent = suggestion;
        }
        
        // Обработчик клика по подсказке
        item.addEventListener('click', function() {
            searchField.value = suggestion;
            performSearch(suggestion);
        });
        
        autocompleteContainer.appendChild(item);
    });
    
    autocompleteContainer.style.display = 'block';
}

// Загрузка данных с сервера
function downloadData(page = 1, searchQuery = '') {
    const factsList = document.querySelector('.facts-list');
    const perPage = document.querySelector('.per-page-btn').value;
    
    let url = `http://cat-facts-api.std-900.ist.mospolytech.ru/facts?page=${page}&per-page=${perPage}`;
    
    if (searchQuery) {
        url += `&q=${encodeURIComponent(searchQuery)}`;
        currentSearchQuery = searchQuery;
    }
    
    // Показываем индикатор загрузки
    factsList.innerHTML = '<div style="text-align: center; padding: 40px;">Loading...</div>';
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            renderRecords(data.records);
            updatePaginationInfo(data._pagination);
            renderPagination(data._pagination);
        })
        .catch(error => {
            console.error('Error loading data:', error);
            factsList.innerHTML = '<div class="no-results">Error loading data. Please try again.</div>';
        });
}

// Рендеринг записей
function renderRecords(records) {
    const factsList = document.querySelector('.facts-list');
    factsList.innerHTML = '';
    
    if (!records || records.length === 0) {
        factsList.innerHTML = `
            <div class="no-results">
                <span class="no-results-icon">😿</span>
                <div>No facts found for "${currentSearchQuery}"</div>
                <div style="margin-top: 10px; font-size: 14px; color: #999;">
                    Try a different search term
                </div>
            </div>
        `;
        return;
    }
    
    records.forEach(record => {
        const item = document.createElement('div');
        item.className = 'facts-list-item';
        
        // Содержимое факта
        const content = document.createElement('div');
        content.className = 'item-content';
        content.textContent = record.text;
        
        // Футер с автором и рейтингом
        const footer = document.createElement('div');
        footer.className = 'item-footer';
        
        const author = document.createElement('div');
        author.className = 'author-name';
        const userName = record.user ? 
            `${record.user.name.first} ${record.user.name.last}` : 
            'Unknown';
        author.textContent = userName;
        
        const upvotes = document.createElement('div');
        upvotes.className = 'upvotes';
        upvotes.innerHTML = `▲ ${record.upvotes}`;
        
        footer.appendChild(author);
        footer.appendChild(upvotes);
        
        item.appendChild(content);
        item.appendChild(footer);
        
        factsList.appendChild(item);
    });
}

// Обновление информации о пагинации
function updatePaginationInfo(pagination) {
    document.querySelector('.total-count').textContent = pagination.total_count;
    
    const start = (pagination.current_page - 1) * pagination.per_page + 1;
    const end = Math.min(pagination.total_count, pagination.current_page * pagination.per_page);
    
    document.querySelector('.current-interval-start').textContent = start;
    document.querySelector('.current-interval-end').textContent = end;
}

// Рендеринг пагинации
function renderPagination(pagination) {
    const paginationContainer = document.querySelector('.pagination');
    paginationContainer.innerHTML = '';
    
    // Не показываем пагинацию если всего 1 страница
    if (pagination.total_pages <= 1) return;
    
    // Кнопка "Назад"
    if (pagination.current_page > 1) {
        const prevBtn = document.createElement('button');
        prevBtn.className = 'btn';
        prevBtn.textContent = '← Previous';
        prevBtn.dataset.page = pagination.current_page - 1;
        paginationContainer.appendChild(prevBtn);
    }
    
    // Кнопки страниц
    const maxVisible = 5;
    let startPage = Math.max(1, pagination.current_page - Math.floor(maxVisible / 2));
    let endPage = Math.min(pagination.total_pages, startPage + maxVisible - 1);
    
    if (endPage - startPage + 1 < maxVisible) {
        startPage = Math.max(1, endPage - maxVisible + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const btn = document.createElement('button');
        btn.className = 'btn';
        if (i === pagination.current_page) {
            btn.classList.add('active');
        }
        btn.textContent = i;
        btn.dataset.page = i;
        paginationContainer.appendChild(btn);
    }
    
    // Кнопка "Вперед"
    if (pagination.current_page < pagination.total_pages) {
        const nextBtn = document.createElement('button');
        nextBtn.className = 'btn';
        nextBtn.textContent = 'Next →';
        nextBtn.dataset.page = pagination.current_page + 1;
        paginationContainer.appendChild(nextBtn);
    }
}

// Обработчик кликов по кнопкам пагинации
function pageBtnHandler(e) {
    if (e.target.tagName === 'BUTTON' && e.target.dataset.page) {
        downloadData(parseInt(e.target.dataset.page), currentSearchQuery);
        // Прокрутка к верху страницы
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// Обработчик изменения количества записей на странице
function perPageBtnHandler() {
    downloadData(1, currentSearchQuery);
}