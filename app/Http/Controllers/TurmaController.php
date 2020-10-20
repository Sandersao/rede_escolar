<?php

namespace App\Http\Controllers;

use App\Escola;
use App\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class TurmaController extends Controller
{
    /**
     * Recover the model "Turma" jointed with the table "escolas"
     *
     * @return App\Turma
     */
    private function selectQuery()
    {
        $fields = [
            'turmas.id',
            'turmas.serie',
            'turmas.ano',
            'turmas.letra_identificadora',
            'turmas.fk_escola',
            'escolas.nome as escola_nome',
        ];
        return Turma::select($fields)->orderBy('id')
            ->join('escolas', 'turmas.fk_escola', 'escolas.id');
    }

    /**
     * Recover the form data
     *
     * @return array
     */
    private function getFormData(){
        $auxEscolas = DB::table('escolas')->get(['id', 'nome']);
        $escolas = [];
        foreach ($auxEscolas as $value) {
            $escolas[$value->id] = $value->nome;
        }
        return [
            'escolas' => $escolas,
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
            $turmas = $this->selectQuery()
                ->where('turmas.serie', 'like', "%$search%")
                ->orWhere('turmas.ano', 'like', "%$search%")
                ->orWhere('turmas.letra_identificadora', 'like', "%$search%")
                ->orWhere('turmas.fk_escola', 'like', "%$search%")
                ->orWhere('escolas.nome', 'like', "%$search%")
                ->paginate(10);
            $turmas->appends(['search' => $search]);
            return view('turma.grid', compact('turmas', 'search'));
        }
        $turmas = $this->selectQuery()->paginate(10);
        return view('turma.grid', compact('turmas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formData = $this->getFormData();
        return view('turma.form', compact('formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $turma = Turma::create($request->all());

        if ($turma) {
            Session::flash('success', "Registro #{$turma->id}  salvo com êxito");
            return redirect()->route('turma.index');
        }
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
        $turma = $this->selectQuery()->find($id);
        return $turma;
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
        $formData["turma"] = Turma::findOrFail($id);
        if ($formData["turma"]) {
            return view('turma.form', compact('formData'));
        }
        return redirect()->back();
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
        $turma = Turma::where('id', $id)->update($request->except('_token', '_method'));

        if ($turma) {
            Session::flash('success', "Registro #{$id} atualizado com êxito");
            return redirect()->route('turma.index');
        }
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
        $turma = Turma::where('id', $id)->delete();
        if ($turma) {
            Session::flash('success', "Registro #{$id} excluído com êxito");
            return redirect()->route('turma.index');
        }
        return redirect()->back()->withErrors(['error', "Registo #{$id} não pode ser excluído"]);
    }
}
