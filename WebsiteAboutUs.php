<?php

/**
 * This is the model class for table "website_about_us".
 *
 * The followings are the available columns in table 'website_about_us':
 * @property string $id
 * @property string $introduction
 * @property string $who_we_are
 * @property string $who_we_serve
 * @property string $our_mission_and_vision
 * @property string $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 * @property integer $update_user_id
 */
class WebsiteAboutUs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'website_about_us';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('introduction, who_we_are, who_we_serve, our_mission_and_vision, status', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>8),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, introduction, who_we_are, who_we_serve, our_mission_and_vision, status, create_time, update_time, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'who_we_are' => 'Who We Are',
			'who_we_serve' => 'Who We Serve',
			'our_mission_and_vision' => 'Our Mission And Vision',
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
		$criteria->compare('who_we_are',$this->who_we_are,true);
		$criteria->compare('who_we_serve',$this->who_we_serve,true);
		$criteria->compare('our_mission_and_vision',$this->our_mission_and_vision,true);
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
	 * @return WebsiteAboutUs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that confirms if the existing about us content is deactivated successfully
         */
        public function isTheExistingAboutUsStatusDeactivated(){
            
            if($this->isThereAnActivatedAboutUs()){
                if($this->isAboutUsDeactivationSuccessful()){
                    return true;
                }else{
                    return false;
                }
                
            }else{
                return true;
            }
        }
        
        
        /**
         * This is the function that confirms the availability of an active about us
         */
        public function isThereAnActivatedAboutUs(){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('website_about_us')
                    ->where("status='active'");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that deatctivates an active about us
         */
        public function isAboutUsDeactivationSuccessful(){
            
            $cmd =Yii::app()->db->createCommand();
                $result = $cmd->update('website_about_us',
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
