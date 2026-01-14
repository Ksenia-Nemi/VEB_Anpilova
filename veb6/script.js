/**
 * Лабораторная работа №6 - Основы JavaScript
 * Реализация функций с интерактивным интерфейсом
 */

// ==================== ФУНКЦИИ ЗАДАЧ ====================

/**
 * Задача 1: Возведение в степень
 * @param {number} x - основание
 * @param {number} n - показатель степени (натуральное число)
 * @returns {number} x в степени n
 */
function pow(x, n) {
    if (n < 1 || !Number.isInteger(n)) {
        throw new Error('Степень должна быть натуральным числом (n >= 1)');
    }
    
    let result = 1;
    for (let i = 0; i < n; i++) {
        result *= x;
    }
    return result;
}

/**
 * Задача 2: Наибольший общий делитель (НОД)
 * @param {number} a - первое число (неотрицательное)
 * @param {number} b - второе число (неотрицательное)
 * @returns {number} наибольший общий делитель a и b
 */
function gcd(a, b) {
    // Проверка на неотрицательные числа
    if (a < 0 || b < 0) {
        throw new Error('Числа должны быть неотрицательными');
    }
    
    // Алгоритм Евклида
    while (b !== 0) {
        const temp = b;
        b = a % b;
        a = temp;
    }
    return a;
}

/**
 * Задача 3: Наименьшая цифра числа
 * @param {number} x - целое неотрицательное число
 * @returns {number} наименьшая цифра числа x
 */
function minDigit(x) {
    if (x < 0 || !Number.isInteger(x)) {
        throw new Error('Число должно быть целым неотрицательным');
    }
    
    if (x === 0) return 0;
    
    const digits = x.toString().split('');
    let min = 9; // Максимальная цифра
    
    for (let digit of digits) {
        const num = parseInt(digit);
        if (num < min) {
            min = num;
        }
    }
    
    return min;
}

/**
 * Задача 4: Склонение слов (Pluralization)
 * @param {number} n - количество записей
 * @returns {string} строка с правильной формой множественного числа
 */
function pluralizeRecords(n) {
    if (n < 0 || !Number.isInteger(n)) {
        throw new Error('Количество должно быть целым неотрицательным числом');
    }
    
    // Правила русского языка для склонения
    let recordsWord;
    let foundWord;
    
    // Склонение слова "запись"
    const lastDigit = n % 10;
const lastTwoDigits = n % 100;

// Склонение слова "запись"
if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    recordsWord = 'записей';
} else if (lastDigit === 1) {
    recordsWord = 'запись';
} else if (lastDigit >= 2 && lastDigit <= 4) {
    recordsWord = 'записи';
} else {
    recordsWord = 'записей';
}

// Склонение слова "найдено"
if (lastTwoDigits >= 11 && lastTwoDigits <= 19) {
    foundWord = 'было найдено';
} else if (lastDigit === 1) {
    foundWord = 'была найдена';
} else if (lastDigit >= 2 && lastDigit <= 4) {
    foundWord = 'было найдено';
} else {
    foundWord = 'было найдено';
}
    
    return `В результате выполнения запроса ${foundWord} ${n} ${recordsWord}`;
}

/**
 * Задача 5: Числа Фибоначчи
 * @param {number} n - позиция в последовательности (0 ≤ n ≤ 1000)
 * @returns {bigint} n-ое число Фибоначчи
 */
function fibb(n) {
    if (n < 0 || n > 1000 || !Number.isInteger(n)) {
        throw new Error('n должно быть целым числом от 0 до 1000');
    }
    
    // Базовые случаи
    if (n === 0) return 0n;
    if (n === 1) return 1n;
    
    // Используем BigInt для больших чисел
    let a = 0n;
    let b = 1n;
    
    for (let i = 2; i <= n; i++) {
        const temp = a + b;
        a = b;
        b = temp;
    }
    
    return b;
}

// ==================== ФУНКЦИИ ИНТЕРФЕЙСА ====================

/**
 * Обновляет отображение результата
 * @param {string} elementId - ID элемента для отображения
 * @param {string} message - сообщение для отображения
 * @param {boolean} isError - является ли сообщение ошибкой
 */
function updateResult(elementId, message, isError = false) {
    const element = document.getElementById(elementId);
    element.textContent = message;
    element.className = 'task-result has-result';
    
    if (isError) {
        element.style.color = '#e74c3c';
        element.style.borderColor = '#e74c3c';
        element.style.background = '#fff5f5';
    } else {
        element.style.color = '#27ae60';
        element.style.borderColor = '#27ae60';
        element.style.background = '#f0fff4';
    }
}

/**
 * Задача 1: Вычисление степени
 */
function calculatePow() {
    try {
        const x = parseFloat(document.getElementById('pow-x').value);
        const n = parseInt(document.getElementById('pow-n').value);
        
        if (isNaN(x) || isNaN(n)) {
            throw new Error('Пожалуйста, введите корректные числа');
        }
        
        const result = pow(x, n);
        updateResult('pow-result', `${x}^${n} = ${result}`);
    } catch (error) {
        updateResult('pow-result', `Ошибка: ${error.message}`, true);
    }
}

/**
 * Задача 2: Вычисление НОД
 */
function calculateGcd() {
    try {
        const a = parseInt(document.getElementById('gcd-a').value);
        const b = parseInt(document.getElementById('gcd-b').value);
        
        if (isNaN(a) || isNaN(b)) {
            throw new Error('Пожалуйста, введите корректные числа');
        }
        
        const result = gcd(a, b);
        updateResult('gcd-result', `НОД(${a}, ${b}) = ${result}`);
    } catch (error) {
        updateResult('gcd-result', `Ошибка: ${error.message}`, true);
    }
}

/**
 * Задача 3: Нахождение минимальной цифры
 */
function calculateMinDigit() {
    try {
        const x = parseInt(document.getElementById('min-digit-x').value);
        
        if (isNaN(x)) {
            throw new Error('Пожалуйста, введите корректное число');
        }
        
        const result = minDigit(x);
        updateResult('min-digit-result', 
            `Наименьшая цифра числа ${x} = ${result}`);
    } catch (error) {
        updateResult('min-digit-result', `Ошибка: ${error.message}`, true);
    }
}

/**
 * Задача 4: Склонение слов
 */
function calculatePlural() {
    try {
        const n = parseInt(document.getElementById('plural-n').value);
        
        if (isNaN(n)) {
            throw new Error('Пожалуйста, введите корректное число');
        }
        
        const result = pluralizeRecords(n);
        updateResult('plural-result', result);
    } catch (error) {
        updateResult('plural-result', `Ошибка: ${error.message}`, true);
    }
}

/**
 * Задача 5: Числа Фибоначчи
 */
function calculateFibb() {
    try {
        const n = parseInt(document.getElementById('fibb-n').value);
        
        if (isNaN(n)) {
            throw new Error('Пожалуйста, введите корректное число');
        }
        
        const result = fibb(n);
        updateResult('fibb-result', 
            `F(${n}) = ${result.toString()}`);
    } catch (error) {
        updateResult('fibb-result', `Ошибка: ${error.message}`, true);
    }
}

/**
 * Выполняет все вычисления
 */
function calculateAll() {
    calculatePow();
    calculateGcd();
    calculateMinDigit();
    calculatePlural();
    calculateFibb();
}

// ==================== ОБРАБОТКА АККОРДЕОНА ====================

/**
 * Инициализация аккордеона с вопросами
 */
function initAccordion() {
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    
    accordionHeaders.forEach(header => {
        header.addEventListener('click', () => {
            // Получаем родительский элемент и контент
            const item = header.parentElement;
            const content = item.querySelector('.accordion-content');
            
            // Закрываем все другие элементы
            document.querySelectorAll('.accordion-item').forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.querySelector('.accordion-header').classList.remove('active');
                    otherItem.querySelector('.accordion-content').classList.remove('active');
                    otherItem.querySelector('.accordion-content').style.maxHeight = null;
                }
            });
            
            // Переключаем текущий элемент
            header.classList.toggle('active');
            content.classList.toggle('active');
            
            if (content.classList.contains('active')) {
                content.style.maxHeight = content.scrollHeight + 'px';
            } else {
                content.style.maxHeight = null;
            }
        });
    });
    
    // Открываем первый элемент по умолчанию
    if (accordionHeaders.length > 0) {
        accordionHeaders[0].click();
    }
}

// ==================== ДОПОЛНИТЕЛЬНЫЕ ФУНКЦИИ ====================

/**
 * Генерация случайных тестовых данных
 */
function generateTestData() {
    // Задача 1: случайные числа для степени
    document.getElementById('pow-x').value = Math.floor(Math.random() * 10) + 1;
    document.getElementById('pow-n').value = Math.floor(Math.random() * 5) + 1;
    
    // Задача 2: случайные числа для НОД
    document.getElementById('gcd-a').value = Math.floor(Math.random() * 100) + 1;
    document.getElementById('gcd-b').value = Math.floor(Math.random() * 100) + 1;
    
    // Задача 3: случайное число для минимальной цифры
    document.getElementById('min-digit-x').value = Math.floor(Math.random() * 10000);
    
    // Задача 4: случайное количество записей
    document.getElementById('plural-n').value = Math.floor(Math.random() * 100) + 1;
    
    // Задача 5: случайное число Фибоначчи (не слишком большое)
    document.getElementById('fibb-n').value = Math.floor(Math.random() * 20);
}

/**
 * Проверка всех введенных значений
 */
function validateAllInputs() {
    const inputs = document.querySelectorAll('input[type="number"]');
    let isValid = true;
    
    inputs.forEach(input => {
        const value = input.value.trim();
        const min = parseFloat(input.min);
        const max = parseFloat(input.max);
        
        if (value === '' || isNaN(parseFloat(value))) {
            input.style.borderColor = '#e74c3c';
            isValid = false;
        } else if ((!isNaN(min) && parseFloat(value) < min) || 
                   (!isNaN(max) && parseFloat(value) > max)) {
            input.style.borderColor = '#e74c3c';
            isValid = false;
        } else {
            input.style.borderColor = '#27ae60';
        }
    });
    
    return isValid;
}

/**
 * Очистка всех результатов
 */
function clearAllResults() {
    const resultElements = document.querySelectorAll('.task-result');
    
    resultElements.forEach(element => {
        element.textContent = 'Результат появится здесь';
        element.className = 'task-result';
        element.style = '';
    });
}

// ==================== ИНИЦИАЛИЗАЦИЯ ====================

/**
 * Инициализация страницы при загрузке
 */
function initPage() {
    // Инициализация аккордеона
    initAccordion();
    
    // Добавление обработчиков событий для валидации
    const inputs = document.querySelectorAll('input[type="number"]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (validateAllInputs()) {
                this.style.borderColor = '#667eea';
            }
        });
    });
    
    // Добавление обработчика для клавиши Enter
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            const focusedElement = document.activeElement;
            if (focusedElement.tagName === 'INPUT') {
                calculateAll();
            }
        }
    });
    
    // Создание кнопок управления
    createControlButtons();
    
    // Автоматическая валидация при загрузке
    validateAllInputs();
}

/**
 * Создание дополнительных кнопок управления
 */
function createControlButtons() {
    const controlsContainer = document.createElement('div');
    controlsContainer.className = 'controls-container';
    controlsContainer.style.cssText = `
        display: flex;
        gap: 15px;
        justify-content: center;
        margin: 30px 0;
        flex-wrap: wrap;
    `;
    
    // Кнопка генерации тестовых данных
    const testBtn = document.createElement('button');
    testBtn.innerHTML = '<i class="fas fa-dice"></i> Случайные данные';
    testBtn.className = 'btn-control';
    testBtn.style.cssText = `
        padding: 12px 24px;
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    `;
    testBtn.onclick = generateTestData;
    testBtn.onmouseover = () => testBtn.style.transform = 'translateY(-2px)';
    testBtn.onmouseout = () => testBtn.style.transform = 'translateY(0)';
    
    // Кнопка очистки результатов
    const clearBtn = document.createElement('button');
    clearBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Очистить результаты';
    clearBtn.className = 'btn-control';
    clearBtn.style.cssText = `
        padding: 12px 24px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    `;
    clearBtn.onclick = clearAllResults;
    clearBtn.onmouseover = () => clearBtn.style.transform = 'translateY(-2px)';
    clearBtn.onmouseout = () => clearBtn.style.transform = 'translateY(0)';
    
    // Кнопка проверки всех значений
    const validateBtn = document.createElement('button');
    validateBtn.innerHTML = '<i class="fas fa-check-circle"></i> Проверить данные';
    validateBtn.className = 'btn-control';
    validateBtn.style.cssText = `
        padding: 12px 24px;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    `;
    validateBtn.onclick = () => {
        if (validateAllInputs()) {
            alert('✅ Все данные корректны!');
        } else {
            alert('❌ Некоторые данные некорректны. Проверьте поля с красной рамкой.');
        }
    };
    validateBtn.onmouseover = () => validateBtn.style.transform = 'translateY(-2px)';
    validateBtn.onmouseout = () => validateBtn.style.transform = 'translateY(0)';
    
    controlsContainer.appendChild(testBtn);
    controlsContainer.appendChild(validateBtn);
    controlsContainer.appendChild(clearBtn);
    
    // Вставляем кнопки перед кнопкой "Выполнить все вычисления"
    const calculateAllCard = document.querySelector('.task-card.full-width');
    if (calculateAllCard) {
        calculateAllCard.insertBefore(controlsContainer, calculateAllCard.querySelector('.btn-calculate-all'));
    }
}

// ==================== ДЕМОНСТРАЦИОННЫЕ ТЕСТЫ ====================

/**
 * Запуск тестов для всех функций
 */
function runTests() {
    console.log('🧪 Запуск тестов функций JavaScript:\n');
    
    try {
        // Тест 1: Возведение в степень
        console.log('1. Тест pow(x, n):');
        console.log(`   pow(2, 3) = ${pow(2, 3)} (ожидается: 8)`);
        console.log(`   pow(5, 4) = ${pow(5, 4)} (ожидается: 625)`);
        console.log(`   pow(3, 1) = ${pow(3, 1)} (ожидается: 3)\n`);
        
        // Тест 2: НОД
        console.log('2. Тест gcd(a, b):');
        console.log(`   gcd(48, 18) = ${gcd(48, 18)} (ожидается: 6)`);
        console.log(`   gcd(17, 13) = ${gcd(17, 13)} (ожидается: 1)`);
        console.log(`   gcd(100, 25) = ${gcd(100, 25)} (ожидается: 25)\n`);
        
        // Тест 3: Минимальная цифра
        console.log('3. Тест minDigit(x):');
        console.log(`   minDigit(5732) = ${minDigit(5732)} (ожидается: 2)`);
        console.log(`   minDigit(1000) = ${minDigit(1000)} (ожидается: 0)`);
        console.log(`   minDigit(999) = ${minDigit(999)} (ожидается: 9)\n`);
        
        // Тест 4: Склонение
        console.log('4. Тест pluralizeRecords(n):');
        console.log(`   n=1: ${pluralizeRecords(1)}`);
        console.log(`   n=2: ${pluralizeRecords(2)}`);
        console.log(`   n=5: ${pluralizeRecords(5)}`);
        console.log(`   n=11: ${pluralizeRecords(11)}`);
        console.log(`   n=21: ${pluralizeRecords(21)}\n`);
        
        // Тест 5: Числа Фибоначчи
        console.log('5. Тест fibb(n):');
        console.log(`   fibb(0) = ${fibb(0)} (ожидается: 0)`);
        console.log(`   fibb(1) = ${fibb(1)} (ожидается: 1)`);
        console.log(`   fibb(10) = ${fibb(10)} (ожидается: 55)`);
        console.log(`   fibb(20) = ${fibb(20)} (ожидается: 6765)\n`);
        
        console.log('✅ Все тесты пройдены успешно!');
        
    } catch (error) {
        console.error(`❌ Ошибка в тестах: ${error.message}`);
    }
}

// ==================== ЗАПУСК ПРИ ЗАГРУЗКЕ ====================

// Запуск инициализации при полной загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    initPage();
    
    // Запуск тестов в консоли (опционально)
    setTimeout(runTests, 1000);
    
    // Добавление информации о студенте
    document.getElementById('student-name').textContent = 'Анпилова Ксения Сергеевна';
    document.getElementById('group').textContent = '241-361';
    
    // Вывод информации о проекте в консоль
    console.log(`
    ============================================
         ЛАБОРАТОРНАЯ РАБОТА №6 - JavaScript
    ============================================
    Автор: Анпилова К.С.
    Группа: 241-361
    Дата: ${new Date().toLocaleDateString()}
    
    Доступные функции:
    1. pow(x, n) - возведение в степень
    2. gcd(a, b) - наибольший общий делитель
    3. minDigit(x) - наименьшая цифра числа
    4. pluralizeRecords(n) - склонение слов
    5. fibb(n) - числа Фибоначчи
    
    Для тестирования введите: runTests()
    ============================================
    `);
});

// ==================== ГЛОБАЛЬНЫЙ ДОСТУП ====================

// Делаем функции доступными глобально для тестирования в консоли
window.pow = pow;
window.gcd = gcd;
window.minDigit = minDigit;
window.pluralizeRecords = pluralizeRecords;
window.fibb = fibb;
window.runTests = runTests;
window.calculateAll = calculateAll;
window.generateTestData = generateTestData;

// Экспорт для использования в модулях (если нужно)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        pow,
        gcd,
        minDigit,
        pluralizeRecords,
        fibb
    };
}