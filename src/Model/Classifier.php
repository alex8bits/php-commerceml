<?php


namespace Zenwalker\CommerceML\Model;


use SimpleXMLElement;
use Zenwalker\CommerceML\Collections\PropertyCollection;

/**
 * Class Classifier
 *
 * @package Zenwalker\CommerceML\Model
 * @property PropertyCollection properties
 * @property Group[] groups
 */
class Classifier extends Simple
{
    /**
     * @var Group[]
     */
    protected array $groups = [];
    /**
     * @var PropertyCollection
     */
    protected PropertyCollection $properties;

    protected array $priceTypes;

    protected array $stockrooms = [];

    /**
     * @return null|\SimpleXMLElement
     */
    public function loadXml(): ?SimpleXMLElement
    {
        if ($this->owner->importXml && $this->owner->importXml->Классификатор) {
            return $this->owner->importXml->Классификатор;
        }

        return null;
    }

    /**
     * @param $id
     * @return \SimpleXMLElement[]
     */
    public function getReferenceBookById($id): array
    {
        return $this->xpath('//c:Свойство[c:Ид = :id]/c:ВариантыЗначений/c:Справочник', ['id' => $id]);
    }

    /**
     * @param $id
     * @return null|\SimpleXMLElement
     */
    public function getReferenceBookValueById($id): ?SimpleXMLElement
    {
        if ($id) {
            $xpath = '//c:Свойство/c:ВариантыЗначений/c:Справочник[c:ИдЗначения = :id]';
            $type = $this->xpath($xpath, ['id' => $id]);
            return $type ? $type[0] : null;
        }

        return null;
    }

    /**
     * @param $id
     * @return null|Group
     */
    public function getGroupById($id): ?Group
    {
        foreach ($this->getGroups() as $group) {
            if ($group->id === $id) {
                return $group;
            }

            if ($child = $group->getChildById($id)) {
                return $child;
            }
        }
        return null;
    }

    /**
     * @return PropertyCollection
     */
    public function getProperties(): PropertyCollection
    {
        if (!isset($this->properties)) {
            $this->properties = new PropertyCollection($this->owner, $this->xml->Свойства);
        }
        return $this->properties;
    }

    /**
     * @return Simple[]
     */
    public function getPriceTypes(): array
    {
        if (empty($this->priceTypes) && $this->xml) {
            foreach ($this->xpath('//c:ТипыЦен/c:ТипЦены') as $type) {
                $this->priceTypes[] = new Simple($this->owner, $type);
            }
        }
        return $this->priceTypes;
    }

    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        if (empty($this->groups) && isset($this->xml->Группы->Группа)) {
            foreach ($this->xml->Группы->Группа as $group) {
                $this->groups[] = new Group($this->owner, $group);
            }
        }
        return $this->groups;
    }

    /**
     * @return Stockroom[]
     */
    public function getStockrooms(): array
    {
        if (empty($this->stockrooms) && isset($this->xml->Склады)) {
            foreach ($this->xml->Склады->Склад as $stockroom) {
                $this->stockrooms[] = new Stockroom($this->owner, $stockroom);
            }
        }
        return $this->stockrooms;
    }
}
