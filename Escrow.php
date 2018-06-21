<?php

/**
 * This is the model class for table "escrow".
 *
 * The followings are the available columns in table 'escrow':
 * @property string $id
 * @property string $escrow_number
 * @property string $product_id
 * @property integer $quote_id
 * @property string $escrow_agreement_file
 * @property integer $is_quoted
 * @property integer $is_futuristic
 * @property string $status
 * @property integer $minimum_number_of_product_to_buy
 * @property string $whats_product_per_item
 * @property integer $quantity
 * @property double $price_per_item
 * @property double $total_amount_purchased
 * @property string $escrow_initiation_date
 * @property string $escrow_acceptance_date
 * @property string $escrow_rejection_date
 * @property string $escrow_expected_date_of_expiry
 * @property integer $escrow_initiated_by
 * @property integer $escrow_requested_by
 * @property integer $escrow_rejected_by
 * @property integer $escrow_accepted_by
 * @property string $direction
 * @property integer $is_invoked
 * @property string $reason_for_invocation
 * @property string $escrow_response_date
 * @property integer $escrow_response_from
 * @property string $escrow_operation_for
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class Escrow extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'escrow';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, status, whats_product_per_item, direction, escrow_operation_for', 'required'),
			array('quote_id, is_quoted, is_futuristic, minimum_number_of_product_to_buy, quantity, escrow_initiated_by, escrow_requested_by, escrow_rejected_by, escrow_accepted_by, is_invoked, escrow_response_from', 'numerical', 'integerOnly'=>true),
			array('price_per_item, total_amount_purchased', 'numerical'),
			array('escrow_number', 'length', 'max'=>200),
			array('product_id, direction', 'length', 'max'=>10),
			array('escrow_agreement_file, whats_product_per_item', 'length', 'max'=>100),
			array('status', 'length', 'max'=>8),
			array('escrow_operation_for', 'length', 'max'=>7),
			array('escrow_initiation_date, escrow_acceptance_date, escrow_rejection_date, escrow_expected_date_of_expiry, reason_for_invocation, escrow_response_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, escrow_number, product_id, quote_id, escrow_agreement_file, is_quoted, is_futuristic, status, minimum_number_of_product_to_buy, whats_product_per_item, quantity, price_per_item, total_amount_purchased, escrow_initiation_date, escrow_acceptance_date, escrow_rejection_date, escrow_expected_date_of_expiry, escrow_initiated_by, escrow_requested_by, escrow_rejected_by, escrow_accepted_by, direction, is_invoked, reason_for_invocation, escrow_response_date, escrow_response_from, escrow_operation_for', 'safe', 'on'=>'search'),
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
			'escrow_number' => 'Escrow Number',
			'product_id' => 'Product',
			'quote_id' => 'Quote',
			'escrow_agreement_file' => 'Escrow Agreement File',
			'is_quoted' => 'Is Quoted',
			'is_futuristic' => 'Is Futuristic',
			'status' => 'Status',
			'minimum_number_of_product_to_buy' => 'Minimum Number Of Product To Buy',
			'whats_product_per_item' => 'Whats Product Per Item',
			'quantity' => 'Quantity',
			'price_per_item' => 'Price Per Item',
			'total_amount_purchased' => 'Total Amount Purchased',
			'escrow_initiation_date' => 'Escrow Initiation Date',
			'escrow_acceptance_date' => 'Escrow Acceptance Date',
			'escrow_rejection_date' => 'Escrow Rejection Date',
			'escrow_expected_date_of_expiry' => 'Escrow Expected Date Of Expiry',
			'escrow_initiated_by' => 'Escrow Initiated By',
			'escrow_requested_by' => 'Escrow Requested By',
			'escrow_rejected_by' => 'Escrow Rejected By',
			'escrow_accepted_by' => 'Escrow Accepted By',
			'direction' => 'Direction',
			'is_invoked' => 'Is Invoked',
			'reason_for_invocation' => 'Reason For Invocation',
			'escrow_response_date' => 'Escrow Response Date',
			'escrow_response_from' => 'Escrow Response From',
			'escrow_operation_for' => 'Escrow Operation For',
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
		$criteria->compare('escrow_number',$this->escrow_number,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('quote_id',$this->quote_id);
		$criteria->compare('escrow_agreement_file',$this->escrow_agreement_file,true);
		$criteria->compare('is_quoted',$this->is_quoted);
		$criteria->compare('is_futuristic',$this->is_futuristic);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('minimum_number_of_product_to_buy',$this->minimum_number_of_product_to_buy);
		$criteria->compare('whats_product_per_item',$this->whats_product_per_item,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price_per_item',$this->price_per_item);
		$criteria->compare('total_amount_purchased',$this->total_amount_purchased);
		$criteria->compare('escrow_initiation_date',$this->escrow_initiation_date,true);
		$criteria->compare('escrow_acceptance_date',$this->escrow_acceptance_date,true);
		$criteria->compare('escrow_rejection_date',$this->escrow_rejection_date,true);
		$criteria->compare('escrow_expected_date_of_expiry',$this->escrow_expected_date_of_expiry,true);
		$criteria->compare('escrow_initiated_by',$this->escrow_initiated_by);
		$criteria->compare('escrow_requested_by',$this->escrow_requested_by);
		$criteria->compare('escrow_rejected_by',$this->escrow_rejected_by);
		$criteria->compare('escrow_accepted_by',$this->escrow_accepted_by);
		$criteria->compare('direction',$this->direction,true);
		$criteria->compare('is_invoked',$this->is_invoked);
		$criteria->compare('reason_for_invocation',$this->reason_for_invocation,true);
		$criteria->compare('escrow_response_date',$this->escrow_response_date,true);
		$criteria->compare('escrow_response_from',$this->escrow_response_from);
		$criteria->compare('escrow_operation_for',$this->escrow_operation_for,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Escrow the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that initiates a transaction escrow
         */
        public function isNewEscrowSuccessfullyInitiated($product_id,$quote_id,$escrow_agreement_filename,$is_quoted,$is_for_future,$status,$minimum_number_of_product_to_buy,$whats_product_per_item,$quantity,$escrow_request_from){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('escrow',
                         array( 'status'=>$status,
                                'product_id'=>$product_id,
                                'quote_id'=>$quote_id,
                                'escrow_agreement_file'=>$escrow_agreement_filename,
                                'minimum_number_of_product_to_buy'=>$minimum_number_of_product_to_buy,
                                'whats_product_per_item'=>$whats_product_per_item,
                                'quantity'=>$quantity,
                                'is_quoted'=>$is_quoted,
                                'escrow_operation_for'=>$escrow_request_from,
                                'is_futuristic'=>$is_for_future,
                                 'escrow_number'=>$this->generateTheEscrowNumberForThisTransaction($quote_id,$product_id),
                                 'escrow_initiation_date'=>new CDbExpression('NOW()'),
                                // 'escrow_expected_date_of_expiry'=>$this->getTheDateOfExpiryOfThisEscrow(),
                                 'escrow_initiated_by'=>Yii::app()->user->id
                                
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        /**
         * This is the function that generates an escrow number
         */
        public function generateTheEscrowNumberForThisTransaction($quote_id,$product_id){
            $model = new Members;
            
            $member_id = Yii::app()->user->id;
             
            $membership_number = $model->getTheMembershipNumberOfThisMember($member_id);
            //get the product code for this quote
            $product_code = $this->getThisProductCode($product_id);
            //get the quote number
            if($quote_id > 0){
                $quote_number = $this->getThisQuoteNumber($quote_id);
                 //obtain the escrow number
                $escrow_number = $product_code.$quote_number.$membership_number;
            }else{
               //get the today's date for this order
                $order_date = $this->getTodayDateForThisOrder();
                 //obtain the escrow number
                $escrow_number = $order_date.$product_code.$membership_number;
            }
     
                       
             if($this->isThisEscrowNumberAlreadyInExistence($escrow_number)){
                return($escrow_number.$this->uniqueNumberDifferentiator());
            }else{
                return $escrow_number;
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
        public function getThisProductCode($product_id){
            $model = new Product;
            return $model->getThisProductCode($product_id);
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
        public function isThisEscrowNumberAlreadyInExistence($escrow_number){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('escrow')
                    ->where("escrow_number = '$escrow_number'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
            
        }
        
        
        /**
         * This is the function that moves an escrow agreement form to its path
         */
        public function moveTheEscrowAgreementToItsPathAndReturnItsFileName($escrow_filename){
            
         
            if(isset($_FILES['escrow_agreement_file']['name'])){
                        $tmpName = $_FILES['escrow_agreement_file']['tmp_name'];
                        $escrowName = $_FILES['escrow_agreement_file']['name'];    
                        $escrowType = $_FILES['escrow_agreement_file']['type'];
                        $escrowSize = $_FILES['escrow_agreement_file']['size'];
                  
                   }
                    
                    if($escrowName !== null) {
                             if($escrow_filename != null || $escrow_filename != ""){
                                $escrowFileName = time().'_'.$escrow_filename;  
                            }else{
                                $escrowFileName = $escrow_filename;  
                            }
                          
                           // upload the icon file
                        if($escrowName !== null){
                            	$escrowPath = Yii::app()->params['escrow'].$escrowFileName;
				move_uploaded_file($tmpName,  $escrowPath);
                                        
                        
                                return $escrowFileName;
                        }else{
                            $escrowFileName = $escrow_filename;
                            return $escrowFileName;
                        } // validate to save file
                        
                      
                     }else{
                         $escrowFileName = $escrow_filename;
                         return $escrowFileName;
                     }
        }
        
        
         /**
         * This is the function that determines if a live product subscription is available 
         */
        public function hasTheEscrowOfThisSubscriptionAlreadyInitiated($member_id,$status,$product_id,$escrow_operation_for){
           
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('escrow')
                    ->where("(status = '$status' and escrow_operation_for='$escrow_operation_for') and (product_id=$product_id and escrow_initiated_by=$member_id)");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        
         /**
         * This is the function that confirms if an escrow facility is associated to a quote
         */
        public function isThereAnAssociatedEscrowToThisQuote($quote_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('escrow')
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
        public function isTheRemovalOfThisAssociatedEscrowSuccessful($quote_id){
           $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('escrow', 'quote_id=:quoteid', array(':quoteid'=>$quote_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function tht effects a modification to an escrow
         */
        public function isEscrowSuccessfullyUpdated($product_id,$quote_id,$escrow_agreement_filename,$requesting_for_a_quote,$is_for_future,$status,$minimum_number_of_product_to_buy,$whats_product_per_item,$quantity){
            
            if($this->isThereAnAssociatedEscrowToThisQuote($quote_id)){
                if($escrow_agreement_filename == ""){
                
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('escrow',
                         array('is_quoted'=>$requesting_for_a_quote,
                                'is_futuristic'=>$is_for_future,
                                'quantity'=>$quantity,
                                
                             
                        ),
                        ("quote_id=$quote_id")
                          
                     );
            
                if($result>0){
                    return true;
                }else{
                 return false;
                 }
                
             }else{
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('escrow',
                         array('is_quoted'=>$requesting_for_a_quote,
                                'is_futuristic'=>$is_for_future,
                                'quantity'=>$quantity,
                                'escrow_agreement_file'=>$escrow_agreement_filename
                             
                        ),
                        ("quote_id=$quote_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
             }
                
            }else{
                if($this->isNewEscrowSuccessfullyInitiated($product_id,$quote_id,$escrow_agreement_filename,$requesting_for_a_quote,$is_for_future,$status,$minimum_number_of_product_to_buy,$whats_product_per_item,$quantity)){
                    return true;
                }else{
                    return false;
                }
            }
            
        }
        
        /**
         * This is the function that determines if escrow is modifiable
         */
        public function isThisEscrowModifiable($escrow_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('escrow')
                    ->where("id = $escrow_id and status='live'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that determines if escrow is cancellable
         */
        public function isThisEscrowCancellable($escrow_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('escrow')
                    ->where("id = $escrow_id and status='live'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that determines if modifying an escrow is a success
         */
        public function isModifyingThisEscrowAtEscrowASuccess($escrow_id,$quantity,$new_escrow_agreement_file,$amount_to_be_paid){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('escrow',
                         array(
                                'quantity'=>$quantity,
                                'escrow_agreement_file'=>$new_escrow_agreement_file,
                                'total_amount_purchased'=>$amount_to_be_paid
                             
                        ),
                        ("id=$escrow_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
         /**
         * This is the function that determines if modifying an escrow without the escrow file is a success
         */
        public function isModifyingThisEscrowAtEscrowWithoutFileASuccess($escrow_id,$quantity,$amount_to_be_paid){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('escrow',
                         array(
                                'quantity'=>$quantity,
                                'total_amount_purchased'=>$amount_to_be_paid
                                                             
                        ),
                        ("id=$escrow_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if cancelling an escrow is a success
         */
        public function isCancellingThisEscrowAtEscrowASuccess($escrow_id){
            
          $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('escrow', 'id=:id', array(':id'=>$escrow_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if escrow is invokable
         */
        public function isThisEscrowInvokable($escrow_id){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('escrow')
                    ->where("id = $escrow_id and status='accepted'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that invokes an escrow
         */
        public function isTheInvocationOfThisEscrowASuccess($escrow_id,$reason_for_invocation,$accepted_escrow_invocation_terms){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('escrow',
                         array(
                                'accepted_escrow_invocation_terms'=>$accepted_escrow_invocation_terms,
                                'reason_for_invocation'=>$reason_for_invocation,
                                'status'=>strtolower('invoked'),
                                'is_invoked'=>1,
                                'escrow_invocation_date'=>new CDbExpression('NOW()'),
                                'escrow_invoked_by'=>Yii::app()->user->id
                                                             
                        ),
                        ("id=$escrow_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that gets the escrow value of a transaction
         */
        public function getTheEscrowChargeForThisTransaction($escrow_id){
                
                $escrow_charge = 0;
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$escrow_id);
                $escrow= Escrow::model()->find($criteria);
                
                if($escrow['quote_id'] == 0){
                    $escrow_charge = $this->getTheApplicableEscrowForNonQuotedTransaction($escrow['total_amount_purchased']);
                }else{
                    $escrow_charge = $this->getTheApplicableEscrowForQuotedTransaction($escrow['quote_id']);
                }
                return $escrow_charge;
        }
        
        
        /**
         * This is the function that get the escrow charge for a non-quoted transaction
         */
        public function getTheApplicableEscrowForNonQuotedTransaction($total_amount_purchased){
            $model = new PlatformSettings;
            
            $escrow_charge = $total_amount_purchased * ($model->getTheApplicableEscrowRate()/100);
            if($escrow_charge >= $model->getTheMinimumApplicableEscrowAmount()){
                return $escrow_charge;
            }else{
                return $model->getTheMinimumApplicableEscrowAmount();
            }
            
        }
        
        /**
         * This is the function that gets the escrow amount for a quoted transaction 
         */
        public function getTheApplicableEscrowForQuotedTransaction($quote_id){
            $model = new PlatformSettings;
            
             $escrow_charge = $this->getTheTotalAmountQuotedForThisQuote($quote_id) * ($model->getTheApplicableEscrowRate()/100);
            if($escrow_charge >= $model->getTheMinimumApplicableEscrowAmount()){
                return $escrow_charge;
            }else{
                return $model->getTheMinimumApplicableEscrowAmount();
            }
            
            
        }
        
        
        /**
         * This is the function that gets the escrow id of a quoted escrow
         */
        public function getTheEscrowIdOfThisQuote($quote_id){
           
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='quote_id=:id';
                $criteria->params = array(':id'=>$quote_id);
                $escrow= Escrow::model()->find($criteria);
                
                return $escrow['id'];
        }
        
        
        /**
         * This is the function that gets the total amount quoted for a transaction 
         */
        public function getTheTotalAmountQuotedForThisQuote($quote_id){
            $model = new QuoteHasResponse;
            return $model->getTheTotalAmountQuotedForThisQuote($quote_id);
        }
        
        
        
}
