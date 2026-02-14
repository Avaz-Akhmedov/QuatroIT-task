<?php
use yii\helpers\Html;
?>

<div class="preview-container">
    <h4 class="mb-3">Предварительный просмотр:</h4>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>Имя пользователя:</strong>
                <p class="mb-0"><?= Html::encode($model->username ?: 'Не указано') ?></p>
            </div>

            <div class="mb-3">
                <strong>Email:</strong>
                <p class="mb-0"><?= Html::encode($model->email ?: 'Не указано') ?></p>
            </div>

            <div class="mb-3">
                <strong>Текст задачи:</strong>
                <p class="mb-0"><?= Html::encode($model->description ?: 'Не указано') ?></p>
            </div>

            <?php if ($model->imageFile): ?>
                <div class="mb-3">
                    <strong>Изображение:</strong>
                    <p class="mb-0 text-muted">Будет загружено и уменьшено до 320×240 пикселей</p>
                </div>
            <?php endif; ?>

            <?php if (!$model->validate()): ?>
                <div class="alert alert-warning mt-3">
                    <strong>Внимание!</strong> Есть ошибки в форме:
                    <ul class="mb-0 mt-2">
                        <?php foreach ($model->errors as $attribute => $errors): ?>
                            <?php foreach ($errors as $error): ?>
                                <li><?= Html::encode($error) ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>