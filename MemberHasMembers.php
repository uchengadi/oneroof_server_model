<?php

/**
 * This is the model class for table "member_has_members".
 *
 * The followings are the available columns in table 'member_has_members':
 * @property string $member_id
 * @property string $other_member_id
 * @property string $status
 * @property string $relationship
 * @property string $reason_for_suspension
 * @property string $date_connection_was_requested
 * @property string $date_connection_was_accepted
 * @property string $date_connection_was_rejected
 * @property string $date_connection_was_suspended
 * @property integer $connection_requested_by
 * @property integer $connection_accepted_by
 * @property integer $connection_rejected_by
 * @property integer $connection_suspended_by
 *
 * The followings are the available model relations:
 * @property Members $member
 * @property Members $otherMember
 */
class MemberHasMembers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_has_members';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, other_member_id, status, relationship', 'required'),
			array('connection_requested_by, connection_accepted_by, connection_rejected_by, connection_suspended_by', 'numerical', 'integerOnly'=>true),
			array('member_id, other_member_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('relationship', 'length', 'max'=>8),
			array('reason_for_suspension', 'length', 'max'=>200),
			array('date_connection_was_requested, date_connection_was_accepted, date_connection_was_rejected, date_connection_was_suspended', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('member_id, other_member_id, status, relationship, reason_for_suspension, date_connection_was_requested, date_connection_was_accepted, date_connection_was_rejected, date_connection_was_suspended, connection_requested_by, connection_accepted_by, connection_rejected_by, connection_suspended_by', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Members', 'member_id'),
			'otherMember' => array(self::BELONGS_TO, 'Members', 'other_member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'member_id' => 'Member',
			'other_member_id' => 'Other Member',
			'status' => 'Status',
			'relationship' => 'Relationship',
			'reason_for_suspension' => 'Reason For Suspension',
			'date_connection_was_requested' => 'Date Connection Was Requested',
			'date_connection_was_accepted' => 'Date Connection Was Accepted',
			'date_connection_was_rejected' => 'Date Connection Was Rejected',
			'date_connection_was_suspended' => 'Date Connection Was Suspended',
			'connection_requested_by' => 'Connection Requested By',
			'connection_accepted_by' => 'Connection Accepted By',
			'connection_rejected_by' => 'Connection Rejected By',
			'connection_suspended_by' => 'Connection Suspended By',
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

		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('other_member_id',$this->other_member_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('relationship',$this->relationship,true);
		$criteria->compare('reason_for_suspension',$this->reason_for_suspension,true);
		$criteria->compare('date_connection_was_requested',$this->date_connection_was_requested,true);
		$criteria->compare('date_connection_was_accepted',$this->date_connection_was_accepted,true);
		$criteria->compare('date_connection_was_rejected',$this->date_connection_was_rejected,true);
		$criteria->compare('date_connection_was_suspended',$this->date_connection_was_suspended,true);
		$criteria->compare('connection_requested_by',$this->connection_requested_by);
		$criteria->compare('connection_accepted_by',$this->connection_accepted_by);
		$criteria->compare('connection_rejected_by',$this->connection_rejected_by);
		$criteria->compare('connection_suspended_by',$this->connection_suspended_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberHasMembers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        /**
         * This is the function that connects this member to another member
         */
        public function isConnectingMeToThisMemberASuccess($other_member_id,$member_id,$relationship){
            
            $model = new Members;
            
            if($model->doesThisMemberAcceptConnections($other_member_id)){
                
                $cmd =Yii::app()->db->createCommand();
                $result = $cmd->insert('member_has_members',
                         array('member_id'=>$other_member_id,
                                'other_member_id' =>$member_id,
                                'status'=>'pending',
                                 'relationship'=>$relationship,
                                 'date_connection_was_requested'=>new CDbExpression('NOW()'),
                                 'connection_requested_by'=>Yii::app()->user->id
                           
                        )
                          
                     );
                 
                 if($result >0){
                     return true;
                 }else{
                     return false;
                 }
                
                
            }else{
                return false;
            }
            
              
        }
        
        
        /**
         * This is the function that confirms if a member is already connected to another member
         */
        public function areYouAlreadyConnectedToThisMember($member_id,$other_member_id){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_has_members')
                    ->where("member_id= $other_member_id and other_member_id=$member_id");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
        /**
         * This is the function that accepts a member to another member connection
         */
        public function isAcceptanceOfThisMemberToConnectionSuccessful($member_id,$other_member_id){
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('member_has_members',
                         array('status'=>'accepted',
                             
                        ),
                        ("member_id=$member_id and other_member_id=$other_member_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if a member is already accepted in a connection
         */
        public function isThisMemberNotAlreadyAcceptedInMyConnection($member_id,$other_member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_has_members')
                    ->where("(member_id= $member_id and other_member_id=$other_member_id) and status='accepted'");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        /**
         * This is the function that rejects a connection request
         */
        public function isRejectionOfThisMemberToConnectionSuccessful($member_id,$other_member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('member_has_members',
                         array('status'=>'rejected',
                             
                        ),
                        ("member_id=$member_id and other_member_id=$other_member_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that confirms if a connection is in suspension
         */
        public function isThisMemberConnectionSuspended($member_id,$other_member_id){
            
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_has_members')
                    ->where("(member_id= $member_id and other_member_id=$other_member_id) and status='suspended'");
                $result = $cmd->queryScalar();
                
                if($result >0){
                    return true;
                }else{
                    return false;
                }
            
        }
        
        /**
         * This is the function that removes an already rejected member from a member's connection
         */
        public function isRemovalOfAMemberConnectionRequestSuccessful($member_id,$other_member_id){
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->delete('member_has_members', 'member_id=:memberid and other_member_id=:otherid', array(':memberid'=>$member_id,':otherid'=>$other_member_id));
            
            if($result >0){
                return true;
            }else{
                return false;
            }
        }
        
        
        /**
         * This is the function that suspends a members connection
         */
        public function isSuspensionOfAMemberConnectionRequestSuccessful($member_id,$other_member_id){
            
            $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('member_has_members',
                         array('status'=>'suspended',
                             
                        ),
                        ("member_id=$member_id and other_member_id=$other_member_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the function that suspends a member connection
         */
        public function isUnSuspensionOfAMemberConnectionRequestSuccessful($member_id,$other_member_id){
            
             $cmd =Yii::app()->db->createCommand();
            $result = $cmd->update('member_has_members',
                         array('status'=>'accepted',
                             
                        ),
                        ("member_id=$member_id and other_member_id=$other_member_id")
                          
                     );
            
            if($result>0){
                return true;
            }else{
                return false;
            }
            
        }
        
        
        /**
         * This is the  function that confirms if  a member is already connected to a member
         */
        public function notInMembersConnectionAlready($member_id,$other_member_id){
            
             $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_has_members')
                    ->where("member_id= $other_member_id and other_member_id=$member_id");
                $result = $cmd->queryScalar();
                
                if($result == 0){
                    return true;
                }else{
                    return false;
                }
        }
        
        
       /**
        * This is the function that retrieves all connected members to a member
        */
        public function getAllMembersConnectedToMember($member_id){
                
                $all_members = [];
                $criteria = new CDbCriteria();
                 $criteria->select = '*';
                 $criteria->condition='member_id=:id ';
                 $criteria->params = array(':id'=>$member_id);
                 $members= MemberHasMembers::model()->findAll($criteria);
                 
                 
                 foreach($members as $member){
                     $all_members[] = $member['other_member_id'];
                 }
                 return $all_members;
        }
        
        
                
        /**
         * This is the function that confirms if a member is already connected to another member
         */
        public function isThisBeneficiaryConnectedToThisMember($member_id,$beneficiary_id){
            $cmd =Yii::app()->db->createCommand();
            $cmd->select('COUNT(*)')
                    ->from('member_has_members')
                    ->where("member_id= $member_id and other_member_id=$beneficiary_id");
                $result = $cmd->queryScalar();
                
                if($result > 0){
                    return true;
                }else{
                    return false;
                }
        }
                
}
