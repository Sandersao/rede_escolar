<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AlunoController extends Controller
{
    /**
     * Recover the model "Aluno" jointed with the tables "escolas", "matriculas" and "turmas"
     *
     * @return App\Aluno
     */
    private function selectQuery()
    {
        $fields = [
            'alunos.id',
            'alunos.nome',
            'alunos.cpf',
            'alunos.email',
            'alunos.data_nascimento',
            'turmas.serie as turma_serie',
            'turmas.letra_identificadora as turma_letra',
            'turmas.ano as turma_ano',
            'matriculas.id_turma',
            'matriculas.id as id_matricula',
            'matriculas.nota_primeiro_bimestre',
            'matriculas.nota_segundo_bimestre',
            'matriculas.nota_terceiro_bimestre',
            'matriculas.nota_quarto_bimestre',
            DB::raw('trunc(
                (
                    (nota_primeiro_bimestre + nota_segundo_bimestre + nota_terceiro_bimestre + nota_quarto_bimestre) / 4
                )::numeric
            , 2) as media_final'),
            'escolas.nome as escola_nome',
        ];
        return Aluno::select($fields)->orderBy('id')
            ->join('matriculas', 'matriculas.id_aluno', 'alunos.id')
            ->join('turmas', 'matriculas.id_turma', 'turmas.id')
            ->join('escolas', 'turmas.fk_escola', 'escolas.id');
    }

    /**
     * Recover the form data
     *
     * @return array
     */
    private function getFormData()
    {
        $auxTurmas = DB::table('turmas')
            ->join('escolas', 'turmas.fk_escola', 'escolas.id')
            ->get([
                'turmas.id',
                'turmas.serie',
                'turmas.ano',
                'turmas.letra_identificadora',
                'turmas.fk_escola',
                'escolas.nome as escola_nome',
            ]);
        $turmas = [];
        foreach ($auxTurmas as $value) {
            $turmas[$value->id] = $value->serie . 'º ' .
                $value->letra_identificadora . ' ' .
                $value->ano . ' ' .
                $value->escola_nome;
        }
        return [
            'turmas' => $turmas,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $search = $request->get('search');
            $alunos = $this->selectQuery()
                ->where('alunos.nome', 'like', "%$search%")
                ->orWhere('alunos.cpf', 'like', "%$search%")
                ->orWhere('alunos.email', 'like', "%$search%")
                ->orWhere('alunos.data_nascimento', 'like', "%$search%")
                ->orderBy('alunos.id')
                ->paginate(10);
            $alunos->appends(['search' => $search]);
            $view = view('aluno.grid', compact('alunos', 'search'));
        } else {
            $alunos = $this->selectQuery()
                ->orderBy('id')
                ->paginate(10);
            $view = view('aluno.grid', compact('alunos'));
        }
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formData = $this->getFormData();
        return view('aluno.form', compact('formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $alunoData = [
            'id' => $requestData['id'],
            'nome' => $requestData['nome'],
            'cpf' => $requestData['cpf'],
            'email' => $requestData['email'],
            'data_nascimento' => $requestData['data_nascimento'],
        ];
        $matriculaData = [
            'id_aluno' => $requestData['id'],
            'id_turma' => $requestData['id_turma']
        ];

        DB::beginTransaction();
        $aluno = Aluno::create($alunoData);
        $matricula = Matricula::create($matriculaData);
        if ($aluno && $matricula) {
            Session::flash('success', "Registro #{$aluno->id}  salvo com êxito");
            DB::commit();
            return redirect()->route('aluno.index');
        }
        DB::rollBack();
        return redirect()->back()->withErrors(['error', "Registo não foi salvo."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aluno = $this->selectQuery()->find($id);
        return view('aluno.show', compact('aluno'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formData = $this->getFormData();
        $formData['aluno'] = $this->selectQuery()->findOrFail($id);

        if ($formData['aluno']) {
            return view('aluno.form', compact('formData'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $alunoData = [
            'nome' => $requestData['nome'],
            'cpf' => $requestData['cpf'],
            'email' => $requestData['email'],
            'data_nascimento' => $requestData['data_nascimento'],
        ];
        $idMatricula = $requestData['id_matricula'];
        $matriculaData = [
            'id_aluno' => $id,
            'id_turma' => $requestData['id_turma']
        ];

        DB::beginTransaction();
        $aluno = Aluno::where('id', $id)->update($alunoData);
        $matricula = Matricula::where('id', $idMatricula)->update($matriculaData);

        if ($aluno && $matricula) {
            Session::flash('success', "Registro #{$id} atualizado com êxito");
            DB::commit();
            return redirect()->route('aluno.index');
        }
        DB::rollBack();
        return redirect()->back()->withErrors(['error', "Registo #{$id} não foi encontrado"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $matricula = Matricula::where('id_aluno', $id)->delete();
        $aluno = Aluno::where('id', $id)->delete();

        if ($aluno && $matricula) {
            Session::flash('success', "Registro #{$id} excluído com êxito");
            DB::commit();
            return redirect()->route('aluno.index');
        }
        DB::rollBack();
        return redirect()->back()->withErrors(['error', "Registo #{$id} não pode ser excluído"]);
    }
}
