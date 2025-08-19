<?php

namespace app\models;

use yii\db\ActiveRecord;

class Contact extends ActiveRecord
{
    /**
     * @return array the validation rules.
     */
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
}
