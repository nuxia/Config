<?php

namespace Nuxia\Component\Config\Model;

use Symfony\Component\PropertyAccess\Exception\NoSuchIndexException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\PropertyAccess\PropertyPathInterface;

/**
 * Fields field management.
 * If you use Doctrine, the field type must be array, simple array or json_array
 *
 * @author Yannick Snobbert <yannick.snobbert@gmail.com>
 */
trait EntityJsonFieldsTrait {

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     *
     * @param string|PropertyPathInterface $propertyPath  The property path to modify
     * @param mixed                        $value
     *
     * @throws NoSuchIndexException
     */
    public function setField($propertyPath, $value)
    {
        $propertyPathAccessor = PropertyAccess::createPropertyAccessor();
        $propertyPathAccessor->setValue($this->fields, $propertyPath, $value);
    }

    /**
     * @param string|PropertyPathInterface $propertyPath  The property path to modify
     *
     * @return mixed
     *
     * @throws NoSuchIndexException
     */
    public function getField($propertyPath)
    {
        $propertyPathAccessor = PropertyAccess::createPropertyAccessor();

        return $propertyPathAccessor->getValue($this->fields, $propertyPath);
    }

    /**
     * @param string|PropertyPathInterface $propertyPath  The property path to modify
     *
     * @throws NoSuchIndexException
     */
    public function removeField($propertyPath)
    {
        $propertyPathAccessor = PropertyAccess::createPropertyAccessor();

        if (!$propertyPath instanceof PropertyPathInterface) {
            $propertyPath = new PropertyPath($propertyPath);
        }

        if (1 === $propertyPath->getLength()) {
            $buffer = &$this->fields;
            unset($buffer[$propertyPath->getElement(0)]);
        } else {
            $parentPropertyPath = $propertyPath->getParent();
            $buffer = $propertyPathAccessor->getValue($this->fields, $parentPropertyPath);
            unset($buffer[$propertyPath->getElement($propertyPath->getLength() - 1)]);
            $propertyPathAccessor->setValue($this->fields, $parentPropertyPath, $buffer);
        }
    }
}