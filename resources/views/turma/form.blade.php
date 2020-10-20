@extends('layout.app')
@section('title', 'Registro de turma')

@section('conteudo')
<h1>Registro de turma</h1>
<hr>

<div class="container">

    @if(isset($formData['turma']))
    {!! Form::model($formData['turma'], ['method' => 'put', 'route' => ['turma.update', $formData['turma']->id ], 'class' => 'form-horizontal']) !!}
    @else
    {!! Form::open(['method' => 'post','route' => 'turma.store', 'class' => 'form-horizontal']) !!}
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">
                @if (isset($formData['turma']))
                Editando registro #{{ $formData['turma']->nome }}
                @else
                Criando novo registro
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="form-row form-group">
                {!! Form::label('serie', 'Série', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::text('serie', null, ['class' => 'form-control', 'placeholder'=>'Defina a serie']) !!}
                </div>
            </div>

            <div class="form-row form-group">
                {!! Form::label('ano', 'Ano letivo', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::text('ano', null, ['class' => 'form-control', 'placeholder'=>'Defina o ano letivo']) !!}
                </div>
            </div>

            <div class="form-row form-group">
                {!! Form::label('letra_identificadora', 'Letra', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::text('letra_identificadora', null, ['class' => 'form-control', 'placeholder'=>'Defina a letra']) !!}
                </div>
            </div>

            <div class="form-row form-group">
                {!! Form::label('fk_escola', 'Escola', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::select('fk_escola', $formData['escolas'], null, ['class' => 'form-control', 'placeholder'=>'Defina a escola']) !!}
                </div>
            </div>

        </div>
        <div class="card-footer">
            {!! Form::button('cancelar', ['class'=>'btn btn-danger btn-sm', 'onclick' =>'windo:history.go(-1);']); !!}
            {!! Form::submit( isset($formData['turma']) ? 'atualizar' : 'criar', ['class'=>'btn btn-success btn-sm']) !!}
        </div>
    </div>

    {!! Form::close() !!}

</div>
@endsection