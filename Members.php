<?php

/**
 * This is the model class for table "members".
 *
 * The followings are the available columns in table 'members':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $picture
 * @property integer $picture_size
 * @property string $address1
 * @property string $address2
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $country_id
 * @property string $usertype
 * @property string $membership_number
 * @property string $delivery_address1
 * @property string $delivery_address2
 * @property string $delivery_city_id
 * @property string $delivery_state_id
 * @property string $delivery_country_id
 * @property string $status
 * @property string $category
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $name
 * @property string $dateofbirth
 * @property string $religion
 * @property string $gender
 * @property string $maritalstatus
 * @property string $role
 * @property integer $can_recieve_connections
 * @property string $account_number
 * @property string $account_title
 * @property string $member_bank
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 * @property integer $suspended_by
 * @property string $suspended_time
 * @property string $deactivated_time
 * @property string $activated_time
 * @property integer $deactivated_by
 * @property integer $activated_by
 * @property string $name_of_organization
 * @property string $business_category
 * @property string $corporate_address1
 * @property string $corporate_address2
 * @property string $corporate_city_id
 * @property string $corporate_state_id
 * @property string $corporate_country_id
 * @property string $landline
 * @property string $mobile_line
 * @property string $unique_registration_number
 * @property string $accounttype
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Authitem[] $authitems
 * @property Product[] $products
 * @property ProductConstituents[] $productConstituents
 * @property MemberHasMembers[] $memberHasMembers
 * @property MemberHasMembers[] $memberHasMembers1
 * @property MemberLogin[] $memberLogins
 * @property Authitem $role0
 * @property MembershipSubscription[] $membershipSubscriptions
 * @property Product[] $products1
 * @property Quote[] $quotes
 * @property SubscriptionPayment[] $subscriptionPayments
 * @property Wallet[] $wallets
 */
class Members extends CActiveRecord
{
	
    private $_identity;
        public $password_repeat;
        public $current_pass;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('password,password_repeat','required', 'on' => 'insert' ),
			array('username, email, usertype, accounttype,status, name,role', 'required'),
			array('picture_size, create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('username, email, address1, address2, delivery_address1, delivery_address2, lastname, account_number, account_title, member_bank', 'length', 'max'=>100),
                        array('username, email, lastname', 'length', 'max'=>100),
                        array('lastname', 'length', 'max'=>250),
                        array('username', 'required', 'on' => 'insert'),
                        array('username, email', 'unique'),
                        array('password', 'authenticate', 'on' => 'login'),
                        array('password, password_repeat', 'length', 'min'=>8, 'max'=>60, 'tooShort'=>'Your Password is less than eight(8) characters', 'tooLong'=>'Password cannot be greater than 60 characters'),
                        array('password, picture, firstname, middlename', 'length', 'max'=>60),
                        array('password, password_repeat', 'match', 'pattern'=>'/^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\W]).*$/', 'message'=>'Password must have at least one capital letter, at least one number, at least one special character, and at least a lower case letter'),
                        //array('password', 'compare', 'compareAttribute'=>'password_repeat'),
			array('city_id, state_id, country_id, delivery_city_id, delivery_state_id, delivery_country_id', 'length', 'max'=>10),
			array('usertype, gender', 'length', 'max'=>6),
                        array('accounttype', 'length', 'max'=>8),
			array('status', 'length', 'max'=>9),
			array('religion', 'length', 'max'=>12),
			array('maritalstatus', 'length', 'max'=>8),
			array('role', 'length', 'max'=>64),
			array('dateofbirth, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, password, picture, picture_size, address1, address2, city_id, state_id, country_id, usertype, membership_number, delivery_address1, delivery_address2, delivery_city_id, delivery_state_id, delivery_country_id, status, firstname, middlename, lastname, dateofbirth, religion, gender, maritalstatus, role, account_number, account_title, member_bank, create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
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
			'orders' => array(self::MANY_MANY, 'Order', 'assigning_order_for_delivery(member_id, order_id)'),
			'authitems' => array(self::MANY_MANY, 'Authitem', 'authassignment(userid, itemname)'),
			'products' => array(self::MANY_MANY, 'Product', 'member_subscribed_to_products(member_id, product_id)'),
			'productConstituents' => array(self::MANY_MANY, 'ProductConstituents', 'member_amended_constituents(member_id, constituent_id)'),
			'memberHasMembers' => array(self::HAS_MANY, 'MemberHasMembers', 'member_id'),
			'memberHasMembers1' => array(self::HAS_MANY, 'MemberHasMembers', 'other_member_id'),
			'memberLogins' => array(self::HAS_MANY, 'MemberLogin', 'member_id'),
			'role0' => array(self::BELONGS_TO, 'Authitem', 'role'),
			'membershipSubscriptions' => array(self::HAS_MANY, 'MembershipSubscription', 'member_id'),
			'products1' => array(self::MANY_MANY, 'Product', 'product_has_vendor(vendor_id, product_id)'),
			'quotes' => array(self::MANY_MANY, 'Quote', 'quote_has_response(member_id, quote_id)'),
			'subscriptionPayments' => array(self::HAS_MANY, 'SubscriptionPayment', 'paid_by_id'),
			'wallets' => array(self::HAS_MANY, 'Wallet', 'member_owner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'picture' => 'Picture',
			'picture_size' => 'Picture Size',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'city_id' => 'City',
			'state_id' => 'State',
			'country_id' => 'Country',
			'usertype' => 'Usertype',
			'membership_number' => 'Membership Number',
			'delivery_address1' => 'Delivery Address1',
			'delivery_address2' => 'Delivery Address2',
			'delivery_city_id' => 'Delivery City',
			'delivery_state_id' => 'Delivery State',
			'delivery_country_id' => 'Delivery Country',
			'status' => 'Status',
			'category' => 'Category',
			'firstname' => 'Firstname',
			'middlename' => 'Middlename',
			'lastname' => 'Lastname',
			'name' => 'Name',
			'dateofbirth' => 'Dateofbirth',
			'religion' => 'Religion',
			'gender' => 'Gender',
			'maritalstatus' => 'Maritalstatus',
			'role' => 'Role',
			'can_recieve_connections' => 'Can Recieve Connections',
			'account_number' => 'Account Number',
			'account_title' => 'Account Title',
			'member_bank' => 'Member Bank',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
			'suspended_by' => 'Suspended By',
			'suspended_time' => 'Suspended Time',
			'deactivated_time' => 'Deactivated Time',
			'activated_time' => 'Activated Time',
			'deactivated_by' => 'Deactivated By',
			'activated_by' => 'Activated By',
			'name_of_organization' => 'Name Of Organization',
			'business_category' => 'Business Category',
			'corporate_address1' => 'Corporate Address1',
			'corporate_address2' => 'Corporate Address2',
			'corporate_city_id' => 'Corporate City',
			'corporate_state_id' => 'Corporate State',
			'corporate_country_id' => 'Corporate Country',
			'landline' => 'Landline',
			'mobile_line' => 'Mobile Line',
			'unique_registration_number' => 'Unique Registration Number',
			'accounttype' => 'Accounttype',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('picture_size',$this->picture_size);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('usertype',$this->usertype,true);
		$criteria->compare('membership_number',$this->membership_number,true);
		$criteria->compare('delivery_address1',$this->delivery_address1,true);
		$criteria->compare('delivery_address2',$this->delivery_address2,true);
		$criteria->compare('delivery_city_id',$this->delivery_city_id,true);
		$criteria->compare('delivery_state_id',$this->delivery_state_id,true);
		$criteria->compare('delivery_country_id',$this->delivery_country_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('middlename',$this->middlename,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('dateofbirth',$this->dateofbirth,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('maritalstatus',$this->maritalstatus,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('can_recieve_connections',$this->can_recieve_connections);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('account_title',$this->account_title,true);
		$criteria->compare('member_bank',$this->member_bank,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('suspended_by',$this->suspended_by);
		$criteria->compare('suspended_time',$this->suspended_time,true);
		$criteria->compare('deactivated_time',$this->deactivated_time,true);
		$criteria->compare('activated_time',$this->activated_time,true);
		$criteria->compare('deactivated_by',$this->deactivated_by);
		$criteria->compare('activated_by',$this->activated_by);
		$criteria->compare('name_of_organization',$this->name_of_organization,true);
		$criteria->compare('business_category',$this->business_category,true);
		$criteria->compare('corporate_address1',$this->corporate_address1,true);
		$criteria->compare('corporate_address2',$this->corporate_address2,true);
		$criteria->compare('corporate_city_id',$this->corporate_city_id,true);
		$criteria->compare('corporate_state_id',$this->corporate_state_id,true);
		$criteria->compare('corporate_country_id',$this->corporate_country_id,true);
		$criteria->compare('landline',$this->landline,true);
		$criteria->compare('mobile_line',$this->mobile_line,true);
		$criteria->compare('unique_registration_number',$this->unique_registration_number,true);
		$criteria->compare('accounttype',$this->accounttype,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Members the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        
          /**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	//public function authenticate($attribute,$params)
       public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}
        
        
        /**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			
                        $this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
                      
                        
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			//$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity);
			return true;
                        
                }else{
                   return false; 
                }
			
	}
        
        
        
         /*
         * Hash the password for security reasons
         */
        public function hashPassword($password){
            
            //return md5($password);
           /**
            if (CRYPT_STD_DES == 1) {
                return crypt($password, Yii::app()->params['encryptionKey_1']);
            }
            if (CRYPT_EXT_DES == 1) {
                 return crypt($password, Yii::app()->params['encryptionKey_2']);
            }
            if (CRYPT_MD5 == 1) {
                return crypt($password, Yii::app()->params['encryptionKey_3']);
            }
            if (CRYPT_BLOWFISH == 1) {
                return crypt($password, Yii::app()->params['encryptionKey_4']);
            }
            if (CRYPT_SHA256 == 1) {
                 return crypt($password, Yii::app()->params['encryptionKey_5']);
            }
            if (CRYPT_SHA512 == 1) {
                 return crypt($password, Yii::app()->params['encryptionKey_6']);
            }
            * 
            */
          $options = [
                
                'cost' => 11,
                'salt' => Yii::app()->params['encryptionKey_6']
            ];
            return password_hash($password,PASSWORD_BCRYPT, $options );
         
         
            
            
        }
        
        
        
        /**
         * Obtain the password validation for maximum length rules
         */
        
        public function getPasswordMaxLengthRule($password){
            
            foreach ($this->getValidators('password') as $validator) {
            if ($validator instanceof CStringValidator && $validator->max !== null) {
                 //echo 'this is the max length ' . $validator->max;
             
                if(is_string($password)){
                   
                        return(strlen($password)<=$validator->max);
                        
                    
                }
                
            }
            }
            
    }
    
    
    /**
         * Obtain the password validation for minimum length rules
         */
        
        public function getPasswordMinLengthRule($password){
            
            foreach ($this->getValidators('password') as $validator) {
            if ($validator instanceof CStringValidator && $validator->min !== null) {
                 //echo 'this is the max length ' . $validator->max;
             
                if(is_string($password)){
                   
                        return(strlen($password)>= $validator->min);
                        
                    
                }
                
            }
            }
            
    }
    
    
    
    /**
         * overwrite the beforeSave() function
         */
      
        public function beforeSave(){
            
            
                if(parent::beforeSave()){
                  if($this->password !== ''){
                      $pass = $this->hashPassword($this->password);
                      //$pass = md5($this->password);
                     $this->password = $pass;
                    return true;
                      
                  }elseif($this->password === ''){
                      
                      $this->password = $this->current_pass;
                      
                      return true;
                  }
                
                
            } else{
                
                return false;
            }
                
              
    }
    
    
     /**
         * Obtain the password validation for pattern rules
         */
        
        public function getPasswordCharacterPatternRule($password){
            
            foreach ($this->getValidators('password') as $validator) {
            if ($validator instanceof CRegularExpressionValidator && $validator->pattern !== null) {
                 //echo 'this is the max length ' . $validator->max;
             
                return(preg_match($validator->pattern,$password));
                   
                       
            }
            }
        }
        
        
        
           /**
         * This is the function that will get the last four digits of a members membership number
         */
        public function getTheLastFourDigitsOfThisMemberMembershipNumber($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                return substr($member['membership_number'], -4);           
            
        }
        
        
        
           /**
         * This is the function that will get the last four digits of a members membership number
         */
        public function getTheLastSevenDigitsOfThisMemberMembershipNumber($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                return substr($member['membership_number'], -7);           
            
        }
        
        
         /**
         * This is the function that gets a states number
         */
        public function getThisMemberStateNumber($member_id){
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
            
                $state_number = $this->getTheStateNumber($member['state_id']);
                
                return $state_number;
        }
        
        /**
         * This is the function that a state number
         */
        public function getTheStateNumber($state_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$state_id);
                $state= State::model()->find($criteria);
                
                return $state['state_number'];
        }
        
        
         /**
         * This is the function that gets the member city number
         */
        public function getThisMemberCityNumber($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                $city_number = $this->getTheCityNumber($member['city_id']);
                
                return $city_number;
            
        }
        
        
        /**
        * This is the function that gets the city number
        */
        public function getTheCityNumber($city_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$city_id);
                $city= City::model()->find($criteria);
                
                return $city['city_number'];
        }
        
        
        /**
         * This is the function that determines if vat is enabled for this member country
         */
        public function isVatEnabledForThisMemberCountry($id){
            
            $model = new Country;
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$id);
             $member= Members::model()->find($criteria);
             
             return $model->isVatEnabledForThisCountry($member['country_id']);
            
            
        }
        
        /**
         * This is the function that provides the vat rate for a country 
         */
        public function theVatRateForTheCountryOfThisMember($member_id){
           $model = new Country;
           
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$member_id);
             $member= Members::model()->find($criteria);
             
             return $model->getTheDefaultVatRateForThisCountry($member['country_id']);
           
            
        }
        
        
        /**
         * This is the function that gets this members year of registration
         */
        public function getThisMemberYearOfRegistration($member_id){
            
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$member_id);
             $member= Members::model()->find($criteria);
             
             $date_of_registration = getdate(strtotime($member['create_time']));
             
             return substr($date_of_registration['year'],-2);
            
        }
        
        
        /**
         * This is the function that confirms the non-existence of a membership number
         */
        public function isMembershipNumberNotAlreadyExisting($membership_code){
            
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('members')
                    ->where("membership_number = '$membership_code'");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that assigns membership number to a member
         */
        public function assignMembershipNumberToMember($id,$membership_code){
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('members',
                         array('membership_number'=>$membership_code,
                             
                        ),
                        ("id=$id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that confirms that username is not unique
         */
        public function isUsernameNotUnique($username){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('members')
                    ->where("username = '$username'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that confirms that email is not unique
         */
        public function isEmailNotUnique($email){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('members')
                    ->where("email = '$email'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        
        /**
         * This is the function that collects the bank assigned to collect for country
         */
        public function getTheBankAccountIdForThisMemberCountry($member_id){
           
            $model = new BankCollectForCountry;            
            //get the country of this member
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$member_id);
             $member= Members::model()->find($criteria);
             
             return $model->getThisCountryActiveBankAccountForCollection($member['country_id']);
        }
        
        
        /**
         * This is the function that gets a membership number of a member
         */
        public function getTheMembershipNumberOfThisMember($member_id){
            
            $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$member_id);
             $member= Members::model()->find($criteria);
             
             return $member['membership_number'];
            
        }
        
        /**
         * This is the function that gets the email address of a member
         */
        public function getTheRegisteredEmailOfThisMember($member_id){
             $criteria = new CDbCriteria();
             $criteria->select = '*';
             $criteria->condition='id=:id';
             $criteria->params = array(':id'=>$member_id);
             $member= Members::model()->find($criteria);
             
             return $member['email'];
        }
        
        
         /**
         * This is the function that gets the firstname of the logged in user
         */
        public function getTheFirstNameOfTheLoggedInUser($userid){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$userid);
                $user= Members::model()->find($criteria);
                
                return $user['firstname'];
        }
        
        
        
        /**
         * This is the function that retrieves a member od given his membersip number
         */
        public function getTheIdOfThisMemberGivenTheMembershipNumber($membership_number){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='membership_number=:membership';
                $criteria->params = array(':membership'=>$membership_number);
                $member= Members::model()->find($criteria);
                
                return $member['id'];
            
        }
        
        
        /**
         * This is the function that retrieves the name of a member
         */
        public function getTheNameOfThisMember($id){
            
               $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $member= Members::model()->find($criteria);
                
                if($member['middlename'] != "" || $member['middlename'] != null){
                    $name = $member['firstname']." ".$member['middlename']." ".$member['lastname'];
                }else{
                     $name = $member['firstname']." ".$member['lastname'];
                }
                return $name;
        }
        
        
        /**
         * This is the function that confirms if a member accepts connections
         */
        public function doesThisMemberAcceptConnections($id){
            
             $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$id);
                $member= Members::model()->find($criteria);
                
                if($member['can_recieve_connections'] == 1){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
        /**
         * This is the function that conforms if a membership number is correct or not
         */
        public function isMembershipNumberValid($membership_number){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('members')
                    ->where("membership_number = '$membership_number'");
                $result = $cmd->queryScalar();
                
                if($result> 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        
           /**
         * This is the function that will get the city id of a member
         */
        public function getThisMemberPrimaryCityId($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                return $member['city_id'];          
            
        }
        
           /**
         * This is the function that will get the state id of a member
         */
        public function getThisMemberPrimaryStateId($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                return $member['state_id'];          
            
        }
        
        
          /**
         * This is the function that will get the country id of a member
         */
        public function getThisMemberPrimaryCountryId($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                return $member['country_id'];          
            
        }
        
         /**
         * This is the function that will get the primary address of a member
         */
        public function getThisMemberPrimaryAddess($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                return $member['address1'];          
            
        }
        
        
         /**
         * This is the function that gets  a member id from a membership number
         */
        public function getTheMemberIdGivenItsMembershipNumber($membership_number){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='membership_number=:number';
                $criteria->params = array(':number'=>$membership_number);
                $member= Members::model()->find($criteria);
                
                return $member['id'];          
            
        }
        
        
        /**
         * This is the function that gets the name of a member given his/her membership number
         */
        public function getTheNameOfThisMemberGivenTheMembershipNumber($membership_number){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='membership_number=:number';
                $criteria->params = array(':number'=>$membership_number);
                $member= Members::model()->find($criteria);
                
                return $this->getTheNameOfThisMember($member['id']);
       
        }
        
        
            /**
         * This is the function that will get the usertype of a member
         */
        public function getThisMemberUsertype($member_id){
            
                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->condition='id=:id';
                $criteria->params = array(':id'=>$member_id);
                $member= Members::model()->find($criteria);
                
                return $member['usertype'];          
            
        }
}
