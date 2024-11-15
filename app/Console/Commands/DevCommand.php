<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Console\Command;

class DevCommand extends Command
{
    protected $signature = 'develop';

    protected $description = 'Command description';

    public function handle()
    {
//        $this->start();
        $user = User::find(1);
        dd($user->books->toArray());
    }

    public function start()
    {
        $authorData1 =[
            'name'=>'Ivan',
            'bio'=>'Some bio'
        ];

        $authorData2 =[
            'name'=>'Solo',
            'bio'=>'Some bio'
        ];

        $author1 = Author::create($authorData1);
        $author2 = Author::create($authorData2);


        $bookData1 =[
            'title'=>'Book 1',
            'author_id'=>$author1->id,
            'published_at'=>fake()->date(),
        ];

        $bookData2 =[
            'title'=>'Book 2',
            'author_id'=>$author1->id,
            'published_at'=>fake()->date(),
        ];

        $bookData3 =[
            'title'=>'Book 3',
            'author_id'=>$author2->id,
            'published_at'=>fake()->date(),
        ];

        $bookData4 =[
            'title'=>'Book 4',
            'author_id'=>$author2->id,
            'published_at'=>fake()->date(),
        ];

        $book1 = Book::create($bookData1);
        $book2 = Book::create($bookData2);
        $book3 = Book::create($bookData3);
        $book4 = Book::create($bookData4);

        $userData =[
            'name'=>'Serg',
            'email'=>'serserpar@gmail.com',
            'password'=>12345,
        ];

        $user = User::create($userData);

        $rentalData1=[
          'user_id'=>$user->id,
          'book_id'=>$book1->id,
          'rented_at'=>fake()->date(),
          'due_date'=>fake()->date(),
        ];

        $rentalData2=[
          'user_id'=>$user->id,
          'book_id'=>$book2->id,
          'rented_at'=>fake()->date(),
          'due_date'=>fake()->date(),
        ];

        $rentalData3=[
          'user_id'=>$user->id,
          'book_id'=>$book3->id,
          'rented_at'=>fake()->date(),
          'due_date'=>fake()->date(),
        ];

        $rentalData4=[
          'user_id'=>$user->id,
          'book_id'=>$book4->id,
          'rented_at'=>fake()->date(),
          'due_date'=>fake()->date(),
        ];

        $rental1 = Rental::create($rentalData1);
        $rental2 = Rental::create($rentalData2);
        $rental3 = Rental::create($rentalData3);
        $rental4 = Rental::create($rentalData4);
    }
}
