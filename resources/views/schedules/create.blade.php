@extends('layout.template')
@section('content')
<div class="col-sm-offset-2 col-sm-4">
        <h1>Create Schedule Line</h1>
        {!! Form::open(['url' => 'schedules']) !!}
    <div class="form-group">
        {!! Form::label('Train Name', 'Train Name:') !!}
        <select name="train_id">
            @foreach($trains as $train)
                <option  value ={{ $train->id }}>{{$train->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        {!! Form::label('Destination', 'Destination:') !!}
        <select name="city_id">
            @foreach($cities as $city)
                <option value ={{ $city->id }}>{{$city->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        {!! Form::label('Departure time', 'Departure time:') !!}
        {!! Form::text('time',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Schedule', 'Schedule:') !!}
        <select name="schedule_type_id">
            @foreach($scheduleTypes as $type)
                <option name="schedule_type_id" value ={{ $type->id }}>{{$type->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <div class="col-sm-4">
            {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop