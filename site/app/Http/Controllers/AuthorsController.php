<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 25/09/18
 * Time: 00:02
 */

namespace App\Http\Controllers;

/**
 * Class AuthorsController
 *
 * Controls all requisitions sent to /authors endpoint
 *
 * @package App\Http\Controllers
 * @see App\Http\CBaseRestController
 * @see App\IRestCall
 */
class AuthorsController extends BaseRestController
{

    public function __construct()
    {
        // Inform the Model name to father
        $this->className = 'Author';

        // Create a string containing the complete Model namespace
        $this->nameSpace = "\\App\\" . $this->className;

        // Create validation rules to be used in father class
        $this->validationRules = [
            'name' => 'bail|required|max:255',
            'last_name' => 'bail|required|max:255',
            'editorial_name' => 'bail|required|max:255',
            'link' => 'bail|url|max:255'
        ];
    }

}