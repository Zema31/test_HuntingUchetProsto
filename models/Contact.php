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
            [['name'], 'required'],
        ];
    }

    // public function getIdText()
    // {
    //     return 'id контакта: ' . $this->id;
    // }

    // public function getNameText()
    // {
    //     return 'Имя: ' . $this->name;
    // }

    // public function getSurnameText()
    // {
    //     return 'Фамилия: ' . $this->surname;
    // }
}
