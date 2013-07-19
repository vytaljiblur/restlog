<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vitaliji
 * Date: 17/07/13
 * Time: 12:49
 * To change this template use File | Settings | File Templates.
 */

namespace RestLog\DAO;


interface GenericDao
{
    public function fetchRow($id);
    public function fetchAll();
    public function insert($item);
    public function update($item);
    public function remove($id);
}