<?php

use yii\db\Migration;

class m250619_061934_create_table_review extends Migration
{
    public function safeUp()
    {
        $this->execute("CREATE TYPE review_status AS ENUM ('pending', 'approved', 'rejected')");

        $this->createTable('review', [
            'id' => $this->primaryKey(),
            'author_name' => $this->string(255)->notNull(),
            'text' => $this->text()->notNull(),
            'status' => "review_status NOT NULL DEFAULT 'pending'",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
       $this->dropTable('review');

       $this->execute("DROP TYPE review_status");
    }

}
