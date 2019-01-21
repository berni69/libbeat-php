<?php
/**
 * Created by PhpStorm.
 * User: berni
 * Date: 20/01/2019
 * Time: 23:38
 */

namespace libbeat;


class Logger
{

    private static $logger;
    public function __construct()
    {
        if (!isset(self::$logger)){
            self::$logger= new \Monolog\Logger('libbeat');
        }

    }



    public static function debug($str, $convert_hex = False)
    {
        if (!isset(self::$logger)){
            new Logger();
        }
        if($convert_hex){
            $str = implode(",",unpack('C*',$str));;
        }
        self::$logger->debug($str);

    }


}