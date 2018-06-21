<?php

/**
 * This is the model class for table "undelivered_ordered_products".
 *
 * The followings are the available columns in table 'undelivered_ordered_products':
 * @property string $id
 * @property string $wallet_id
 * @property string $order_id
 * @property string $product_id
 * @property double $product_total_cost
 * @property double $product_delivery_cost
 * @property string $date_registered
 * @property integer $registered_by
 *
 * The followings are the available model relations:
 * @property Order $order
 * @property Product $product
 * @property Wallet $wallet
 */
class UndeliveredOrderedProducts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'undelivered_ordered_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_id, order_id, product_id', 'required'),
			array('registered_by', 'numerical', 'integerOnly'=>true),
			array('product_total_cost, product_delivery_cost', 'numerical'),
			array('wallet_id, order_id, product_id', 'length', 'max'=>10),
			array('date_registered', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wallet_id, order_id, product_id, product_total_cost, product_delivery_cost, date_registered, registered_by', 'safe', 'on'=>'search'),
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
			'product_total_cost' => 'Product Total Cost',
			'product_delivery_cost' => 'Product Delivery Cost',
			'date_registered' => 'Date Registered',
			'registered_by' => 'Registered By',
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
		$criteria->compare('product_total_cost',$this->product_total_cost);
		$criteria->compare('product_delivery_cost',$this->product_delivery_cost);
		$criteria->compare('date_registered',$this->date_registered,true);
		$criteria->compare('registered_by',$this->registered_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UndeliveredOrderedProducts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that registers the undelivered products in an order due to payment settlement
         */
        public function isTheRegistrationOfNonSettledProductASuccess($wallet_id,$order_id,$product_id,$cost_of_this_product,$total_delivery_cost,$product_settlement_from){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('undelivered_ordered_products',
                         array( 
                             'wallet_id'=>$wallet_id,
                             'order_id'=>$order_id,
                             'product_id'=>$product_id,
                             'product_total_cost'=>$cost_of_this_product,
                             'product_delivery_cost'=>$total_delivery_cost,
                             'settlement_from'=>strtolower($product_settlement_from),
                             'remark'=>'Insufficient fund',
                             'date_registered'=>new CDbExpression('NOW()'),
                             'registered_by'=>Yii::app()->user->id
                                
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
        }
}
