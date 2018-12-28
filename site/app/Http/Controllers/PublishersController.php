<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 23/09/18
 * Time: 13:10
 */

namespace App\Http\Controllers;

/**
 * Class PublishersController
 *
 * Controls all requisitions sent to /publishers endpoint
 *
 * @package App\Http\Controllers
 * @see App\Http\CBaseRestController
 * @see App\IRestCall
 */
class PublishersController extends BaseRestController
{
    public function __construct()
    {
        // Inform the Model name to father
        $this->className = 'Publisher';

        // Create a string containing the complete Model namespace
        $this->nameSpace = "\\App\\" . $this->className;

        // Create validation rules to be used in father class
        $this->validationRules = [
            'name' => 'required|max:255',
        ];
    }
}