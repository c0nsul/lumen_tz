<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table="currencies";
    protected $primaryKey="id";

    protected $guarded=['id'];

    public function saveCurrency(array $data)
    {
        $self = new self();
            foreach ($data as $key=>$value){
                if(is_array($value)){
                    $self->create($value);
                }
                continue;
            }
    }

}
