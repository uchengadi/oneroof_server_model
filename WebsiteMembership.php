<?php

/**
 * This is the model class for table "website_membership".
 *
 * The followings are the available columns in table 'website_membership':
 * @property string $id
 * @property string $introduction
 * @property string $membership_basic
 * @property string $membership_business
 * @property string $membership_dons
 * @property string $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class WebsiteMembership extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'website_membership';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('introduction, membership_basic, membership_business, membership_basic_prime,membership_business_prime, status', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>8),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, introduction, membership_basic, membership_business, membership_dons, status, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'introduction' => 'Introduction',
			'membership_basic' => 'Membership Basic',
			'membership_business' => 'Membership Business',
			'membership_dons' => 'Membership Dons',
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
		$criteria->compare('introduction',$this->introduction,true);
		$criteria->compare('membership_basic',$this->membership_basic,true);
		$criteria->compare('membership_business',$this->membership_business,true);
		$criteria->compare('membership_dons',$this->membership_dons,true);
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
	 * @return WebsiteMembership the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that confirms if the existing membership content is deactivated successfully
         */
        public function isTheExistingMembershipContentStatusDeactivated(){
            
            if($this->isThereAnActivatedMembershipContent()){
                if($this->isMembershipContentDeactivationSuccessful()){
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
        public function isThereAnActivatedMembershipContent(){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('website_membership')
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
        public function isMembershipContentDeactivationSuccessful(){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('website_membership',
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
