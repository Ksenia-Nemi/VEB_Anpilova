<?php
// Устанавливаем московский часовой пояс
date_default_timezone_set('Europe/Moscow');

// Получаем данные из GET параметров (для заполнения формы при возврате)
$fio = isset($_GET['fio']) ? htmlspecialchars($_GET['fio']) : '';
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
$source = isset($_GET['source']) ? htmlspecialchars($_GET['source']) : '';
$topic = isset($_GET['topic']) ? htmlspecialchars($_GET['topic']) : '';
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Проверяем, есть ли сообщения об ошибках
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';

$pageTitle = "Форма обратной связи";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }
        .form-control {
            padding: 10px;
            border: 2px solid #bdc3c7;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #3498db;
            outline: none;
        }
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        .checkbox-group, .radio-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .radio-options {
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }
        .btn {
            background: #3498db;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #2980b9;
        }
        .required {
            color: #e74c3c;
        }
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ecf0f1;
        }
        .error-message {
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success-message {
            background: #27ae60;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Форма обратной связи</h1>
        
        <?php if ($error === 'empty_fields'): ?>
            <div class="error-message">
                ❌ Пожалуйста, заполните все обязательные поля!
            </div>
        <?php elseif ($error === 'direct_access'): ?>
            <div class="error-message">
                ❌ Неверный доступ к странице!
            </div>
        <?php endif; ?>
        
        <form action="home.php" method="POST" enctype="multipart/form-data">
            <!-- Скрытое поле для проверки отправки формы -->
            <input type="hidden" name="form_submitted" value="1">
            
            <!-- Личная информация -->
            <div class="form-section">
                <div class="form-group">
                    <label for="fio">ФИО <span class="required">*</span></label>
                    <input type="text" id="fio" name="fio" class="form-control" value="<?php echo $fio; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Ваш e-mail <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="<?php echo $email; ?>" placeholder="example@mail.ru" required>
                </div>
            </div>

            <!-- Сообщение -->
            <div class="form-section">
                <div class="form-group">
                    <label for="message">Сообщение <span class="required">*</span></label>
                    <textarea id="message" name="message" class="form-control" required><?php echo $message; ?></textarea>
                </div>
            </div>

            <!-- Тема обращения -->
            <div class="form-section">
                <div class="form-group">
                    <label for="topic">Тема обращения</label>
                    <select id="topic" name="topic" class="form-control">
                        <option value="">-- Выберите тему --</option>
                        <option value="Предложение" <?php echo ($topic == 'Предложение') ? 'selected' : ''; ?>>Предложение</option>
                        <option value="Жалоба" <?php echo ($topic == 'Жалоба') ? 'selected' : ''; ?>>Жалоба</option>
                        <option value="Вопрос" <?php echo ($topic == 'Вопрос') ? 'selected' : ''; ?>>Вопрос</option>
                        <option value="Благодарность" <?php echo ($topic == 'Благодарность') ? 'selected' : ''; ?>>Благодарность</option>
                    </select>
                </div>
            </div>

            <!-- Источник информации -->
            <div class="form-section">
                <div class="form-group">
                    <label>Откуда вы о нас узнали?</label>
                    <div class="radio-options">
                        <div class="radio-group">
                            <input type="radio" id="source_internet" name="source" value="Реклама из интернета" 
                                   <?php echo ($source == 'Реклама из интернета') ? 'checked' : ''; ?>>
                            <label for="source_internet">Реклама из интернета</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="source_friends" name="source" value="Рассказали друзья"
                                   <?php echo ($source == 'Рассказали друзья') ? 'checked' : ''; ?>>
                            <label for="source_friends">Рассказали друзья</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="source_social" name="source" value="Социальные сети"
                                   <?php echo ($source == 'Социальные сети') ? 'checked' : ''; ?>>
                            <label for="source_social">Социальные сети</label>
                        </div>
                        <div class="radio-group">
                            <input type="radio" id="source_other" name="source" value="Другое"
                                   <?php echo ($source == 'Другое') ? 'checked' : ''; ?>>
                            <label for="source_other">Другое</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Файл -->
            <div class="form-section">
                <div class="form-group">
                    <label for="file">Прикрепить файл</label>
                    <input type="file" id="file" name="file" class="form-control">
                </div>
            </div>

            <!-- Согласие -->
            <div class="form-section">
                <div class="checkbox-group">
                    <input type="checkbox" id="consent" name="consent" value="yes" required>
                    <label for="consent">Даю согласие на обработку данных <span class="required">*</span></label>
                </div>
            </div>

            <!-- Кнопка отправки -->
            <div class="form-group">
                <button type="submit" class="btn">Отправить</button>
            </div>
        </form>
    </div>
</body>
</html>