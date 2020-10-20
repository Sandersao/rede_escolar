<?php

namespace App\Http\Controllers;

use App\Escola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EscolaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $search = $request->get('search');
            $escolas = Escola::where('nome', 'like', "%$search%")
                ->orderBy('id')
                ->paginate(10);
            $escolas->appends(['search' => $search]);
            $view = view('escola.grid', compact('escolas', 'search'));
        } else {
            $escolas = Escola::orderBy('id')->paginate(10);
            $view = view('escola.grid', compact('escolas'));
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
        return view('escola.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $escola = Escola::create($request->all());

        if ($escola) {
            Session::flash('success', "Registro #{$escola->id}  salvo com êxito");
            return redirect()->route('escola.index');
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
        $escola = Escola::find($id);
        return $escola;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $escola = Escola::findOrFail($id);

        if ($escola) {
            return view('escola.form', compact('escola'));
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
        $escola = Escola::where('id', $id)->update($request->except('_token', '_method'));

        if ($escola) {
            Session::flash('success', "Registro #{$id} atualizado com êxito");
            return redirect()->route('escola.index');
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
        $escola = Escola::where('id', $id)->delete();

        if ($escola) {
            Session::flash('success', "Registro #{$id} excluído com êxito");
            return redirect()->route('escola.index');
        }
        return redirect()->back()->withErrors(['error', "Registo #{$id} não pode ser excluído"]);
    }
}
