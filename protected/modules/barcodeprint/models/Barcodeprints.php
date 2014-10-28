<?php

/**
 * This is the model class for table "barcodeprints".
 *
 * The followings are the available columns in table 'barcodeprints':
 * @property string $id
 * @property string $idatetime
 * @property string $regnum
 * @property string $papersize
 * @property integer $paperwidth
 * @property integer $paperheight
 * @property integer $labelwidth
 * @property integer $labelheight
 * @property integer $startnumber
 * @property integer $totalnum
 * @property string $barcodetype
 * @property string $userlog
 * @property string $datetimelog
 */
class Barcodeprints extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'barcodeprints';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, idatetime, regnum, papersize, labelwidth, labelheight, userlog, datetimelog', 'required'),
			array('paperwidth, paperheight, startnumber, totalnum, labelwidth, labelheight', 'numerical'),
			array('id, userlog', 'length', 'max'=>21),
			array('idatetime, datetimelog', 'length', 'max'=>19),
			array('regnum', 'length', 'max'=>12),
			array('branch', 'length', 'max'=>10),
			array('papersize, barcodetype', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idatetime, regnum, papersize, paperwidth, paperheight, labelwidth, labelheight, barcodetype, userlog, datetimelog', 'safe', 'on'=>'search'),
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
			'idatetime' => 'Tanggal',
			'regnum' => 'Nomor Urut',
			'papersize' => 'Ukuran Kertas',
			'paperwidth' => 'Lebar Kertas (mm)',
			'paperheight' => 'Tinggi Kertas (mm)',
			'labelwidth' => 'Lebar Label (mm)',
			'labelheight' => 'Tinggi Label (mm)',
			'barcodetype' => 'Jenis Barcode',
			'startnumber' => 'Mulai Nomor',
			'totalnum' => 'Jumlah',
			'userlog' => 'Userlog',
			'datetimelog' => 'Datetimelog',
			'branch' => 'Cabang',
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
		$criteria->compare('idatetime',$this->idatetime,true);
		$criteria->compare('regnum',$this->regnum,true);
		$criteria->compare('papersize',$this->papersize,true);
		$criteria->compare('paperwidth',$this->paperwidth);
		$criteria->compare('paperheight',$this->paperheight);
		$criteria->compare('labelwidth',$this->labelwidth);
		$criteria->compare('labelheight',$this->labelheight);
		$criteria->compare('barcodetype',$this->barcodetype,true);
		$criteria->compare('startnumber',$this->startnumber);
		$criteria->compare('totalnum',$this->totalnum);
		$criteria->compare('branch',$this->totalnum);
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
	 * @return Barcodeprints the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
