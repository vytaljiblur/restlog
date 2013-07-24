<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace RestLog\Component;

use RestLog\Entity\RsRestapicallhistory;
use RestLog\Form\RsRestapicallhistoryItemForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {


        $gets = $this->getRequest()->getQuery();

        $last_n = $gets['last_n'];

        if (isset($last_n)) {
            $data = $this->getService()->fetchLastN($last_n);
        } else {
            $data = $this->getService()->fetchAll();
        }


        $view_model = new ViewModel();
        $view_model->setVariables(array(
            'data' => $data
        ));


        return $view_model;
    }

    public function itemAction()
    {
        $gets = $this->getRequest()->getQuery();
        $posts = $this->getRequest()->getPost();

        $id = $gets['id'];

        $view_model = new ViewModel();
        $view_model->setTemplate('rest-log/index/item');

        $form = new RsRestapicallhistoryItemForm();

        if (isset($id)) {
            $item = $this->getService()->fetchRow($id);
        } else {
            $item = new RsRestapicallhistory();
        }


        $form->bind($item);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                ///$item->setDate(new \DateTime($item->getDate()));

                if ($posts['action'] == 'add') {
                    $this->getService()->insert($item);
                } else {
                    $item->setId($posts['id']);
                    $this->getService()->update($item);
                }

                $this->redirect()->toRoute('all_items');

            }

        }

        if (!isset($id)) {
            $view_model->setVariables(array(
                'action' => 'add',
                'form' => $form,

            ));
        } else {
            $view_model->setVariables(array(
                'id' => $id,
                'action' => 'edit',
                'form' => $form,
            ));
        }

        return $view_model;
    }

    public function removeAction() {
        $gets = $this->getRequest()->getQuery();

        $id = $gets['id'];

        $this->getService()->remove($id);

        $this->redirect()->toRoute('all_items');
    }


    private function getService() {
        return $this->getServiceLocator()->get('RsRestapicallhistoryLogic');
    }


}
