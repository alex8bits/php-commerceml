<?php

namespace Zenwalker\CommerceML\Tests;


use PHPUnit\Framework\Attributes\DataProvider;

class CommerceMLTest extends TestCase
{
    /**
     * @param $values
     */
    #[DataProvider('xmlProvider')]
    public function testAddXmls($values): void
    {
        $this->cml->addXmls($values['import'], $values['offer'], $values['order']);
        $this->assertNotEmpty($this->cml->catalog->xml);
        $this->assertNotEmpty($this->cml->classifier->xml);
        $this->assertNotEmpty($this->cml->order->xml);
    }

    /**
     * @param $values
     */
    #[DataProvider('xmlProvider')]
    public function testLoadImportXml($values): void
    {
        $this->cml->loadImportXml($values['import']);
        $this->assertNotEmpty($this->cml->catalog->xml);
    }

    /**
     * @param $values
     */
    #[DataProvider('xmlProvider')]
    public function testLoadOffersXml($values): void
    {
        $this->cml->loadImportXml($values['offer']);
        $this->assertNotEmpty($this->cml->classifier->xml);
    }

    /**
     * @param $values
     */
    #[DataProvider('xmlProvider')]
    public function testLoadOrdersXml($values): void
    {
        $this->cml->loadOrdersXml($values['order']);
        $this->assertNotEmpty($this->cml->order->xml);
    }
}
