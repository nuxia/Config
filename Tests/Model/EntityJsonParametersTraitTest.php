<?php

namespace Nuxia\Component\Tests\Model;

use Nuxia\Component\Config\Model\EntityJsonParametersTrait;

/**
 * Unit tests for {@see \Nuxia\Component\Config\Model\EntityJsonParametersTrait}
 *
 * @author Yannick Snobbert <yannick.snobbert@gmail.com>
 */
class EntityJsonParametersTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return EntityJsonParametersTrait
     */
    protected function getObject()
    {
        return $this->getMockForTrait('Nuxia\Component\Config\Model\EntityJsonParametersTrait');

    }

    public function testDefaultValues()
    {
        $this->assertEquals(array(), $this->getObject()->getParameters());
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonParametersTrait::getParameters
     */
    public function testGetParameters()
    {
        $object = $this->getObject();

        $reflectionObject = new \ReflectionObject($object);
        $property = $reflectionObject->getProperty('parameters');
        $property->setAccessible(true);

        $parametersValue = array('k' => 'v');
        $property->setValue($object, $parametersValue);
        $this->assertEquals($parametersValue, $object->getParameters());
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonParametersTrait::setParameters
     */
    public function testSetParameters()
    {
        $object = $this->getObject();

        $reflectionObject = new \ReflectionObject($object);
        $property = $reflectionObject->getProperty('parameters');
        $property->setAccessible(true);

        $parametersValue = array('k' => 'v');
        $object->setParameters($parametersValue);
        $this->assertEquals($parametersValue, $property->getValue($object));
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonParametersTrait::getParameter
     */
    public function testGetParameter()
    {
        $object = $this->getObject();
        $object->setParameters(array('k' => 'v', 'k2' => 'v2', 'k3' => array('sk' => 'sv')));

        $this->assertEquals('v2', $object->getParameter('[k2]'));
        $this->assertEquals('sv', $object->getParameter('[k3][sk]'));

        $this->setExpectedException('Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException');
        $object->getParameter('malformedPath');
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonParametersTrait::setParameter
     */
    public function testSetParameter()
    {
        $object = $this->getObject();
        $object->setParameters(array('k' => 'v', 'k2' => 'v2'));

        $object->setParameter('[k2]', 'nv2');
        $object->setParameter('[k3]', 'v3');
        $object->setParameter('[k4][sk]', 'sv');
        $this->assertEquals(array('k' => 'v', 'k2' => 'nv2', 'k3' => 'v3', 'k4' => array('sk' => 'sv')), $object->getParameters());

        $this->setExpectedException('Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException');
        $object->setParameter('malformedPath', 'v');
    }

    /**
     * @covers \Nuxia\Component\Config\Model\EntityJsonParametersTrait::removeParameter
     */
    public function testRemoveParameter()
    {
        $object = $this->getObject();
        $object->setParameters(array('k' => 'v', 'k2' => 'v2', 'k3' => array('sk' => 'sv', 'sk2' => 'sv2')));

        $object->removeParameter('[k2]');
        $object->removeParameter('[k3][sk]');
        $this->assertEquals(array('k' => 'v', 'k3' => array('sk2' => 'sv2')), $object->getParameters());

        $this->setExpectedException('Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException');
        $object->setParameter('malformedPath', 'v');
    }
}