@extends('layout.app')
@section('title', 'Registro de escola')

@section('conteudo')
<h1>Registro de escola</h1>
<hr>

<div class="container">

    @if(isset($escola))
    {!! Form::model($escola, ['method' => 'put', 'route' => ['escola.update', $escola->id ], 'class' => 'form-horizontal']) !!}
    @else
    {!! Form::open(['method' => 'post','route' => 'escola.store', 'class' => 'form-horizontal']) !!}
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">
                @if (isset($escola))
                Editando registro #{{ $escola->nome }}
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

        </div>
        <div class="card-footer">
            {!! Form::button('cancelar', ['class'=>'btn btn-danger btn-sm', 'onclick' =>'windo:history.go(-1);']); !!}
            {!! Form::submit( isset($escola) ? 'atualizar' : 'criar', ['class'=>'btn btn-success btn-sm']) !!}
        </div>
    </div>

    {!! Form::close() !!}

</div>
@endsection