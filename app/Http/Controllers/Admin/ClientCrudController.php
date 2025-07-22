<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ClientCrudController extends CrudController
{
    use ListOperation;
    use ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings('client', 'clients');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('id')->type('number');
        CRUD::column('first_name')->type('text');
        CRUD::column('last_name')->type('text');
        CRUD::column('ssn')->type('text');
        CRUD::column('email')->type('text');
        CRUD::column('phone')->type('text');
        CRUD::column('status')->type('enum');
    }

    protected function setupShowOperation(): void
    {
        CRUD::column('id')->type('number');
        CRUD::column('first_name')->type('text');
        CRUD::column('last_name')->type('text');
        CRUD::column('ssn')->type('text');
        CRUD::column('email')->type('text');
        CRUD::column('phone')->type('text');
        CRUD::column('status')->type('enum');
    }
}
