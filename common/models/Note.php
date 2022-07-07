<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property string $description
 * @property int $export_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Export $export
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note';
    }
    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'export_id'], 'required'],
            [['id', 'export_id', 'created_by','vehicle_id', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','imageurl'], 'safe'],
            [['description'], 'string'],
            [['id', 'export_id'], 'unique', 'targetAttribute' => ['id', 'export_id']],
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
            'description' => Yii::t('app', 'Description'),
            'export_id' => Yii::t('app', 'Export ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
 public static function note($data){
     $note = new Note();
     $note->export_id =$data['Export']['id'];
     $note->description =$data['Export']['text'];
     $note->imageurl =$data['Export']['imageurl'];
     $save = $note->save() ? $note : null;
     if($save){
        $update_exported_vehicle = Yii::$app->db->createCommand()
        ->update('export', ['notes_status' => 2,     
                ], 'id ="' .$note->export_id. '"')
        ->execute();
        return $save;
     }
 }
 public static function notevehicel($data){
    $note = new Note();
    if($data){
        if(isset($data['Vehicle'])){
            $note->vehicle_id =$data['Vehicle']['id'];
            $note->description =$data['Vehicle']['text'];
            $note->imageurl =$data['Vehicle']['imageurl'];
        }        
        $save = $note->save() ? $note : null;
        if($save){
            $update_exported_vehicle = Yii::$app->db->createCommand()
            ->update('vehicle', ['notes_status' => 2,     
                    ], 'id ="' .$note->vehicle_id. '"')
            ->execute();
            return $save;
         }else{
             var_dump($note->getErrors());
             exit();
         }
    }else{
        return 0;
    }
    
}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExport()
    {
        return $this->hasOne(Export::className(), ['id' => 'export_id']);
    }
}
