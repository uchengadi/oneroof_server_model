<?php

/**
 * This is the model class for table "country".
 *
 * The followings are the available columns in table 'country':
 * @property string $id
 * @property string $name
 * @property string $continent
 * @property string $description
 * @property integer $enable_vat_collection
 * @property string $prevailing_vat_policy
 * @property string $flag
 * @property string $country_code
 * @property integer $flag_size
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Banker[] $bankers
 * @property Currencies[] $currencies
 * @property Member[] $members
 * @property State[] $states
 * @property Stores[] $stores
 */
class Country extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('enable_vat_collection, flag_size, create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('continent', 'length', 'max'=>13),
			//array('description', 'length', 'max'=>150),
			array('prevailing_vat_policy', 'length', 'max'=>47),
			array('flag', 'length', 'max'=>40),
			array('country_code', 'length', 'max'=>6),
			array('description,create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, continent, description, enable_vat_collection, prevailing_vat_policy, flag, country_code, flag_size, create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
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
			'bankers' => array(self::MANY_MANY, 'Banker', 'bank_collect_for_country(country_id, bank_id)'),
			'currencies' => array(self::HAS_MANY, 'Currencies', 'country_id'),
			'members' => array(self::HAS_MANY, 'Member', 'country_id'),
			'states' => array(self::HAS_MANY, 'State', 'country_id'),
			'stores' => array(self::HAS_MANY, 'Stores', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'continent' => 'Continent',
			'description' => 'Description',
			'enable_vat_collection' => 'Enable Vat Collection',
			'prevailing_vat_policy' => 'Prevailing Vat Policy',
			'flag' => 'Flag',
			'country_code' => 'Country Code',
			'flag_size' => 'Flag Size',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('continent',$this->continent,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('enable_vat_collection',$this->enable_vat_collection);
		$criteria->compare('prevailing_vat_policy',$this->prevailing_vat_policy,true);
		$criteria->compare('flag',$this->flag,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('flag_size',$this->flag_size);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that determines if vat collection is enabled for a country
         */
        public function isVatEnabledForThisCountry($id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $country= Country::model()->find($criteria);
             
             if($country['enable_vat_collection'] == true){
                 return true;
             }else{
                 return false;
             }
            
        }
        
        
        /**
         * This is the function that gets the default vat rate for this country
         */
        public function getTheDefaultVatRateForThisCountry($id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $country= Country::model()->find($criteria);
             
             return $country['country_default_vat_rate'];
            
        }
        
        
        /**
         * This is the function that retrieves the first two letters of a country code
         */
        public function getThisCountryFirstTwoLettetCode($id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $country= Country::model()->find($criteria);
             
             return substr($country['country_code'],0,2);
            
        }
        
        
        /**
         * This is the function that gets the name of a country
         */
        public function getThisCountryName($country_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$country_id);
             $country= Country::model()->find($criteria);
             
             return $country['name']; 
        }
}
