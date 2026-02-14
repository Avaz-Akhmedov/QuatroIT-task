<?php

namespace app\models;

use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\imagine\Image;

class Task extends ActiveRecord
{

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_DONE = 'done';
    public $imageFile;

    public static function tableName(): string
    {
        return "{{%task}}";
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'description'], 'required', 'on' => 'create'],

            [['username', 'email', 'description', 'status'], 'required', 'on' => 'update'],

            ['email', 'email'],

            [['username', 'email'], 'string', 'max' => 255],

            ['description', 'string'],

            [
                'status', 'in',
                'range' => [
                    self::STATUS_PENDING,
                    self::STATUS_IN_PROGRESS,
                    self::STATUS_DONE
                ],
            ],

            [
                'imageFile', 'file', 'skipOnEmpty' => true,
                'extensions' => 'jpg, jpeg, gif, png',
                'maxSize' => 1024 * 1024 * 2,
                'on' => 'create'
            ],
        ];
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();

        $scenarios['create'] = ['username', 'email', 'description', 'imageFile'];

        $scenarios['update'] = ['username', 'email', 'description', 'status'];

        return $scenarios;
    }


    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'text' => 'Текст задачи',
            'image' => 'Изображение',
            'status' => 'Выполнено',
            'created_at' => 'Дата создания',
        ];
    }


    public function getStatusList(): array
    {
        return [
            self::STATUS_PENDING => 'Ожидает',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_DONE => 'Выполнено',
        ];
    }

    public function uploadImage(): bool
    {
        if ($this->validate(['imageFile'])) {

            if ($this->imageFile) {
                $fileName = uniqid() . '.' . $this->imageFile->extension;
                $folderPath = Yii::getAlias('@webroot/uploads/');

                if (!is_dir($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }

                $filePath = $folderPath . $fileName;

                if ($this->imageFile->saveAs($filePath)) {

                    Image::thumbnail(
                        $filePath,
                        320,
                        240,
                        ManipulatorInterface::THUMBNAIL_INSET
                    )->save($filePath, ['quality' => 90]);

                    $this->image = $fileName;
                    return true;
                }
            }
        }
        return false;
    }
}