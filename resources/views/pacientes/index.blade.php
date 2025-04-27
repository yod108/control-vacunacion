@extends('adminlte::page')

@section('title', 'Control de Vacunación')

@section('content_header')
    <h1>Registro de Vacunación</h1>
@stop

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        label.required::after {
            content: " *";
            color: red;
            font-weight: bold;
        }
    </style>
@stop

@section('content')

    <!-- Modal de éxito -->
    <div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="modalSuccessLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalSuccessLabel">¡Éxito!</h5>
                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal de errores -->
    <div class="modal fade" id="modalErrores" tabindex="-1" aria-labelledby="modalErroresLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalErroresLabel">¡Error!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    @if (session('error'))
                        <p>{{ session('error') }}</p>
                    @elseif ($errors->any())
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var successModal = new bootstrap.Modal(document.getElementById('modalSuccess'));
                successModal.show();
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var errorModal = new bootstrap.Modal(document.getElementById('modalErrores'));
                errorModal.show();
            });
        </script>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pacientes.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="required">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="required">Edad:</label>
                    <input type="number" name="edad" class="form-control" required>
                </div>

                <!-- Menú desplegable para vacunas -->
                <div class="form-group">
                    <label class="required">Vacuna Aplicada:</label>
                    <select name="vacuna" class="form-control" required>
                        <option value="">Seleccionar Vacuna</option>
                        @foreach($vacunas as $vacuna => $nombre)
                            <option value="{{ $vacuna }}">{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Registrar Vacuna</button>
            </form>
        </div>
    </div>

    <h2 class="mt-5">Pacientes Vacunados: {{ $totalVacunados }}</h2>

    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Vacuna</th>
                    <th>Apto</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->nombre }}</td>
                    <td>{{ $paciente->edad }}</td>
                    <td>{{ $paciente->vacuna }}</td>
                    <td>
                        @if($paciente->apto)
                            <span class="badge bg-success">Sí</span>
                        @else
                            <span class="badge bg-danger">No</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        @if (session('error') || $errors->any())
            var modalErrores = new bootstrap.Modal(document.getElementById('modalErrores'));
            modalErrores.show();
        @endif
    </script>
@stop
