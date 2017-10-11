<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userbets".
 *
 * @property integer $id
 * @property integer $skins
 * @property integer $betdeatail
 * @property integer $options
 *
 * @property Betdetails $betdeatail0
 * @property Skins $skins0
 */
class Userbets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userbets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['skins', 'options'], 'required'],
            [['skins', 'betdeatail', 'options'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'skins' => 'Number of Skins you wish to bet',
            'betdeatail' => 'Betdeatail',
            'options' => '[1=>2*,2=>3* ,3=>5*,4=>50*]',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBetdeatail0()
    {
        return $this->hasOne(Betdetails::className(), ['id' => 'betdeatail']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkins0()
    {
        return $this->hasOne(Skins::className(), ['id' => 'skins']);
    }
}
