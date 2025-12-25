<?php


namespace Zenwalker\CommerceML\Model;

use SimpleXMLElement;

/**
 * import.xml -> Каталог
 *
 * Class Catalog
 *
 * @package Zenwalker\CommerceML\Model
 * @property Product[] $products
 */
class Catalog extends Simple
{
    /**
     * @var Product[]
     */
    protected array $products = [];

    /**
     * @param string $id
     * @return null|Product
     */
    public function getById(string $id): ?Product
    {
        foreach ($this->getProducts() as $product) {
            if ($product->id === $id) {
                return $product;
            }
        }
        return null;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        if (empty($this->products) && $this->xml && $this->xml->Товары) {
            foreach ($this->xml->Товары->Товар as $product) {
                $this->products[] = new Product($this->owner, $product);
            }
        }
        return $this->products;
    }

    /**
     * @return \SimpleXMLElement|null
     */
    public function loadXml(): ?SimpleXMLElement
    {
        return $this->owner->importXml->Каталог ?? null;
    }
}