<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Task;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список задач</title>
    <!-- Подключаем Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Список задач</h1>

    <!-- Кнопка "Создать задачу" -->
    <div class="mb-4">
        <a href="<?= Yii::$app->urlManager->createUrl(['task/create']) ?>"
           class="btn btn-success">
            Создать новую задачу
        </a>

        <?php if (!Yii::$app->user->isGuest): ?>
            <a href="<?= Yii::$app->urlManager->createUrl(['site/logout']) ?>"
               class="btn btn-danger"
               data-method="post">
                Выйти (<?= Yii::$app->user->identity->username ?>)
            </a>
        <?php else: ?>
            <a href="<?= Yii::$app->urlManager->createUrl(['site/login']) ?>"
               class="btn btn-primary">
                Войти как администратор
            </a>
        <?php endif; ?>
    </div>

    <!-- Форма сортировки -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Сортировка</h5>
        </div>
        <div class="card-body">
            <form method="get" action="<?= Yii::$app->urlManager->createUrl(['task/index']) ?>">
                <div class="row">
                    <div class="col-md-4">
                        <label for="sort" class="form-label">Сортировать по:</label>
                        <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                            <option value="username" <?= $sort == 'username' ? 'selected' : '' ?>>
                                Имени пользователя
                            </option>
                            <option value="email" <?= $sort == 'email' ? 'selected' : '' ?>>
                                Email
                            </option>
                            <option value="status" <?= $sort == 'status' ? 'selected' : '' ?>>
                                Статусу
                            </option>
                            <option value="created_at" <?= $sort == 'created_at' ? 'selected' : '' ?>>
                                Дате создания
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Направление:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                   name="direction" value="<?= SORT_ASC ?>"
                                <?= $direction == SORT_ASC ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label class="form-check-label">По возрастанию</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                   name="direction" value="<?= SORT_DESC ?>"
                                <?= $direction == SORT_DESC ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label class="form-check-label">По убыванию</label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Список задач -->
    <div class="row">
        <?php foreach ($dataProvider->models as $task): ?>
            <div class="col-md-12 mb-3">
                <div class="card <?= $task->status ? 'border-success' : '' ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($task->username) ?></h5>
                        <p class="card-text">
                            <strong>Email:</strong> <?= Html::encode($task->email) ?>
                        </p>
                        <p class="card-text">
                            <strong>Текст задачи:</strong><br>
                            <?= Html::encode($task->description) ?>
                        </p>

                        <?php if ($task->image): ?>
                            <div class="mt-3">
                                <img src="<?= Yii::$app->urlManager->createUrl(['uploads/' . $task->image]) ?>"
                                     alt="Изображение задачи"
                                     class="img-fluid"
                                     style="max-height: 240px; object-fit: contain;">
                            </div>
                        <?php endif; ?>

                        <div class="mt-3">
                            <?php if ($task->status === Task::STATUS_DONE): ?>
                                <span class="badge bg-success">Выполнено</span>

                            <?php elseif ($task->status === Task::STATUS_IN_PROGRESS): ?>
                                <span class="badge  text-dark">В процессе</span>

                            <?php elseif ($task->status === Task::STATUS_PENDING): ?>
                                <span class="badge bg-secondary">Ожидает</span>

                            <?php else: ?>
                                <span class="badge bg-light text-dark">Неизвестно</span>
                            <?php endif; ?>
                        </div>

                        <?php if (!Yii::$app->user->isGuest): ?>
                            <a href="<?= Yii::$app->urlManager->createUrl(['task/update', 'id' => $task->id]) ?>"
                               class="btn btn-primary btn-sm ms-2 mt-2 ">
                                Редактировать
                            </a>
                        <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Пагинация -->
        <div class="mt-4">
            <nav aria-label="Навигация по страницам">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' => 'pagination justify-content-center'],
                    'linkOptions' => ['class' => 'page-link'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',
                    'prevPageLabel' => '&laquo;',
                    'nextPageLabel' => '&raquo;',
                    'firstPageLabel' => 'Первая',
                    'lastPageLabel' => 'Последняя',
                ]) ?>
            </nav>
        </div>
</div>

<!-- Подключаем Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>