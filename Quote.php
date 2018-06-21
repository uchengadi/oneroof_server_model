<?php

/**
 * This is the model class for table "quote".
 *
 * The followings are the available columns in table 'quote':
 * @property string $id
 * @property string $quote_number
 * @property string $product_id
 * @property string $quote_file
 * @property integer $is_escrowed
 * @property integer $is_for_future
 * @property string $status
 * @property integer $minimum_number_of_product_to_buy
 * @property string $whats_product_per_item
 * @property integer $quantity
 * @property double $total_amount_quoted
 * @property string $quote_initiation_date
 * @property string $quote_acceptance_date
 * @property string $quote_rejection_date
 * @property string $quote_expected_date_of_expiry
 * @property integer $quote_initiated_by
 * @property integer $quote_rejected_by
 * @property integer $quote_accepted_by
 * @property string $quote_submission_date_of_expiry
 * @property string $direction
 * @property integer $is_already_accepted
 * @property string $quote_response_date
 * @property integer $quote_response_from
 * @property string $quote_modification_date
 * @property integer $quote_modified_by
 *
 * The followings are the available model relations:
 * @property Futures[] $futures
 * @property Product $product
 */
class Quote extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, whats_product_per_item, direction', 'required'),
			array('is_escrowed, is_for_future, minimum_number_of_product_to_buy, quantity, quote_initiated_by, quote_rejected_by, quote_accepted_by, is_already_accepted, quote_response_from, quote_modified_by', 'numerical', 'integerOnly'=>true),
			array('total_amount_quoted', 'numerical'),
			array('quote_number', 'length', 'max'=>200),
			array('product_id, direction', 'length', 'max'=>10),
			array('quote_file, whats_product_per_item', 'length', 'max'=>100),
			array('status', 'length', 'max'=>8),
			array('quote_initiation_date, quote_acceptance_date, quote_rejection_date, quote_expected_date_of_expiry, quote_submission_date_of_expiry, quote_response_date, quote_modification_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, quote_number, product_id, quote_file, is_escrowed, is_for_future, status, minimum_number_of_product_to_buy, whats_product_per_item, quantity, total_amount_quoted, quote_initiation_date, quote_acceptance_date, quote_rejection_date, quote_expected_date_of_expiry, quote_initiated_by, quote_rejected_by, quote_accepted_by, quote_submission_date_of_expiry, direction, is_already_accepted, quote_response_date, quote_response_from, quote_modification_date, quote_modified_by', 'safe', 'on'=>'search'),
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
			'futures' => array(self::HAS_MANY, 'Futures', 'quote_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quote_number' => 'Quote Number',
			'product_id' => 'Product',
			'quote_file' => 'Quote File',
			'is_escrowed' => 'Is Escrowed',
			'is_for_future' => 'Is For Future',
			'status' => 'Status',
			'minimum_number_of_product_to_buy' => 'Minimum Number Of Product To Buy',
			'whats_product_per_item' => 'Whats Product Per Item',
			'quantity' => 'Quantity',
			'total_amount_quoted' => 'Total Amount Quoted',
			'quote_initiation_date' => 'Quote Initiation Date',
			'quote_acceptance_date' => 'Quote Acceptance Date',
			'quote_rejection_date' => 'Quote Rejection Date',
			'quote_expected_date_of_expiry' => 'Quote Expected Date Of Expiry',
			'quote_initiated_by' => 'Quote Initiated By',
			'quote_rejected_by' => 'Quote Rejected By',
			'quote_accepted_by' => 'Quote Accepted By',
			'quote_submission_date_of_expiry' => 'Quote Submission Date Of Expiry',
			'direction' => 'Direction',
			'is_already_accepted' => 'Is Already Accepted',
			'quote_response_date' => 'Quote Response Date',
			'quote_response_from' => 'Quote Response From',
			'quote_modification_date' => 'Quote Modification Date',
			'quote_modified_by' => 'Quote Modified By',
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
		$criteria->compare('quote_number',$this->quote_number,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('quote_file',$this->quote_file,true);
		$criteria->compare('is_escrowed',$this->is_escrowed);
		$criteria->compare('is_for_future',$this->is_for_future);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('minimum_number_of_product_to_buy',$this->minimum_number_of_product_to_buy);
		$criteria->compare('whats_product_per_item',$this->whats_product_per_item,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('total_amount_quoted',$this->total_amount_quoted);
		$criteria->compare('quote_initiation_date',$this->quote_initiation_date,true);
		$criteria->compare('quote_acceptance_date',$this->quote_acceptance_date,true);
		$criteria->compare('quote_rejection_date',$this->quote_rejection_date,true);
		$criteria->compare('quote_expected_date_of_expiry',$this->quote_expected_date_of_expiry,true);
		$criteria->compare('quote_initiated_by',$this->quote_initiated_by);
		$criteria->compare('quote_rejected_by',$this->quote_rejected_by);
		$criteria->compare('quote_accepted_by',$this->quote_accepted_by);
		$criteria->compare('quote_submission_date_of_expiry',$this->quote_submission_date_of_expiry,true);
		$criteria->compare('direction',$this->direction,true);
		$criteria->compare('is_already_accepted',$this->is_already_accepted);
		$criteria->compare('quote_response_date',$this->quote_response_date,true);
		$criteria->compare('quote_response_from',$this->quote_response_from);
		$criteria->compare('quote_modification_date',$this->quote_modification_date,true);
		$criteria->compare('quote_modified_by',$this->quote_modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Quote the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that gets the product id of a quote
         */
        public function getTheProductIdOfThisQuote($quote_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$quote_id);
             $quote= Quote::model()->find($criteria);
             
             return $quote['product_id'];
        }
        
        
        /**
         * This is the function that gets a quotes code given its id
         */
        public function getThisQuoteNumber($quote_id){
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$quote_id);
             $quote= Quote::model()->find($criteria);
             
             return $quote['quote_number'];
        }
        
        
        /**
         * This is the function that generates the quote number of a transaction
         */
        public function generateThisQuoteNumber($service_id,$category_id,$type_id,$product_id){
            
            $model= new Members;
            $member_id = Yii::app()->user->id;
            //get the last four digit of the logged in user membership number
            $membership_number = $model->getTheLastFourDigitsOfThisMemberMembershipNumber($member_id);
            
            //get the service code
            $service_code = $this->getThisServiceCode($service_id);
            
            //get the category code
            
            $category_code = $this->getThisCategoryCode($category_id);
            
            //get the type code
            $type_code = $this->getThisProductTypeCode($type_id);
            
            //get the last four digit of the product code
            $product_code = $this->getTheLastFourDigitOfTheProductCode($product_id);
            
             //get the today's date for this order
            $order_date = $this->getTodayDateForThisOrder();
            
            $quote_number = $order_date.$product_code.$membership_number.$service_code.$category_code.$type_code;
            
           
            
            if($this->isThisQuoteNumberAlreadyInExistence($quote_number)){
                return($quote_number.$this->uniqueNumberDifferentiator());
            }else{
                return $quote_number;
            }
            
        }
        
        
        /**
         * This is the function that retrieves todays date for an order
         */
        public function getTodayDateForThisOrder(){
            $model = new Order;
            
            return $model->getTodayDateForThisOrder();
        }
        
        /**
         * This is the function that retrieves a type code
         */
        public function getThisProductTypeCode($type_id){
            $model = new ProductType;
            return $model->getThisProductTypeCode($type_id);
        }
        
        
        /**
         * This is the function that retrieves the category code
         */
        public function getThisCategoryCode($category_id){
            $model = new Category;
            return $model->getThisCategoryCode($category_id);
        }
        
        
        /**
         * This is the function that gets a service code
         */
        public function getThisServiceCode($service_id){
            $model = new Service;
            return $model->getThisServiceCode($service_id);
        }
        
        
        /**
         * This is the function that gets the last four digits of a product code
         */
        public function getTheLastFourDigitOfTheProductCode($product_id){
            $model = new Product;
            return $model->getTheLastFourDigitOfTheProductCode($product_id);
        }
        
        
         /**
         * This is the function that gets the new unique number differentiator
         */
        public function uniqueNumberDifferentiator(){
                
            $model = new PlatformSettings;
                             
            return $model->uniqueNumberDifferentiator();
                
        }
        
             /**
         * This is the function that verifies the existence of an order number
         */
        public function isThisQuoteNumberAlreadyInExistence($quote_number){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('quote')
                    ->where("quote_number = '$quote_number'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
            
        }
        
        
        /**
         * This is the function that the quote submission expiry duw date
         */
        public function getThisQuoteSubmissionExpiryDueDate(){
            
            $model = new PlatformSettings;
            //get the maximum date for quote submission
            $maximum_days_for_quote_submission = $model->retrieveTheMaximumDaysBeforeQuoteSubmission();
            
            $expiry_date = (mktime(0, 0, 0, date("m")  , date("d")+$maximum_days_for_quote_submission, date("Y")));
            return date("Y-m-d H:i:s", $expiry_date);
            
            
        }
        
        
        /**
         * This is the function that confirms if a quote response is from a member
         */
        public function isThisQuoteResponseFromMember($id,$member_id){
            
           $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('quote')
                    ->where("id = $id and quote_response_from=$member_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
                
        }  
        
        /**
         * This is the function that effects the cancellation of a quote
         */
        public function isTheCancellationOfThisQuoteSuccessful($quote_id){
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('quote', 'id=:quoteid', array(':quoteid'=>$quote_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that retrieves the current status of a quote
         */
        public function getThisQuoteCurrentStatus($quote_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$quote_id);
             $quote= Quote::model()->find($criteria);
             
             return $quote['status'];
        }
        
        /**
         * This is the function that determines if decision had been made on a quote request
         */
        public function hasDecisionBeenMadeOnThisQuoteRequest($quote_id){
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$quote_id);
             $quote= Quote::model()->find($criteria);
             
             if($quote['status'] != 'live'){
                 return true;
             }else{
                 return false;
             }
        }
        
        
        /**
         * This is the function that effects decision on a quote
         */
        public function isTakingAcceptanceDecisionOnThisQuoteASuccess($quote_id){
            
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('quote',
                                  array(
                                    'status'=>'accepted',
                                                             
                            ),
                     ("id=$quote_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that determines if a duplicate quotation is about to be made
         */
        public function isThereAPendingQuoteOfThisProductOfSameQuantity($product_id,$status,$quantity,$is_for_future,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency){
            $model = new Futures;
            
            if($is_for_future == 0){
                $cmd =Yii::app()->db->createCommand();
                $cmd->select('COUNT(*)')
                    ->from('quote')
                    ->where("(product_id = $product_id and quantity=$quantity) and (status='$status' and is_for_future=$is_for_future)");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                if($model->isTheFuturesConditionParametersSameComparedToAnotherLiveQuote($product_id,$status,$quantity,$is_for_future,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency)){
                  $cmd =Yii::app()->db->createCommand();
                        $cmd->select('COUNT(*)')
                        ->from('quote')
                        ->where("(product_id = $product_id and quantity=$quantity) and (status='$status' and is_for_future=$is_for_future)");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
             }else{
                    return false;
                }
            }
            
            
        }
        
        /**
         * This is the function that retrieves quote id given some parameters
         */
        public function getThisQuoteId($product_id,$status,$quantity,$is_for_future,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency){
            
                $model = new Futures;
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='product_id=:productid and (quantity=:quantity and status=:status)';
                $criteria->params = array(':productid'=>$product_id,':quantity'=>$quantity,':status'=>$status);
                $quotes= Quote::model()->findAll($criteria);
                
                foreach($quotes as $quote){
                    if($model->isThisFutureSameWithThePreviousOneForAnotherLiveQuote($quote['id'],$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency)){
                        return $quote['id'];
                    }
                }
                return 0;
                
                
        }
        
        /**
         * This is the function that gets the product id given the quote id
         */
        public function getThisProductIdGivenTheQuoteId($quote_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$quote_id);
                $quote= Quote::model()->find($criteria);
                
                return $quote['product_id'];
        }
        
        /**
         * This is the function that automatically adds a quote to a cart
         */
        public function isThisQuoteSuccessfullyAddedToTheCart($quote_id,$is_quote_escrowed,$is_escrow_terms_accepted,$total_amount_quoted,$delivery_cost){
                
                $model = new OrderHasProducts;
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$quote_id);
                $quote= Quote::model()->find($criteria);
                
                if($is_quote_escrowed == 1){
                    $escrow_id = $this->getTheEscrowIdOfThisQuote($quote_id);
                }else{
                  $escrow_id = 0;  
                }
                
                if($model->isAddingThisQuoteToAMemberCartASuccess($quote_id,$quote['product_id'],$quote['quantity'],$escrow_id,$is_quote_escrowed,$is_escrow_terms_accepted,$total_amount_quoted,$delivery_cost)){
                    return true;
                }else{
                    return false;
                }
          
               
        }
        
                /**
                 * This is the function that gets the escrow id of am escrowable quote
                 */
                public function getTheEscrowIdOfThisQuote($quote_id){
                    $model = new Escrow;
                    return $model->getTheEscrowIdOfThisQuote($quote_id);
                }
        
        
}
