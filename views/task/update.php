<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать задачу</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="form-container">
        <h1 class="mb-4">Редактировать задачу</h1>

        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
            ],
        ]); ?>

        <!-- Поле: Имя пользователя -->
        <?= $form->field($model, 'username')->textInput([
            'class' => 'form-control',
        ]) ?>

        <!-- Поле: Email -->
        <?= $form->field($model, 'email')->textInput([
            'class' => 'form-control',
            'type' => 'email',
        ]) ?>

        <!-- Поле: Текст задачи -->
        <?= $form->field($model, 'description')->textarea([
            'class' => 'form-control',
            'rows' => 6,
        ]) ?>

        <!-- Поле: Статус (выпадающий список) -->
        <?= $form->field($model, 'status')->dropDownList(
            $model->statusList,
            ['class' => 'form-select']
        ) ?>

        <!-- Кнопки формы -->
        <div class="form-group mt-4">
            <?= Html::submitButton('Сохранить', [
                'class' => 'btn btn-success me-2',
            ]) ?>

            <a href="<?= Yii::$app->urlManager->createUrl(['task/index']) ?>"
               class="btn btn-secondary">
                Отмена
            </a>
        </div>

        <?php ActiveForm::end(); ?>

        <!-- Flash сообщения -->
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success mt-4">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>