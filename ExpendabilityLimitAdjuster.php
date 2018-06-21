<?php

/**
 * This is the model class for table "expendability_limit_adjuster".
 *
 * The followings are the available columns in table 'expendability_limit_adjuster':
 * @property string $id
 * @property string $wallet_id
 * @property string $order_id
 * @property string $product_id
 * @property double $previous_limit
 * @property double $current_limit
 * @property string $adjusted_at
 * @property string $date_adjusted
 * @property string $date_reconstructed
 * @property integer $adjusted_by
 * @property integer $reconstructed_by
 *
 * The followings are the available model relations:
 * @property Order $order
 * @property Product $product
 * @property Wallet $wallet
 */
class ExpendabilityLimitAdjuster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'expendability_limit_adjuster';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_id, order_id, product_id, adjusted_at', 'required'),
			array('adjusted_by, reconstructed_by', 'numerical', 'integerOnly'=>true),
			array('previous_limit, current_limit', 'numerical'),
			array('wallet_id, order_id, product_id', 'length', 'max'=>10),
			array('adjusted_at', 'length', 'max'=>8),
			array('date_adjusted, date_reconstructed', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wallet_id, order_id, product_id, previous_limit, current_limit, adjusted_at, date_adjusted, date_reconstructed, adjusted_by, reconstructed_by', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'Order', 'order_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'wallet' => array(self::BELONGS_TO, 'Wallet', 'wallet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wallet_id' => 'Wallet',
			'order_id' => 'Order',
			'product_id' => 'Product',
			'previous_limit' => 'Previous Limit',
			'current_limit' => 'Current Limit',
			'adjusted_at' => 'Adjusted At',
			'date_adjusted' => 'Date Adjusted',
			'date_reconstructed' => 'Date Reconstructed',
			'adjusted_by' => 'Adjusted By',
			'reconstructed_by' => 'Reconstructed By',
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
		$criteria->compare('wallet_id',$this->wallet_id,true);
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('previous_limit',$this->previous_limit);
		$criteria->compare('current_limit',$this->current_limit);
		$criteria->compare('adjusted_at',$this->adjusted_at,true);
		$criteria->compare('date_adjusted',$this->date_adjusted,true);
		$criteria->compare('date_reconstructed',$this->date_reconstructed,true);
		$criteria->compare('adjusted_by',$this->adjusted_by);
		$criteria->compare('reconstructed_by',$this->reconstructed_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExpendabilityLimitAdjuster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
         /**
         * This is the function that registers limit adjusters and confirm its success
         */
        public function isTheRegistrationOfThisLimitAdjustmentASuccess($wallet_id,$order_id,$product_id,$product_expensibility_limit,$new_expensibility_limit,$product_expensibility_limit_from){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('expendability_limit_adjuster',
                         array( 
                             'wallet_id'=>$wallet_id,
                             'order_id'=>$order_id,
                             'product_id'=>$product_id,
                             'previous_limit'=>$product_expensibility_limit,
                             'current_limit'=>$new_expensibility_limit,
                             'adjusted_at'=>strtolower($product_expensibility_limit_from),
                             'date_adjusted'=>new CDbExpression('NOW()'),
                             'adjusted_by'=>Yii::app()->user->id
                                
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
        
        
        /**
         * This is the function that confirms if the reconstruction of a produvt limiter is a success
         */
        public function isTheExpendibilityLimitReconstructionSuccessful($wallet_id,$order_id){
            
            $model = new WalletHasCategoryExpendableLimit;

            //get all the products to be reconstructed
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid and order_id=:orderid';
            $criteria->params = array(':walletid'=>$wallet_id,':orderid'=>$order_id);
            $limits= ExpendabilityLimitAdjuster::model()->findAll($criteria);
            $counter = 0;
            foreach($limits as $limit){
                if($limit['adjusted_at'] == strtolower('category')){
                    $category_id = $this->getTheCategoryIdOfThisProduct($limit['product_id']);
                    if($model->isThisCategoryLimitReconstructionASuccess($wallet_id,$category_id,$limit['previous_limit'])){
                        $counter = $counter + 1;
                    }
                }else if($limit['adjusted_at'] == strtolower('product')){
                    if($this->isProductLimitReconstructionASuccess($wallet_id,$limit['product_id'],$limit['previous_limit'])){
                        $counter = $counter + 1;
                    }
                }
                
            }
            if($counter>0){
                if($this->isThisExpendibilityLimitReconstructionASuccess($wallet_id,$order_id)){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
                    
                    
        }
        
        
        /**
         * This is the function that confirms if an expendibility reconstruction is a success
         */
        public function isThisExpendibilityLimitReconstructionASuccess($wallet_id,$order_id){
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('expendability_limit_adjuster',
                                  array(
                                     'date_reconstructed'=>new CDbExpression('NOW()'),
                                      'reconstructed_by'=>Yii::app()->user->id
                                                             
                            ),
                     ("wallet_id=$wallet_id and order_id=$order_id"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
        
        
        /**
         * This is the function that confirms if a product limiter reconstruction is a success
         */
        public function isProductLimitReconstructionASuccess($wallet_id,$product_id,$previous_limit){
            $model = new WalletHasProductExpendableLimit;
            return $model->isProductLimitReconstructionASuccess($wallet_id,$product_id,$previous_limit);
        }
        
        /**
         * This is the function that gets the category id of a product
         */
        public function getTheCategoryIdOfThisProduct($product_id){
            $model = new Product;
            return $model->getTheCategoryIdOfThisProduct($product_id);
        }
}
