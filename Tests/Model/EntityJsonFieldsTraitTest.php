<?php

namespace Nuxia\Component\Tests\Model;

use Nuxia\Component\Config\Model\EntityJsonFieldsTrait;

/**
 * Unit tests for {@see \Nuxia\Component\Config\Model\EntityJsonFieldsTrait}
 *
 * @author Yannick Snobbert <yannick.snobbert@gmail.com>
 */
class EntityJsonFieldsTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return EntityJsonFieldsTrait
     */
    protected function getObject()
    {
        return $this->getMockForTrait('Nuxia\Component\Config\Model\EntityJsonFieldsTrait');

    }

    public function testDefaultValues()
    {
        $this->assertEquals(array(), $this->getObject()->getFields());
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonFieldsTrait::getFields
     */
    public function testGetFields()
    {
        $object = $this->getObject();

        $reflectionObject = new \ReflectionObject($object);
        $property = $reflectionObject->getProperty('fields');
        $property->setAccessible(true);

        $fieldsValue = array('k' => 'v');
        $property->setValue($object, $fieldsValue);
        $this->assertEquals($fieldsValue, $object->getFields());
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonFieldsTrait::setFields
     */
    public function testSetFields()
    {
        $object = $this->getObject();

        $reflectionObject = new \ReflectionObject($object);
        $property = $reflectionObject->getProperty('fields');
        $property->setAccessible(true);

        $fieldsValue = array('k' => 'v');
        $object->setFields($fieldsValue);
        $this->assertEquals($fieldsValue, $property->getValue($object));
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonFieldsTrait::getField
     */
    public function testGetField()
    {
        $object = $this->getObject();
        $object->setFields(array('k' => 'v', 'k2' => 'v2', 'k3' => array('sk' => 'sv')));

        $this->assertEquals('v2', $object->getField('[k2]'));
        $this->assertEquals('sv', $object->getField('[k3][sk]'));

        $this->setExpectedException('Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException');
        $object->getField('malformedPath');
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonFieldsTrait::setField
     */
    public function testSetField()
    {
        $object = $this->getObject();
        $object->setFields(array('k' => 'v', 'k2' => 'v2'));

        $object->setField('[k2]', 'nv2');
        $object->setField('[k3]', 'v3');
        $object->setField('[k4][sk]', 'sv');
        $this->assertEquals(array('k' => 'v', 'k2' => 'nv2', 'k3' => 'v3', 'k4' => array('sk' => 'sv')), $object->getFields());

        $this->setExpectedException('Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException');
        $object->setField('malformedPath', 'v');
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonFieldsTrait::removeField
     */
    public function testRemoveField()
    {
        $object = $this->getObject();
        $object->setFields(array('k' => 'v', 'k2' => 'v2', 'k3' => array('sk' => 'sv', 'sk2' => 'sv2')));

        $object->removeField('[k2]');
        $object->removeField('[k3][sk]');
        $this->assertEquals(array('k' => 'v', 'k3' => array('sk2' => 'sv2')), $object->getFields());

        $this->setExpectedException('Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException');
        $object->setField('malformedPath', 'v');
    }
}