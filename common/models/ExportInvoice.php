<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "export_invoice".
 *
 * @property int $id
 * @property string $name
 * @property int $export_id
 *
 * @property Export $export
 */
class ExportInvoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'export_invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['export_id'], 'required'],
            [['export_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['export_id'], 'exist', 'skipOnError' => true, 'targetClass' => Export::className(), 'targetAttribute' => ['export_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'export_id' => Yii::t('app', 'Export ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExport()
    {
        return $this->hasOne(Export::className(), ['id' => 'export_id']);
    }
}
