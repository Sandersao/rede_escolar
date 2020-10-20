@extends('layout.app')
@section('title', 'Turmas')

@section('conteudo')
<h1>Listagem de Turmas</h1>
<hr>
{!! Form::open([
'method' => 'get',
'route' => 'turma.index',
'class' => 'form-horizontal'
]) !!}
<div class="container">
  <div class="row">
    <div class="col-sm-3 mb-2">
      <a href="{{ route('turma.create') }}" class="btn btn-info btn-block">Novo</a>
    </div>
    <div class="col-sm-6 mb-2">
      <div class="input-group">
        {!! Form::text('search', isset($search) ? $search : null, ['class' => 'form-control', 'placeholder' => 'Digite aqui']) !!}
        <div class="input-group-append">
          {!! Form::submit('Pesquisar', ['class'=>'btn btn-primary form-control']) !!}
        </div>
      </div>
    </div>
    <div class="col-sm-3 mb-2">
      <a href="{{ route('principal') }}" class="btn btn-dark btn-block">Voltar</a>
    </div>
  </div>
</div>
{!! Form::close() !!}

<div class="container">
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Ano</th>
          <th>Serie</th>
          <th>Letra</th>
          <th>Escola</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse($turmas as $turma)
        <tr>
          <td>{{ $turma->id }}</td>
          <td>{{ $turma->ano }}</td>
          <td>{{ $turma->serie }}ª</td>
          <td>{{ $turma->letra_identificadora }}</td>
          <td>{{ $turma->escola_nome }}</td>
          <td>
            <a href="{{ route('turma.edit', ['id' => $turma->id]) }}" class="btn btn-warning btn-sm">Editar</a>
            <form method="POST" action="{{ route('turma.destroy', ['id' => $turma->id]) }}" style="display: inline" onsubmit="return confirm('Deseja excluir este registro?');">
              @csrf
              <input type="hidden" name="_method" value="delete">
              <button class="btn btn-danger btn-sm">Excluir</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6">Nenhum registro encontrado para listar</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection