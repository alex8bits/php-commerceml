<?php


namespace Zenwalker\CommerceML\Model;


/**
 * Class Group
 *
 * @package Zenwalker\CommerceML\Model
 * @property Group parent
 * @property Group[] children
 */
class Group extends Simple
{
    /**
     * @var Group[]
     */
    protected array $children = [];

    /**
     * @var Group
     */
    protected Group $parent;

    /**
     * @return Group[]
     */
    public function getChildren(): array
    {
        if (empty($this->children) && $this->xml->Группы) {
            foreach ($this->xml->Группы->Группа as $group) {
                $this->children[] = new Group($this->owner, $group);
            }
        }
        return $this->children;
    }

    /**
     * @return Group
     */
    public function getParent(): Group
    {
        if (!isset($this->parent)) {
            $parent = $this->xpath('../..')[0];
            if ($parent->getName() === 'Группа') {
                $this->parent = new Group($this->owner, $parent);
            }
        }
        return $this->parent;
    }

    /**
     * @param string $id
     * @return null|Group
     */
    public function getChildById(string $id): ?Group
    {
        foreach ($this->getChildren() as $child) {
            if ($child->id === $id) {
                return $child;
            }

            if ($subChild = $child->getChildById($id)) {
                return $subChild;
            }
        }
        return null;
    }
}