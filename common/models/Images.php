<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;
use yii\imagine\Image;


/**
 * This is the model class for table "images".
 *
 * @property int $id
 * @property string $name
 * @property string $thumbnail
 * @property string $normal
 * @property int $vehicle_id
 * @property bool $is_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Vehicle $vehicle
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
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
         [['vehicle_id'], 'required'],
            [['vehicle_id', 'created_by', 'updated_by'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['name','baseurl'], 'string', 'max' => 200],
            [['name'], 'file',  'maxFiles' => 50],
            
            [['thumbnail', 'normal'], 'string', 'max' => 45],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Add Attachments',
            'thumbnail' => 'Thumbnail',
            'normal' => 'Normal',
            'vehicle_id' => 'Vehicle ID',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

 

    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }
    public static function save_container_images($model_id,$photo){
        $images = new Images();
       foreach($photo as $photo){
           $images->isNewRecord = true;
           $images->id = null;
          $images->name= $photo->name;
          $ext = explode(".", $photo->name);
           $file_extension = end($ext);                 
          $images->name = Yii::$app->security->generateRandomString() . ".{$file_extension}";
          $path = Yii::getAlias('@app').'/../uploads/'.$images->name;
          $photo->saveAs($path);
          Image::thumbnail($path, 350, 350)
          ->save(Yii::getAlias('@app').'/../uploads/thumb-'.$images->name, ['quality' => 100]);
          $images->thumbnail = 'thumb-'.$images->name;
          $images->vehicle_id = $model_id;
          $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
           $images->baseurl = $actual_link.'/uploads/';
          $images->save();
          }
   }
}
