<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 23/09/18
 * Time: 12:52
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use DB;
use App\{IRestCall, Utils};


/**
 * Class BaseRestController
 *
 * Father class containing all default calls common to any endpoint (or almost part)
 *
 * @package App\Http\Controllers
 * @see App\Http\CBaseRestController
 * @see App\IRestCall
 */
class BaseRestController extends BaseController implements IRestCall
{
    // Receive the son's class name
    protected $className = "";
    // Receive the complete namespace from son's
    protected $nameSpace = "";
    // Store all validations rules
    protected $validationRules = [];


    /**
     * Get all rows of a Model, using or not limit and offset
     *
     * @param int $offset
     * @param int $limit
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAll(int $offset = 0, int $limit = 0)
    {

        $content = DB::table(strtolower($this->className) . 's');

        // An offset parameter only can be used with a limit value
        if ($offset > 0 && $limit > 0) {
            $content->offset($offset);
            $content->limit($limit);
        }

        $res = $content->get()->toArray();

        if (count($res) > 0) {
            $ret = Utils::genReturnContent(0, $res);
        } else {
            $ret = Utils::genReturnContent(1);
        }

        return response()->json($ret);
    }


    /**
     * Get an specific row of a Model
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getOne(int $id = 0)
    {

        $res = $this->nameSpace::find($id);

        if (!is_null($res)) {
            $ret = Utils::genReturnContent(0, [$res->toArray()]);
        } else {
            $ret = Utils::genReturnContent(1);
        }

        return response()->json($ret);
    }


    /**
     * Insert data using Model
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(Request $request)
    {

        $this->validate($request, $this->validationRules);

        $res = $this->nameSpace::create($request->all());

        if (!is_null($res)) {
            $ret = Utils::genReturnContent(0, [$res->toArray()]);
        } else {
            $ret = Utils::genReturnContent(1);
        }

        return response()->json($ret);

    }


    /**
     * Update data using Model
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(int $id = 0, Request $request)
    {
        $this->validate($request, $this->validationRules);

        $res = $this->nameSpace::find($id);

        $retHttpCode = 201;

        if ($res !== null) {
            $included = $res->update($request->all());

            if ($included === true) {
                $ret = Utils::genReturnContent(0, [$this->nameSpace::find($id)->toArray()]);
            } else {
                $ret = Utils::genReturnContent(5);
            }

        } else {
            $ret = Utils::genReturnContent(6, [], "Resource not found.");
            $retHttpCode = 404;
        }

        return response()->json($ret, $retHttpCode);
    }


    /**
     * Soft Delete data using Model
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function delete(int $id = 0)
    {
        $res = $this->nameSpace::find($id);

        $retHttpCode = 200;

        if ($res !== null) {
            $excluded = $res->delete();

            if ($excluded === true) {
                $ret = Utils::genReturnContent(0);
            } else {
                $ret = Utils::genReturnContent(5);
            }

        } else {
            $ret = Utils::genReturnContent(6, [], "Resource not found.");
            $retHttpCode = 404;
        }

        return response()->json($ret, $retHttpCode);
    }

}