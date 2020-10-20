@extends('layout.app')
@section('title', 'Principal')

@section('conteudo')
<h1>Menu Principal</h1>
<hr>
<div class="container">
    <div class="row">
        <div class="col-md-4 mb-2">
            <a href="{{ route('escola.index') }}" class="btn btn-info btn-block">Escola</a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="{{ route('turma.index') }}" class="btn btn-info btn-block">Turma</a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="{{ route('aluno.index') }}" class="btn btn-info btn-block">Aluno</a>
        </div>
    </div>
</div>
@endsection