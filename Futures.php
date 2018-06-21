<?php

/**
 * This is the model class for table "futures".
 *
 * The followings are the available columns in table 'futures':
 * @property string $id
 * @property string $future_number
 * @property string $quote_id
 * @property string $future_agreement_file
 * @property integer $is_quoted
 * @property integer $is_escrowed
 * @property string $status
 * @property integer $minimum_number_of_product_to_buy
 * @property string $whats_product_per_item
 * @property integer $quantity
 * @property double $total_amount_of_purchase
 * @property string $delivery_month
 * @property string $delivery_year
 * @property string $payment_method
 * @property string $staggered_payment_frequency
 * @property string $futures_initiation_date
 * @property string $futures_acceptance_date
 * @property string $futures_rejection_date
 * @property string $futures_expected_date_of_expiry
 * @property integer $futures_initiated_by
 * @property integer $futures_requested_by
 * @property integer $futures_rejected_by
 * @property integer $futures_accepted_by
 *
 * The followings are the available model relations:
 * @property Quote $quote
 * @property Payment[] $payments
 */
class Futures extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'futures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, status, whats_product_per_item', 'required'),
			array('is_quoted, is_escrowed, minimum_number_of_product_to_buy, quantity, futures_initiated_by, futures_requested_by, futures_rejected_by, futures_accepted_by', 'numerical', 'integerOnly'=>true),
			array('total_amount_of_purchase', 'numerical'),
			array('future_number', 'length', 'max'=>200),
			array('quote_id', 'length', 'max'=>10),
			array('future_agreement_file, whats_product_per_item', 'length', 'max'=>100),
			array('status', 'length', 'max'=>8),
			array('delivery_month, delivery_year, payment_method, staggered_payment_frequency', 'length', 'max'=>15),
			array('futures_initiation_date, futures_acceptance_date, futures_rejection_date, futures_expected_date_of_expiry', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, future_number, quote_id, future_agreement_file, is_quoted, is_escrowed, status, minimum_number_of_product_to_buy, whats_product_per_item, quantity, total_amount_of_purchase, delivery_month, delivery_year, payment_method, staggered_payment_frequency, futures_initiation_date, futures_acceptance_date, futures_rejection_date, futures_expected_date_of_expiry, futures_initiated_by, futures_requested_by, futures_rejected_by, futures_accepted_by', 'safe', 'on'=>'search'),
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
			'quote' => array(self::BELONGS_TO, 'Quote', 'quote_id'),
			'payments' => array(self::MANY_MANY, 'Payment', 'futures_has_payment(futures_id, payment_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'future_number' => 'Future Number',
			'quote_id' => 'Quote',
			'future_agreement_file' => 'Future Agreement File',
			'is_quoted' => 'Is Quoted',
			'is_escrowed' => 'Is Escrowed',
			'status' => 'Status',
			'minimum_number_of_product_to_buy' => 'Minimum Number Of Product To Buy',
			'whats_product_per_item' => 'Whats Product Per Item',
			'quantity' => 'Quantity',
			'total_amount_of_purchase' => 'Total Amount Of Purchase',
			'delivery_month' => 'Delivery Month',
			'delivery_year' => 'Delivery Year',
			'payment_method' => 'Payment Method',
			'staggered_payment_frequency' => 'Staggered Payment Frequency',
			'futures_initiation_date' => 'Futures Initiation Date',
			'futures_acceptance_date' => 'Futures Acceptance Date',
			'futures_rejection_date' => 'Futures Rejection Date',
			'futures_expected_date_of_expiry' => 'Futures Expected Date Of Expiry',
			'futures_initiated_by' => 'Futures Initiated By',
			'futures_requested_by' => 'Futures Requested By',
			'futures_rejected_by' => 'Futures Rejected By',
			'futures_accepted_by' => 'Futures Accepted By',
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
		$criteria->compare('future_number',$this->future_number,true);
		$criteria->compare('quote_id',$this->quote_id,true);
		$criteria->compare('future_agreement_file',$this->future_agreement_file,true);
		$criteria->compare('is_quoted',$this->is_quoted);
		$criteria->compare('is_escrowed',$this->is_escrowed);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('minimum_number_of_product_to_buy',$this->minimum_number_of_product_to_buy);
		$criteria->compare('whats_product_per_item',$this->whats_product_per_item,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('total_amount_of_purchase',$this->total_amount_of_purchase);
		$criteria->compare('delivery_month',$this->delivery_month,true);
		$criteria->compare('delivery_year',$this->delivery_year,true);
		$criteria->compare('payment_method',$this->payment_method,true);
		$criteria->compare('staggered_payment_frequency',$this->staggered_payment_frequency,true);
		$criteria->compare('futures_initiation_date',$this->futures_initiation_date,true);
		$criteria->compare('futures_acceptance_date',$this->futures_acceptance_date,true);
		$criteria->compare('futures_rejection_date',$this->futures_rejection_date,true);
		$criteria->compare('futures_expected_date_of_expiry',$this->futures_expected_date_of_expiry,true);
		$criteria->compare('futures_initiated_by',$this->futures_initiated_by);
		$criteria->compare('futures_requested_by',$this->futures_requested_by);
		$criteria->compare('futures_rejected_by',$this->futures_rejected_by);
		$criteria->compare('futures_accepted_by',$this->futures_accepted_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Futures the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that initiates new future purchase
         */
        public function isNewFuturesSuccessfullyInitiated($quote_id,$is_quoted,$is_escrowed,$status,$minimum_number_of_product_to_buy,$whats_product_per_item,$quantity,$delivery_month,$delivery_year,$payment_method,$staggered_payment_frequency){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('futures',
                         array( 'status'=>$status,
                                'quote_id'=>$quote_id,
                                'minimum_number_of_product_to_buy'=>$minimum_number_of_product_to_buy,
                                'whats_product_per_item'=>$whats_product_per_item,
                                'quantity'=>$quantity,
                                'is_quoted'=>$is_quoted,
                                'is_escrowed'=>$is_escrowed,
                                'delivery_month'=>$delivery_month,
                                'delivery_year'=>$delivery_year,
                                'payment_method'=>$payment_method,
                                'staggered_payment_frequency'=>$staggered_payment_frequency,
                                 'future_number'=>$this->generateTheFuturesNumberForThisTransaction($quote_id),
                                 'futures_initiation_date'=>new CDbExpression('NOW()'),
                                // 'futures_expected_date_of_expiry'=>$this->getTheDateOfExpiryOfThisFutures(),
                                 'futures_initiated_by'=>Yii::app()->user->id
                                 
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        
        /**
         * This is the function that generates a futures number
         */
        public function generateTheFuturesNumberForThisTransaction($quote_id){
            //get the quote code
            $quote_code = $this->getThisQuoteNumber($quote_id);
            
            //get the product code for this quote
            $product_code = $this->getThisQuoteProductCode($quote_id);
            
            //obtain the futures code
            $futures_number = $quote_code.$product_code;
            
                     
             if($this->isThisFuturesNumberAlreadyInExistence($futures_number)){
                return($futures_number.$this->uniqueNumberDifferentiator());
            }else{
                return $futures_number;
            }
            
      
        }
        
        
        /**
         * This is the function that obtains a quotes code
         * 
         */
        public function getThisQuoteNumber($quote_id){
            $model = new Quote;
            return $model->getThisQuoteNumber($quote_id);
        }
        
        /**
         * This is the function that gets a product code
         */
        public function getThisQuoteProductCode($quote_id){
            $model = new Product;
            return $model->getThisQuoteProductCode($quote_id);
        }
        
        
        
              /**
         * This is the function that verifies the existence of an order number
         */
        public function isThisFuturesNumberAlreadyInExistence($futures_number){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('futures')
                    ->where("future_number = '$futures_number'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
            
        }
        
        
        /**
         * This is the function that confirms if a futures facility is associated to a quote
         */
        public function isQuoteAlreadyAssociatedWithFutures($quote_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('futures')
                    ->where("quote_id = $quote_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that removes a futures facility from a quote
         */
        public function isTheRemovalOfAssociatedFuturesSuccessful($quote_id){
           $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('futures', 'quote_id=:quoteid', array(':quoteid'=>$quote_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        
        /**
         * This is the function tht effects a modification to a futures facility
         */
        public function isFuturesSuccessfullyUpdated($quote_id,$requesting_for_a_quote,$is_escrowed,$status,$minimum_number_of_product_to_buy,$whats_product_per_item,$quantity,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency){
         if($this->isQuoteAlreadyAssociatedWithFutures($quote_id)){
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('futures',
                         array('is_quoted'=>$requesting_for_a_quote,
                                'is_escrowed'=>$is_escrowed,
                                'quantity'=>$quantity,
                                'delivery_month'=>$month_of_delivery,
                                'delivery_year'=>$year_of_delivery,
                                'payment_method'=>$payment_type,
                                'staggered_payment_frequency'=>$payment_frequency
                                
                             
                        ),
                        ("quote_id=$quote_id")
                          
                     );
            
                if($result>0){
                    return true;
                }else{
                 return false;
                 }
             
         }else{
             
             if($this->isNewFuturesSuccessfullyInitiated($quote_id,$requesting_for_a_quote,$is_escrowed,$status,$minimum_number_of_product_to_buy,$whats_product_per_item,$quantity,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency)){
                 return true;
             }else{
                 return false;
             }
         }    
                
                
         
        }
        
        
        /**
         * This is the function that determines if the futures parameters are some with another future 
         */
        public function isTheFuturesConditionParametersSameComparedToAnotherLiveQuote($product_id,$status,$quantity,$is_for_future,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency){
            $model = new Quote;
            //get the previous quote id
            $quote_id = $model->getThisQuoteId($product_id,$status,$quantity,$is_for_future,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency);
            if($quote_id>0){
                 if($this->isThisFutureSameWithThePreviousOneForAnotherLiveQuote($quote_id,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency)){
                return true;
            }else{
                return false;
            }
            }else{
                return false;
            }
           
            
        }
        
        /**
         * This is the function that compares if two futures has same parameters
         */
        public function isThisFutureSameWithThePreviousOneForAnotherLiveQuote($quote_id,$month_of_delivery,$year_of_delivery,$payment_type,$payment_frequency){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='quote_id=:id';
                $criteria->params = array(':id'=>$quote_id);
                $futures= Futures::model()->find($criteria);
                
                if($futures['delivery_month'] == $month_of_delivery){
                    if($futures['delivery_year'] == $year_of_delivery){
                        if($futures['payment_method'] == $payment_type){
                            if($futures['staggered_payment_frequency'] == $payment_frequency){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
        }
        
       
}
