<?php

namespace api\models;

use yii\db\ActiveRecord;

/**
 * Class Review
 * @package api\models
 *
 * @property int $id
 * @property string $author_name
 * @property string $text
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Review extends ActiveRecord
{
    public const string STATUS_PENDING = 'pending';
    public const string STATUS_APPROVED = 'approved';
    public const string STATUS_REJECTED = 'rejected';

    public static function tableName(): string
    {
        return 'review';
    }

    public function rules(): array
    {
        return [
            [['author_name', 'text'], 'required'],
            ['author_name', 'string', 'max' => 255],
            ['text', 'string'],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
            ['status', 'default', 'value' => self::STATUS_PENDING],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }
}