<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "skins".
 *
 * @property integer $id
 * @property integer $skins
 * @property string $time
 * @property integer $transdirection
 * @property string $transactionid
 * @property integer $user
 * @property integer $type
 * @property integer $status
 *
 * @property Money[] $moneys
 * @property User $user0
 * @property Userbets[] $userbets
 */
class Skins extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['skins'/*, 'transdirection', 'user', 'type'*/], 'required'],
            [['skins'/*, 'transdirection', 'user', 'type', 'status'*/], 'integer'],
           // [['time'], 'safe'],
           // [['transactionid'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'skins' => 'Skins',
            'time' => 'Time',
            'transdirection' => 'Transaction type',//[1=>add,2=>subtract]
            'transactionid' => 'Relevant transaction table id',
            'user' => 'User',
            'type' => 'Details',//'[\'1\'=>\'bet\', \'2\'=>\'betloss\', \'3\'=>\'betgain\', \'4\'=>\'deposit\', \'5\'=>\'withdrawal\' ]',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoneys()
    {
        return $this->hasMany(Money::className(), ['skins' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserbets()
    {
        return $this->hasMany(Userbets::className(), ['skins' => 'id']);
    }
}
