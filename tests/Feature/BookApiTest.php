<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class BookApiTest extends TestCase
{
    use RefreshDatabase;
    /**  @test */
    function can_get_all_books(){

        $books = Book::factory(5)->create();

        $response= $this->getJson(route('books.index'));

        $response->assertJsonFragment([
            'titulo'=>$books[0]->titulo
        ])->assertJsonFragment([
            'titulo'=>$books[1]->titulo
        ]);

    }

    /**  @test */
    function can_get_one_books(){

        $book=Book::factory()->create();

        $response= $this->getJson(route('books.show',$book));

        //verificar el titulo sea igual al book 'titulo
        $response->assertJsonFragment([
            'titulo'=>$book->titulo
        ]);
    }

    /**  @test */
    function can_creat_books(){

        //test de regresion
        $this->postJson(route('books.store'),[])
            ->assertJsonValidationErrorFor('titulo');

        $this->postJson(route('books.store'),[
            'titulo'=>'Mis anecdotas'
        ])->assertJsonFragment([
            'titulo'=>'Mis anecdotas'
        ]);

        $this->assertDatabaseHas('books',[
            'titulo'=>'Mis anecdotas'
        ]);
    }

    /**  @test */
    function can_update_books(){


        $book=Book::factory()->create();

        //test de regresion
        $this->patchJson(route('books.update',$book),[])
            ->assertJsonValidationErrorFor('titulo');

        $this->patchJson(route('books.update',$book),[
            'titulo'=>'Titulo editado'
        ])->assertJsonFragment([
            'titulo'=>'Titulo editado'
        ]);

        $this->assertDatabaseHas('books',[
            'titulo'=>'Titulo editado'
        ]);

    }

    /**  @test */
    function can_delete_books(){

        $book=Book::factory()->create();

        $this->deleteJson(route('books.destroy',$book))
            ->assertNoContent();
        $this->assertDatabaseCount('books',0);

    }
}
