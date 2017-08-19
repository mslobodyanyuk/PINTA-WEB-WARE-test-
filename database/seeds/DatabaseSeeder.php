<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CitiesTableSeeder::class);
         $this->call(ScheduletypesTableSeeder::class);
         $this->call(TrainsTableSeeder::class);
         $this->call(ScheduleTableSeeder::class);
    }
}

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
                                        ['name' => 'Баловка'],
                                        ['name' => 'Верховцево'],
                                        ['name' => 'Геническ'],
                                        ['name' => 'Днепродзержинск'],
                                        ['name' => 'Запорожье'],
                                        ['name' => 'Красноармейск'],
                                        ['name' => 'Красноград'],
                                        ['name' => 'Кривой Рог'],
                                        ['name' => 'Лозовая'],
                                        ['name' => 'Межевая'],
                                        ['name' => 'Орловщина'],
                                        ['name' => 'Пятихатки'],
                                        ['name' => 'Синельниково'],
                                        ['name' => 'Славянка'],
                                        ['name' => 'Чаплино']
                                     ]);
    }
}

class ScheduletypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedule_types')->insert([
                                                ['name' => 'ежедневно'],
                                                ['name' => 'по-будням'],
                                                ['name' => 'по-выходным']
                                            ]);
    }

}

class TrainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trains')->insert([
                                        ['name' => '6272', 'type' =>'-'],
                                        ['name' => '6005', 'type' =>'-'],
                                        ['name' => '6284', 'type' =>'-'],
                                        ['name' => '6253', 'type' =>'-'],
                                        ['name' => '6256', 'type' =>'-'],
                                        ['name' => '6255', 'type' =>'-'],
                                        ['name' => '6011', 'type' =>'-'],
                                        ['name' => '6013', 'type' =>'-'],
                                        ['name' => '6702', 'type' =>'скоростной'],
                                        ['name' => '6701', 'type' =>'скоростной'],
                                        ['name' => '6013', 'type' =>'-'],
                                        ['name' => '6112', 'type' =>'-'],
                                        ['name' => '6111', 'type' =>'-'],
                                        ['name' => '6110', 'type' =>'-'],
                                        ['name' => '6015', 'type' =>'-'],
                                        ['name' => '6172', 'type' =>'-'],
                                        ['name' => '826П', 'type' =>'-'],
                                        ['name' => '6547', 'type' =>'-'],
                                        ['name' => '6548', 'type' =>'-'],
                                        ['name' => '6023', 'type' =>'-'],
                                        ['name' => '6140', 'type' =>'-'],
                                        ['name' => '6027', 'type' =>'-'],
                                        ['name' => '6276', 'type' =>'-'],
                                        ['name' => '6031', 'type' =>'-'],
                                        ['name' => '6118', 'type' =>'-'],
                                        ['name' => '6033', 'type' =>'-'],
                                        ['name' => '6535', 'type' =>'-'],
                                        ['name' => '6280', 'type' =>'-'],
                                        ['name' => '6124', 'type' =>'-'],
                                        ['name' => '6123', 'type' =>'-'],
                                        ['name' => '6537', 'type' =>'-'],
                                        ['name' => '6122', 'type' =>'-'],
                                        ['name' => '6035', 'type' =>'-'],
                                        ['name' => '6154', 'type' =>'-'],
                                        ['name' => '6037', 'type' =>'-'],
                                        ['name' => '6126', 'type' =>'-'],
                                        ['name' => '6039', 'type' =>'-'],
                                        ['name' => '6282', 'type' =>'-'],
                                        ['name' => '6174', 'type' =>'-'],
                                        ['name' => '6041', 'type' =>'-'],
                                        ['name' => '6043', 'type' =>'-'],
                                        ['name' => '6130', 'type' =>'-'],
                                        ['name' => '6156', 'type' =>'-'],
                                        ['name' => '6136', 'type' =>'-'],
                                        ['name' => '6045', 'type' =>'-'],
                                        ['name' => '6047', 'type' =>'-'],
                                    ]);
    }

}

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->insert([
                                            ['train_id' => '1', 'city_id' => '9', 'time' => '03.25', 'schedule_type_id' => '2' ],
                                            ['train_id' => '2', 'city_id' => '12', 'time' => '05.00', 'schedule_type_id' => '1' ],
                                            ['train_id' => '3', 'city_id' => '9', 'time' => '05.34', 'schedule_type_id' => '1' ],
                                            ['train_id' => '4', 'city_id' => '4', 'time' => '06.20', 'schedule_type_id' => '2' ],
                                            ['train_id' => '5', 'city_id' => '1', 'time' => '06.20', 'schedule_type_id' => '2' ],
                                            ['train_id' => '6', 'city_id' => '1', 'time' => '06.20', 'schedule_type_id' => '2' ],
                                            ['train_id' => '7', 'city_id' => '8', 'time' => '06.51', 'schedule_type_id' => '2' ],
                                            ['train_id' => '8', 'city_id' => '2', 'time' => '07.18', 'schedule_type_id' => '2' ],
                                            ['train_id' => '9', 'city_id' => '3', 'time' => '07.18', 'schedule_type_id' => '1' ],
                                            ['train_id' => '10', 'city_id' => '3', 'time' => '07.18', 'schedule_type_id' => '1' ],
                                            ['train_id' => '11', 'city_id' => '12', 'time' => '07.18', 'schedule_type_id' => '2' ],
                                            ['train_id' => '12', 'city_id' => '5', 'time' => '08.09', 'schedule_type_id' => '1' ],
                                            ['train_id' => '13', 'city_id' => '5', 'time' => '08.09', 'schedule_type_id' => '1' ],
                                            ['train_id' => '14', 'city_id' => '15', 'time' => '08.40', 'schedule_type_id' => '1' ],
                                            ['train_id' => '15', 'city_id' => '2', 'time' => '08.40', 'schedule_type_id' => '2' ],
                                            ['train_id' => '16', 'city_id' => '7', 'time' => '08.47', 'schedule_type_id' => '1' ],
                                            ['train_id' => '17', 'city_id' => '6', 'time' => '09.40', 'schedule_type_id' => '2' ],
                                            ['train_id' => '18', 'city_id' => '5', 'time' => '10.09', 'schedule_type_id' => '1' ],
                                            ['train_id' => '19', 'city_id' => '5', 'time' => '10.09', 'schedule_type_id' => '1' ],
                                            ['train_id' => '20', 'city_id' => '4', 'time' => '10.50', 'schedule_type_id' => '2' ],
                                            ['train_id' => '21', 'city_id' => '15', 'time' => '11.03', 'schedule_type_id' => '2' ],
                                            ['train_id' => '22', 'city_id' => '8', 'time' => '12.57', 'schedule_type_id' => '2' ],
                                            ['train_id' => '23', 'city_id' => '9', 'time' => '13.20', 'schedule_type_id' => '1' ],
                                            ['train_id' => '24', 'city_id' => '4', 'time' => '14.38', 'schedule_type_id' => '2' ],
                                            ['train_id' => '25', 'city_id' => '13', 'time' => '14.40', 'schedule_type_id' => '2' ],
                                            ['train_id' => '26', 'city_id' => '4', 'time' => '15.44', 'schedule_type_id' => '2' ],
                                            ['train_id' => '27', 'city_id' => '12', 'time' => '15.51', 'schedule_type_id' => '2' ],
                                            ['train_id' => '28', 'city_id' => '9', 'time' => '16.06', 'schedule_type_id' => '1' ],
                                            ['train_id' => '29', 'city_id' => '5', 'time' => '16.16', 'schedule_type_id' => '1' ],
                                            ['train_id' => '30', 'city_id' => '5', 'time' => '16.16', 'schedule_type_id' => '1' ],
                                            ['train_id' => '31', 'city_id' => '8', 'time' => '16.20', 'schedule_type_id' => '1' ],
                                            ['train_id' => '32', 'city_id' => '15', 'time' => '16.27', 'schedule_type_id' => '1' ],
                                            ['train_id' => '33', 'city_id' => '12', 'time' => '16.50', 'schedule_type_id' => '1' ],
                                            ['train_id' => '34', 'city_id' => '11', 'time' => '17.21', 'schedule_type_id' => '2' ],
                                            ['train_id' => '35', 'city_id' => '12', 'time' => '17.23', 'schedule_type_id' => '1' ],
                                            ['train_id' => '36', 'city_id' => '15', 'time' => '17.30', 'schedule_type_id' => '1' ],
                                            ['train_id' => '37', 'city_id' => '4', 'time' => '18.18', 'schedule_type_id' => '1' ],
                                            ['train_id' => '38', 'city_id' => '13', 'time' => '18.38', 'schedule_type_id' => '1' ],
                                            ['train_id' => '39', 'city_id' => '7', 'time' => '18.50', 'schedule_type_id' => '1' ],
                                            ['train_id' => '40', 'city_id' => '2', 'time' => '19.36', 'schedule_type_id' => '1' ],
                                            ['train_id' => '41', 'city_id' => '12', 'time' => '20.27', 'schedule_type_id' => '1' ],
                                            ['train_id' => '42', 'city_id' => '10', 'time' => '20.43', 'schedule_type_id' => '1' ],
                                            ['train_id' => '43', 'city_id' => '14', 'time' => '21.30', 'schedule_type_id' => '2' ],
                                            ['train_id' => '44', 'city_id' => '13', 'time' => '22.09', 'schedule_type_id' => '2' ],
                                            ['train_id' => '45', 'city_id' => '2', 'time' => '22.33', 'schedule_type_id' => '2' ],
                                            ['train_id' => '46', 'city_id' => '2', 'time' => '23.46', 'schedule_type_id' => '1' ]
                                        ]);
    }

}