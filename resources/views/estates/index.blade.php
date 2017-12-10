@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Фільтр</h3>
                </div>
                <div class="box-body form-inline">
                    <div class="row">
                        {!! Form::open(['method' => 'GET']) !!}
                        <div class="col-md-4">
                            <div class="dataTables_length">
                                <label for="room">
                                    Кількість кімнат
                                    {!! Form::select('room', $rooms, 0, ['class' => 'form-control input-sm']) !!}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dataTables_length">
                                <label for="region">
                                    Район
                                    {!! Form::select('region', $regions, 0, ['class' => 'form-control input-sm']) !!}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary pull-right">Фільтрувати</button>
                        </div>
                        {!! Form::close(); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h1 class="box-title">Квартири</h1>

                    <div class="box-tools">
                        <a href="{{ route('estates.create') }}" class="btn btn-primary">Додати</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>Назва</th>
                                        <th>Адреса</th>
                                        <th>Телефон</th>
                                        <th width="100px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @unless($estates->count())
                                    <tr>
                                        <td colspan="4">
                                            Квартир не знайдено
                                        </td>
                                    </tr>
                                    @endunless
                                    @foreach($estates as $estate)
                                        <tr>
                                            <td><a href="{{ route('estates.show', $estate->id) }}">{{ $estate->name }}</a></td>
                                            <td>{{ $estate->address }}</td>
                                            <td>{{ $estate->phone }}</td>
                                            <td>
                                                <a href="{{ route('estates.edit', $estate->id) }}"
                                                   class="btn btn-primary"><i class="icon ion-edit"></i></a>
                                                {!! Form::open([ 'route' => ['estates.destroy', $estate->id], 'method' => 'DELETE', 'class' => 'inline']) !!}
                                                <button type="submit" class="btn btn-danger"><i class="icon ion-trash-a"></i></button>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pull-right">
                                    {{ $estates->appends($request->only('room', 'region'))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection