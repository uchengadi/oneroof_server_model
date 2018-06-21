<?php

/**
 * This is the model class for table "wallet_adjuster".
 *
 * The followings are the available columns in table 'wallet_adjuster':
 * @property string $id
 * @property string $wallet_id
 * @property string $order_id
 * @property string $voucher_id
 * @property double $previous_voucher_available_balance
 * @property double $previous_voucher_used_balance
 * @property double $current_voucher_available_balance
 * @property double $current_voucher_used_balance
 * @property string $date_adjusted
 * @property string $date_reconstructed
 * @property integer $adjusted_by
 * @property integer $reconstructed_by
 *
 * The followings are the available model relations:
 * @property Order $order
 * @property Voucher $voucher
 * @property Wallet $wallet
 */
class WalletAdjuster extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wallet_adjuster';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_id, order_id, voucher_id', 'required'),
			array('adjusted_by, reconstructed_by', 'numerical', 'integerOnly'=>true),
			array('previous_voucher_available_balance, previous_voucher_used_balance, current_voucher_available_balance, current_voucher_used_balance', 'numerical'),
			array('wallet_id, order_id, voucher_id', 'length', 'max'=>10),
			array('date_adjusted, date_reconstructed', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wallet_id, order_id, voucher_id, previous_voucher_available_balance, previous_voucher_used_balance, current_voucher_available_balance, current_voucher_used_balance, date_adjusted, date_reconstructed, adjusted_by, reconstructed_by', 'safe', 'on'=>'search'),
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
			'voucher' => array(self::BELONGS_TO, 'Voucher', 'voucher_id'),
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
			'voucher_id' => 'Voucher',
			'previous_voucher_available_balance' => 'Previous Voucher Available Balance',
			'previous_voucher_used_balance' => 'Previous Voucher Used Balance',
			'current_voucher_available_balance' => 'Current Voucher Available Balance',
			'current_voucher_used_balance' => 'Current Voucher Used Balance',
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
		$criteria->compare('voucher_id',$this->voucher_id,true);
		$criteria->compare('previous_voucher_available_balance',$this->previous_voucher_available_balance);
		$criteria->compare('previous_voucher_used_balance',$this->previous_voucher_used_balance);
		$criteria->compare('current_voucher_available_balance',$this->current_voucher_available_balance);
		$criteria->compare('current_voucher_used_balance',$this->current_voucher_used_balance);
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
	 * @return WalletAdjuster the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that registers adjustments of a wallet
         */
        public function isTheRegistrationOfThisWalletAdjustmentASuccess($wallet_id,$order_id,$voucher_id,$voucher_available_value,$used_voucher_value,$new_voucher_available_value,$new_used_voucher_value){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->insert('wallet_adjuster',
                         array( 
                             'wallet_id'=>$wallet_id,
                             'order_id'=>$order_id,
                             'voucher_id'=>$voucher_id,
                             'previous_voucher_available_balance'=>$voucher_available_value,
                             'previous_voucher_used_balance'=>$used_voucher_value,
                             'current_voucher_available_balance'=>$new_voucher_available_value,
                             'current_voucher_used_balance'=>$new_used_voucher_value,
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
         * This is the function that confirms if a wallet reconstruction was successful after wallet adjustment
         */
        public function isTheWalletReconstructionSuccessful($wallet_id,$order_id){
            
            $model = new WalletHasVouchers;
            //get all the vouchers to be reconstructed
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $criteria->condition='wallet_id=:walletid and order_id=:orderid';
            $criteria->params = array(':walletid'=>$wallet_id,':orderid'=>$order_id);
            $adjustables= WalletAdjuster::model()->findAll($criteria);
            
            $counter = 0;
            foreach($adjustables as $adjustable){
                if($model->isTheReconstructionOfThisVoucherASuccess($wallet_id,$adjustable['voucher_id'],$adjustable['previous_voucher_available_balance'],$adjustable['previous_voucher_used_balance'])){
                    $counter = $counter + 0;
                }
            }
            if($counter>0){
                if($this->isThisWalletReconstructionASuccess($wallet_id,$order_id)){
                  return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
            
        }
        
        /**
         * This is the function that confirms the success of a wallet reconstruction after an adjustment
         */
        public function isThisWalletReconstructionASuccess($wallet_id,$order_id){
             $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('wallet_adjuster',
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
}
