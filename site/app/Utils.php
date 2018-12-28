<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 23/09/18
 * Time: 14:52
 */

namespace App;


/**
 * Class Utils
 *
 * This class contains general purpose and usage variables, contants and functions
 *
 * @package App
 */
class Utils
{

    /**
     * Constant that contains the success messages that will be selected randomly
     */
    const MESSAGES_SUCCESS = [
        'Well done! I see you did your homework.',
        'Congrats!',
        'You are a mentalist...maybe I need take care...',
        'Everything looks like fine!',
    ];


    /**
     * Constant that contains the unauthorized messages that will be selected randomly
     */
    const MESSAGES_UNAUTHORIZED = [
        'Hey! You aren\'t authorized, move out!',
        'Wait in line...we are sending some officers to you location...',
        'What?',
        'Please, don\'t try access here again...it\'s so dangerous.'
    ];


    /**
     * Constant that contains the "no results" messages that will be selected randomly
     */
    const MESSAGES_NORESULTS = [
        'Ooooooowwww...your search don\'t have results.',
        'Probably you need to improve your search criteria.',
        'Do you want to try again?'
    ];


    /**
     * Constant that contains the 404 error messages that will be selected randomly
     */
    const MESSAGES_404 = [
        'Maybe you are looking for something doesn\'t exists anymore.',
        'Are you lost?',
        'Really?! Are you lost??',
        'Did I already see you before here?',
        'I suggest you call a support...I think you are a little bit lost...',
        'I see dead content...'
    ];


    /**
     * Constant that contains the "not allowed" messages that will be selected randomly
     */
    const MESSAGES_NOTALLOWED = [
        'What you think doing this here?',
        'Wait for the police, you doing something bad trying this here.',
        'You you try again using this method, I will call mom...last chance.',
        'Oh my...again?! Last notice, don\'t try again!',
    ];


    /**
     * Constant that contains exceptions errors messages that will be selected randomly
     */
    const MESSAGES_EXCEPTION = [
        'Oh, bad server...bad, bad, server!',
        'This server isn\'t what it was.',
        'We are really charmed, but something is wrong. :(',
        'Oh, bad developers...bad, bad, developers!',
        'Oh, bad system...bad, bad, system!',
        'Maybe you need take a break, your passing bad feelings to our system and he is sad now.'
    ];


    /**
     * Constant that contains the validations messages that will be selected randomly
     */
    const MESSAGES_VALIDATION = [
        'Please, observe what you trying to do.',
        'Make mistakes is from human nature.',
        'I know you can do! Try again!',
        'Do you need some help? Call 112...',
        'Persistence is the key to success.',
        'Shit happens...don\'t worry, be happy...! :)',
        'Keep calm and carry on...let\'s try again'
    ];

    /**
     * Format the pattern statuses to texts
     *
     * Codes:
     * success      => 0
     * noresults    => 1
     * unauthorized => 2
     * notallowed   => 3
     * 404          => 4
     * exception    => 5
     * validation   => 6
     */
    const STATUS = [
        'success',
        'noresults',
        'unauthorized',
        'notallowed',
        '404',
        'exception',
        'validation'
    ];

    /**
     * Stores the default message body, when return list of data
     * status  => @see STATUS
     * message => @see MESSAGES_*
     * total   => total rows in result
     * content => rows result
     */
    const GET_ALL_RESPONSE_MSG = [
        'header' => [
            'status' => "",
            'message' => "",
            'total' => 0,
        ],
        'content' => [
        ],
    ];

    /**
     * Stores the default general message body
     * status  => @see STATUS
     * message => @see MESSAGES_*
     * content => some important content
     */
    const GENERAL_RESPONSE_MSG = [
        'header' => [
            'status' => "",
            'message' => "",
        ],
        'content' => [
        ],
    ];


    /**
     * Generate a random message based on message code input
     *
     * @param int $type [0 = success, 1 = noresults, 2 = unauthorized, 3 = notallowed, 4 = 404, 5 = 500, 6 = validation]
     * @return string [message]
     */
    public static function generateRandomMessage(int $type) : string {

        $ret = "";

        $msgType = constant("self::" . "MESSAGES_" . strtoupper(self::STATUS[$type]));

        if (isset($msgType)) {
            $ret = $msgType[rand(0, count($msgType) - 1)];
        }

        return $ret;
    }


    /**
     * Create and return a formatted message for results search
     *
     * @param int $status [0 = success, 1 = noresults, 2 = unauthorized, 3 = notallowed, 4 = 404, 5 = 500, 6 = validation]
     * @param array $content [content that will be exhibited after some action]
     * @param string $message [custom message that will override the default one]
     * @param string $customStatus [custom status that will override the default one inside response header]
     * @return array [formatted message array]
     */
    public static function genReturnContent(int $status = -1, array $content = [],
                                            string $message = "", string $customStatus = "") : array {

        $ret = [];

        if ($status >= 0 || !empty($customStatus)) {

            $statusRet = (!empty($customStatus) ? $customStatus : self::STATUS[$status]);
            $msgRet = (!empty($message) ? $message : self::generateRandomMessage($status));

            $countContent = count($content);

            if ($countContent > 0) {
                $ret = self::GET_ALL_RESPONSE_MSG;
                $ret['header']['total'] = $countContent;
            } else {
                $ret = self::GENERAL_RESPONSE_MSG;
            }

            $ret['header']['status'] = $statusRet;
            $ret['header']['message'] = $msgRet;
            $ret['content'] = $content;

        }

        return $ret;

    }

}