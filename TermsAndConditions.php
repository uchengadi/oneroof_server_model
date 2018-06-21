<?php

/**
 * This is the model class for table "terms_and_conditions".
 *
 * The followings are the available columns in table 'terms_and_conditions':
 * @property string $id
 * @property string $membership_terms_and_conditions
 * @property string $purchase_terms_and_conditions
 * @property string $generic_terms_and_conditions
 * @property string $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class TermsAndConditions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'terms_and_conditions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('membership_terms_and_conditions, purchase_terms_and_conditions, generic_terms_and_conditions, status', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>8),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, membership_terms_and_conditions, purchase_terms_and_conditions, generic_terms_and_conditions, status, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'membership_terms_and_conditions' => 'Membership Terms And Conditions',
			'purchase_terms_and_conditions' => 'Purchase Terms And Conditions',
			'generic_terms_and_conditions' => 'Generic Terms And Conditions',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_user_id' => 'Create User',
			'update_user_id' => 'Update User',
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
		$criteria->compare('membership_terms_and_conditions',$this->membership_terms_and_conditions,true);
		$criteria->compare('purchase_terms_and_conditions',$this->purchase_terms_and_conditions,true);
		$criteria->compare('generic_terms_and_conditions',$this->generic_terms_and_conditions,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TermsAndConditions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that confirms if the existing membership content is deactivated successfully
         */
        public function isTheExistingTermsAndConditionContentStatusDeactivated(){
            
            if($this->isThereAnActivatedTermsAndConditionContent()){
                if($this->isTermsAndConditionContentDeactivationSuccessful()){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
        }
        
        
        /**
         * This is the function that confirms the availability of an active membership content
         */
        public function isThereAnActivatedTermsAndConditionContent(){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('terms_and_conditions')
                    ->where("status='active'");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that deatctivates an active membership content
         */
        public function isTermsAndConditionContentDeactivationSuccessful(){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('terms_and_conditions',
                                  array(
                                    'status'=>'inactive',
                                                             
                            ),
                     ("status='active'"));
            
           if($result>0){
               return true;
           }else{
               return false;
           }
        }
}
