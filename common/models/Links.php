<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "links".
 *
 * @property int $id
 * @property string $link
 * @property string $short_link
 * @property int $time
 * @property int|null $counter
 */
class Links extends \yii\db\ActiveRecord{

    public $hours;
    public $minute;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link', 'short_link', 'time'], 'required'],
            [['time', 'counter', 'hours', 'minute'], 'integer'],
            ['minute', 'integer', 'min' => 1, 'max' => 60],
            ['hours','integer', 'min' => 0, 'max' => 23],
            [['link'], 'string', 'max' => 300],
            [['short_link'], 'string', 'max' => 8],
            [['short_link'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'short_link' => 'Short Link',
            'time' => 'Time',
            'counter' => 'Counter',
        ];
    }
    /**
     * Create random short link.
     *
     * @return string
     */
    public function Short_Link($strength = 8){

        $link = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $link_length = strlen($link);
        $random_link = '';

        for($i = 0; $i < $strength; $i++) {
            $random_character = $link[mt_rand(0, $link_length - 1)];
            $random_link .= $random_character;
        }

        return $random_link;
    }
    /**
     * Find id.
     *
     * @return object
     */
    public static function findLink($id){
        return static::findOne(['id' => $id]);
    }
    /**
     * Set link time.
     *
     * @return object
     */
    public function LinkTime($model){
        $model->time = $model->hours * 3600 + $model->minute * 60 + time();
        return $model;
    }

    /**
     * Check counter and change it.
     *
     * @return bool
     */
    public function Check_Counter($model){;
        if($model->counter === 0){
            return false;
        } elseif ($model->counter == null){
            return true;
        } elseif($model->counter !== 0){
            $model->counter = $model->counter-1;
            $model->save();
            return true;
        } else return false;

    }
    /**
     * Check link time.
     *
     * @return bool
     */
    public function Check_Time($model){
        $now_time = time();
        if ($model->time > $now_time){
            return true;
        } else return false;

    }
    /**
     * Check if count is zero.
     *
     * @return object
     */
    public function Check_Zero($model){
        if ($model->counter == 0){
            $model->counter = $model->counter = null;
        }
        return $model;
    }

}
