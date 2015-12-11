{{ \Carbon\Carbon::setLocale('es') }}
@extends('layouts.master')

@section('title', 'Zegucom - Resumen de peticion de transferencia')
@section('style', URL::asset('css/pdf.css'))

@section('header')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
            @parent
            <h1>Resumen de pretransferencia</h1>
        </div>
    </div>
@endsection

@section('content')
    <p>Origen: <strong> {{ $pretransferencias->first()->origen->nombre }} </strong> </p>
    <p>Destino: <strong> {{ $pretransferencias->first()->destino->nombre }} </strong></p>
    <p>Fecha creación: <em>{{ \Carbon\Carbon::now()->format('d/m/Y, g:i a') }}</em></p>
    <p>Creadores: </p>
    <ul>
        @foreach($pretransferencias->pluck('empleado')->unique('id') as $empleado)
        <li>{{$empleado->id}}: {{$empleado->nombre}}</li>
        @endforeach
    </ul>
    <table>
        <thead>
            <tr>
                <th>Creador</th>
                <th>Descripcion</th>
                <th>UPC</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pretransferencias as $pretransferencia)
                <tr>
                    <td>{{ $pretransferencia->empleado->id }}</td>
                    <td>{{ $pretransferencia->producto->descripcion }}</td>
                    <td>{{ $pretransferencia->producto->upc }}</td>
                    <td>{{ $pretransferencia->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
