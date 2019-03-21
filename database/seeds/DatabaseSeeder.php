<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\Author;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		if (($handle = fopen ( public_path () . '/Lab4Books.csv', 'r' )) !== FALSE) {
			while ( ($data = fgetcsv ( $handle, ',' )) !== FALSE ) {
				try {
					$b_data = new Book ();
					$b_data->ISBN = trim($data [0]);
					$b_data->name = trim($data [1]);
					$b_data->publication_year = trim($data [3]);
					$b_data->publisher = trim($data [4]);
					$b_data->image = trim($data [5]);
					$b_data->save ();
					$book = Book::where('ISBN', $data[0])->first();
					$authNames = $data[2];
					$auths = explode(",", $authNames);
					foreach($auths as $name) {
						$name = trim($name, " \"\n\t\r");
						if (Author::where('name', 'ILIKE', $name)->exists() != 1) {
							$a_data = new Author();
							$a_data->name = $name;
							$a_data->save();
							//$a_id = $a_data->id;
							$book->authors()->attach($a_data->id);
						}
						else {
						//	$a_id = Author::where('name', 'ILIKE', trim($data[2]))->first()->id;
							$book->authors()->attach(Author::where('name', 'ILIKE', $name)->first()->id);
						}
						//$book->authors()->attach($a_id);
					}
				} catch (Exception $e) {
					//
				}
			}
			fclose ( $handle );
		}
		}
}
