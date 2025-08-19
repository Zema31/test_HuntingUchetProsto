<?php

namespace app\models;

use yii\db\ActiveRecord;

class Deal extends ActiveRecord
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
                'tooShort' => 'Название сделки должно содержать минимум {min} символа',
                'tooLong' => 'Название сделки не должно превышать {max} символов',
                'message' => 'Название сделки должно быть строкой'
            ],
            [
                'sum',
                'number',
                'min' => 0,
                'max' => 99999999.99,
                'tooSmall' => 'Сумма не может быть отрицательной',
                'tooBig' => 'Сумма не может превышать 100 миллионов',
                'message' => 'Сумма должна быть числом'
            ],
            [['name', 'sum'], 'safe'],
            [
                'name',
                'required',
                'message' => 'Пожалуйста, укажите название сделки'
            ],
        ];
    }
}
