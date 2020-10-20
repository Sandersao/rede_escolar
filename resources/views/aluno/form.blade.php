@extends('layout.app')
@section('title', 'Registro')

@section('conteudo')
<h1>Registro</h1>
<hr>

<div class="container">

    @if(isset($formData['aluno']))
    {!! Form::model($formData['aluno'], ['method' => 'put', 'route' => ['aluno.update', $formData['aluno']->id ], 'class' => 'form-horizontal']) !!}
    @else
    {!! Form::open(['method' => 'post','route' => 'aluno.store', 'class' => 'form-horizontal']) !!}
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">
                @if (isset($formData['aluno']))
                Editando registro #{{ $formData['aluno']->nome }}
                @else
                Criando novo registro
                @endif
            </span>
        </div>
        <div class="card-body">

            <div class="form-row form-group">
                {!! Form::label('nome', 'Nome', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder'=>'Defina o nome']) !!}
                </div>
            </div>

            <div class="form-row form-group">
                {!! Form::label('cpf', 'CPF', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::text('cpf', null, ['class' => 'form-control', 'placeholder'=>'Defina o CPF']) !!}
                </div>
            </div>

            <div class="form-row form-group">
                {!! Form::label('email', 'E-mail', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-8">
                    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'Defina o email']) !!}
                </div>
            </div>

            <div class="form-row form-group">
                {!! Form::label('data_nascimento', 'Data de nascimento', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::date('data_nascimento', null, ['class' => 'form-control', 'placeholder'=>'Defina a data de nascimento']) !!}
                </div>
            </div>

            <div class="form-row form-group">
                {!! Form::label('id_turma', 'Turma', ['class' => 'col-form-label col-sm-2 text-right']) !!}
                <div class="col-sm-4">
                    {!! Form::select('id_turma', $formData['turmas'], null, ['class' => 'form-control', 'placeholder'=>'Defina a turma']) !!}
                </div>
            </div>

            {!! Form::hidden('id_matricula') !!}

        </div>
        <div class="card-footer">
            {!! Form::button('cancelar', ['class'=>'btn btn-danger btn-sm', 'onclick' =>'windo:history.go(-1);']); !!}
            {!! Form::submit( isset($formData['aluno']) ? 'atualizar' : 'criar', ['class'=>'btn btn-success btn-sm']) !!}
        </div>
    </div>

    {!! Form::close() !!}

</div>
@endsection