@extends('layouts.admin')

@section('title', 'Admin | ' . (isset($currency) ? 'Editar' : 'Adicionar') . ' Moeda ')

@section('breadcrumb')
<li class="breadcrumb-item"><a class="text-white" href="{{ route('admin.currencies.index') }}">Moedas</a></li>
<li class="breadcrumb-item active">{{ (isset($currency) ? 'Editar' : 'Adicionar') }}</li>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Geral</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Código <span class="text-danger">*</span></label>
                        <input type="text" role="code" value="{{ $currency->code ?? '' }}" minlength="3" maxlength="3"
                            data-extra="checkCurrencyCode" class="validate form-control">
                        <span class="error invalid-feedback" id="errorFeedbackCode">Preencha este campo</span>
                        <span class="success valid-feedback">Campo preenchido</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Símbolo <span class="text-danger">*</span></label>
                        <input type="text" role="symbol" value="{{ $currency->symbol ?? '' }}"
                            class="validate form-control">
                        <span class="error invalid-feedback" id="errorFeedbackCode">Preencha este campo</span>
                        <span class="success valid-feedback">Campo preenchido</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        @foreach ($languages as $key => $language)
                        <li class="nav-item"><a class="nav-link <?= $key == 0 ? "active" : '' ?>"
                                href="#<?= $language->name ?>" data-toggle="tab"><?= $language->case; ?></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @foreach ($languages as $key => $language)
                        <div class="tab-pane <?= $key == 0 ? "active" : '' ?>" id="<?= $language->name ?>">

                            <div class="form-group">
                                <label for="inputDisplayName">Nome em <?= $language->case ?> <span
                                        class="text-danger">*</span></label>
                                <input type="text" role="<?= $language->name ?>"
                                    value="{{ $currencyInfo->{$language->name}->name ?? '' }}" data-role="name"
                                    class="validate form-control">
                                <span class="error invalid-feedback">Preencha este
                                    campo</span>
                                <span class="success valid-feedback">Campo preenchido</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" row">
        <div class="col-12">
            <a href="{{ route('admin.currencies.index') }}" class="btn btn-secondary">Voltar</a>
            <button type="submit" id="btnSubmit" class="btn btn-success float-right">Guardar Alterações</button>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="/assets/admin/js/currencies/from.js"></script>
<script src="/assets/js/allForm.js"></script>
@endsection