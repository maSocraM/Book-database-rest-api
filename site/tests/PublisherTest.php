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
 * Unity test on /publishers endpoint
 *
 */
class PublisherTest extends TestCase
{

    /**
     * [GET]
     * /publisher/list
     *
     * Test: Get all publishers
     * Return code: 200
     */
    public function testGetAll()
    {
        $this->get('/publishers/list', []);
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
                    'name',
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /publisher/list/n/n
     *
     * Test: Get all publishers with offset and limit
     * Return code: 200
     */
    public function testGetAllWithOffset()
    {
        $this->get('/publishers/list/5/5', []);
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
                    'name',
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /publisher/{id}
     *
     * Test: Get only one publisher record
     * Return code: 200
     */
    public function testGetOne()
    {
        $this->get('/publishers/1', []);
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
                    'name',
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    }

    /**
     * [GET]
     * /publisher
     *
     * Test: Send a GET where POST is expected
     * Return code: 405
     */
    public function testGetOneNotAllowed()
    {
        $this->get('/publishers', []);
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
     * /publisher/list
     *
     * Test: Send a POST where GET is expected
     * Return code: 405
     */
    public function testGetAllNotAllowed()
    {
        $this->post('/publishers/list', []);
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
     * /publisher/{id}
     *
     * Test: Send a POST where PUT or DELETE are expected
     * Return code: 405
     */
    public function testGetOneMethodNotAllowed()
    {
        $this->post('/publishers/2', []);
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
     * /publisher
     */
    public function testInsert()
    {
        $posted_data = [
            'name' => 'Publisher Test'
        ];

        $this->post("publishers", $posted_data, []);
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
                    'created_at',
                    'updated_at',
                    'id'
                ]
            ],
        ]);

    }

    /**
     * [POST]
     * /publisher
     *
     * Test: Validation of name field (empty)
     * Return code: 422
     */
    public function testInsertValidation()
    {
        $posted_data = [
            'name' => ''
        ];

        $this->post("publishers", $posted_data, []);
        $this->seeStatusCode(422);
        $this->seeJsonStructure([
            'header' => [
                'status',
                'message',
            ],
            'content' => [],
        ]);

    }

    /**
     * [PUT]
     * /publisher
     *
     * Test: Update a Publisher record
     * Return code: 201
     */
    public function testUpdate()
    {
        $posted_data = [
            'name' => 'Publisher Test Update'
        ];

        $this->put("publishers/3", $posted_data, []);
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
                    'deleted_at',
                    'created_at',
                    'updated_at'
                ]
            ],
        ]);
    }

    /**
     * [PUT]
     * /publisher
     *
     * Test: Send a PUT without content and record ID
     * Return code: 405
     */
    public function testUpdateMethodNotAllowed()
    {
        $posted_data = [];

        $this->put("publishers", $posted_data, []);
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
     * /publisher
     *
     * Test: Validation of name field (empty)
     * Return code: 422
     */
    public function testUpdateNameValidation()
    {
        $posted_data = [
            'name' => ''
        ];

        $this->put("publishers/4", $posted_data, []);
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
     * /publisher/{id}
     *
     * Test: Send a PUT without content
     * Return code: 422
     */
    public function testUpdateUnprocessableEntity()
    {
        $posted_data = [];

        $this->put("publishers/5", $posted_data, []);
        $this->seeStatusCode('422');
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
     * /publisher/{id}
     *
     * Test: Delete an publisher record
     * Return code: 200
     */
    public function testDelete()
    {
        $this->delete('publishers/6', [], []);
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
     * /publisher
     *
     * Test: Send a DELETE without an Author ID
     * Return code: 405
     */
    public function testDeleteMethodNotAllowed()
    {
        $this->delete("publishers", []);
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