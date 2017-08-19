@extends('layout.template')
@section('content')
        <h1>Update Schedule</h1>
        {!! Form::model($schedule,['method' => 'PATCH','route'=>['schedules.update',$schedule[0]->id]]) !!}

        <div class="form-group">
            {!! Form::label('Train Name', 'Train Name:') !!}
            <select name="train_id">
                @foreach($trains as $train)
                    <option  value ={{ $train->id }}>{{$train->name}}</option>
                @endforeach
                    <option value={{$schedule[0]->train_id}} selected="selected">{{$schedule[0]->train}}</option>
            </select>
        </div>

        <div class="form-group">
              {!! Form::label('Destination', 'Destination:') !!}
              <select name="city_id">
                  @foreach($cities as $city)
                      <option value ={{ $city->id }}>{{$city->name}}</option>
                  @endforeach
                    <option value={{$schedule[0]->city_id}} selected="selected">{{$schedule[0]->city}}</option>
              </select>
        </div>

        <div class="form-group">

                {!! Form::label('Departure time', 'Departure time:') !!}

        <div class="col-sm-1">
                <input type="text" class="form-control" name="time" placeholder={{$schedule[0]->time}}>
        </div>
        </div>

        <div class="form-group">
            {!! Form::label('Schedule', 'Schedule:') !!}
            <select name="schedule_type_id">
                @foreach($scheduleTypes as $type)
                    <option  value ={{ $type->id }}>{{$type->name}}</option>
                @endforeach
                    <option value={{$schedule[0]->schedule_type_id}} selected="selected">{{$schedule[0]->schedule_type}}</option>
            </select>
        </div>

        <div class="col-sm-offset-1 col-sm-1">
            {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
            {!! Form::close() !!}
        </div>

</form>
@stop