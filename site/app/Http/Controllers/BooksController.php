<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 25/09/18
 * Time: 00:02
 */

namespace App\Http\Controllers;


use App\Utils;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


/**
 * Class BooksController
 *
 * Controls all requisitions sent to /books endpoint
 *
 * @package App\Http\Controllers
 * @see App\Http\CBaseRestController
 * @see App\IRestCall
 */
class BooksController extends BaseRestController
{

    public function __construct()
    {
        // Inform the Model name to father
        $this->className = 'Book';

        // Create a string containing the complete Model namespace
        $this->nameSpace = "\\App\\" . $this->className;

        // Create validation rules to be used in father class
        $this->validationRules = [
            'title' => 'required|max:125',
            'publisher_id' => 'required|exists:publishers,id',
            'publish_date' => 'required|date',
            'isbn' => 'required|max:10',
            'isbn_thirteen' => 'required|max:13',
            'description' => 'required|max:300',
            'image' => 'url',
            'highlight' => 'boolean',
            'authors' => 'required|exists:authors,id'
        ];
    }


    /**
     * Get all rows of a Model, using or not limit and offset
     *
     * @param int $offset [start position results]
     * @param int $limit [limit total of results]
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getAll(int $offset = 0, int $limit = 0)
    {

        $books = $this->nameSpace::where('highlight', '=', 1);

        // An offset parameter only can be used with a limit value
        if ($offset > 0 && $limit > 0) {
            $books->offset($offset);
            $books->limit($limit);
        }

        $res = $books->with('authors:id,editorial_name')->get()->toArray();

        if (count($res) > 0) {
            $ret = Utils::genReturnContent(0, $res);
        } else {
            $ret = Utils::genReturnContent(1);
        }

        return response()->json($ret);

    }


    /**
     * Get an specific row using Book model
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getOne(int $id = 0)
    {

        $res = $this->nameSpace::with('authors:id,editorial_name')
            ->get()
            ->find($id);

        if (!is_null($res)) {
            $ret = Utils::genReturnContent(0, [$res->toArray()]);
        } else {
            $ret = Utils::genReturnContent(1);
        }

        return response()->json($ret);
    }


    /**
     * Get results from string search
     *
     * @param string $term [term criteria to search in title and description]
     * @param int $offset [start position results]
     * @param int $limit [current pagination pointer]
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSearch(string $term, int $offset = 0, int $limit = 0)
    {

        $content = $this->nameSpace::with('authors:id,editorial_name')
            ->where('title', 'LIKE', '%' . $term . '%')
            ->orWhere('description', 'LIKE', '%' . $term . '%');

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
     * Validate and insert Book data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insert(Request $request)
    {
        $this->validate($request, $this->validationRules);

        $requestAll = $request->all();

        // get all authors data to store ahead
        $authors = $requestAll['authors'];

        // exclude authors data from root, because it will be
        // inserted in another process
        unset($requestAll['authors']);

        // Insert data and retrive ID from the row
        $id = $this->nameSpace::insertGetId($requestAll);

        if (is_numeric($id) && $id > 0) {

            $book = $this->nameSpace::find($id);

            // Insert in pivot table the authors to this book
            $book->authors()->attach($authors);

            $ret = Utils::genReturnContent(0,
                [
                 $this->nameSpace::with('authors:id,editorial_name')
                                 ->find($id)
                                 ->toArray()
                ]
            );
        } else {
            $ret = Utils::genReturnContent(5);
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

        $book = $this->nameSpace::find($id);

        $retHttpCode = 201;

        if ($book !== null) {

            $requestAll = $request->all();

            $authors = $requestAll['authors'];

            unset($requestAll['authors']);

            $updated = $book->update($requestAll);

            if ($updated === true) {

                // clean all pivot keys
                $book->authors()->detach();

                // to insert the new ones
                $book->authors()->attach($authors);

                $ret = Utils::genReturnContent(0,
                    [
                        $this->nameSpace::with('authors:id,editorial_name')
                            ->find($id)
                            ->toArray()
                    ]
                );

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