<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Examen
 *
 * @property int $id
 * @property int $patient_id
 * @property string $type
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Examen whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Examen extends Model
{
    protected $fillable = [
        
        'image',
        'nom',
        'description',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
