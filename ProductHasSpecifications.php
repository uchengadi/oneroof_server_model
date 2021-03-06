<?php

/**
 * This is the model class for table "product_has_specifications".
 *
 * The followings are the available columns in table 'product_has_specifications':
 * @property string $product_id
 * @property string $specification_id
 * @property string $specification_value
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class ProductHasSpecifications extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_has_specifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, specification_id', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('product_id, specification_id', 'length', 'max'=>10),
			array('specification_value', 'length', 'max'=>250),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_id, specification_id, specification_value, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'specification_id' => 'Specification',
			'specification_value' => 'Specification Value',
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

		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('specification_id',$this->specification_id,true);
		$criteria->compare('specification_value',$this->specification_value,true);
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
	 * @return ProductHasSpecifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that assigns specifications to a product
         */
        public function isAssigningThisSpecificationValuesToThisProductSuccessful($thismodel,$type_specifications,$product_id){
            $model = new ProductSpecification;
            
            foreach($type_specifications as $typespec){
                //get the code of this specification
                $spec_code = $model->getTheCodeOfThisSpecification($typespec);
                $counter = 0;
                if($spec_code == '001'){
                    //write the spec value to the product
                    if($this->isAssignSpec001ValuesToProductSuccessful($thismodel,$product_id,$typespec)){
                        $counter = $counter + 1;
                    }
                }if($spec_code == '002'){
                     //write the spec value to the product
                    if($this->isAssignSpec002ValuesToProductSuccessful($thismodel,$product_id,$typespec)){
                        $counter = $counter + 1;
                    }
                }else if($spec_code == '003'){
                     //write the spec value to the product
                    if($this->isAssignSpec003ValuesToProductSuccessful($thismodel,$product_id,$typespec)){
                        $counter = $counter + 1;
                    }
                }else if($spec_code == '003'){
                      //write the spec value to the product
                    if($this->isAssignSpec003ValuesToProductSuccessful($thismodel,$product_id,$typespec)){
                        $counter = $counter + 1;
                    }
                }else if($spec_code == '004'){
                     //write the spec value to the product
                    if($this->isAssignSpec004ValuesToProductSuccessful($thismodel,$product_id,$typespec)){
                        $counter = $counter + 1;
                    } 
                }else if($spec_code == '005'){
                     //write the spec value to the product
                    if($this->isAssignSpec005ValuesToProductSuccessful($thismodel,$product_id,$typespec)){
                        $counter = $counter + 1;
                    } 
                }
                
            }
            if($counter > 0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that assigns spec 001 values to a product
         */
        public function isAssignSpec001ValuesToProductSuccessful($thismodel,$product_id,$spec_id){
            
          
        }
}
