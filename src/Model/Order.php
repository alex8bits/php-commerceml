<?php


namespace Zenwalker\CommerceML\Model;


use SimpleXMLElement;

/**
 * Class Order
 *
 * @package Zenwalker\CommerceML\Model
 */
class Order extends Simple
{
    /**
     * @var Document[]
     */
    public array $documents = [];

    public function loadXml(): ?SimpleXMLElement
    {
        if ($this->owner->ordersXml) {
            foreach ($this->owner->ordersXml->Документ as $document) {
                $this->documents[] = new Document($this->owner, $document);
            }
        }
        return $this->owner->ordersXml;
    }
}