<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Collection;

class Book extends Model
{
    /**
     * Получает все книги у которых N и более авторов
     *
     * @param int $count
     * @return string
     */
   public function getBookWithNAuthors(int $count) : string
   {
        $query = "
            SELECT 
                id, title, book_ids.cnt
            FROM
                library.books
                    INNER JOIN
                (SELECT 
                    COUNT(book_id) AS cnt, book_id
                FROM
                    library.authors
                GROUP BY book_id
                HAVING cnt >= $count) AS book_ids ON library.books.id = book_ids.book_id
         ";

       $orders = DB::select($query);
       return json_encode($orders);

   }

    /**
     * Получаем все книги
     *
     * @return Collection
     */
    public function getAllBooks() : Collection
    {
        return DB::table('books')->select('*')->get();
    }
}
