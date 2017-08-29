Test task: Schedule of electric trains

Every day dozens of electric trains leave from the city's X station in various directions. They go on schedule, some - every day at the same time, others - only on working days or on weekends. You have to write a Web application to create a timetable for suburban trains. The application should consist of:

1. Timetables, in the form of a table with columns:
- Departure time
- Destination
- Does the train leave on any day, only for workers or only on weekends.
2. Possibilities to add, delete, edit the lines of the schedule.
3. Possibilities to filter the schedule at the destination station.
4. The ability to quickly find out when the next train leaves to the selected station, taking into account today's date and days off.

The application is single-user, there is no need to implement access control.

Implement the application in php using your favorite web framework. You can use any libraries that can help you with the task, including your own experience. Ajax and modern approaches are welcome.

Despite the simplicity of the task, do not write a "minimalistic" application on the release. Your program should show your degree of mastery of modern software development principles: OOP, Design patterns, MVC, etc ...

What will be considered:
1. Convenience of the user interface. The ability to assess the problem from the user's point of view and offer the best solution. Aesthetics of the application.
2. The quality of the source code. Modularity, readability, compliance with coding standards, variable names, contingency handling.
3. Degree of ownership of php and the chosen framework.
4. Productivity of labor.



Install the project
-------------------
1. `git clone << project path >>`

2. `сomposer install`

3. `env` database configuration file.

4. Starting Migrations
	
	`php artisan migrate`
	
5. launch of fixtures - start seeder
	
	`php artisan db:seed`
	
6. configure the host.

7. testing (use the project)




Project creation protocol
-------------------------
>creating a project
`сomposer create-project laravel/laravel trainschedule.loc --prefer-dist`

>creating migrations
`php artisan make:migration --create = trains create_trains_table ...`

>edit the migration, add the fields.
`php artisan migrate`

If the migrations were manually deleted -
######
After deleting "manually" "incomplete" migrations - created without specifying the parameter --create = table, so that there was no error, you need to call the command
`сomposer dump-autoload`
[ - forum link](https://laravel.io/forum/09-04-2014-after-deleting-migrations-file-manually-receive-errorexception-failed-to-open-stream-no-such-file-or-directory)

When debugging a project, it can be convenient to clear the fields id autoincrement /
######
To nullify AUTO_INCREMENT, you need the following query:
ALTER TABLE <table name> AUTO_INCREMENT = 0
TRUNCATE <table_name>
[Clears the table, but also resets the counter](https://www.stackoverflow.com/questions/131727/%D0%9A%D0%B0%D0%BA-%D0%BE%D0%B1%D0%BD%D1%83%D0%BB%D0%B8%D1%82%D1%8C-%D0%B7%D0%BD%D0%B0%D1%87%D0%B5%D0%BD%D0%B8%D0%B5-auto-increment)


- In phpMyAdmin -> SQL:
######

    TRUNCATE cities;
    TRUNCATE schedules;
    TRUNCATE schedule_types;
    TRUNCATE trains;

Or use in console / phpStorm Termonal> php artisan migrate: rollback
`php artisan migrate`

Useful link - 
######
[creating CRUD-editor](http://georgehk.blogspot.com/2015/04/crud-operations-in-laravel-5-with-mysql.html)

Create a controller.
######
`php artisan make:controller ScheduleController`

1. Creation of models, in the command line:
######
`php artisan make: model Train`
...

- City
- Schedule
- Train
- ScheduleType

2. Install Form and Html Facades
######
`сomposer require illuminate/html`
>Add in providers config/app.php the following line of code
'Illuminate\Html\HtmlServiceProvider',
Add in aliases config/app.php the following lines of code
>'Form' => 'Illuminate\Html\ FormFacade',
>'Html' => 'Illuminate\Html\HtmlFacade',

3. routes\web.php file
######
 
>Route::resource('/', 'ScheduleController');
>Route::resource('schedule', 'ScheduleController');

4. Create all the views:
######
`resources/views/schedules/`

>Create layout for train schedule
>Go to folder resources/views and create a new folder called layout;
>inside that new folder create a php file called template.blade.php and copy the following code:
`Template.blade.php` file
useful link:
[Call to undefined method Illuminate\Foundation\Application::bindShared() after updating to Laravel 5.2](Https://github.com/laracasts/flash/issues/55)

>Illuminate/HTML package has been deprecated
[Use: laravelcollective/html](https://stackoverflow.com/a/34991188/3327198)

`сomposer require laravelcollective/html`

Add this lines in `config/app.php`
In providers group:

>Collective\Html\HtmlServiceProvider::class,

In aliases group:

>'Form' => Collective\Html\FormFacade::class,
>'Html' => Collective\Html\HtmlFacade::class,

5. Specify the fields to be filled in the corresponding array-property of the model.
######
```php
Class Schedule extends Model
{
    protected $fillable = [
        'id',
        'id_train',
        'time',
        'Schedule_type_id'
    ];
}
```

REALIZE CRUD-EDITOR
#####
it is necessary to "reseed" the seeders to the table were empty, because of the error of the old service provider did not miss their execution. (Illuminate / HTML package has been deprecated)

6. Create all the views:
######
Create view to show schedule list

`resources/views/schedules/`
`index.blade.php`
V Create v Read v Update v Delete
 - respectively, the controller's actions.
 
`ScheduleController`
`show`
+
`show.blade.php`

7. Read schedule (Display single line schedule)
######
Let's implement Read action, create a new file in `resources/views/schedules/` called `show.blade.php` and paste the code:
`show.blade.php`file:

```php
    public function show ($id)
    {
        $schedule = DB::table('schedules')
                            -> join('trains', 'schedules.train_id', '=', 'trains.id')
                            -> join('cities', 'schedules.city_id', '=', 'cities.id')
                            -> join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
                            -> select('schedules.id AS id', 'trains.name AS train', 'cities.name AS city', 'schedules.time AS time', 'schedule_types.name AS schedule_type')
                            -> where('schedules.id', '=', $ id)
                            -> get();

        return view ('schedules.show', compact ('schedule'));
    }
```
8. Create schedule
######
Create a new file in `resources/views/schedules/` called `create.blade.php` and paste the code:
`create.blade.php` file
```php
    public function create ()
    {
        $trains = Train::all();
        $cities = City::all();
        $scheduleTypes = ScheduleType::all();

        return view ('schedules.create', compact ('trains', 'cities', 'scheduleTypes'));
    }
/ **
 * Store a newly created resource in storage.
 *
 * @return Response
 * /
    public function store ()
    {
        $schedule = Request::all();
        Schedule::create($schedule);
        return redirect('schedules');
    }
```

9. add namespace `use Illuminate\Support\Facades\Request;` That there was no error with the recognition of the class.
######

Now we need to modify the schedule for mass assignment

```php 
Use Illuminate\Database\Eloquent\Model;
class Schedule extends Model
{
    protected $fillable = [
        'id',
        'Train_id',
        'city_id',
        'time',
        'schedule_type_id'
    ];
```
Refresh the Browser and click on create schedule


10. Update Schedule
######
Create a new file in `resources/views/schedules` called `edit.blade.php` and paste the code:

`edit.blade.php` file:

```php
 public function edit($id)
    {
        $trains = Train::all();
        $cities = City::all();
        $scheduleTypes = ScheduleType::all();

        $schedule = DB::table('schedules')
                            -> join('trains', 'schedules.train_id', '=', 'trains.id')
                            -> join('cities', 'schedules.city_id', '=', 'cities.id')
                            -> join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
                            -> select('schedules.id AS id', 'trains.name AS train', 'cities.name AS city', 'schedules.time AS time', 'schedule_types.name AS schedule_type', 'schedules.train_id', 'schedules.city_id', 'schedules.schedule_type_id')
                            -> where('schedules.id', '=', $ id)
                            -> get();

        return view('schedules.edit', compact('schedule', 'trains', 'cities', 'scheduleTypes'));
    }

/ **
 * Update the specified resource in storage.
 *
 * @param int $id
 * @return Response
 * /
    public function update ($id)
    {
        $scheduleUpdate = Request::all();
        $schedule = Schedule::find($id);
        $schedule->update($scheduleUpdate);
        return redirect('schedules');
    }
```
Refresh the browser, select the schedule line and click Update button


CREATE button
######
- in the Train, City, Schedule, ScheduleType models - to declare an array of fillable fields.

[Accessing data in object (stdClass), output the result of the query to the view.](Https://stackoverflow.com/questions/21168422/how-to-access-a-property-of-an-object-stdclass-object-member-element-of-an-arr)

	var_dump shows:
	Array (1) {[0] => object (stdClass) # 185 (5) {["id"] => int (1) ["train"] => string (4) "6272" ["city"] => String (14) "time" => string (5) "03.25" ["schedule_type"] => string (17) "on weekdays"}}

```php	
$schedule = $schedule[0];
echo $schedule[0] -> id;
```


>Setting datepicker - <https://jqueryui.com/datepicker/>
View source:

```php
<!doctype html>
<html lang = "en">
<head>
  <meta charset = "utf-8">
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <title> jQuery UI Datepicker - Default functionality </ title>
  <link rel = "stylesheet" href = "//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel = "stylesheet" href = "/resources/demos/style.css">
  <script src = "https://code.jquery.com/jquery-1.12.4.js"> </ script>
  <script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"> </ script>
  <script>
  $(function () {
    $("#datepicker").datepicker ();
  });
  </ script>
</head>
<body>
 
<p> Date: <input type = "text" id = "datepicker"> </ p>
 
 
</body>
</html>

  <script>
  $(function () {
    $ ("#datepicker") .datepicker ();
  });
  </script>
```  
  
[Datepicker Calendar Language Change](http://it-bloknot.ru/?q=book/%D0%BF%D1%80%D0%B8%D0%BC%D0%B5%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5-%D1%8F%D0%B7%D1%8B%D0%BA%D0%B0-javascript-%D0%B8-%D0%B1%D0%B8%D0%B1%D0%BB%D0%B8%D0%BE%D1%82%D0%B5%D0%BA%D0%B8-jquery-%D0%BF%D1%80%D0%B8-%D1%81%D0%BE%D0%B7%D0%B4%D0%B0%D0%BD%D0%B8%D0%B8-%D0%B2%D0%B5%D0%B1-%D1%81%D0%B0%D0%B9%D1%82%D0%B0/62-%D1%81%D0%BC%D0%B5%D0%BD%D0%B0-%D1%8F%D0%B7%D1%8B%D0%BA%D0%B0-%D0%BA%D0%B0%D0%BB%D0%B5%D0%BD%D0%B4%D0%B0%D1%80%D1%8F)


```php
 $(function () {
                $ ("#datepicker") .datepicker ({
                    monthNames: ['January', 'February', 'March', 'April',
                        May, June, July, August, September,
                        'October, November, December'],
                    DayNamesMin: ['Sun', 'Mon', 'W', 'Cp', 'Th', 'Fri', 'Sat'],
                    DateFormat: 'dd.mm.yy',
                    firstDay: 1
                })
                });
```

It is necessary that the previous dates were not active. Video - 
######

[- datepicker disable previousdate](https://www.youtube.com/watch?v=GYNtRphgzIw)

```php
  $(document).ready (function () {//////
                var minDate = new Date (); //////
                $("#datepicker").datepicker ({
                    minDate: minDate, /////
                    monthNames: ['January', 'February', 'March', 'April',
                        May, June, July, August, September,
                        'October, November, December'],
                    dayNamesMin: ['Sun', 'Mon', 'W', 'Cp', 'Th', 'Fri', 'Sat'],
                    dateFormat: 'dd.mm.yy',
                    firstDay: 1,
                    onClose: function (selectedDate) {/////
                    $('#return'). Datepicker ("option", "minDate", selectedDate); ////
                    }
                })
                });
```

Add a route.
######

`routes\web`

```php
    Route::post('searchSchedule', 'ScheduleController@searchSchedule');
```

`scheduleController.php`

```php
 public function searchSchedule (Request $request)
    {
        $city_id = Input::get('city');
```
    we get the parameter value select
    + date	
```php
	  $date = Request::get('date');
      if (NULL == $date) {
          $date = Carbon::now('dd.i.Y');
```
    Determine a weekday or holiday.
```php	
  if ($dayofWeek == 6 || $dayofWeek == 0) {
```
    + Transfer parameters to the view from the controller by default ... - if the date is not specified	
```php	
 public function searchSchedule ()
    {...
     $date = Request::get('date'); ////// ******************
        if (NULL == $date) {////////////// ******************
             $date = Carbon::today();
             $date = $date->format('d.m.Y');
        }
        $dayofWeek = Carbon::createFromFormat('d.m.Y', $date);
```

nearest - a mark on the checkbox, Nearest:
######

```php
$request = Request::all();
    if(!empty ($request ['nearest'])) {
                $sql ​​= $sql. 'AND schedules.time> ='. Carbon::now ('Europe/Kiev') -> format('H.i'). 'ORDER BY schedules.time limit 1';
```
    (- item 4. The ability to quickly find out when the next train leaves to the selected station, given today's date and weekend).
  
Set time zone:
######

`config/app.php`

```php
'timezone' => 'Europe/Kiev',
```

transmission and processing of parameters in the view resources/views/schedules/ index.blade.php
######

```html
                <select name = "city">
                    @if (empty ($city_id))
                        @begin
                            @foreach ($cities as $city)
                                <option value = {{$city-> id}}> {{$city-> name}} </ option>
                            @endforeach
                            <option value = "0" selected = "selected"> {{'- All--'}} </ option>
                        @end
                    @else
                        @begin
                            @foreach ($cities as $city)
                                @if ($city_id == $city-> id)
                                    <option value = {{$city-> id}} selected = "selected"> {{$city-> name}} </ option>
                                @else
                                    <option value = {{$city-> id}}> {{$city-> name}} </ option>
                                @endif
                            @endforeach
                                <Option value = "0"> {{'- All--'}} </ option>
                        @end
                    @endif
                </ select>

                {!! Form::label ('Date', 'Date:') !!}
                @if (empty ($date))
                    <input type = "text" id = "datepicker" name = "date">
                @else
                    <input type = "text" id = "datepicker" name = "date" value = {{$date}}>
                @endif
```

Laravel Syntax (QueryBuilder) - Relationships
######

Use QueryBuilder for sql-queries
	
`useful links: `

[Lesson # 18 Laravel 5.2 [ working with the database, SQL queries, the facade DB ] ( 32:00 )](https://www.youtube.com/watch?v=Hgyj2qXJLZE)    
[Lesson # 19 Laravel 5.2 [ Query Builder, QueryBuilder ] ( 57:06 )](https://www.youtube.com/watch?v=lpxXfSpUTmo)

    It is very convenient when developing to track all SQL-queries.
	
[Lesson # 18 Laravel 5.2 [ working with the database, SQL queries, the facade DB ] ( 32:00 )](https://www.youtube.com/watch?v=Hgyj2qXJLZE)    

`In the app/Providers/AppServiceProvider.php:`

```php
Class AppServiceProvider extends ServiceProvider
{
/ **
* Bootstrap any application services.
*
* @return void
* /
public function boot ()
{
DB::listen(function ($query) {
dump ($query-> sql);
});
}
```

MODEL TIES FOR DATABASE OBJECTS, COMMUNICATION INSTALLATION
######
[Lesson # 22 Laravel 5.2 [data model, Eloquent (links between tables)] ( 50:54 )](https://www.youtube.com/watch?v=HvVxbaaLGtI) 

<http://laravel.su/docs/5.3/eloquent#relationships>

Contact id tables of trains, cities, schedule_types with foreign keys in the compound table schedules.
######

```php
   'WHERE schedules.train_id = trains.id'.
                            'AND(schedules.schedule_type_id = schedule_types.id'.
                            'AND schedules.city_id = cities.id'.
                            'AND((schedules.schedule_type_id =: everyDay) OR (schedules.schedule_type_id =: scheduleType)))'

 $sqlSearch = 'SELECT schedules.id AS id, trains.name AS train, cities.name AS city, schedules.time AS time, schedule_types.name AS schedule_type'.
                        'FROM schedules, trains, cities, schedule_types'.
                        'WHERE schedules.train_id = trains.id'.
                            'AND(schedules.schedule_type_id = schedule_types.id'.
                            'AND schedules.city_id = cities.id'.
                            'AND((schedules.schedule_type_id =: everyDay) OR (schedules.schedule_type_id =: scheduleType)))';
```

    or using the QueryBuilder:
	
```php	
-> join('trains', 'schedules.train_id', '=', 'trains.id')
-> join('cities', 'schedules.city_id', '=', 'cities.id')
-> join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
- a one-to-many relationship between all tables to the main table, these tables are not related to each other.

        $schedules = DB::table('schedules')
                            ->join('trains', 'schedules.train_id', '=', 'trains.id')
                            ->join('cities', 'schedules.city_id', '=', 'cities.id')
                            ->join('schedule_types', 'schedules.schedule_type_id', '=', 'schedule_types.id')
                            ->select('schedules.id AS id', 'trains.name AS train', 'cities.name AS city', 'schedules.time AS time', 'schedule_types.name AS schedule_type')
                            ->orderBy('id', 'asc')
                            ->get();
```
    For a compound master table, you must specify foreign keys for communication with other tables. Database/migrations/2017_07_28_171359_create_schedules_table.php
	
```php
            $table-> integer('train_id') -> unsigned();
            $table-> foreign('train_id') -> references('id') -> on('trains');

            $table-> integer('city_id') -> unsigned();
            $table-> foreign('city_id') -> references('id') -> on('cities');

            $table-> string('time');

            $table-> integer('schedule_type_id') -> unsigned();
            $table-> foreign('schedule_type_id') -> references('id') -> on('schedule_types');
```

    When the ScheduleTableSeeder() was executed, when debugging, an error occurred with the foreign key constraint, the child row in the trains table was missing after adding another train to the Schedules schedule table.

Accordingly, in the models we indicate the links:

`app/Schedule.php`

```php
public function train() {
        return $this-> belongsTo('App\Train');
    }

    public function city () {
        return $this-> belongsTo('App\City');
    }

    public function scheduleType() {
        return $this-> belongsTo('App\ScheduleType');
    }
```

`app/Train.php`

```php
public function schedules () {
        return $this-> hasMany ('App\Schedule');
    }
```

`app/City.php`

```php
   public function schedules() {
        return $this-> hasMany ('App\Schedule');
    }
```

`app/ScheduleType.php`

```php
    public function schedules() {
        return $this-> hasMany ('App\Schedule');
    }
```

We get the types of the traffic graph from the scheduleType model
######

```php    
	public function searchSchedule()
    {        
        $types = scheduleType::all();
        foreach ($types as $scheduleType) {
            $scheduleTypes ["$scheduleType-> name_en"] = $scheduleType-> id;
    }
```

`useful links:`

If the migrations were manually deleted - 
[use link](https://laravel.io/forum/09-04-2014-after-deleting-migrations-file-manually-receive-errorexception-failed-to-open-stream-no-such-file-Or-directory)

[Clears the table, but also resets the counter.](Https://www.stackoverflow.com/questions/131727/%D0%9A%D0%B0%D0%BA-%D0%BE%D0%B1%D0%BD%D1%83%D0%BB%D0%B8%D1%82%D1%8C-%D0%B7%D0%BD%D0%B0%D1%87%D0%B5%D0%BD%D0%B8%D0%B5-auto-increment)

[creating CRUD-editor](http://georgehk.blogspot.com/2015/04/crud-operations-in-laravel-5-with-mysql.html)

[Call to undefined method Illuminate\Foundation\Application::bindShared() after updating to Laravel 5.2](Https://github.com/laracasts/flash/issues/55) 

[Illuminate / HTML package has been deprecated - Use: laravelcollective/Html](https://stackoverflow.com/a/34991188/3327198) 

[Accessing data in object (stdClass), output the result of the query to the view.](Https://stackoverflow.com/questions/21168422/how-to-access-a-property-of-an-object-stdclass-object-member-element-of-an-arr)

Setting datepicker - <https://jqueryui.com/datepicker/>

[Change the calendar language Datepicker](http://it-bloknot.ru/?q=book/%D0%BF%D1%80%D0%B8%D0%BC%D0%B5%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5-%D1%8F%D0%B7%D1%8B%D0%BA%D0%B0-javascript-%D0%B8-%D0%B1%D0%B8%D0%B1%D0%BB%D0%B8%D0%BE%D1%82%D0%B5%D0%BA%D0%B8-jquery-%D0%BF%D1%80%D0%B8-%D1%81%D0%BE%D0%B7%D0%B4%D0%B0%D0%BD%D0%B8%D0%B8-%D0%B2%D0%B5%D0%B1-%D1%81%D0%B0%D0%B9%D1%82%D0%B0/62%D1%81%D0%BC%D0%B5%D0%BD%D0%B0-%D1%8F%D0%B7%D1%8B%D0%BA%D0%B0-%D0%BA%D0%B0%D0%BB%D0%B5%D0%BD%D0%B4%D0%B0%D1%80%D1%8F)

It is necessary that the previous dates were not active. Video - 
[datepicker disable previousdate](https://www.youtube.com/watch?v=GYNtRphgzIw)

[Lesson # 18 Laravel 5.2 [ working with the database, SQL queries, the facade DB ] ( 32:00 ) ](https://www.youtube.com/watch?v=Hgyj2qXJLZE)
	- It is very convenient when developing to track all SQL-queries.
	
[Lesson # 19 Laravel 5.2 [Query Builder, QueryBuilder] ( 57:06 )](https://www.youtube.com/watch?v=lpxXfSpUTmo)

 Eloquent lessons Vasily Pupkin # 20-24 
######
 
[Lesson # 20 Laravel 5.2 [ Eloquent data model ] ( 32:20 )](https://www.youtube.com/watch?v=rVLiDwLbKew)

[Lesson # 21 Laravel 5.2 [ data model, Eloquent (softDelete, create, delete, update) ] ( 33:27 )](https://www.youtube.com/watch?v=sOKFssTuKPI)

[Lesson # 22 Laravel 5.2 [data model, Eloquent (links between tables)] ( 50:54 ) ](https://www.youtube.com/watch?v=HvVxbaaLGtI) 
	
[+relationships between tables Laravel documentation](Http://laravel.su/docs/5.3/eloquent#relationships)

[Lesson # 23 Laravel 5.2 [ using links between Eloquent models ] ( 37:47 ) ](https://www.youtube.com/watch?v=pZpHbabxCFc&t=5s) 

[Lesson # 24 Laravel 5.2 [ using links between Eloquent models, mutators ] ( 44:03 ) ](https://www.youtube.com/watch?v=tgTIs3rG7XE)