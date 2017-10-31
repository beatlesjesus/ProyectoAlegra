<?php
/**
 * Class para comunicar el ExtJS con el api de Alegra.com
 */
class ApiController extends Zend_Controller_Action
{
  public function init()
  {
    //
  }

  /**
   * Metodo para listar los contactos
   * @method GET
   * @param  {string}  type
   * @param  {string}  query
   * @param  {int}     start
   * @param  {int}     limit
   * @param  {string}  orderDirection
   * @param  {string}  orderField
   * @param  {boolean} metadata
   * @return {object}  Retorna object con la lista de
   * contactos o json con error
   */
  public function indexAction()
  {
    $this->getHelper('Layout')->disableLayout();
    $this->getHelper('ViewRenderer')->setNoRender();

    $start = intval($this->_request->getQuery('start')) ? intval($this->_request->getQuery('start')) : 0;
    $limit = intval($this->_request->getQuery('limit')) ? intval($this->_request->getQuery('limit')) : 20;
    $page = intval($this->_request->getQuery('page'));

    $contacts = new Application_Model_ContactMapper();
    $data = $contacts->fetchAll('', '', $start, $limit);

    $this->getResponse()->setHeader('Content-Type', 'application/json');
    return $this->_helper->json->sendJson($data);
  }

  /**
   * Metodo para crear un contacto
   * @method POST
   * @param  {object} data contiene un object con toda
   * la data del contacto
   * @return {object} Retorna object con la data del
   * contacto creado o object con error
   */
  public function createAction()
  {
    $this->getHelper('Layout')->disableLayout();
    $this->getHelper('ViewRenderer')->setNoRender();

    $params = (array) json_decode($this->getRequest()->getPost('data'));
    unset($params['id']);

    $contact = new Application_Model_ContactMapper();
    $form = new Application_Model_Contact($params);
    $data = $contact->upsert($form);

    $this->getResponse()->setHeader('Content-Type', 'application/json');
    return $this->_helper->json->sendJson($data);
  }

  /**
   * Metodo para actualizar un contacto
   * @method POST
   * @param  {object} data contiene un object con
   * la data del contacto
   * @return {object} Retorna object con la data del
   * contacto actualizado o object con error
   */
  public function updateAction()
  {
    $this->getHelper('Layout')->disableLayout();
    $this->getHelper('ViewRenderer')->setNoRender();

    $params = (array) json_decode($this->getRequest()->getPost('data'));

    $contact = new Application_Model_ContactMapper();
    $form = new Application_Model_Contact($params);
    $data = $contact->upsert($form);

    $this->getResponse()->setHeader('Content-Type', 'application/json');
    return $this->_helper->json->sendJson($data);
  }

  /**
   * Metodo para actualizar un contacto
   * @method POST
   * @param  {object} data contiene un object con la
   * data del contacto
   * @return {object} Retorna object con mensaje de
   * confirmacion o object con error
   */
  public function deleteAction()
  {
    $this->getHelper('Layout')->disableLayout();
    $this->getHelper('ViewRenderer')->setNoRender();

    $param = json_decode($this->getRequest()->getPost('data'));

    $contact = new Application_Model_ContactMapper();
    $data = $contact->delete($param->id);

    $this->getResponse()->setHeader('Content-Type', 'application/json');
    return $this->_helper->json->sendJson($data);
  }
}
