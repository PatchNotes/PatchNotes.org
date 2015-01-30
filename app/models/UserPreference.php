<?php

class UserPreference extends Eloquent
{
    protected $table = 'user_preferences';

    protected $fillable = array('user_id');

    public function user() {
        return $this->belongsTo('User');
    }

    public static function timezoneSelectBox() {
        $tzs = DateTimeZone::listIdentifiers();

        return array_combine($tzs, $tzs);
    }

    public static function timeSelectBox() {
        return [
            "00:00:00" => "12:00 a.m. midnight",
            "01:00:00" => "1:00 a.m.",
            "02:00:00" => "2:00 a.m.",
            "03:00:00" => "3:00 a.m.",
            "04:00:00" => "4:00 a.m.",
            "05:00:00" => "5:00 a.m.",
            "06:00:00" => "6:00 a.m.",
            "07:00:00" => "7:00 a.m.",
            "08:00:00" => "8:00 a.m.",
            "09:00:00" => "9:00 a.m.",
            "10:00:00" => "10:00 a.m.",
            "11:00:00" => "11:00 a.m.",
            "12:00:00" => "12:00 p.m. noon",
            "13:00:00" => "1:00 p.m.",
            "14:00:00" => "2:00 p.m.",
            "15:00:00" => "3:00 p.m.",
            "16:00:00" => "4:00 p.m.",
            "17:00:00" => "5:00 p.m.",
            "18:00:00" => "6:00 p.m.",
            "19:00:00" => "7:00 p.m.",
            "20:00:00" => "8:00 p.m.",
            "21:00:00" => "9:00 p.m.",
            "22:00:00" => "10:00 p.m.",
            "23:00:00" => "11:00 p.m.",
        ];
    }

    public static function daySelectBox() {
        $days = [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];

        return array_combine($days, $days);
    }

}