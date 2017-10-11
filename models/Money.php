<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money".
 *
 * @property integer $id
 * @property string $transactionid
 * @property integer $amount
 * @property string $currency
 * @property integer $skins
 *
 * @property Skins $skins0
 */
class Money extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transactionid', 'amount', 'skins'], 'required'],
            [['amount', 'skins'], 'integer'],
            [['transactionid'], 'string', 'max' => 11],
            [['currency'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transactionid' => 'Transactionid',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'skins' => 'relevant skin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkins0()
    {
        return $this->hasOne(Skins::className(), ['id' => 'skins']);
    }
}
