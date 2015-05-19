<?php

/**
 * This is the model class for table "detailchangeserialnum".
 *
 * The followings are the available columns in table 'detailchangeserialnum':
 * @property string $iddetail
 * @property string $id
 * @property string $tablename
 * @property string $iddetailtable
 */
class Detailchangeserialnum extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detailchangeserialnum';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iddetail, id, tablename, iddetailtable', 'required'),
			array('iddetail, id, iddetailtable', 'length', 'max'=>21),
			array('tablename', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iddetail, id, tablename, iddetailtable', 'safe', 'on'=>'search'),
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
			'iddetail' => 'Iddetail',
			'id' => 'ID',
			'tablename' => 'Tablename',
			'iddetailtable' => 'Iddetailtable',
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

		$criteria->compare('iddetail',$this->iddetail,true);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('tablename',$this->tablename,true);
		$criteria->compare('iddetailtable',$this->iddetailtable,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Detailchangeserialnum the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
