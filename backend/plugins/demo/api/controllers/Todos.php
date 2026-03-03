<?php namespace Demo\Api\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Demo\Api\Models\Todo;

class Todos extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\FormController::class,
    ];

    public string $listConfig = 'config_list.yaml';
    public string $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Demo.Api', 'todos', 'todos');
    }

    public function index()
    {
        $this->vars['totalCount'] = Todo::count();
        $this->vars['doneCount'] = Todo::where('done', true)->count();
        $this->vars['pendingCount'] = Todo::where('done', false)->count();
        $this->vars['todayCount'] = Todo::whereDate('created_at', today())->count();

        $this->asExtension('ListController')->index();
    }
}
