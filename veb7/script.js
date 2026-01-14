// DOM элементы
const expressionDisplay = document.getElementById('expression');
const resultDisplay = document.getElementById('result');
const buttons = document.querySelectorAll('.btn');

// Переменные калькулятора
let currentExpression = '';
let result = '0';

// Приоритет операторов
const precedence = {
    '+': 1,
    '-': 1,
    '*': 2,
    '/': 2
};

// Инициализация калькулятора
function initCalculator() {
    // Добавляем декоративные сердечки
    addHeartDecorations();
    
    // Назначаем обработчики событий для всех кнопок
    buttons.forEach(button => {
        button.addEventListener('click', handleButtonClick);
    });
    
    // Обновляем дисплей
    updateDisplay();
    
    // Добавляем обработчик клавиатуры
    document.addEventListener('keydown', handleKeyboardInput);
    
    // Показываем приветственное сообщение
    setTimeout(() => {
        expressionDisplay.value = 'Добро пожаловать!';
        setTimeout(() => {
            if (currentExpression === '') {
                expressionDisplay.value = '0';
            }
        }, 1500);
    }, 500);
}

// Добавляем декоративные сердечки
function addHeartDecorations() {
    const container = document.querySelector('body');
    
    for (let i = 0; i < 12; i++) {
        const heart = document.createElement('div');
        heart.className = 'heart-decoration';
        heart.innerHTML = '<i class="fas fa-heart"></i>';
        
        const left = Math.random() * 100;
        const top = Math.random() * 100;
        const size = Math.random() * 25 + 15;
        const delay = Math.random() * 8;
        const duration = Math.random() * 10 + 8;
        
        heart.style.left = `${left}%`;
        heart.style.top = `${top}%`;
        heart.style.fontSize = `${size}px`;
        heart.style.animationDelay = `${delay}s`;
        heart.style.animationDuration = `${duration}s`;
        heart.style.opacity = Math.random() * 0.5 + 0.3;
        
        const pinkColors = [
            'rgba(255, 182, 193, 0.6)',
            'rgba(255, 105, 180, 0.6)',
            'rgba(255, 20, 147, 0.6)',
            'rgba(219, 112, 147, 0.6)'
        ];
        heart.style.color = pinkColors[Math.floor(Math.random() * pinkColors.length)];
        
        container.appendChild(heart);
    }
}

// Обработчик нажатия на кнопку
function handleButtonClick(event) {
    const button = event.currentTarget;
    
    // Анимация нажатия
    button.classList.add('button-pressed');
    setTimeout(() => {
        button.classList.remove('button-pressed');
    }, 150);
    
    // Обработка чисел
    if (button.hasAttribute('data-number')) {
        const number = button.getAttribute('data-number');
        appendToExpression(number);
    }
    
    // Обработка операторов
    else if (button.hasAttribute('data-operator')) {
        const operator = button.getAttribute('data-operator');
        appendToExpression(operator);
    }
    
    // Обработка специальных действий
    else if (button.hasAttribute('data-action')) {
        const action = button.getAttribute('data-action');
        
        switch(action) {
            case 'clear':
                clearExpression();
                expressionDisplay.classList.add('clear-animation');
                setTimeout(() => {
                    expressionDisplay.classList.remove('clear-animation');
                }, 300);
                break;
            case 'backspace':
                backspace();
                break;
            case '.':
                appendToExpression('.');
                break;
            case '(':
                appendToExpression('(');
                break;
            case ')':
                appendToExpression(')');
                break;
            case 'calculate':
                calculateResult();
                break;
        }
    }
    
    updateDisplay();
}

// Обработчик ввода с клавиатуры
function handleKeyboardInput(event) {
    const key = event.key;
    
    // Цифры
    if (/[0-9]/.test(key)) {
        appendToExpression(key);
        updateDisplay();
    }
    
    // Операторы
    else if (['+', '-', '*', '/'].includes(key)) {
        appendToExpression(key);
        updateDisplay();
    }
    
    // Скобки
    else if (['(', ')'].includes(key)) {
        appendToExpression(key);
        updateDisplay();
    }
    
    // Точка
    else if (key === '.') {
        appendToExpression('.');
        updateDisplay();
    }
    
    // Enter или = для вычисления
    else if (key === 'Enter' || key === '=') {
        event.preventDefault();
        calculateResult();
        updateDisplay();
    }
    
    // Backspace для удаления
    else if (key === 'Backspace') {
        backspace();
        updateDisplay();
    }
    
    // Escape для очистки
    else if (key === 'Escape') {
        clearExpression();
        updateDisplay();
    }
}

// Добавление символа к выражению
function appendToExpression(value) {
    // Если результат отображается и пользователь начинает вводить новое число
    if (result !== '0' && result !== 'Ошибка' && /[0-9]/.test(value) && 
        (currentExpression === result || currentExpression === '')) {
        currentExpression = value;
    } else {
        currentExpression += value;
    }
}

// Очистка выражения
function clearExpression() {
    currentExpression = '';
    result = '0';
}

// Удаление последнего символа
function backspace() {
    currentExpression = currentExpression.slice(0, -1);
}

// Обновление дисплея
function updateDisplay() {
    expressionDisplay.value = currentExpression || '0';
    resultDisplay.value = result;
}

// Вычисление результата
function calculateResult() {
    if (!currentExpression || currentExpression === '0') return;
    
    try {
        // Анимация загрузки
        resultDisplay.classList.add('calculating');
        resultDisplay.value = '...';
        
        setTimeout(() => {
            // Преобразуем выражение в обратную польскую нотацию
            const rpn = infixToRPN(currentExpression);
            
            // Вычисляем выражение в ОПН
            const calculatedResult = evaluateRPN(rpn);
            
            // Проверяем, является ли результат числом
            if (isNaN(calculatedResult) || !isFinite(calculatedResult)) {
                throw new Error('Некорректный результат вычислений');
            }
            
            // Форматируем результат
            result = formatResult(calculatedResult);
            
            // Анимация результата
            animateResult(result);
            
            // Сохраняем результат как новое выражение
            currentExpression = result;
            
            resultDisplay.classList.remove('calculating');
        }, 300);
        
    } catch (error) {
        result = 'Ошибка';
        resultDisplay.classList.remove('calculating');
        
        // Анимация ошибки
        animateError();
        
        console.error('Ошибка вычисления:', error);
        
        // Сбрасываем ошибку через 2 секунды
        setTimeout(() => {
            if (result === 'Ошибка') {
                result = '0';
                updateDisplay();
            }
        }, 2000);
    }
}

// Анимация результата
function animateResult(finalValue) {
    resultDisplay.classList.add('result-animation');
    resultDisplay.value = finalValue;
    
    setTimeout(() => {
        resultDisplay.classList.remove('result-animation');
    }, 500);
}

// Анимация ошибки
function animateError() {
    resultDisplay.classList.add('error-animation');
    
    setTimeout(() => {
        resultDisplay.classList.remove('error-animation');
    }, 500);
}

// Преобразование инфиксной нотации в обратную польскую нотацию (ОПН)
function infixToRPN(expression) {
    const output = [];
    const operators = [];
    
    // Токенизация выражения
    const tokens = tokenize(expression);
    
    for (let token of tokens) {
        // Если токен - число, добавляем в вывод
        if (!isNaN(parseFloat(token)) || token === '.') {
            output.push(token);
        }
        // Если токен - оператор
        else if (token in precedence) {
            // Пока стек операторов не пуст и приоритет текущего оператора меньше или равен
            // приоритету оператора на вершине стека, перемещаем операторы из стека в вывод
            while (operators.length > 0 && 
                   operators[operators.length - 1] !== '(' &&
                   precedence[token] <= precedence[operators[operators.length - 1]]) {
                output.push(operators.pop());
            }
            operators.push(token);
        }
        // Если токен - открывающая скобка
        else if (token === '(') {
            operators.push(token);
        }
        // Если токен - закрывающая скобка
        else if (token === ')') {
            // Перемещаем операторы из стека в вывод, пока не встретим открывающую скобку
            while (operators.length > 0 && operators[operators.length - 1] !== '(') {
                output.push(operators.pop());
            }
            // Удаляем открывающую скобку из стека
            if (operators[operators.length - 1] === '(') {
                operators.pop();
            } else {
                throw new Error('Несбалансированные скобки');
            }
        }
    }
    
    // Перемещаем оставшиеся операторы из стека в вывод
    while (operators.length > 0) {
        if (operators[operators.length - 1] === '(') {
            throw new Error('Несбалансированные скобки');
        }
        output.push(operators.pop());
    }
    
    return output;
}

// Токенизация выражения
function tokenize(expression) {
    const tokens = [];
    let currentNumber = '';
    
    for (let i = 0; i < expression.length; i++) {
        const char = expression[i];
        
        // Если символ - цифра или точка (часть числа)
        if (!isNaN(parseInt(char)) || char === '.') {
            currentNumber += char;
        } 
        // Если символ - оператор или скобка
        else {
            // Добавляем накопленное число в токены
            if (currentNumber !== '') {
                tokens.push(currentNumber);
                currentNumber = '';
            }
            
            // Добавляем оператор или скобку
            if (char === '+' || char === '-' || char === '*' || char === '/' || char === '(' || char === ')') {
                tokens.push(char);
            }
            // Игнорируем пробелы
            else if (char !== ' ') {
                throw new Error(`Недопустимый символ: ${char}`);
            }
        }
    }
    
    // Добавляем последнее накопленное число
    if (currentNumber !== '') {
        tokens.push(currentNumber);
    }
    
    return tokens;
}

// Вычисление выражения в обратной польской нотации
function evaluateRPN(rpnTokens) {
    const stack = [];
    
    for (let token of rpnTokens) {
        // Если токен - число, помещаем в стек
        if (!isNaN(parseFloat(token))) {
            stack.push(parseFloat(token));
        } 
        // Если токен - оператор
        else {
            // Извлекаем два операнда из стека
            if (stack.length < 2) {
                throw new Error('Недостаточно операндов для операции');
            }
            
            const b = stack.pop();
            const a = stack.pop();
            
            // Выполняем операцию
            let result;
            switch(token) {
                case '+':
                    result = a + b;
                    break;
                case '-':
                    result = a - b;
                    break;
                case '*':
                    result = a * b;
                    break;
                case '/':
                    if (b === 0) {
                        throw new Error('Деление на ноль');
                    }
                    result = a / b;
                    break;
                default:
                    throw new Error(`Неизвестный оператор: ${token}`);
            }
            
            // Помещаем результат обратно в стек
            stack.push(result);
        }
    }
    
    // В стеке должен остаться один элемент - результат
    if (stack.length !== 1) {
        throw new Error('Некорректное выражение');
    }
    
    return stack[0];
}

// Форматирование результата
function formatResult(value) {
    // Округляем до 10 знаков после запятой
    const rounded = Math.round(value * 10000000000) / 10000000000;
    
    // Если число целое, убираем десятичную часть
    if (rounded % 1 === 0) {
        return rounded.toString();
    }
    
    // Иначе возвращаем с разумным количеством знаков после запятой
    return rounded.toFixed(10).replace(/\.?0+$/, '');
}

// Добавляем CSS для анимации кнопок
const style = document.createElement('style');
style.textContent = `
    .button-pressed {
        transform: scale(0.95) !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2) !important;
    }
`;
document.head.appendChild(style);

// Инициализируем калькулятор при загрузке страницы
window.addEventListener('DOMContentLoaded', initCalculator);