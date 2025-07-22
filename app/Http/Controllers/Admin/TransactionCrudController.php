<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TransactionCrudController extends CrudController
{
    use ListOperation;
    use ShowOperation;

    public function setup(): void
    {
        CRUD::setModel(Transaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction');
        CRUD::setEntityNameStrings('transaction', 'transactions');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('id')->type('number');
        CRUD::column('name')->type('text');
        CRUD::column('card_number')->type('text');
        CRUD::column('amount')->type('text');
        CRUD::column('type')->type('enum');
    }

    protected function setupShowOperation(): void
    {
        CRUD::column('id')->type('number');
        CRUD::column('name')->type('text');
        CRUD::column('card_number')->type('text');
        CRUD::column('amount')->type('text');
        CRUD::column('type')->type('enum');
    }
}
