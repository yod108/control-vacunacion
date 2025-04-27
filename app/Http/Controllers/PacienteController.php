<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();
        $totalVacunados = $pacientes->count();

        // Lista de vacunas (puedes agregar más vacunas aquí)
        $vacunas = [
            'Vacuna A' => 'Vacuna Contra la Varicela',
            'Vacuna B' => 'Vacuna Vacuna DTPa (difteria, tétanos, tos ferina)',
            'Vacuna C' => 'Vacuna contra la hepatitis A',
            'Vacuna D' => 'Vacuna contra el VPH',
            'Vacuna E' => 'Vacuna Antigripal',
            'Vacuna F' => 'Vacuna Triple Viral',
            'Vacuna G' => 'Vacuna contra el Rotavirus',
            'Vacuna H' => 'Vacuna contra el COVID-19',
            'Vacuna I' => 'Vacuna contra el tétanos',
            'Vacuna J' => 'Vacuna contra la culebrilla',
            'Vacuna K' => 'Vacuna contra la polio',
        ];

        return view('pacientes.index', compact('pacientes', 'totalVacunados', 'vacunas'));
    }

    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombre' => 'required|string',
            'edad' => 'required|integer|min:0',
            'vacuna' => 'required|string',
        ]);

        // Detenerse si nombre es vacío o edad negativa
        if (empty($request->nombre) || $request->edad < 0) {
            return redirect()->route('pacientes.index')->with('error', 'Registro centinela detectado. Operación detenida.');
        }

        // Verificar si el paciente es apto (ejemplo: mayores de 5 años pueden vacunarse)
        $apto = $request->edad >= 6;

        // Crear el paciente
        Paciente::create([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'vacuna' => $request->vacuna,
            'apto' => $apto,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado correctamente.');
    }
}