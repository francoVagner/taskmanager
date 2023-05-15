<?php

namespace App\Models;
use CodeIgniter\Model;

class Tasks extends Model {
    protected $table = 'adv_tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','cliente','tarefa','data','limite','status','processo','prioridade'];
}