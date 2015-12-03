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
    <table>
        <thead>
            <tr>
                <th>Descripcion</th>
                <th>UPC</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pretransferencias as $pretransferencia)
                <tr>
                    <td>{{ $pretransferencia->producto->descripcion }}</td>
                    <td>{{ $pretransferencia->producto->upc }}</td>
                    <td>{{ $pretransferencia->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
