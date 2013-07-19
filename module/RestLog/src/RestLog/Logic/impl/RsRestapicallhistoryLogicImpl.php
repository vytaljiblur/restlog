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
        return $this->sm->get('RsRestapicallhistoryDao')->fetchAll();
    }

    public function fetchLastN($n) {
        return $this->sm->get('RsRestapicallhistoryDao')->fetchLastN($n);
    }

    public function fetchRow($id)
    {
        return $this->sm->get('RsRestapicallhistoryDao')->fetchRow($id);
    }


    public function insert($item)
    {
        $this->sm->get('RsRestapicallhistoryDao')->insert($item);
    }

    public function update($item)
    {
        $this->sm->get('RsRestapicallhistoryDao')->update($item);
    }

    public function remove($item)
    {
        $this->sm->get('RsRestapicallhistoryDao')->remove($item);
    }



}