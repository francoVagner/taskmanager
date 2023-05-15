<?php

namespace App\Controllers;
use App\Models\Tasks;


class Home extends BaseController
{
    public function index()
    {
        $tarefas = new Tasks();
        $lista['data'] = $tarefas->select('*')
        ->orderBy('limite ASC')
        ->where('status', 1)->findAll();
        return view('tasks/tasks', $lista);
    }

    public function salvar_tarefa()
    {
        /*echo '<pre>';
        print_r($_POST);
        exit();
        */

        $session = session();
        $rules = [
               'cliente' => 'required', 
               'tarefa' => 'required',
               'prazo' => 'required',
               'processo' => 'required',
        ];

        if ( !$this->validate($rules) ){
            session()->setFlashdata('msg','Verifique os dados da tarefa!');
            return redirect()->to(base_url());
        }

        $date_form  = $this->request->getPost('prazo');
        $prazo = implode('-', array_reverse(explode('/', $date_form)));

        $new_task = [
            'cliente' => $this->request->getPost('cliente'),
            'tarefa'  => $this->request->getPost('tarefa'),
            'data'    => date('Y-m-d'),
            'limite'   => $prazo,
            'status'  => 1,
            'prioridade'=> 1,
            'processo'=> $this->request->getPost('processo')
        ];


        $queryTask = new Tasks();

        if ( $queryTask->insert($new_task) ){
            session()->setFlashdata('msg','A Tarefa foi cadastrada!');
            return redirect()->to(base_url());
        }

    }

    public function deletar($id='')
    {
        $model = new Tasks();
        if( $model->delete(['id',$id]) ){
            session()->setFlashdata('msg','Tarefa deletada!');
            return redirect()->to(base_url());
        }
    }


}
