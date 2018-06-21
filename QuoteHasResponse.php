<?php

/**
 * This is the model class for table "quote_has_response".
 *
 * The followings are the available columns in table 'quote_has_response':
 * @property string $quote_id
 * @property string $member_id
 * @property string $status
 * @property integer $is_quote_escrowed
 * @property integer $is_quote_for_future
 * @property integer $is_escrow_terms_accepted
 * @property integer $is_future_facility_terms_accepted
 * @property integer $is_platform_quotation_terms_accepted
 * @property string $quotation_file
 * @property string $date_quotation_was_sent
 * @property integer $quotation_sent_by
 * @property double $total_amount_quoted
 */
class QuoteHasResponse extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'quote_has_response';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quote_id, member_id, status', 'required'),
			array('is_quote_escrowed, is_quote_for_future, is_escrow_terms_accepted, is_future_facility_terms_accepted, is_platform_quotation_terms_accepted, quotation_sent_by', 'numerical', 'integerOnly'=>true),
			array('total_amount_quoted', 'numerical'),
			array('quote_id, member_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>8),
			array('quotation_file', 'length', 'max'=>100),
			array('date_quotation_was_sent', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('quote_id, member_id, status, is_quote_escrowed, is_quote_for_future, is_escrow_terms_accepted, is_future_facility_terms_accepted, is_platform_quotation_terms_accepted, quotation_file, date_quotation_was_sent, quotation_sent_by, total_amount_quoted', 'safe', 'on'=>'search'),
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
			'quote_id' => 'Quote',
			'member_id' => 'Member',
			'status' => 'Status',
			'is_quote_escrowed' => 'Is Quote Escrowed',
			'is_quote_for_future' => 'Is Quote For Future',
			'is_escrow_terms_accepted' => 'Is Escrow Terms Accepted',
			'is_future_facility_terms_accepted' => 'Is Future Facility Terms Accepted',
			'is_platform_quotation_terms_accepted' => 'Is Platform Quotation Terms Accepted',
			'quotation_file' => 'Quotation File',
			'date_quotation_was_sent' => 'Date Quotation Was Sent',
			'quotation_sent_by' => 'Quotation Sent By',
			'total_amount_quoted' => 'Total Amount Quoted',
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

		$criteria->compare('quote_id',$this->quote_id,true);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('is_quote_escrowed',$this->is_quote_escrowed);
		$criteria->compare('is_quote_for_future',$this->is_quote_for_future);
		$criteria->compare('is_escrow_terms_accepted',$this->is_escrow_terms_accepted);
		$criteria->compare('is_future_facility_terms_accepted',$this->is_future_facility_terms_accepted);
		$criteria->compare('is_platform_quotation_terms_accepted',$this->is_platform_quotation_terms_accepted);
		$criteria->compare('quotation_file',$this->quotation_file,true);
		$criteria->compare('date_quotation_was_sent',$this->date_quotation_was_sent,true);
		$criteria->compare('quotation_sent_by',$this->quotation_sent_by);
		$criteria->compare('total_amount_quoted',$this->total_amount_quoted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QuoteHasResponse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * This is the function that confirms if a member had already responded to a quote
         */
        public function hasMemberNotAlreadyRespondedToThisQuote($member_id,$quote_id){
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('quote_has_response')
                    ->where("quote_id = $quote_id and member_id=$member_id");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        
        /**
         * This is the function that sends a quotation for a quote request
         */
        public function isTheSendingOfThisQuotationASuccess($quote_id,$is_quote_escrowed,$is_quote_for_future,$total_amount_quoted,$is_platform_quotation_terms_accepted,$status,$quotation_file,$video_filename,$is_with_video,$member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('quote_has_response',
                         array( 'status'=>$status,
                                'quote_id'=>$quote_id,
                                'member_id'=>$member_id,
                                'is_quote_escrowed'=>$is_quote_escrowed,
                                'is_quote_for_future'=>$is_quote_for_future,
                                'is_escrow_terms_accepted'=>$is_quote_escrowed,
                                'is_future_facility_terms_accepted'=>$is_quote_for_future,
                                'total_amount_quoted'=>$total_amount_quoted,
                                'quotation_file'=>$quotation_file,
                                'video_filename'=>$video_filename,
                                'is_with_video'=>$is_with_video,                             
                                'is_platform_quotation_terms_accepted'=>$is_platform_quotation_terms_accepted,
                                'date_quotation_was_sent'=>new CDbExpression('NOW()'),
                                'quotation_sent_by'=>Yii::app()->user->id
        
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
            
        }
        
        /**
         * This is the function that moves quotation file to its path and returns its filename
         */
        public function moveTheQuotationAgreementToItsPathAndReturnItsFileName($quotation_filename){
            
            if(isset($_FILES['quotation_file']['name'])){
                        $tmpName = $_FILES['quotation_file']['tmp_name'];
                        $quotationName = $_FILES['quotation_file']['name'];    
                        $quotationType = $_FILES['quotation_file']['type'];
                        $quotationSize = $_FILES['quotation_file']['size'];
                  
                   }
                    
                    if($quotationName !== null) {
                             if($quotation_filename != null || $quotation_filename != ""){
                                $quotationFileName = time().'_'.$quotation_filename;  
                            }else{
                                $quotationFileName = $quotation_filename;  
                            }
                          
                           // upload the icon file
                        if($quotationName !== null){
                            	$escrowPath = Yii::app()->params['quotation'].$quotationFileName;
				move_uploaded_file($tmpName,  $escrowPath);
                                        
                        
                                return $quotationFileName;
                        }else{
                            $quotationFileName = $quotation_filename;
                            return $quotationFileName;
                        } // validate to save file
                        
                      
                     }else{
                         $quotationFileName = $quotation_filename;
                         return $quotationFileName;
                     }
        }
        
        
        
        /**
         * This is the function that determines the total amount in quotations that this member had made 
         */
        public function getTheTotalAmountOfQuotesHandledByMemberInThisMonth($member_id){
            
            $total_monthly_amount = 0;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid';
             $criteria->params = array(':memberid'=>$member_id);
             $quotes= QuoteHasResponse::model()->findAll($criteria);
                
             foreach($quotes as $quote){
                 if($this->isTransactionDoneThisMonth($quote['date_quotation_was_sent'])){
                     $total_monthly_amount = $total_monthly_amount + $quote['total_amount_quoted'];
                 }
             } 
             return $total_monthly_amount;
        }
        
        
        /**
         * This is the function that determines the total amount in quotation this member had done
         */
        public function getTheTotalAmountOfQuotesHandledByThisMemberToday($member_id,$today){
            
            $total_daily_amount = 0;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='member_id=:memberid';
             $criteria->params = array(':memberid'=>$member_id);
             $quotes= QuoteHasResponse::model()->findAll($criteria);
                
             foreach($quotes as $quote){
                 if($this->isTransactionDoneToday($quote['date_quotation_was_sent'],$today)){
                     $total_daily_amount = $total_daily_amount + $quote['total_amount_quoted'];
                 }
             } 
             return $total_daily_amount;
        }
        
        
        
        /**
         * This is the function that confirms if  a transaction was done today
         */
        public function isTransactionDoneToday($date_quotation_was_sent,$today){
            
          // $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
             $date_of_quotation = getdate(strtotime($date_quotation_was_sent));
             
             if(($today['year'] - $date_of_quotation['year'])>1 ){
                 return false;
             }else{
                 if(($today['mon'] - $date_of_quotation['mon'])>1){
                     return false;
                 }else{
                     if(($today['mday'] - $date_of_quotation['mday'])>1){
                         return false;
                     }else{
                         return true;
                     }
                     
                 }
             }
        }
        
        
         /**
         * This is the function that confirms if  a transaction was done this month
         */
        public function isTransactionDoneThisMonth($date_quotation_was_sent){
            
             $today = getdate(mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
             $date_of_quotation = getdate(strtotime($date_quotation_was_sent));
             
             if(($today['year'] - $date_of_quotation['year'])>1 ){
                 return false;
             }else{
                 if(($today['mon'] - $date_of_quotation['mon'])>1){
                     return false;
                 }else{
                     return true;
                     
                     
                 }
             }
        }
         
           /**
            * This is the function that effects accptance decision on a quote response
            */  
        public function isAcceptingThisQuoteResponseASuccess($quote_id,$member_id){
            
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('quote_has_response',
                                  array(
                                    'status'=>'accepted',
                                                             
                            ),
                     ("quote_id=$quote_id and member_id=$member_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
          /**
            * This is the function that effects accptance decision on a quote response
            */  
        public function isRejectingThisQuoteResponseASuccess($quote_id,$member_id){
            
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('quote_has_response',
                                  array(
                                    'status'=>'rejected',
                                                             
                            ),
                     ("quote_id=$quote_id and member_id=$member_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
       
        
        /**
         * This is the function that gets the delivery cost of a quote
         */
        public function getTheCostOfDeliveryOfThisQuote($quote_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='quote_id=:quoteid';
             $criteria->params = array(':quoteid'=>$quote_id);
             $quotes= QuoteHasResponse::model()->findAll($criteria);
             
             foreach($quotes as $quote){
                 if($quote['status'] == strtolower('accepted')){
                     return $quote['delivery_cost'];
                 }
             }
             return 0;
        }
        
        
        /**
         * This is the function that gets the total quoted amount for a quote
         */
        public function getTheTotalAmountQuotedForThisQuote($quote_id){
            
                 
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='quote_id=:quoteid';
             $criteria->params = array(':quoteid'=>$quote_id);
             $quotes= QuoteHasResponse::model()->findAll($criteria);
             
             foreach($quotes as $quote){
                 if($quote['status'] == strtolower('accepted')){
                     return $quote['total_amount_quoted'];
                 }
             }
             return 0;
        }
        
        
        /**
         * This is the function that automatically adds the accepted quote to cart
         */
        public function isTheAdditionOfThisQuoteToCartSuccessful($quote_id){
            
            $model = new Quote;
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='quote_id=:quoteid';
             $criteria->params = array(':quoteid'=>$quote_id);
             $quotes= QuoteHasResponse::model()->findAll($criteria);
             
             foreach($quotes as $quote){
                 if($quote['status'] == strtolower('accepted')){
                     //add this quote to cart
                     if($model->isThisQuoteSuccessfullyAddedToTheCart($quote_id,$quote['is_quote_escrowed'],$quote['is_escrow_terms_accepted'],$quote['total_amount_quoted'],$quote['delivery_cost'])){
                         return true;
                     }else{
                         return false;
                     }
                 }
             }
        }
        
        
        /**
         * This is the function that moves a quotation video file to its path and return its name
         */
        public function moveTheQuotationVideoToItsPathAndReturnItsName($video_filename){
            
            if(isset($_FILES['video_filename']['name'])){
                        $tmpName = $_FILES['video_filename']['tmp_name'];
                        $videoName = $_FILES['video_filename']['name'];    
                        $videoType = $_FILES['video_filename']['type'];
                        $videoSize = $_FILES['video_filename']['size'];
                  
                   }
                   
                   if($videoName !== null) {
                             if($video_filename != null || $video_filename != ""){
                                $videoFileName = time().'_'.$video_filename;  
                            }else{
                                $videoFileName = $video_filename;  
                            }
                          
                           // upload the icon file
                        if($videoName !== null){
                            	$videoPath = Yii::app()->params['video'].$videoFileName;
				move_uploaded_file($tmpName,  $videoPath);
                                        
                        
                                return $videoFileName;
                        }else{
                            $videoFileName = $video_filename;
                            return $videoFileName;
                        } // validate to save file
                        
                      
                     }else{
                         $videoFileName = $video_filename;
                         return $videoFileName;
                     }
                     
                     
                    
                   }
                   
                   
                    /**
         * This is the function that determines the type and size of video file
         */
        public function isVideoFileTypeAndSizeLegal(){
            $model = new PlatformSettings;
           if(isset($_FILES['video_filename']['name'])){
                $tmpName = $_FILES['video_filename']['tmp_name'];
                $videoFileName = $_FILES['video_filename']['name'];    
                $videoFileType = $_FILES['video_filename']['type'];
                $videoFileSize = $_FILES['video_filename']['size'];
            } 
         
            if($videoFileSize<=$model->getTheMaximumVideoSizeForThisService()){
                 if($videoFileType == 'video/mp4'){
                      return true;
                   }else{
                        return false;
            }
            }else{
                return false;
            }
      
        }
        
        
        
}
