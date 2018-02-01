<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Collection;

class AjaxController extends Controller
{
    protected $author;
    protected $book;
    protected $request;

    /**
     * AjaxController constructor.
     * @param Author $author
     * @param Book $book
     * @param Request $request
     */
    public function __construct(Author $author, Book $book, Request $request)
    {
        $this->author = $author;
        $this->book = $book;
        $this->request = $request;
    }

    /**
     * Получаем книги из модели по количеству авторов
     *
     * @return string
     */
    public function task() :string
    {
        $qty = (int) $this->request->get('qty');
        if($qty === 0) return 'false';
        $result = $this->book->getBookWithNAuthors($qty);
        return $result !== '[]' ? $result : 'false';

    }

    /**
     * Получаем всех авторов
     *
     * @return Collection
     */
    public function authors() : Collection
    {
       return $this->author->getAllAuthors();
    }

    /**
     * Получаем все книги
     *
     * @return Collection
     */
    public function books() : Collection
    {
        return $this->book->getAllBooks();
    }

    /**
     * Записываем информацию в файл
     */
    public function file()
    {
        $currentDate = getdate();
        $arrInfo = [
            'width' => (int) $this->request->get('width'),
            'height' => (int) $this->request->get('height'),
            'y' => $currentDate['year'],
            'm' => $currentDate['mon'],
            'mday' => $currentDate['mday'],
            'hours' => $currentDate['hours'],
            'minutes' => $currentDate['minutes'],
            'seconds' => $currentDate['seconds'],

        ];
        $fd = fopen("../info.txt", 'w') or die("не удалось создать файл");
        $str = "Данные: дата,время: {$arrInfo['y']}-{$arrInfo['m']}-{$arrInfo['mday']} {$arrInfo['hours']}:{$arrInfo['minutes']}:{$arrInfo['seconds']}."
            . " Разрешение экрана: {$arrInfo['width']}X{$arrInfo['height']}";
        fwrite($fd, $str);
        fclose($fd);

    }

    /**
     * Задача про баронов
     *
     * @param int $m
     * @param int $n
     * @return int
     */
    function distributeStake(int $m, int $n): int
    {
        return round($n / $m);
    }

}
