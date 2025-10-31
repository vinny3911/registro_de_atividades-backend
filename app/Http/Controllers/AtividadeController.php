<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AtividadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('atividades.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('atividades.create');
    }

    public function list()
    {
        return response() -> json(Atividade::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i|after_or_equal:08:00|before_or_equal:22:00',
            'hora_termino' => 'required|date_format:H:i|after:hora_inicio|before_or_equal:22:00',
            'recorrencia' => 'integer|min:1',
        ],[
            'nome.required' => 'Campo de evento obrigatório',
            'data.required' => 'Campo de data obrigatório',
            'hora_inicio.required' => 'Campo de horário de início obrigatório',
            'hora_termino.required' => 'Campo de horário de término obrigatório',
            'hora_termino.after' => 'A hora de término deve ser depois da hora de início.',
            'hora_inicio.after_or_equal' => 'A hora de início mínima permitida é 08:00.',
            'hora_termino.before_or_equal' => 'A hora de término máxima permitida é 22:00.'
        ]);

        if (empty($validated['recorrencia'])) {
            $validated['recorrencia'] = 1; // valor padrão
        }

        $dataInicial = Carbon::parse($validated['data']);
        $horaInicio = $validated['hora_inicio'];
        $horaTermino = $validated['hora_termino'];
        $recorrencia = $validated['recorrencia'];

        // VALIDAÇÃO DE CONFLITO DE DATAS NO BANCO DE DADOS
        for ($i = 0; $i < $recorrencia; $i++) {
            $dataAtual = $dataInicial -> copy() -> addDays($i * 7) -> format('Y-m-d');

            $conflito = Atividade::where('data', $dataAtual)
                -> where(function ($query) use ($horaInicio, $horaTermino) {
                    $query
                        -> where('hora_inicio', '>', $horaInicio)
                        -> where('hora_inicio', '<', $horaTermino)
                -> orWhere (function ($q) use ($horaInicio, $horaTermino) {
                    $q  
                        -> where('hora_termino', '>', $horaInicio)
                        -> where('hora_termino', '<', $horaTermino);
                        });
                })
                -> exists();

                if ($conflito) {
                    return back()
                        -> withErrors([
                            'conflito' => "Conflito detectado no dia " . Carbon::parse($dataAtual)->format('d/m/Y') . " entre {$horaInicio} e {$horaTermino}."
                        ])
                        -> withInput();
                }
        };

        for ($i = 0; $i < $recorrencia; $i++) {
            $dataAtual = $dataInicial -> copy() -> addDays($i * 7) -> format('Y-m-d');

            Atividade::create([
                ...$validated,
                'data' => $dataAtual, //Sobrescrever a data no validated
            ]);
        }

        return redirect() 
            -> route('atividades.index')
            -> with('success', 'Atividade criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Atividade $atividade)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Atividade $atividade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Atividade $atividade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atividade $atividade)
    {
        //
    }
}
