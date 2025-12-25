<?php


namespace Zenwalker\CommerceML\Model;

/**
 * Class Image
 *
 * @package Zenwalker\CommerceML\Model
 * @property string path
 * @property string caption
 */
class Image extends Simple
{

    /**
     * @return string
     */
    public function getPath(): string
    {
        return trim((string)$this->xml);
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        if ($xml = $this->xpath('//c:ЗначениеРеквизита[contains(c:Значение, :path)]', ['path' => "{$this->path}#"])) {
            return (string)current(\array_slice(explode('#', (string)$xml[0]->Значение), 1));
        }

        return '';
    }
}