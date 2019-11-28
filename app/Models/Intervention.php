<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Intervention
 *
 * @property int $id
 * @property int $patient_id
 * @property string $traitement_sortie
 * @property string $suite_operatoire
 * @property string $sortie
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention whereSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention whereSuiteOperatoire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention whereTraitementSortie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Intervention whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Intervention extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
