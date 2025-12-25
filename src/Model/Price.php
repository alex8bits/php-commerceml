<?php


namespace Zenwalker\CommerceML\Model;


/**
 * Class Price
 *
 * @package Zenwalker\CommerceML\Model
 * @property string performance
 * @property string cost
 * @property string currency
 * @property string unit
 * @property string rate
 * @property Simple type
 */
class Price extends Simple
{
    protected ?Simple $type = null;

    public function __get($name)
    {
        $result = parent::__get($name);

        if ($result && isset($this->type) && ($value = $this->type->{$name})) {
            return $value;
        }

        return $result;
    }

    public function propertyAliases(): array
    {
        return [
            'Представление' => 'performance',
            'ИдТипаЦены' => 'id',
            'ЦенаЗаЕдиницу' => 'cost',
            'Валюта' => 'currency',
            'Единица' => 'unit',
            'Коэффициент' => 'rate',
        ];
    }

    public function getType(): ?Simple
    {
        if (!isset($this->type) && ($id = $this->id) && $type = $this->owner->offerPackage->xpath('//c:ТипЦены[c:Ид = :id]', ['id' => $id])) {
            $this->type = new Simple($this->owner, $type[0]);
        }
        return $this->type;
    }

    public function init(): void
    {
        if ($this->xml && $this->xml->Цена) {
            foreach ($this->xml->Цена as $price) {
                $this->append(new self($this->owner, $price));
            }
            $this->getType();
        }
        parent::init();
    }
}