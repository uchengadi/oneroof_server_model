<?php

/**
 * This is the model class for table "product_has_vendor".
 *
 * The followings are the available columns in table 'product_has_vendor':
 * @property string $product_id
 * @property string $vendor_id
 * @property string $status
 * @property string $date_product_was_added_to_vendor
 * @property string $date_product_to_vendor_was_updated
 * @property integer $product_was_added_by
 * @property integer $product_was_updated_by
 */
class ProductHasVendor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_has_vendor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, vendor_id, status', 'required'),
			array('product_was_added_by, product_was_updated_by', 'numerical', 'integerOnly'=>true),
			array('product_id, vendor_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('date_product_was_added_to_vendor, date_product_to_vendor_was_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_id, vendor_id, status, date_product_was_added_to_vendor, date_product_to_vendor_was_updated, product_was_added_by, product_was_updated_by', 'safe', 'on'=>'search'),
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
			'vendor_id' => 'Vendor',
			'status' => 'Status',
			'date_product_was_added_to_vendor' => 'Date Product Was Added To Vendor',
			'date_product_to_vendor_was_updated' => 'Date Product To Vendor Was Updated',
			'product_was_added_by' => 'Product Was Added By',
			'product_was_updated_by' => 'Product Was Updated By',
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
		$criteria->compare('vendor_id',$this->vendor_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_product_was_added_to_vendor',$this->date_product_was_added_to_vendor,true);
		$criteria->compare('date_product_to_vendor_was_updated',$this->date_product_to_vendor_was_updated,true);
		$criteria->compare('product_was_added_by',$this->product_was_added_by);
		$criteria->compare('product_was_updated_by',$this->product_was_updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductHasVendor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that confirms if a product is not already assigned to a member
         */
        public function isProductNotAlreadyAssignedToThisMember($vendor_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('product_has_vendor')
                    ->where("vendor_id= $vendor_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that determines the status of the assigned product to a vendor
         */
        public function isAssignedProductToMemberNotYetActive($vendor_id,$product_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='vendor_id=:vendorid and product_id=:productid';
             $criteria->params = array(':vendorid'=>$vendor_id,':productid'=>$product_id);
             $status= ProductHasVendor::model()->find($criteria);
             
             if($status['status'] == 'inactive'){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the product that confirms the assignment of product to a vendor
         */
        public function isTheAssignmentOfProductToMemberASuccess($vendor_id,$product_id){
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->insert('product_has_vendor',
                         array('vendor_id'=>$vendor_id,
                                'product_id' =>$product_id,
                                'status'=>'inactive',
                                'date_product_was_added_to_vendor'=>new CDbExpression('NOW()'),
                                 'product_was_added_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        
        /**
         * This is the function that retrieves all products a merchant registered to trade on
         */
        public function getAllTheProductThisMemberIsAMerchantOf($vendor_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='vendor_id=:vendorid';
             $criteria->params = array(':vendorid'=>$vendor_id);
             $products= ProductHasVendor::model()->findAll($criteria);
             
             $all_products = [];
             
             foreach($products as $product){
                 $all_products[] = $product['product_id'];
             }
             return $all_products;
            
        }
        
        
        /**
         * This is the function that removes a product from a vendor
         */
        public function isRemovalOfProductFromTheVendorSuccessful($vendor_id,$product_id){
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('product_has_vendor', 'vendor_id=:vendorid and product_id=:productid', array(':vendorid'=>$vendor_id,':productid'=>$product_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
}
