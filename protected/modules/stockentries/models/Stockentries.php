<?php

/**
 * This is the model class for table "stockentries".
 *
 * The followings are the available columns in table 'stockentries':
 * @property string $id
 * @property string $regnum
 * @property string $idatetime
 * @property string $transid
 * @property string $transname
 * @property string $idwarehouse
 * @property string $donum
 * @property string $transinfo
 * @property string $remark
 * @property string $faceid
 * @property string $userlog
 * @property string $datetimelog
 */
class Stockentries extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stockentries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, regnum, idatetime, transid, transname, idwarehouse, donum, transinfo, userlog, datetimelog', 'required'),
			array('id, idwarehouse, userlog', 'length', 'max'=>21),
			array('transname', 'length', 'max'=>64),
			array('transinfo', 'length', 'max'=>100),
			array('regnum', 'length', 'max'=>12),
			array('transid', 'length', 'max'=>30),
			array('donum', 'length', 'max'=>50),
			array('idatetime, datetimelog', 'length', 'max'=>19),
			array('remark, faceid', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('regnum, idatetime, transid, transname, idwarehouse, donum, transinfo, remark, userlog, datetimelog', 'safe', 'on'=>'search'),
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
			'regnum' => 'Nomor Urut',
			'idatetime' => 'Tanggal',
			'transid' => 'Nomor LPB',
			'transname' => 'Jenis Transaksi',
			'idwarehouse' => 'Gudang',
			'donum' => 'Nomor SJ',
			'transinfo' => 'Info Transaksi',
			'remark' => 'Catatan',
			'faceid' => 'Photo ID',
			'userlog' => 'Userlog',
			'datetimelog' => 'Datetimelog',
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
		$criteria->compare('regnum',$this->regnum,true);
		$criteria->compare('idatetime',$this->idatetime,true);
		$criteria->compare('transid',$this->transid,true);
		$criteria->compare('transname',$this->transname,true);
		$criteria->compare('idwarehouse',$this->idwarehouse,true);
		$criteria->compare('donum',$this->donum,true);
		$criteria->compare('transinfo',$this->transinfo,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('userlog',$this->userlog,true);
		$criteria->compare('datetimelog',$this->datetimelog,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stockentries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
