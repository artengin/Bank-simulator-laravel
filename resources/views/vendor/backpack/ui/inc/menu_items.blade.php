{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Clients" icon="lar la-user" :link="backpack_url('client')" />

<x-backpack::menu-item title="Transactions" icon="las la-money-bill-alt" :link="backpack_url('transaction')" />
