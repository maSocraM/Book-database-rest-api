<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * Utilitary class to seed the database, in this case, with fake data
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Publisher::class, 25)->create();
        factory(App\Author::class, 43)->create();
        factory(App\Book::class, 100)->create();

        $authors = \App\Author::pluck('id')->all();

        // select all 100 book records
        foreach (range(1, 100) as $index) {

            // select a random number of authors
            $r = rand(1, 7);

            // do a loop...
            for ($r; $r > 0; $r--) {

                // ...and insert randomly an author $r *
                DB::table('author_book')->insert(
                   [
                       'author_id' => $authors[rand(0, count($authors) - 1)],
                       'book_id' => $index,
                   ]
                );                
            }
        }        
    }
}
