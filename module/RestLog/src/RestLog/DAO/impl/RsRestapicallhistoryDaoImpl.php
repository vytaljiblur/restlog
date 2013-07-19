<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vitaliji
 * Date: 17/07/13
 * Time: 11:01
 * To change this template use File | Settings | File Templates.
 */

namespace RestLog\DAO\impl;

use RestLog\DAO\GenericDao;
use Doctrine\Tests\Common\Annotations\Null;

class RsRestapicallhistoryDaoImpl implements GenericDao {

    private $entity_manager;
    private $service_manager;
    private $table_name = 'RestLog\Entity\RsRestapicallhistory';

    function __construct($sm)
    {
        $this->service_manager = $sm->get('doctrine.entitymanager.orm_default');
        $this->entity_manager = $sm->get('doctrine.entitymanager.orm_default')->getRepository($this->table_name);
    }

    public function fetchRow($id)
    {
        return $this->entity_manager->findOneBy(array('id' => $id));
    }

    public function fetchAll()
    {
        return $this->entity_manager->findAll();
    }

    public function insert($item)
    {
        $item->setDate(new \DateTime($item->getDate()));

        $this->service_manager->persist($item);
        $this->service_manager->flush();
    }

    public function update($item)
    {
        $item->setDate(new \DateTime($item->getDate()));
        $this->service_manager->merge($item);
        $this->service_manager->flush();
    }

    public function remove($id)
    {
        $this->service_manager->remove($this->fetchRow($id));
        $this->service_manager->flush();
    }

    public function fetchLastN($n)
    {
        return $this->entity_manager->findBy(
            array(),
            array('id' => 'DESC'),
            $n,
            null
        );
    }

}