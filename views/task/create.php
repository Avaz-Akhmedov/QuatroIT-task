<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать задачу</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .preview-container {
            margin-top: 20px;
            padding: 15px;
            background-color: #e7f3ff;
            border: 1px solid #b3d7ff;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="form-container">
        <h1 class="mb-4">Создать новую задачу</h1>

        <div class="mb-3">
            <a href="<?= Yii::$app->urlManager->createUrl(['task/index']) ?>"
               class="btn btn-secondary">
                ← Назад к списку задач
            </a>
        </div>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Введите ваше имя',
        ]) ?>

        <?= $form->field($model, 'email')->textInput([
            'class' => 'form-control',
            'placeholder' => 'example@email.com',
        ]) ?>

        <?= $form->field($model, 'description')->textarea([
            'class' => 'form-control',
            'rows' => 6,
            'placeholder' => 'Опишите задачу...',
        ]) ?>

        <?= $form->field($model, 'imageFile')->fileInput([
            'class' => 'form-control',
        ]) ?>

        <div class="alert alert-info">
            <strong>Требования к изображению:</strong><br>
            - Формат: JPG, JPEG, GIF, PNG<br>
            - Максимальный размер: 2 МБ<br>
            - Изображение будет автоматически уменьшено до 320×240 пикселей
        </div>

        <div class="form-group mt-4">
            <?= Html::submitButton('Создать задачу', [
                'class' => 'btn btn-success me-2',
            ]) ?>

            <button type="button" class="btn btn-info" id="previewBtn">
                Предварительный просмотр
            </button>
        </div>

        <?php ActiveForm::end(); ?>

        <div id="previewResult"></div>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success mt-4">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger mt-4">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('#previewBtn').click(function() {
            // Получаем данные формы
            var formData = {
                username: $('#task-username').val(),
                email: $('#task-email').val(),
                description: $('#task-description').val()
            };

            // Показываем индикатор загрузки
            $('#previewResult').html('<div class="alert alert-info">Загрузка...</div>');

            // Отправляем AJAX запрос
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(['task/preview']) ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Отображаем результат превью
                    $('#previewResult').html(response.html);

                    // Прокручиваем к результату
                    $('html, body').animate({
                        scrollTop: $('#previewResult').offset().top - 50
                    }, 500);
                },
                error: function(xhr, status, error) {
                    $('#previewResult').html('<div class="alert alert-danger">Ошибка при загрузке превью</div>');
                    console.error(error);
                }
            });
        });
    });
</script>
</body>
</html>