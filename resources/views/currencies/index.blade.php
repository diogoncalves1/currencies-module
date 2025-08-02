@extends('layouts.admin')

@section('title', 'CashManager | Moedas')

@section('breadcrumb')
<li class="breadcrumb-item active">Moedas</li>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if(auth()->user() && auth()->user()->hasPermission("addCurrencies"))
                        <button id="btnAdd" class="btn btn-default">Adicionar Moeda</button>
                        @endif
                    </div>
                    <div class="card-body">
                        <table id="table" class="table table-bordered table-striped ">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="/assets/admin/js/currencies/index.js"></script>
<script src="/assets/js/allIndex.js"></script>
@endsection