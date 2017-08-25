<?php

namespace App\Http\Controllers;

use App\City;
use App\Schedule;
use App\ScheduleType;
use App\Train;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;


class ScheduleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::all();

        $schedules = DB::table('schedules')
                            ->join('trains', 'schedules.train_id', '=', 'trains.id')
                            ->join('cities', 'schedules.city_id', '=', 'cities.id')
                            ->join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
                            ->select('schedules.id AS id', 'trains.name AS train', 'cities.name AS city', 'schedules.time AS time', 'schedule_types.name AS schedule_type')
                            ->orderBy('id', 'asc')
                            ->get();

        return view('schedules.index', compact('schedules', 'cities'));
    }

    public function searchSchedule()
    {
        $cities = City::all();
        $city_id = Input::get('city');
        $date = Request::get('date');

        $request = Request::all();

        if( NULL == $date ){
            $date = Carbon::today();
            $date = $date->format('d.m.Y');
        }

        $dayofWeek = Carbon::createFromFormat('d.m.Y', $date);
        $dayofWeek = $dayofWeek->dayOfWeek;

        $types = scheduleType::all();
        foreach ($types as $scheduleType) {
            $scheduleTypes["$scheduleType->name_en"] = $scheduleType->id;
        }
        // ?попробовать обратиться через динамическое поле

        //dump($scheduleTypes);
    /*   $schedules = DB::table('schedules')
                               ->join('trains', 'schedules.train_id', '=', 'trains.id')
                               ->join('cities', 'schedules.city_id', '=', 'cities.id')
                               ->join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
                               ->select('schedules.id AS id', 'trains.name AS train', 'cities.name AS city', 'schedules.time AS time', 'schedule_types.name AS schedule_type')
                               ->where('schedules.schedule_type_id', $everyDay )
                               ->orWhere('schedules.schedule_type_id', $scheduleType)
                               ->get();*/

        $sqlSearch = 'SELECT schedules.id AS id, trains.name AS train, cities.name AS city, schedules.time AS time, schedule_types.name AS schedule_type'.
                        ' FROM schedules, trains, cities, schedule_types'.
                        ' WHERE schedules.train_id = trains.id'.
                            ' AND( schedules.schedule_type_id = schedule_types.id'.
                            ' AND schedules.city_id = cities.id '.
                            ' AND( ( schedules.schedule_type_id = :everyDay ) OR ( schedules.schedule_type_id = :scheduleType ) ))';

        $nearestTrainSQL = ' AND schedules.time >= '. Carbon::now('Europe/Kiev')->format('H.i'). ' ORDER BY schedules.time limit 1';

        $everyDay = $scheduleTypes['everyDay'];

        if( $dayofWeek == 6 || $dayofWeek == 0 ){
            $scheduleType = $scheduleTypes['holiDay'];
        }else{
            $scheduleType = $scheduleTypes['workDay'];
        }


        if( '0' == $city_id || NULL == $city_id ){
    // nearest train to everywhere
            if( !empty($request['nearest']) ) {
                $sqlSearch = $sqlSearch . $nearestTrainSQL;
            }else{
                $sqlSearch = $sqlSearch . ' ORDER BY time, city, train ASC ';
            }

            $schedules = DB::select($sqlSearch, [$everyDay, $scheduleType] );
        }else{
                $sqlSearch = $sqlSearch . ' AND cities.id = :city_id ';
    // nearest train to concrete station
                if( !empty($request['nearest']) ) {
                    $sqlSearch = $sqlSearch . $nearestTrainSQL;
                }else{
                    $sqlSearch = $sqlSearch . '  ORDER BY time, train ASC ';
                }

                $schedules = DB::select( $sqlSearch, [$everyDay, $scheduleType, $city_id] );
        }
        return view('schedules.index', compact('schedules', 'cities', 'date', 'city_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $trains = Train::all();
        $cities = City::all();
        $scheduleTypes = ScheduleType::all();

        return view('schedules.create', compact('trains', 'cities', 'scheduleTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $schedule=Request::all();
        Schedule::create($schedule);
        return redirect('schedules');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $schedule = DB::table('schedules')
                            ->join('trains', 'schedules.train_id', '=', 'trains.id')
                            ->join('cities', 'schedules.city_id', '=', 'cities.id')
                            ->join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
                            ->select('schedules.id AS id', 'trains.name AS train', 'cities.name AS city', 'schedules.time AS time', 'schedule_types.name AS schedule_type')
                            ->where('schedules.id', '=', $id)
                            ->get();

        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $trains = Train::all();
        $cities = City::all();
        $scheduleTypes = ScheduleType::all();

        $schedule = DB::table('schedules')
                            ->join('trains', 'schedules.train_id', '=', 'trains.id')
                            ->join('cities', 'schedules.city_id', '=', 'cities.id')
                            ->join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
                            ->select('schedules.id AS id', 'trains.name AS train', 'cities.name AS city', 'schedules.time AS time', 'schedule_types.name AS schedule_type', 'schedules.train_id', 'schedules.city_id', 'schedules.schedule_type_id')
                            ->where('schedules.id', '=', $id )
                            ->get();

        return view('schedules.edit', compact('schedule', 'trains', 'cities', 'scheduleTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $scheduleUpdate=Request::all();
        $schedule=Schedule::find($id);
        $schedule->update($scheduleUpdate);
        return redirect('schedules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Schedule::find($id)->delete();
        return redirect('schedules');
    }
}

