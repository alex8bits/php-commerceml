<?php

namespace Zenwalker\CommerceML\Model;

class Stockroom extends Simple
{
    private Stockroom $_packageStockroom;

    public function getPackageStockroom(): Stockroom|static
    {
        if (isset($this->_packageStockroom)) {
            return $this->_packageStockroom;
        }
        $id = $this->id;
        $xml = current($this->owner->offerPackage->xpath('//c:Склад[c:Ид = :id]', ['id' => $id]));
        return $this->_packageStockroom = new static($this->owner, $xml);
    }

    public function propertyAliases(): array
    {
        return array_merge(parent::propertyAliases(), [
            'ИдСклада' => 'id',
            'КоличествоНаСкладе' => 'count',
        ]);
    }
}