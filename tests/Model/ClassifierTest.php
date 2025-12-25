<?php


namespace Zenwalker\CommerceML\Tests\Model;


use PHPUnit\Framework\Attributes\DataProvider;
use Zenwalker\CommerceML\Tests\ModelTestCase;

class ClassifierTest extends ModelTestCase
{
    #[DataProvider('referenceValueProvider')]
    public function testGetReferenceBookValueById($id, $value): void
    {
        $item = $this->cml->classifier->getReferenceBookValueById($id);
        $this->assertEquals($value, $item ? (string)$item->Значение : null);
    }

    /**
     * @param $id
     * @param $value
     */
    #[DataProvider('referenceProvider')]
    public function testGetReferenceBookById($id, $value): void
    {
        $items = $this->cml->classifier->getReferenceBookById($id);
        $this->assertEquals($value, isset($items[0]) ? (string)$items[0]->Значение : null);
    }

    #[DataProvider('groupProvider')]
    public function testGetGroupById($id, $name): void
    {
        $group = $this->cml->classifier->getGroupById($id);
        $this->assertEquals($name, $group?->name);
    }

    public static function referenceProvider(): array
    {
        return [
            ['444bbe9e-6b18-11e0-9819-e0cb4ed5eed4', '115'],
            ["[]\*$#@:c'", null],
            ['', null],
        ];
    }

    public static function referenceValueProvider(): array
    {
        return [
            ['444bbf2d-6b18-11e0-9819-e0cb4ed5eed4', '100'],
            ['444bbf75-6b18-11e0-9819-e0cb4ed5eed4', '1,5'],
            ["[]\*$#@:c'", null],
            ['', null],
        ];
    }

    public static function groupProvider(): array
    {
        return [
            ['453d6e1a-7233-11e0-8636-0011951d229d', 'Бытовая техника'],
            ['f3257ce7-9c2f-11e1-a282-0011955bd175', 'Бытовая техника с учетом серий, гарантия 12 мес.'],
            ["[]\*$#@:c'", null],
            ['', null],
        ];
    }
}