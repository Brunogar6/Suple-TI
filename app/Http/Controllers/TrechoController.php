<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trecho;
use Illuminate\Support\Facades\Http;

class TrechoController extends Controller
{
    public function index()
    {
        return Trecho::with(['uf', 'rodovia'])->get();
    }

    public function show($id)
    {
        return Trecho::with(['uf', 'rodovia'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|integer',
            'rodovia_id' => 'required|integer',
            'tipo' => 'required|string',
            'km_inicial' => 'required|numeric|min:0',
            'km_final' => 'required|numeric|min:0|gte:km_inicial',
            'geo' => 'required',
        ]);

        $trecho = Trecho::create($validatedData);

        return response()->json(['message' => 'Trecho criado com sucesso!', 'trecho' => $trecho], 201);
    }

    public function update(Request $request, $id)
    {
        $trecho = Trecho::find($id);

        if (!$trecho) {
            return response()->json(['error' => 'Trecho não encontrado.'], 404);
        }

        $validatedData = $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|integer',
            'rodovia_id' => 'required|integer',
            'tipo' => 'required|string',
            'km_inicial' => 'required|numeric|min:0',
            'km_final' => 'required|numeric|min:0|gte:km_inicial',
        ]);

        $trecho->update($validatedData);

        return response()->json(['message' => 'Trecho atualizado com sucesso!', 'trecho' => $trecho]);
    }

    public function destroy($id)
    {
        $trecho = Trecho::find($id);

        if (!$trecho) {
            return response()->json(['error' => 'Trecho não encontrado.'], 404);
        }

        $trecho->delete();

        return response()->json(['message' => 'Trecho excluído com sucesso!']);
    }

    public function getGeoJson(Request $request)
    {
        $rodovia = $request->input('rodovia');
        $tipo = $request->input('tipo');
        $uf = $request->input('uf');
        $data_referencia = $request->input('data_referencia');
        $km_inicial = $request->input('km_inicial');
        $km_final = $request->input('km_final');

        $url = "https://servicos.dnit.gov.br/sgplan/apigeo/rotas/espacializarlinha?br={$rodovia}&tipo={$tipo}&uf={$uf}&cd_tipo=null&data={$data_referencia}&kmi={$km_inicial}&kmf={$km_final}";

        $response = Http::get($url);

        $geoJson = $response->json();

        return response()->json($geoJson);
    }
}
