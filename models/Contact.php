<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Contact extends ActiveRecord
{
    public $dealIds;

    public function rules()
    {
        return [
            [
                'name',
                'string',
                'min' => 2,
                'max' => 64,
                'tooShort' => 'Имя должно содержать минимум {min} символа',
                'tooLong' => 'Имя не должно превышать {max} символов',
                'message' => 'Имя должно быть строкой'
            ],
            [
                'surname',
                'string',
                'min' => 2,
                'max' => 64,
                'tooShort' => 'Фамилия должна содержать минимум {min} символа',
                'tooLong' => 'Фамилия не должна превышать {max} символов',
                'message' => 'Фамилия должна быть строкой'
            ],
            [['name', 'surname'], 'safe'],
            [
                'name',
                'required',
                'message' => 'Пожалуйста, укажите имя контакта'
            ],
        ];
    }

    public function getDealContacts()
    {
        return $this->hasMany(DealContact::class, ['contact_id' => 'id']);
    }

    public function getDeals()
    {
        return $this->hasMany(Deal::class, ['id' => 'deal_id'])
            ->via('dealContacts');
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            Yii::error('Ошибка в beforeSave: ' . print_r($this->errors, true));
            return false;
        }

        Yii::info('Сохранение контакта: ' . print_r($this->attributes, true));
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::info('Контакт успешно сохранен: ' . $this->id);
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if ($this->hasErrors()) {
            Yii::error('Ошибки валидации: ' . print_r($this->errors, true));
        } else {
            Yii::info('Валидация прошла успешно');
        }
    }
}
