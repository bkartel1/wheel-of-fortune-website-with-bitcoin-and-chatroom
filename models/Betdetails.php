<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "betdetails".
 *
 * @property integer $id
 * @property string $time
 * @property integer $results
 * @property integer $status
 *
 * @property Userbets[] $userbets
 */
class Betdetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'betdetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rolltime'], 'safe'],
            [['results', 'stage'], 'required'],
            [['results', 'stage'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'time' => 'Time',
            'results' => 'Results',
            //'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserbets()
    {
        return $this->hasMany(Userbets::className(), ['betdeatail' => 'id']);
    }
}
