<?php

/**
 * This is the model class for table "container".
 *
 * The followings are the available columns in table 'container':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $image
 * @property integer $icon_size
 * @property integer $image_size
 *
 * The followings are the available model relations:
 * @property Service[] $services
 */
class Container extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'container';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('icon_size, image_size', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('description', 'length', 'max'=>250),
			array('icon', 'length', 'max'=>60),
			array('image', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, icon, image, icon_size, image_size', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'services' => array(self::HAS_MANY, 'Service', 'container_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'icon' => 'Icon',
			'image' => 'Image',
			'icon_size' => 'Icon Size',
			'image_size' => 'Image Size',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('icon_size',$this->icon_size);
		$criteria->compare('image_size',$this->image_size);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Container the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
