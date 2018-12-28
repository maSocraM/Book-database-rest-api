<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 22/09/18
 * Time: 23:59
 * Reference: https://medium.com/@stephenjudesuccess/testing-lumen-api-with-phpunit-tests-555835724b96
 */

/**
 * Class AuthorTest
 *
 * Unity test on /authors endpoint
 *
 */
class AuthorTest extends TestCase
{

    /**
     * [GET]
     * /authors/list
     *
     * Test: Get all authors
     * Return code: 200
     */
    public function testGetAll()
    {
        $this->get('/authors/list', []);
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
                    'name',
                    'last_name',
                    'editorial_name',
                    'link',
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /authors/list/n/n
     *
     * Test: Get all authors with offset and limit
     * Return code: 200
     */
    public function testGetAllWithOffset()
    {
        $this->get('/authors/list/5/5', []);
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
                    'name',
                    'last_name',
                    'editorial_name',
                    'link',
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /authors/{id}
     *
     * Test: Get only one author record
     * Return code: 200
     */
    public function testGetOne()
    {
        $this->get('/authors/1', []);
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
                    'name',
                    'last_name',
                    'editorial_name',
                    'link',
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /authors
     *
     * Test: Send a GET where POST is expected
     * Return code: 405
     */
    public function testGetOneNotAllowed()
    {
        $this->get('/authors', []);
        $this->seeStatusCode(405);
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
     * /authors/list
     *
     * Test: Send a POST where GET is expected
     * Return code: 405
     */
    public function testGetAllNotAllowed()
    {
        $this->post('/authors/list', []);
        $this->seeStatusCode(405);
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
     * /authors/{id}
     *
     * Test: Send a POST where PUT or DELETE are expected
     * Return code: 405
     */
    public function testGetOneMethodNotAllowed()
    {
        $this->post('/authors/2', []);
        $this->seeStatusCode(405);
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
     * /authors
     *
     * Test: Create a Author record
     * Return code: 200
     */
    public function testInsert()
    {
        $posted_data = [
            'name' => 'Name',
            'last_name' => 'Last Name',
            'editorial_name' => 'Editorial Name',
            'link' => 'http://www.xpto.org/john_nobody.html', 
        ];

        $this->post("authors", $posted_data, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
                'total',
            ],
            'content' => [
                '*' => [
                    'name',
                    'last_name',
                    'editorial_name',
                    'link',
                    'created_at',
                    'updated_at',
                    'id'
                ]
            ],
        ]);

    }

    /**
     * [POST]
     * /authors
     *
     * Test: Validation of name field (empty)
     * Return code: 422
     */
    public function testInsertNameValidation()
    {
        $posted_data = [
            'name' => '',
            'last_name' => 'Last Name',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * [POST]
     * /authors
     *
     * Test: Validation of name field (large than expected)
     * Return code: 422
     */
    public function testInsertNameLargeValidation()
    {
        $posted_data = [
            'name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
            'last_name' => 'Last Name',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * [POST]
     * /authors
     *
     * Test: Validation of last name field (empty)
     * Return code: 422
     */
    public function testInsertLastNameValidation()
    {
        $posted_data = [
            'name' => 'First Name',
            'last_name' => '',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * [POST]
     * /authors
     *
     * Test: Validation of last name field (large than expected)
     * Return code: 422
     */
    public function testInsertLastNameLargeValidation()
    {
        $posted_data = [
            'name' => 'First Name',
            'last_name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * [POST]
     * /authors
     *
     * Test: Validation of editorial name (large than expected)
     * Return code: 422
     */
    public function testInsertEditorialtNameLargeValidation()
    {
        $posted_data = [
            'name' => 'First Name',
            'last_name' => 'Last Name',
            'editorial_name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
        ];

        $this->post("authors", $posted_data, []);
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
     * [POST]
     * /authors
     *
     * Test: Validation of editorial name field (empty)
     * Return code: 422
     */
    public function testInsertEditorialNameValidation()
    {
        $posted_data = [
            'name' => 'First Name',
            'last_name' => 'Last Name',
            'editorial_name' => '',
        ];

        $this->post("authors", $posted_data, []);
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
     * [POST]
     * /authors
     *
     * Test: Validation of name and last name fields (empty)
     * Return code: 422
     */
    public function testInsertNameLastNameValidation()
    {
        $posted_data = [
            'name' => '',
            'last_name' => '',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * [POST]
     * /authors
     *
     * Test: Validation of all fields (empty)
     * Return code: 422
     */
    public function testInsertAllEmptyValidation()
    {
        $posted_data = [
            'name' => '',
            'last_name' => '',
            'editorial_name' => '',
        ];

        $this->post("authors", $posted_data, []);
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
     * /authors
     *
     * Test: Update an Author record
     * Return code: 201
     */
    public function testUpdate()
    {
        $posted_data = [
            'name' => 'Name',
            'last_name' => 'Last Name',
            'editorial_name' => 'Editorial Name',
        ];

        $this->put("authors/3", $posted_data, []);
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
                    'name',
                    'last_name',
                    'editorial_name',
                    'link',
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    } 

    /**
     * [PUT]
     * /authors
     *
     * Test: Validation of name field (empty)
     * Return code: 422
     */
    public function testUpdateNameValidation()
    {
        $posted_data = [
            'name' => '',
            'last_name' => 'Last Name',
            'editorial_name' => 'Editorial Name',
        ];

        $this->put("authors/4", $posted_data, []);
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
     * [PUT]
     * /authors
     *
     * Test: Validation of name (large than expected)
     * Return code: 422
     */
    public function testUpdateNameLargeValidation()
    {
        $posted_data = [
            'name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
            'last_name' => 'Last Name',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * /authors
     *
     * Test: Validation of last name field (empty)
     * Return code: 422
     */
    public function testUpdateLastNameValidation()
    {
        $posted_data = [
            'name' => 'Name',
            'last_name' => '',
            'editorial_name' => 'Editorial Name',
        ];

        $this->put("authors/4", $posted_data, []);
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
     * [PUT]
     * /authors
     *
     * Test: Validation of last name field (large than expected)
     * Return code: 422
     */
    public function testUpdateLastNameLargeValidation()
    {
        $posted_data = [
            'name' => 'Name',
            'last_name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * /authors
     *
     * Test: Validation of name (empty) and last name fields (large than expected)
     * Return code: 422
     */
    public function testUpdateTwoValidation()
    {
        $posted_data = [
            'name' => '',
            'last_name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
            'editorial_name' => 'Editorial Name',
        ];

        $this->post("authors", $posted_data, []);
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
     * /authors
     *
     * Test: Validation of name (empty), last name and editorial_name fields (large than expected)
     * Return code: 422
     */
    public function testUpdateThreeValidation()
    {
        $posted_data = [
            'name' => '',
            'last_name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
            'editorial_name' => 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',
        ];

        $this->post("authors", $posted_data, []);
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
     * /authors
     *
     * Test: Send a PUT without content and record ID
     * Return code: 405
     */
    public function testUpdateMethodNotAllowed()
    {
        $posted_data = [];

        $this->put("authors", $posted_data, []);
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
     * /authors/{id}
     *
     * Test: Send a PUT without content
     * Return code: 422
     */
    public function testUpdateUnprocessableEntity()
    {
        $posted_data = [];

        $this->put("authors/5", $posted_data, []);
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
     * /authors/{id}
     *
     * Test: Delete an author record
     * Return code: 200
     */
    public function testDelete()
    {
        $this->delete('authors/6', [], []);
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
     * /authors
     *
     * Test: Send a DELETE without an Author ID
     * Return code: 405
     */
    public function testDeleteMethodNotAllowed()
    {
        $this->delete("authors", []);
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
}