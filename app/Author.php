<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Collection;

class Author extends Model
{
    /**
     * Получаем всех авторов
     *
     * @return Collection
     */
    public function getAllAuthors() : Collection
    {
        return DB::table('authors')->select('*')->get();
    }
}
