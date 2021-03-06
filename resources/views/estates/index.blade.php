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
                        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                            <a href="{{ route('estates.create') }}" class="btn btn-primary">Додати</a>
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                @php($colspan = \Illuminate\Support\Facades\Auth::user()->is_admin ? 7 : 6 )
                                <table class="table table-hover table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>Адреса</th>
                                        <th>Кількість кімнат</th>
                                        <th>Район</th>
                                        <th>Телефон</th>
                                        <th>Ціна</th>
                                        <th>Опис</th>
                                        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                            <th width="100px"></th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @unless($estates->count())
                                        <tr>
                                            <td colspan="{{ $colspan }}">
                                                Квартир не знайдено
                                            </td>
                                        </tr>
                                    @endunless
                                    @php($date = '')
                                    @foreach($estates as $estate)
                                        @if($date != $estate->created_at->toDateString())
                                            @php($date = $estate->created_at->toDateString())
                                            <tr>
                                                <td colspan="{{ $colspan }}" align="center" style="color: #00c0ef">
                                                    <b>{{$date}}</b>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>
                                                <a href="{{ route('estates.show', $estate->id) }}">{{ $estate->address }}</a>
                                            </td>
                                            <td>{{ $estate->roomOption->name }}</td>
                                            <td>{{ $estate->region->name }}</td>
                                            <td>{{ $estate->phone }}</td>
                                            <td>{{ $estate->price }}</td>
                                            <td>{{ $estate->description }}</td>
                                            @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                                                <td>
                                                    <a href="{{ route('estates.edit', $estate->id) }}"
                                                       class="btn btn-primary"><i class="icon ion-edit"></i></a>
                                                    {!! Form::open([ 'route' => ['estates.destroy', $estate->id], 'method' => 'DELETE', 'class' => 'inline']) !!}
                                                    <button type="submit" class="btn btn-danger delete"><i
                                                                class="icon ion-trash-a"></i></button>
                                                    {!! Form::close() !!}
                                                </td>
                                            @endif
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
    <!-- Modal delete-->
    <div id="model-delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    Ви дійсно бажаєте видалити квартиру?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Відмінити</button>
                    <button type="button" class="btn btn-primary">Видалити</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.delete').click(function (e) {
               e.preventDefault();
               e.stopPropagation();
               var form = $(this).closest('form');

                $('#model-delete').modal();
                $('#model-delete .btn-primary').click(function (e) {
                    $(form).submit();
                });
            });
        });
    </script>
@endsection
