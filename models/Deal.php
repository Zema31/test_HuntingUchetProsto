<?php

namespace app\models;

use yii\db\ActiveRecord;

class Deal extends ActiveRecord
{
    public $contactIds;

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
            [['name', 'sum', 'contactIds'], 'safe'],
            [
                'name',
                'required',
                'message' => 'Пожалуйста, укажите название сделки'
            ],
        ];
    }

    public function getDealContacts()
    {
        return $this->hasMany(DealContact::class, ['deal_id' => 'id']);
    }

    public function getContacts()
    {
        return $this->hasMany(Contact::class, ['id' => 'contact_id'])
            ->via('dealContacts');
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Обновляем связи только если contactIds были переданы
        if ($this->contactIds !== null) {
            $this->updateContacts();
        }
    }

    protected function updateContacts()
    {
        $currentIds = $this->getContacts()->select('id')->column();
        $newIds = $this->contactIds;

        // Удаляем отсутствующие связи
        foreach (array_diff($currentIds, $newIds) as $contactId) {
            $this->unlink('contacts', Contact::findOne($contactId), true);
        }

        // Добавляем новые связи
        foreach (array_diff($newIds, $currentIds) as $contactId) {
            $this->link('contacts', Contact::findOne($contactId));
        }
    }
}
