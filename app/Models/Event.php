<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Event
 *
 * @property int $id
 * @property string $title
 * @property string $date
 * @property string $start_time
 * @property string|null $end_time
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $patient_id
 * @property-read \App\Patient|null $patients
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUserId($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    protected $fillable = ['title', 'date', 'start_time','end_time','color', 'patient_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
