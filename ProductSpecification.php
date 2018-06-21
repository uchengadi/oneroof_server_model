<?php

/**
 * This is the model class for table "product_specification".
 *
 * The followings are the available columns in table 'product_specification':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $code
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property ProductConstituents[] $productConstituents
 * @property Product[] $products
 * @property ProductType[] $productTypes
 */
class ProductSpecification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_specification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name, code', 'length', 'max'=>200),
			array('description, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, code, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'productConstituents' => array(self::MANY_MANY, 'ProductConstituents', 'constituent_has_specifications(specification_id, constituent_id)'),
			'products' => array(self::MANY_MANY, 'Product', 'product_has_specifications(specification_id, product_id)'),
			'productTypes' => array(self::MANY_MANY, 'ProductType', 'producttype_has_specifications(specification_id, product_type_id)'),
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
			'code' => 'Code',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_user_id' => 'Create User',
			'update_user_id' => 'Update User',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSpecification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
         /**
         * This is the function that gets a product specification name 
         */
        public function getThisProductSpecificationName($id){
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $specification = ProductSpecification::model()->find($criteria);
            
            return $specification['name'];
        }
        
        /**
         * This is the function that retrieves the code of a specification
         */
        public function getTheCodeOfThisSpecification($id){
            
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='id=:id';
            $criteria->params = array(':id'=>$id);
            $specification = ProductSpecification::model()->find($criteria);
            
            return $specification['code'];
        }
}
