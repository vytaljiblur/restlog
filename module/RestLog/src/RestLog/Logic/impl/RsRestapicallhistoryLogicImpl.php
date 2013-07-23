<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vitaliji
 * Date: 17/07/13
 * Time: 13:05
 * To change this template use File | Settings | File Templates.
 */

namespace RestLog\Logic\impl;

class RsRestapicallhistoryLogicImpl {

    private $sm;

    function __construct($sm = null)
    {
        $this->sm = $sm;
    }

    public function fetchAll()
    {
        return $this->getDao()->fetchAll();
    }

    public function fetchLastN($n) {
        return $this->getDao()->fetchLastN($n);
    }

    public function fetchRow($id)
    {
        return $this->getDao()->fetchRow($id);
    }


    public function insert($item)
    {
        $this->getDao()->insert($item);
    }

    public function update($item)
    {
        $this->getDao()->update($item);
    }

    public function remove($item)
    {
        $this->getDao()->remove($item);
    }

    private function getDao() {
        return $this->sm->get('RsRestapicallhistoryDao');
    }



}