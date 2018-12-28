<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 22/09/18
 * Time: 23:59
 * Reference: https://medium.com/@stephenjudesuccess/testing-lumen-api-with-phpunit-tests-555835724b96
 */

/**
 * Class BookTest
 *
 * Unity test on /books endpoint
 */
class BookTest extends TestCase
{

    /**
     * [GET]
     * /books/highlighted
     *
     * Test: Get all highlighted books
     * Return code: 200
     */
    public function testHighlightedAll()
    {
        $this->get('/books/highlighted', []);
        $this->seeStatusCode('200');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'id',
                    'title',
                    'publisher_id',
                    'publish_date',
                    'isbn',
                    'isbn_thirteen',
                    'description',
                    'image',
                    'highlight',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'authors'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /books/highlighted/n/n
     *
     * Test: Get all highlighted books with offset and limit
     * Return code: 200
     */
    public function testHighlightedAllWithOffset()
    {
        $this->get('/books/highlighted/5/5', []);
        $this->seeStatusCode('200');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'id',
                    'title',
                    'publisher_id',
                    'publish_date',
                    'isbn',
                    'isbn_thirteen',
                    'description',
                    'image',
                    'highlight',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'authors'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /books/{id}
     *
     * Test: Get only one book record
     * Return code: 200
     */
    public function testGetOne()
    {
        $this->get('/books/1', []);
        $this->seeStatusCode('200');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'id',
                    'title',
                    'publisher_id',
                    'publish_date',
                    'isbn',
                    'isbn_thirteen',
                    'description',
                    'image',
                    'highlight',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'authors'
                ]
            ],
        ]);
    }
    
    /**
     * [GET]
     * /books/search
     *
     * Test: Textual search without results
     * Return code: 200
     */
    public function testSearchNoResults()
    {
        $this->get('/books/search', []);
        $this->seeStatusCode('200');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message'
            ],
            'content' => [],
        ]);
    }

    /**
     * [POST]
     * /books/highlighted
     *
     * Test: Send a POST where GET is expected
     * Return code: 405
     */
    public function testHighlightedAllNotAllowed()
    {
        $this->post('/books/highlighted', []);
        $this->seeStatusCode('405');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message'
            ],
            'content' => [],
        ]);
    }

    /**
     * [POST]
     * /books/{id}
     *
     * Test: Send a POST where GET is expected
     * Return code: 405
     */
    public function testGetOneMethodNotAllowed()
    {
        $this->post('/books/2', []);
        $this->seeStatusCode('405');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [],
        ]);
    }

    /**
     * [POST]
     * /books
     *
     * Test: Create a Book record
     * Return code: 200
     */
    public function testInsert()
    {
        $posted_data = [
            "title" => "Title Test 4",
            "publisher_id" => 25,
            "publish_date" => "1978-05-04",
            "isbn" => 1234567890,
            "isbn_thirteen" => 1234567890123,
            "description" => "A book about fair tales.",
            "highlight" => 0,
            "authors" => [7]
        ];

        $this->post("books", $posted_data, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'id',
                    'title',
                    'publisher_id',
                    'publish_date',
                    'isbn',
                    'isbn_thirteen',
                    'description',
                    'image',
                    'highlight',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'authors'
                ]
            ],
        ]);

    }

    /**
     * [POST]
     * /books
     *
     * Test: Validation of all mandatory fields
     * Return code: 422
     */
    public function testInsertValidation()
    {
        $posted_data = [
            "title" => "",
            "publisher_id" => 0,
            "publish_date" => "",
            "isbn" => 12345678901,
            "isbn_thirteen" => 12345678901234,
            "description" => "",
            "highlight" => 0,
            "authors" => []
        ];

        $this->post("books", $posted_data, []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [
                '*' => [],
            ],
        ]);

    }
    
    /**
     * [PUT]
     * /books
     *
     * Test: Update a Book record
     * Return code: 201
     */
    public function testUpdate()
    {
        $posted_data = [
            "title" => "Title Test 5",
            "publisher_id" => 12,
            "publish_date" => "1978-05-04",
            "isbn" => 1234567890,
            "isbn_thirteen" => 1234567890123,
            "description" => "A book about fair tales.",
            "highlight" => 0,
            "authors" => [7]
        ];

        $this->put("books/3", $posted_data, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'id',
                    'title',
                    'publisher_id',
                    'publish_date',
                    'isbn',
                    'isbn_thirteen',
                    'description',
                    'image',
                    'highlight',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'authors'
                ]
            ],
        ]);
    } 

    /**
     * [PUT]
     * /books
     *
     * Test: Validation of all mandatory fields
     * Return code: 422
     */
    public function testUpdateValidation()
    {
        $posted_data = [
            "title" => "",
            "publisher_id" => 0,
            "publish_date" => "",
            "isbn" => 12345678901,
            "isbn_thirteen" => 12345678901234,
            "description" => "",
            "highlight" => 0,
            "authors" => []
        ];

        $this->put("books/4", $posted_data, []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [
                '*' => [],
            ],
        ]);
    }
  
    /**
     * [PUT]
     * /books
     *
     * Test: Send a PUT without content and record ID
     * Return code: 405
     */
    public function testUpdateMethodNotAllowed()
    {
        $posted_data = [];

        $this->put("books", $posted_data, []);
        $this->seeStatusCode(405);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [
            ],
        ]);
    }
    
    /**
     * [PUT]
     * /books/{id}
     *
     * Test: Send a PUT without content
     * Return code: 422
     */
    public function testUpdateUnprocessableEntity()
    {
        $posted_data = [];

        $this->put("books/5", $posted_data, []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [
            ],
        ]);
    }

    /**
     * [DELETE]
     * /books/{id}
     *
     * Test: Delete a book record
     * Return code: 200
     */
    public function testDelete()
    {
        $this->delete('books/6', [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [
            ],
        ]);
    }

    /**
     * [DELETE]
     * /books
     *
     * Test: Send a DELETE without an expected ID
     * Return code: 405
     */
    public function testDeleteMethodNotAllowed()
    {
        $this->delete("books", []);
        $this->seeStatusCode(405);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [
            ],
        ]);
    }

    /**
     * [GET]
     * /books/search/{term}
     *
     * Test: Do a textual search by title and description
     * Return code: 200
     */
    public function testSearch()
    {
        $this->get('/books/search/test', []);
        $this->seeStatusCode('200');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'id',
                    'title',
                    'publisher_id',
                    'publish_date',
                    'isbn',
                    'isbn_thirteen',
                    'description',
                    'image',
                    'highlight',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'authors'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /books/search/{term}/{offset}/{limit}
     *
     * Test: Do a textual search by title and description using Offset and Limit
     * Return code: 200
     */
    public function testSearchOffsetLimit()
    {
        $this->get('/books/search/test/1/10', []);
        $this->seeStatusCode('200');
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'id',
                    'title',
                    'publisher_id',
                    'publish_date',
                    'isbn',
                    'isbn_thirteen',
                    'description',
                    'image',
                    'highlight',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                    'authors'
                ]
            ],
        ]);
    }
}