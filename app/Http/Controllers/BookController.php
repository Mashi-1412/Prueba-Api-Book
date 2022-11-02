<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        //return Book::paginate();
        /** Con paginate() podriamos tener un listado ordenado por paginas
         */
        return Book::all();
    }


    public function store(Request $request)
    {
        $request->validate(['titulo'=>['required']]);

        $book = new Book; //Se crea la instancia del modelo book de eloquent
        $book->titulo= $request->input('titulo'); //Se asigna el nombre  al libro nuevo y obtenemos el titulo con request
        $book->save(); // guardamos el dato en la base con save

        return $book;
    }

    /**Con la inyeccion del Objeto Book nos devuelve todos los datos,
     * pero solo con la variable $book se retorna el ID del libros,
     * para ello podriamo utilizar 'return Book::find($book);
     */
    public function show(Book $book)
    {
        return $book;
    }


    public function update(Request $request, Book $book)
    {
        $request->validate(['titulo'=>['required']]);


        $book->titulo= $request->input('titulo'); //Se asigna el nombre actualizado del libro obtenido
        $book->save(); // guardamos el dato en la base con save

        return $book;
    }


    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
