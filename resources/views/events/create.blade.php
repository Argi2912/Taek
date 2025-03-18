@extends('layouts.app')

@section('title', 'Crear Evento')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Crear Nuevo Evento</h1>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Volver
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre del Evento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Tipo de Evento <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type"
                                        name="type" required>
                                        <option value="">Seleccionar tipo...</option>
                                        <option value="Competition" {{ old('type') == 'Competition' ? 'selected' : '' }}>
                                            Competencia
                                        </option>
                                        <option value="Promotion_Test"
                                            {{ old('type') == 'Promotion_Test' ? 'selected' : '' }}>
                                            Examen de Promoción
                                        </option>
                                        <option value="Training" {{ old('type') == 'Training' ? 'selected' : '' }}>
                                            Entrenamiento
                                        </option>
                                        <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>
                                            Otro
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="venue_id">Sede</label>
                                    <select class="form-control @error('venue_id') is-invalid @enderror" id="venue_id"
                                        name="venue_id">
                                        <option value="">Seleccionar sede...</option>
                                        @foreach ($venues as $venue)
                                            <option value="{{ $venue->id }}"
                                                {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                                {{ $venue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('venue_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_deadline">Fecha Límite de Inscripción</label>
                                    <input type="date"
                                        class="form-control @error('registration_deadline') is-invalid @enderror"
                                        id="registration_deadline" name="registration_deadline"
                                        value="{{ old('registration_deadline') }}">
                                    @error('registration_deadline')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Fecha de Inicio</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date" value="{{ old('start_date') }}">
                                    @error('start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Fecha de Fin</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date" value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sección de Categorías -->
                        <div class="form-group">
                            <label for="categories">Categorías</label>
                            <div id="categories-container">
                                <div class="category-row mb-2">
                                    <select name="categories[0][category_id]" class="form-control" required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name.' - '.$category->type }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="categories[0][registration_fee]" class="form-control mt-2"
                                        placeholder="Tarifa de registro" step="0.01">
                                </div>
                            </div>
                            <button type="button" id="add-category" class="btn btn-secondary mt-2">
                                <i class="fas fa-plus"></i> Agregar Categoría
                            </button>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Guardar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let categoryIndex = 1;

            // Agregar una nueva fila de categoría
            document.getElementById('add-category').addEventListener('click', function() {
                const container = document.getElementById('categories-container');
                const newRow = document.createElement('div');
                newRow.classList.add('category-row', 'mb-2');

                newRow.innerHTML = `
                                    <select name="categories[${categoryIndex}][category_id]" class="form-control" required>
                                        <option value="">Seleccionar categoría...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name.' - '.$category->color }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="categories[${categoryIndex}][registration_fee]" class="form-control mt-2" placeholder="Tarifa de registro" step="0.01">
                                `;

                container.appendChild(newRow);
                categoryIndex++;
            });

            // Validación de fechas
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const registrationDeadline = document.getElementById('registration_deadline');

            startDate.addEventListener('change', function() {
                endDate.min = this.value;
            });

            endDate.addEventListener('change', function() {
                startDate.max = this.value;
            });

            registrationDeadline.addEventListener('change', function() {
                if (startDate.value && this.value > startDate.value) {
                    this.value = startDate.value;
                    alert(
                        'La fecha límite de inscripción no puede ser posterior a la fecha de inicio del evento.'
                        );
                }
            });
        });
    </script>
@stop
