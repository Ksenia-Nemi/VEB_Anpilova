<?php
// ============================================
// ЛАБОРАТОРНАЯ РАБОТА №9, ВАРИАНТ 2
// ============================================

// Инициализация параметров
$x = isset($_GET['x']) ? floatval($_GET['x']) : -10.0;
$n = isset($_GET['n']) ? intval($_GET['n']) : 30;
$step = isset($_GET['step']) ? floatval($_GET['step']) : 0.5;
$fmin = isset($_GET['fmin']) ? floatval($_GET['fmin']) : -50.0;
$fmax = isset($_GET['fmax']) ? floatval($_GET['fmax']) : 50.0;
$type = isset($_GET['type']) ? strtoupper(trim($_GET['type'])) : 'A';
if(!in_array($type,['A','B','C','D','E'])) $type='A';
$loop = isset($_GET['loop']) ? strtolower(trim($_GET['loop'])) : 'for';
if(!in_array($loop,['for','while','do'])) $loop='for';
$precision = 3;

// Функция вычисления f(x) для варианта 2
function f_val($x,$p=3){
    if($x <= 10){
        if(abs($x) < 1e-12){
            return 'error (деление на 0)';
        }
        return round((10 + $x) / $x, $p);
    }
    elseif($x < 20){
        return round(($x / 7) * ($x - 2), $p);
    }
    else{
        return round($x * 8 + 2, $p);
    }
}

// Форматирование числа
function fmt($v){
    if($v === 'error (деление на 0)'){
        return 'error (деление на 0)';
    }
    return number_format((float)$v, 3, '.', '');
}

// Вычисление значений
$rows = [];
$numeric_values = [];
$sum = 0;
$total_values = 0;

if($loop === 'for'){
    for($i = 0, $cx = $x; $i < $n; $i++, $cx += $step){
        $f = f_val($cx, $precision);
        $rows[] = ['x' => $cx, 'f' => $f];
        $total_values++;
        
        if($f !== 'error (деление на 0)' && is_numeric($f)){
            if($f < $fmin || $f > $fmax){
                break;
            }
            $numeric_values[] = $f;
            $sum += $f;
        }
    }
}
elseif($loop === 'while'){
    $i = 0; $cx = $x;
    while($i < $n){
        $f = f_val($cx, $precision);
        $rows[] = ['x' => $cx, 'f' => $f];
        $total_values++;
        
        if($f !== 'error (деление на 0)' && is_numeric($f)){
            if($f < $fmin || $f > $fmax){
                break;
            }
            $numeric_values[] = $f;
            $sum += $f;
        }
        $i++; $cx += $step;
    }
}
else{ // do-while
    $i = 0; $cx = $x;
    if($n > 0){
        do{
            $f = f_val($cx, $precision);
            $rows[] = ['x' => $cx, 'f' => $f];
            $total_values++;
            
            if($f !== 'error (деление на 0)' && is_numeric($f)){
                if($f < $fmin || $f > $fmax){
                    break;
                }
                $numeric_values[] = $f;
                $sum += $f;
            }
            $i++; $cx += $step;
        }while($i < $n);
    }
}

// Вычисление статистики
$stats = [];
if(count($numeric_values) > 0){
    $stats['min'] = min($numeric_values);
    $stats['max'] = max($numeric_values);
    $stats['average'] = $sum / count($numeric_values);
    $stats['sum'] = $sum;
    $stats['total'] = $total_values;
    $stats['numeric'] = count($numeric_values);
    $stats['errors'] = $total_values - count($numeric_values);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа №9, Вариант 2 - Анпилова Ксения 241-361</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="page-container">
        <header>
            <div class="header-content">
                <img src="logo.jpg" alt="Логотип университета" width="160" height="80">
                <div class="header-info">
                    <h1>Лабораторная работа №9 (Вариант 2)</h1>
                    <p>Выполнила: Анпилова Ксения Сергеевна</p>
                    <p>Группа: 241-361</p>
                </div>
            </div>
        </header>

        <div class="type-selector">
            <form method="GET" class="controls-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="x">Начальное x:</label>
                        <input type="number" step="0.001" name="x" id="x" value="<?php echo htmlspecialchars((string)$x); ?>">
                    </div>
                    <div class="form-group">
                        <label for="n">Количество n:</label>
                        <input type="number" name="n" id="n" value="<?php echo htmlspecialchars((string)$n); ?>">
                    </div>
                    <div class="form-group">
                        <label for="step">Шаг step:</label>
                        <input type="number" step="0.001" name="step" id="step" value="<?php echo htmlspecialchars((string)$step); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fmin">f<sub>min</sub> (стоп, если меньше):</label>
                        <input type="number" step="0.001" name="fmin" id="fmin" value="<?php echo htmlspecialchars((string)$fmin); ?>">
                    </div>
                    <div class="form-group">
                        <label for="fmax">f<sub>max</sub> (стоп, если больше):</label>
                        <input type="number" step="0.001" name="fmax" id="fmax" value="<?php echo htmlspecialchars((string)$fmax); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="type">Тип верстки:</label>
                        <select name="type" id="type">
                            <option value="A" <?php echo $type === 'A' ? 'selected' : ''; ?>>A - Простой текст</option>
                            <option value="B" <?php echo $type === 'B' ? 'selected' : ''; ?>>B - Маркированный список</option>
                            <option value="C" <?php echo $type === 'C' ? 'selected' : ''; ?>>C - Нумерованный список</option>
                            <option value="D" <?php echo $type === 'D' ? 'selected' : ''; ?>>D - Таблица</option>
                            <option value="E" <?php echo $type === 'E' ? 'selected' : ''; ?>>E - Блочная верстка</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="loop">Тип цикла:</label>
                        <select name="loop" id="loop">
                            <option value="for" <?php echo $loop === 'for' ? 'selected' : ''; ?>>for</option>
                            <option value="while" <?php echo $loop === 'while' ? 'selected' : ''; ?>>while</option>
                            <option value="do" <?php echo $loop === 'do' ? 'selected' : ''; ?>>do-while</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-calculate">Вычислить</button>
                    </div>
                </div>
            </form>
        </div>

        <main class="content-area">
            <div class="result-output type-<?php echo $type; ?>">
                <h2>Результаты вычислений (тип верстки: <?php echo $type; ?>, цикл: <?php echo $loop; ?>)</h2>
                
                <?php if($type === 'A'): ?>
                    <!-- Тип A: Простая верстка текстом -->
                    <?php foreach($rows as $row): ?>
                        f(<?php echo number_format($row['x'], 2); ?>) = <?php echo $row['f']; ?><br>
                    <?php endforeach; ?>
                    
                <?php elseif($type === 'B'): ?>
                    <!-- Тип B: Маркированный список -->
                    <ul>
                        <?php foreach($rows as $row): ?>
                            <li>f(<?php echo number_format($row['x'], 2); ?>) = <?php echo $row['f']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                <?php elseif($type === 'C'): ?>
                    <!-- Тип C: Нумерованный список -->
                    <ol>
                        <?php foreach($rows as $row): ?>
                            <li>f(<?php echo number_format($row['x'], 2); ?>) = <?php echo $row['f']; ?></li>
                        <?php endforeach; ?>
                    </ol>
                    
                <?php elseif($type === 'D'): ?>
                    <!-- Тип D: Таблица -->
                    <table>
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>x</th>
                                <th>f(x)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($rows as $row): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo number_format($row['x'], 2); ?></td>
                                    <td><?php echo $row['f']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                <?php elseif($type === 'E'): ?>
                    <!-- Тип E: Блочная верстка -->
                    <div class="block-container">
                        <?php foreach($rows as $row): ?>
                            <div class="function-block">
                                f(<?php echo number_format($row['x'], 2); ?>) = <?php echo $row['f']; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if(!empty($stats)): ?>
                <div class="stats">
                    <h3>Статистика вычислений</h3>
                    <p><strong>Минимальное значение:</strong> <?php echo number_format($stats['min'], 3); ?></p>
                    <p><strong>Максимальное значение:</strong> <?php echo number_format($stats['max'], 3); ?></p>
                    <p><strong>Среднее арифметическое:</strong> <?php echo number_format($stats['average'], 3); ?></p>
                    <p><strong>Сумма всех значений:</strong> <?php echo number_format($stats['sum'], 3); ?></p>
                    <p><strong>Всего вычислено значений:</strong> <?php echo $stats['total']; ?></p>
                    <p><strong>Из них числовых:</strong> <?php echo $stats['numeric']; ?></p>
                    <?php if($stats['errors'] > 0): ?>
                        <p><strong>Некорректных значений (ошибки):</strong> <?php echo $stats['errors']; ?></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="error">
                    Нет числовых данных для статистики.
                </div>
            <?php endif; ?>
        </main>
    </div>

    <footer>
        <div class="footer-content">
            <p>Тип верстки: <strong><?php echo $type; ?></strong> | Тип цикла: <strong><?php echo $loop; ?></strong></p>
            <p>&copy; Анпилова К.С., Лабораторная работа №9, Вариант 2</p>
        </div>
    </footer>
</body>
</html>