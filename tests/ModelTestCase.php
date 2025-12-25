<?php


namespace Zenwalker\CommerceML\Tests;


class ModelTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->cml->addXmls(parent::$import, parent::$offer, parent::$order);
    }
}