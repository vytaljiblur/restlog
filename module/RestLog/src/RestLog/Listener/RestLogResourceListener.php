<?php

namespace RestLog\Listener;

use PhlyRestfully\ResourceEvent;
use RestLog\DAO\RsRestapicallhistoryDao;
use RestLog\Entity\RsRestapicallhistory;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class RestLogResourceListener extends AbstractListenerAggregate {
    protected $persistence;

    public function __construct(RsRestapicallhistoryDao $persistence)
    {
        $this->persistence = $persistence;
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('update', array($this, 'onUpdate'));
        $this->listeners[] = $events->attach('delete', array($this, 'onDelete'));
        $this->listeners[] = $events->attach('fetch', array($this, 'onGet'));
        $this->listeners[] = $events->attach('fetchAll', array($this, 'onGetAll'));
    }

    public function onUpdate($e)
    {
        $data=$e->getParam('data');
        $data=(array) $data;


        $entered_item = new RsRestapicallhistory();

        $entered_item->setId((int)$data['id']);
        $entered_item->setDate($data['date']);
        $entered_item->setHmackeyId($data['hmackey']);
        $entered_item->setMethod($data['method']);
        $entered_item->setUri($data['uri']);
        $entered_item->setUriParameters($data['uriParameters']);


        $item = $this->persistence->fetchRow($entered_item->getId());
        if (!$item) {
            $this->persistence->insert($entered_item);
        } else {
            $this->persistence->update($entered_item);
        }

    }

    public function onDelete($e)
    {
        $id = $e->getParam('id');
        $item = $this->persistence->fetchRow($id);
        if (!$item) {
            throw new DomainException('Item not found', 404);
        }
        $this->persistence->remove($item);
    }

    public function onGet($e)
    {
        $id = $e->getParam('id');
        $item = $this->persistence->fetchRow($id);
        if (!$item) {
            throw new DomainException('Item not found', 404);
        }
        return $item;
    }

    public function onGetAll(ResourceEvent $e)
    {
        $array = $this->persistence->fetchAll();
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($array));
        return $paginator;
    }
}