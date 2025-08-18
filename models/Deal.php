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
            [['name'], 'required'],
        ];
    }

    // public function getIdText()
    // {
    //     return 'id сделки: ' . $this->id;
    // }

    // public function getNameText()
    // {
    //     return 'Наименование: ' . $this->name;
    // }

    // public function getSumText()
    // {
    //     return 'Сумма: ' . $this->sum;
    // }
}
