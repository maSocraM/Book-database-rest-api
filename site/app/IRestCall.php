<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 23/09/18
 * Time: 12:44
 */

namespace App;


use Illuminate\Http\Request;

/**
 * Interface IRestCall
 *
 * The boilerplate for the base endpoint's controllers
 *
 * @package App
 * @see App\Http\BaseRestController
 * @see App\IRestCall
 */
interface IRestCall
{

    /**
     * Get all rows from a table (AKA Model)
     *
     * @param int $offset [start point of result]
     * @param int $limit  [total rows that will be shown]
     * @return mixed
     */
    public function getAll(int $offset = 0, int $limit = 0);

    /**
     * Get only a result row from a table
     *
     * @param int $id [id from desired record]
     * @return mixed
     */
    public function getOne(int $id = 0);

    /**
     * Store posted data (Request object) in a table
     *
     * @param Request $request [posted data - json format]
     * @return mixed
     */
    public function insert(Request $request);

    /**
     * Update posted data (Request object) in a table
     *
     * @param int $id          [id from desired record]
     * @param Request $request [posted data - json format]
     * @return mixed
     */
    public function update(int $id = 0, Request $request);

    /**
     * Delete a specific record
     *
     * @param $id [id from desired record]
     * @return mixed
     */
    public function delete(int $id = 0);

}