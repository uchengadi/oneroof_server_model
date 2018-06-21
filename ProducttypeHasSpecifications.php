<?php

/**
 * This is the model class for table "producttype_has_specifications".
 *
 * The followings are the available columns in table 'producttype_has_specifications':
 * @property string $product_type_id
 * @property string $specification_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class ProducttypeHasSpecifications extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'producttype_has_specifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_type_id, specification_id', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('product_type_id, specification_id', 'length', 'max'=>10),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_type_id, specification_id, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_type_id' => 'Product Type',
			'specification_id' => 'Specification',
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

		$criteria->compare('product_type_id',$this->product_type_id,true);
		$criteria->compare('specification_id',$this->specification_id,true);
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
	 * @return ProducttypeHasSpecifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
          /**
         * This is the function that inserts a specification to a product type 
         */
        public function isThisSpecificationAssignedToThisProducttype($producttype_id,$specification_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('producttype_has_specifications',
                         array('product_type_id'=>$producttype_id,
                               'specification_id'=>$specification_id,
                              'create_time'=>new CDbExpression('NOW()'),
                             'create_user_id'=>Yii::app()->user->id
                           
                        )
                          
                     );
               
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
}
