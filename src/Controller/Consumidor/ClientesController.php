<?php

/**
 * Description of ClientesController
 *
 * @author Admin
 */

namespace App\Controller\Consumidor;

use App\Controller\Consumidor\ConsumidorAppController;

class ClientesController extends ConsumidorAppController
{

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->loadModel('Clientes');
        $this->set('titulo', 'Dados Cadastrais');
    }

    public function alterar()
    {
        $cliente = $this->Clientes->findById($this->Auth->user('id'));
        if ($this->request->isMethod('POST'))
        {
            $this->request->data['id']=$this->Auth->user('id');
            if ($this->Clientes->save($this->request->data))
            {
                $this->session->setFlash('Alterado com Sucesso!', 'success');
                $this->redirect(['action' => 'alterar']);
            }
            $this->session->setFlash('Erro ao Salvar os Dados"');
        }

        $this->request->setData($cliente);
    }

}
