@extends('layout.template')
@section('content')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(document). ready( function() {
                var minDate = new Date();
                $( "#datepicker" ).datepicker({
                    minDate: minDate,
                    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель',
                        'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
                        'Октябрь', 'Ноябрь', 'Декабрь'],
                    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                    dateFormat: 'dd.mm.yy',
                    firstDay: 1,
                    onClose: function(selectedDate){
                        $('#return').datepicker("option", "minDate", selectedDate);
                    }
                })
                } );
        </script>
    </head>

    <label><h1>Welcome to test program!!!</h1></label><br />
        {{--{!! Form::model($schedule,['method' => 'PATCH','route'=>['schedules.',$schedule[0]->id]]) !!}--}}
        <form id="station" method="post" action="/searchSchedule">
            {{ csrf_field() }}

            <div class="form-group">
                {!! Form::label('Destination', 'Destination:') !!}
                <select name="city">
                    @if ( empty($city_id) )
                        @begin
                            @foreach($cities as $city)
                                <option value ={{ $city->id }}>{{$city->name}}</option>
                            @endforeach
                            <option value ="0" selected="selected">{{ '--Все--' }}</option>
                        @end
                    @else
                        @begin
                            @foreach($cities as $city)
                                @if ( $city_id == $city->id )
                                    <option value ={{ $city->id }} selected="selected">{{$city->name}}</option>
                                @else
                                    <option value ={{ $city->id }}>{{$city->name}}</option>
                                @endif
                            @endforeach
                                <option value ="0">{{ '--Все--' }}</option>
                        @end
                    @endif
                </select>

                {!! Form::label('Date', 'Date:') !!}
                @if ( empty($date) )
                    <input type="text"  id="datepicker" name="date">
                @else
                    <input type="text"  id="datepicker" name="date" value={{$date}}>
                @endif

                {!! Form::label('Nearest', 'Nearest train:') !!} {{ Form::checkbox('nearest') }}
            </div>



            <div class="col-sm-offset-5 col-sm-1">
                {{-- <input type="submit" name="st_submit" id="st_submit" value="Найти" class="submit_search" placeholder=""> --}}
                {!! Form::submit('Search', ['class' => 'btn btn-warning form-control']) !!}
            </div>

        </form>




    <div class="container">
        <div class="form-group">
            <br/><hr/><h1>Timetable of suburban electric trains on the Dnipro station:</h1>
            <a href="{{url('/schedules/create')}}" class="btn btn-success">Create Schedule Line</a>
            <hr>
        </div>
    </div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr class="bg-info">
            <th>#</th>
            <th>Train Name</th>
            <th>Departure time</th>
            <th>Destination</th>
            <th>Schedule</th>
            <th colspan="3">Actions</th>
        </tr>
    </thead>

<tbody>
@foreach ($schedules as $schedule)
    <tr>
        <td>{{ $schedule->id }}</td>
        <td>{{ $schedule->train }}</td>
        <td>{{ $schedule->time }}</td>
        <td>{{ $schedule->city }}</td>
        <td>{{ $schedule->schedule_type }}</td>

        <td><a href="{{url('schedules',$schedule->id)}}" class="btn btn-primary">Read</a></td>
        <td><a href="{{route('schedules.edit',$schedule->id)}}" class="btn btn-warning">Update</a></td>
        <td>
        {!! Form::open(['method' => 'DELETE', 'route'=>['schedules.destroy', $schedule->id]]) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
        </td>
    </tr>
@endforeach
</tbody>
</table>
@endsection