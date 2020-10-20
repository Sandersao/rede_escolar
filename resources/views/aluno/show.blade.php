@extends('layout.app')
@section('title', 'Aluno')

@section('conteudo')
<h1>Detalhes de aluno</h1>
<hr>
{!! Form::open([
'method' => 'get',
'route' => 'aluno.index',
'class' => 'form-horizontal'
]) !!}
<div class="container">
    <div class="row">
        <div class="col-sm-9 mb-2">
        </div>
        <div class="col-sm-3 mb-2">
            <a href="{{ route('aluno.index') }}" class="btn btn-dark btn-block">Voltar</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
<style>
    th {
        text-align: right;
    }
</style>
<div class="container">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">Informações sobre: {{$aluno->nome}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="2" width="50%">Nome</th>
                    <td colspan="2">{{$aluno->nome}}</td>
                </tr>
                <tr>
                    <th colspan="2">E-mail</th>
                    <td colspan="2">{{$aluno->email}}</td>
                </tr>
                <tr>
                    <th colspan="2">Turma/Escola</th>
                    <td colspan="2">
                        {{$aluno->turma_serie}}º
                        {{$aluno->turma_letra}}
                        {{$aluno->turma_ano}} -
                        {{$aluno->escola_nome}}
                    </td>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">Notas Bimestrais</th>
                </tr>
                <tr>
                    <th>Primeiro</th>
                    <td>{{$aluno->nota_primeiro_bimestre}}</td>
                    <th>Segundo</th>
                    <td>{{$aluno->nota_segundo_bimestre}}</td>
                </tr>
                <tr>
                    <th>Terceiro</th>
                    <td>{{$aluno->nota_terceiro_bimestre}}</td>
                    <th>Quarto</th>
                    <td>{{$aluno->nota_quarto_bimestre}}</td>
                </tr>
                <tr>
                    <th colspan="2">Média final</th>
                    <td colspan="2">{{$aluno->media_final}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection