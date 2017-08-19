@extends('layout.template')
@section('content')
    <form class="form-horizontal">

        <div class="form-group">
                <h1 align="left">Show Schedule Line</h1>
            <label for="name" class="col-sm-2 control-label">#</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="id" placeholder={{$schedule[0]->id}} readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="directory_id" class="col-sm-2 control-label">Train Name</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="train" placeholder={{$schedule[0]->train}} readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="directory_id" class="col-sm-2 control-label">Destination</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="city" placeholder={{$schedule[0]->city}} readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="directory_id" class="col-sm-2 control-label">Departure time</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="time" placeholder={{$schedule[0]->time}} readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="directory_id" class="col-sm-2 control-label">Schedule</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="schedule_type" placeholder={{$schedule[0]->schedule_type}} readonly>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-5">
                <a href="{{ url('schedules')}}" class="btn btn-primary">Back</a>
            </div>
        </div>

    </form>
@stop
