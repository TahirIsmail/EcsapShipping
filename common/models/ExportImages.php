<?php

namespace common\models;
use yii\imagine\Image;
use Yii;

/**
 * This is the model class for table "export_images".
 *
 * @property int $id
 * @property string $name
 * @property string $thumbnail
 * @property int $export_id
 *
 * @property Export $export
 */
class ExportImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'export_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          
            [['export_id'], 'integer'],
            [['name', 'thumbnail','baseurl'], 'string','max' => 50],
            [['name'], 'file',  'maxFiles' => 50],
            
            [['export_id'], 'exist', 'skipOnError' => true, 'targetClass' => Export::className(), 'targetAttribute' => ['export_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Container Images',
            'thumbnail' => 'Thumbnail',
            'export_id' => 'Export ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExport()
    {
        return $this->hasOne(Export::className(), ['id' => 'export_id']);
    }

    public static function save_container_images($model_id,$photo){
       
        foreach($photo as $photo){
            $images = new ExportImages();
            $images->isNewRecord = true;
            $images->id = null;
           $images->name= $photo->name;
           $ext = explode(".", $photo->name);
            $file_extension = end($ext);                 
           $images->name = Yii::$app->security->generateRandomString() . ".{$file_extension}";
           $path = Yii::getAlias('@app').'/../uploads/'.$images->name;
           $photo->saveAs($path);
           Image::thumbnail($path, 550, 550)
           ->save(Yii::getAlias('@app').'/../uploads/thumb-'.$images->name, ['quality' => 100]);
           $images->thumbnail = 'thumb-'.$images->name;
           $images->export_id = $model_id;
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
           $images->baseurl = $actual_link.'/uploads/';
           $images->save();
           }
    }
}
