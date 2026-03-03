<?php namespace Demo\Api\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Todos Backend Controller
 * Registers in OctoberCMS Admin panel under Demo > Todos
 * Create/edit todos here → Vue.js reads them via API
 */
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
        BackendMenu::setContext('Demo.Api', 'todos');
    }
}
