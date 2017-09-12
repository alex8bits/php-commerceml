<?php


namespace Zenwalker\CommerceML\Model;


use Zenwalker\CommerceML\ORM\Model;

/**
 * Class SpecificationCollection
 *
 * @package Zenwalker\CommerceML\Model
 */
class SpecificationCollection extends Model
{
    public function init()
    {
        if (isset($this->xml->ХарактеристикаТовара)) {
            foreach ($this->xml->ХарактеристикаТовара as $specification) {
                $this->append(new Simple($this->owner, $specification));
            }
        }
        parent::init();
    }
}