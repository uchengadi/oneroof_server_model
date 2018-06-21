<?php

/**
 * This is the model class for table "voucher_limited_to_products".
 *
 * The followings are the available columns in table 'voucher_limited_to_products':
 * @property string $voucher_id
 * @property string $product_id
 * @property string $status
 * @property double $expendable_limits_in_percentage
 * @property string $date_limit_was_added_placed
 * @property string $date_limi_was_updated
 * @property integer $voucher_limit_was_placed_by
 * @property integer $voucher_limit_was_updated_by
 */
class VoucherLimitedToProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'voucher_limited_to_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('voucher_id, product_id, status', 'required'),
			array('voucher_limit_was_placed_by, voucher_limit_was_updated_by', 'numerical', 'integerOnly'=>true),
			array('expendable_limits_in_percentage', 'numerical'),
			array('voucher_id, product_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('date_limit_was_added_placed, date_limi_was_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('voucher_id, product_id, status, expendable_limits_in_percentage, date_limit_was_added_placed, date_limi_was_updated, voucher_limit_was_placed_by, voucher_limit_was_updated_by', 'safe', 'on'=>'search'),
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
			'voucher_id' => 'Voucher',
			'product_id' => 'Product',
			'status' => 'Status',
			'expendable_limits_in_percentage' => 'Expendable Limits In Percentage',
			'date_limit_was_added_placed' => 'Date Limit Was Added Placed',
			'date_limi_was_updated' => 'Date Limi Was Updated',
			'voucher_limit_was_placed_by' => 'Voucher Limit Was Placed By',
			'voucher_limit_was_updated_by' => 'Voucher Limit Was Updated By',
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

		$criteria->compare('voucher_id',$this->voucher_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('expendable_limits_in_percentage',$this->expendable_limits_in_percentage);
		$criteria->compare('date_limit_was_added_placed',$this->date_limit_was_added_placed,true);
		$criteria->compare('date_limi_was_updated',$this->date_limi_was_updated,true);
		$criteria->compare('voucher_limit_was_placed_by',$this->voucher_limit_was_placed_by);
		$criteria->compare('voucher_limit_was_updated_by',$this->voucher_limit_was_updated_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VoucherLimitedToProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        
        /**
         * This is the function that determines if a category is already limiting a voucher
         */
        public function isThisProductNotAlreadyLimitingThisVoucher($voucher_id,$product_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('voucher_limited_to_products')
                    ->where("voucher_id = $voucher_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        
        /**
         * This is the function that limits a voucher to a product
         */
        public function isThisVoucherLimitingToThisProductSuccessful($voucher_id,$product_id,$expendable_limits_in_percentage){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('voucher_limited_to_products',
                         array( 
                             'voucher_id'=>$voucher_id,
                             'product_id'=>$product_id,
                             'status'=>strtolower('active'),
                                'expendable_limits_in_percentage'=>$expendable_limits_in_percentage,
                                'date_limit_was_added_placed'=>new CDbExpression('NOW()'),
                               'voucher_limit_was_placed_by'=>Yii::app()->user->id
                                
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
                 
                 
                 
       /**
         * This is the function that effects the change in the status of category limiter 
         */
        public function isProductLimiterSatusChangeASuccess($product_id,$voucher_id,$status){
            
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('voucher_limited_to_products',
                                  array(
                                    'status'=>$status,
                                                             
                            ),
                     ("voucher_id=$voucher_id and product_id=$product_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        
         /**
         * This is the function that removes a product limiter
         */
        public function isTheRemovalOfThisProductLimiterFromVoucherSuccessful($product_id,$voucher_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('voucher_limited_to_products', 'product_id=:prodid and voucher_id=:vatid', array(':prodid'=>$product_id,':vatid'=>$voucher_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that determines if a voucher is limited by product
         */
        public function isThisVoucherLimitedByProduct($voucher_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('voucher_limited_to_products')
                    ->where("voucher_id = $voucher_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that determines is limiting a voucher
         */
        public function isThisProductLimitingThisVoucher($voucher_id,$product_id){
           
              $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('voucher_limited_to_products')
                    ->where("voucher_id = $voucher_id and product_id=$product_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
                
                
                     
        }
        
        
        /**
         * This is the function that confirms if a voucher can settle a product
         */
        public function canThisVoucherSettleThisProductTransaction($wallet_id,$voucher,$product,$cost_of_this_product,$product_cost_for_delivery,$product_quantity){
            
            //get the allocated voucher fund in a wallet
            $allocated_voucher_fund = $this->getTheAllocatedVoucherFundInAWallet($wallet_id,$voucher);
            
            //get the unallocated voucher fund in a wallet
            $unallocated_voucher_fund = $this->getTheUnallocatedVoucherFundInAWallet($wallet_id,$voucher);
            
            $transaction_total_cost = $cost_of_this_product + ($product_cost_for_delivery *$product_quantity);
            
            if($this->isThereAFundAllocationForThisProductInThisVoucher($voucher,$product)){
                if($this->isTheProductAllocatedFundSufficientToCoverTheCostOfThisProduct($wallet_id,$voucher,$product,$product_cost_for_delivery,$product_quantity)){
                        return true;
                    }else{
                        return false;
                    }
            }else{
                 if($this->canTheUnallocatedFundInTheVoucherCoverTheCostOfThisTransaction($wallet_id,$voucher,$transaction_total_cost,$unallocated_voucher_fund)){
                        return true;
                     }else{
                        return false;
                     }
                    }
                
           
            
        }
        
        
        /**
         * This is the function that determines if a function has unallocated fund
         */
        public function isVoucherWithUnallocatedProductFund($wallet_id,$voucher_id){
            
            $model = new WalletHasVouchers;
            
            $voucher_actual_value = $model->getTheExistActualValueInThewallet($wallet_id, $voucher_id);
            
            //get the total value of this share in this wallet
            $percentage_sum = 0;
            $limitless_counter = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='voucher_id=:voucherid and status=:status';
            $criteria->params = array(':voucherid'=>$voucher_id,':status'=>'active');
            $products= VoucherLimitedToProducts::model()->findAll($criteria);
            
            foreach($products as $product){
                
                if($product['expendable_limits_in_percentage'] == -1){
                    $limitless_counter = $limitless_counter + 1;
                }else{
                    $percentage_sum = $percentage_sum + $product['expendable_limits_in_percentage'];
                }
            }
            if($percentage_sum>=100){
                return false;
            }else{
                if($limitless_counter>0){
                    return false;
                }else{
                    return true;
                }
            }
            
            
        }
        
        
        
        /**
         * This is the function that gets the unallocated fund in a limited voucher
         */
        public function getTheUnallocatedProductFundInTheLimitedVoucher($wallet_id,$voucher_id){
            
            $model = new WalletHasVouchers;
            
            $voucher_actual_value = $model->getTheExistActualValueInThewallet($wallet_id, $voucher_id);
            
            //get the total value of this share in this wallet
            $percentage_sum = 0;
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='voucher_id=:voucherid and status=:status';
            $criteria->params = array(':voucherid'=>$voucher_id,':status'=>'active');
            $products= VoucherLimitedToProducts::model()->findAll($criteria);
            
            foreach($products as $product){
                
                if($product['expendable_limits_in_percentage'] == -1){
                    $limitless_counter = $limitless_counter + 1;
                }else{
                    $percentage_sum = $percentage_sum + $product['expendable_limits_in_percentage'];
                }
            }
            if($percentage_sum>=100){
                return 0;
            }else{
                if($limitless_counter>0){
                    return 0;
                }else{
                    $unallocated_fund = $voucher_actual_value - ($voucher_actual_value*$percentage_sum/100);
                    return $unallocated_fund;
                }
            }
            
        }
        
        
}
