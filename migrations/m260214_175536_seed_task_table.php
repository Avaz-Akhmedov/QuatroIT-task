<?php

use app\models\Task;
use Faker\Factory;
use yii\db\Migration;

class m260214_175536_seed_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Factory::create();
        $tasks = [];


        for ($i = 0; $i < 30; $i++) {
            $tasks[] = [
                $faker->userName(),
                $faker->email,
                $faker->sentence(10),
                $faker->randomElement([Task::STATUS_DONE, Task::STATUS_IN_PROGRESS, Task::STATUS_PENDING]),
            ];
        }

        $this->batchInsert('{{%task}}', ['username', 'email', 'description', 'status',], $tasks);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%task}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260214_175536_seed_task_table cannot be reverted.\n";

        return false;
    }
    */
}
