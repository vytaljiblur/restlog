<?php

namespace RestLog\Form;

use RestLog\Entity\RsRestapicallhistory;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class RsRestapicallhistoryItemForm extends Form
{
    public function __construct()
    {
        parent::__construct('rsRestapicallhistory');
        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new RsRestapicallhistory());

        $this->add(array(
            'name' => 'hmackeyId',
            'type' => '\Zend\Form\Element\Number',
            'options' => array(
                'label' => 'HMACKey id'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'method',
            'options' => array(
                'label' => 'method',
                'value_options' => array( 'GET' => 'GET', 'POST' => 'POST', 'PUT' => 'PUT', 'DELETE' => 'DELETE' )
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));


        $this->add(array(
            'name' => 'uri',
            'options' => array(
                'label' => 'uri'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'uriParameters',
            'options' => array(
                'label' => 'uri parameters'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Date',
            'options' => array(
                'label' => 'date'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
            ),
        ));

    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            )
        );
    }
}