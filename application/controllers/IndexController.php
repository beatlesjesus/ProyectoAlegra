<?php
/**
 * Class para comunicacion con el api de Alegra.com
 */
class IndexController extends Zend_Controller_Action
{
  /**
   * @var string URi de la api de Alegra.com
   */
  private $_baseUri;

  /**
   * @var string URi de la api de Alegra.com incluyendo el sufijo(controlador)
   */
  private $_uri;

  /**
   * @var string Correo registrado en Alegra.com
   */
  private $_mail;

  /**
   * @var string Token generado desde la configuracion
   * de Alegra.com
   */
  private $_token;

  /**
   * @var Zend_Http_Client Object cliente para la comunicacion
   */
  private $_client;

  public function init()
  {
    // Se obtinen las configuraciones en application.ini
    $dataBootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
    // Se setea las configuraciones de configAlegra en una var
    $dataAlegra = $dataBootstrap->getOption('configAlegra');
    // Se asigna la URi a una variable privada
    $this->_baseUri = $dataAlegra['uri'];
    // Se setea el sufijo(controlador)
    $this->_uri = $this->_baseUri . '/contacts';
    // Se asigna el mail a una variable privada
    $this->_mail = $dataAlegra['mail'];
    // Se asigna el token a una variable privada
    $this->_token = $dataAlegra['token'];
    // Se crea una instancia de Zend_Http_Client para su posterior uso
    $this->_client = new Zend_Http_Client();
    // Se setea la URi
    $this->_client->setUri($this->_uri);
    // Se setean los datos de autenticacion
    $this->_client->setAuth($this->_mail, $this->_token);
  }

  public function indexAction()
  {
    //
  }
}
