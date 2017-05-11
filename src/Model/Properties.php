<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

/**
 * Class ValueProperties
 * @package Zenwalker\CommerceML\Model
 */
class Properties extends Model
{
    /**
     * @param $id
     * @return Product|null
     */
    public function getById($id)
    {
        foreach ($this as $property) {
            if ($property->id == (string)$id) {
                return $property;
            }
        }
        return null;
    }

    public function init()
    {
        if ($this->xml->ЗначенияСвойства) {
            foreach ($this->xml->ЗначенияСвойства as $property) {
                $properties = $this->owner->classifier->getProperties();
                $object = clone $properties->getById($property->Ид);
                $object->productId = (string)$this->xml->xpath('..')[0]->Ид;
                $object->init();
                $this->append($object);
            }
        }
        if ($this->xml->Свойство) {
            foreach ($this->xml->Свойство as $property) {
                $this->append(new Property($this->owner, $property));
            }
        }
    }
}