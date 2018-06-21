<?php

/**
 * This is the model class for table "voucher".
 *
 * The followings are the available columns in table 'voucher':
 * @property string $id
 * @property string $vouncher_number
 * @property string $purpose
 * @property string $status
 * @property string $voucher_type
 * @property double $voucher_value
 * @property double $remaining_voucher_value
 * @property string $topup_value_status
 * @property double $topup_value
 * @property double $remaining_voucher_share_in_percentage
 * @property integer $accepted_voucher_creation_and_user_terms
 * @property string $date_created
 * @property string $topup_date
 * @property string $date_confirmed
 * @property string $date_updated
 * @property integer $create_by
 * @property integer $confirmed_by
 * @property integer $updated_by
 * @property integer $toppedup_by
 * @property integer $topup_confimed_by
 *
 * The followings are the available model relations:
 * @property Category[] $categories
 * @property Product[] $products
 * @property Wallet[] $wallets
 */
class Voucher extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'voucher';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, voucher_type', 'required'),
			array('accepted_voucher_creation_and_user_terms, create_by, confirmed_by, updated_by, toppedup_by, topup_confimed_by', 'numerical', 'integerOnly'=>true),
			array('voucher_value, remaining_voucher_value, topup_value, remaining_voucher_share_in_percentage', 'numerical'),
			array('voucher_number', 'length', 'max'=>200),
			array('status, topup_value_status', 'length', 'max'=>8),
			array('voucher_type', 'length', 'max'=>5),
			array('purpose, date_created, topup_date, date_confirmed, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, voucher_number, purpose, status, voucher_type, voucher_value, remaining_voucher_value, topup_value_status, topup_value, remaining_voucher_share_in_percentage, accepted_voucher_creation_and_user_terms, date_created, topup_date, date_confirmed, date_updated, create_by, confirmed_by, updated_by, toppedup_by, topup_confimed_by', 'safe', 'on'=>'search'),
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
			'categories' => array(self::MANY_MANY, 'Category', 'voucher_limited_to_categories(voucher_id, category_id)'),
			'products' => array(self::MANY_MANY, 'Product', 'voucher_limited_to_products(voucher_id, product_id)'),
			'wallets' => array(self::MANY_MANY, 'Wallet', 'wallet_has_vouchers(voucher_id, wallet_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vouncher_number' => 'Vouncher Number',
			'purpose' => 'Purpose',
			'status' => 'Status',
			'voucher_type' => 'Voucher Type',
			'voucher_value' => 'Voucher Value',
			'remaining_voucher_value' => 'Remaining Voucher Value',
			'topup_value_status' => 'Topup Value Status',
			'topup_value' => 'Topup Value',
			'remaining_voucher_share_in_percentage' => 'Remaining Voucher Share In Percentage',
			'accepted_voucher_creation_and_user_terms' => 'Accepted Voucher Creation And User Terms',
			'date_created' => 'Date Created',
			'topup_date' => 'Topup Date',
			'date_confirmed' => 'Date Confirmed',
			'date_updated' => 'Date Updated',
			'create_by' => 'Create By',
			'confirmed_by' => 'Confirmed By',
			'updated_by' => 'Updated By',
			'toppedup_by' => 'Toppedup By',
			'topup_confimed_by' => 'Topup Confimed By',
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
		$criteria->compare('vouncher_number',$this->vouncher_number,true);
		$criteria->compare('purpose',$this->purpose,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('voucher_type',$this->voucher_type,true);
		$criteria->compare('voucher_value',$this->voucher_value);
		$criteria->compare('remaining_voucher_value',$this->remaining_voucher_value);
		$criteria->compare('topup_value_status',$this->topup_value_status,true);
		$criteria->compare('topup_value',$this->topup_value);
		$criteria->compare('remaining_voucher_share_in_percentage',$this->remaining_voucher_share_in_percentage);
		$criteria->compare('accepted_voucher_creation_and_user_terms',$this->accepted_voucher_creation_and_user_terms);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('topup_date',$this->topup_date,true);
		$criteria->compare('date_confirmed',$this->date_confirmed,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('confirmed_by',$this->confirmed_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('toppedup_by',$this->toppedup_by);
		$criteria->compare('topup_confimed_by',$this->topup_confimed_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Voucher the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that confirms if there is an existing topup value
         */
        public function isThereAnExistingUnconfrimedTopupValue($voucher_id){
            
          $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('voucher')
                    ->where("is_voucher_toppedup = 1 and is_topup_payment_confirmed=0");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that gets a voucher number
         */
        public function getThisVoucherNumber($voucher_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$voucher_id);
             $voucher= Voucher::model()->find($criteria);
             
             return $voucher['voucher_number'];
        }
        
        
        /**
         * This is the function that ensures that voucher fund position is adjusted after wallet funding 
         */
        public function isVoucherFundPositionModifiedSuccessfully($voucher_id,$voucher_value,$remaining_voucher_value,$allocated_voucher_value){
            
            $new_remaining_voucher_value = ($remaining_voucher_value - $allocated_voucher_value);
            $remaining_voucher_share_in_percentage = ($new_remaining_voucher_value/$voucher_value)*100;
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('voucher',
                                  array(
                                    'remaining_voucher_value'=>$new_remaining_voucher_value,
                                     'remaining_voucher_share_in_percentage'=>$remaining_voucher_share_in_percentage 
                                                             
                            ),
                     ("id=$voucher_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        /**
         * This is the function that confirms if a voucher is limited either by product or by category
         */
        public function isThisVoucherLimited($voucher_id){
            $model = new VoucherLimitedToCategories;
            
            if($model->isThisVoucherLimitedByCategory($voucher_id)){
                return true;
            }else{
                if($this->isThisVoucherLimitedByProduct($voucher_id)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        
        /**
         * This is the function that determines if a voucher is limited by a particular product
         */
        public function isThisVoucherLimitedToThisProduct($voucher_id,$product_id){
            $model = new VoucherLimitedToCategories;
            //get the category of this product
            
            $category_id = $this->getTheCategoryIdOfThisProduct($product_id);
             if($model->isThisCategoryLimitingThisVoucher($voucher_id,$category_id)){
                return true;
            }else{
                if($this->isThisProductLimitingThisVoucher($voucher_id,$product_id)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
        /**
         * This is the function that confirms if a voucher is limited by product
         */
        public function isThisVoucherLimitedByProduct($voucher_id){
            $model = new VoucherLimitedToProducts;
            return $model->isThisVoucherLimitedByProduct($voucher_id);
        }
        
        
        /**
         * This is the function that determines if a voucher is limited by a particular product
         */
        public function isThisProductLimitingThisVoucher($voucher_id,$product_id){
            $model = new VoucherLimitedToProducts;
            return $model->isThisProductLimitingThisVoucher($voucher_id,$product_id);
        }
        
        /**
         * This is the function that gets the category of a product
         */
        public function getTheCategoryIdOfThisProduct($product_id){
            $model = new Product;
            return $model->getTheCategoryIdOfThisProduct($product_id);
        }
        
        
        /**
         * This is the function that that confirms if a voucher has an unallocated fund
         */
        public function isThisLimitedVoucherWithUnallocatedFund($wallet_id,$voucher_id){
            $model = new VoucherLimitedToCategories;
            
            if($model->isThisVoucherLimitedByCategory($voucher_id)){
                if($model->isThisVoucherWithUnallocatedCategoryFund($wallet_id,$voucher_id)){
                    return true;
                }else{
                    if($this->isThisVoucherLimitedByProduct($voucher_id)){
                        if($this->isVoucherWithUnallocatedProductFund($wallet_id,$voucher_id)){
                            return true;
                        }else{
                            return false;
                        }
                    }
                }
            }else{
                if($this->isThisVoucherLimitedByProduct($voucher_id)){
                        if($this->isVoucherWithUnallocatedProductFund($wallet_id,$voucher_id)){
                            return true;
                        }else{
                            return false;
                        }
                    } 
            }
        }
        
        /**
         * This is the function that confirms if a voucher is with unallocated fund
         */
        public function isVoucherWithUnallocatedProductFund($wallet_id,$voucher_id){
            $model = new VoucherLimitedToProducts;
            return $model->isVoucherWithUnallocatedProductFund($wallet_id,$voucher_id);
        }
}
