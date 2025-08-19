<?php

namespace app\models;

use yii\db\ActiveRecord;

class DealContact extends ActiveRecord
{
    public function rules()
    {
        return [
            [['deal_id', 'contact_id'], 'required'],
            [['deal_id', 'contact_id'], 'integer'],
        ];
    }

    public function getDeal()
    {
        return $this->hasOne(Deal::class, ['id' => 'deal_id']);
    }

    public function getContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id']);
    }
}
