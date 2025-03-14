@extends('layouts.app')
@section('title', 'Manuales del Sistema')
@section('content_header')
    <h1>Listado de Atletas</h1>
@stop
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Manuales del Sistema</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Archivo</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Manual de Usuario</td>
                                        <td>Instrucciones para el uso del sistema</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="openModal('/pdf/manual_de_usuario.pdf')">Ver</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Manual de Mantenimiento</td>
                                        <td>Instrucciones para el mantenimiento del sistema</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                onclick="openModal('/pdf/mantenimiento.pdf')">Ver</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Visualizar Manual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" src="" width="100%" height="500px" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function openModal(pdfUrl) {
                // Cargar el PDF en el iframe
                document.getElementById('pdfIframe').src = pdfUrl;
                // Mostrar el modal
                $('#pdfModal').modal('show');
            }
        </script>
    @endpush
@endsection
