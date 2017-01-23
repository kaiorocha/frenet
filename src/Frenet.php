<?php

namespace Frenet;

class Frenet {

    private static $api;

    private static $apiUrl = 'http://services.frenet.com.br/';

    private static $service;
    private static $method;

    private static $arguments = [];

    public static function init($options)
    {
        self::$service = $options['service'];
        self::$method = $options['method'];

        self::$arguments = [
            'quoteRequest' => [
                'Username' => $options['Username'],
                'Password' => $options['Password'],
                'SellerCEP' => $options['SellerCEP'],
                'RecipientCountry' => isset($options['RecipientCountry']) ? $options['RecipientCountry'] : 'BR'
            ]
        ];

        return self::class;
    }

    public static function getUrl()
    {
        return self::$apiUrl;
    }

    public static function get($function, $arguments)
    {
        self::$arguments['quoteRequest'] = array_merge(self::$arguments['quoteRequest'], $arguments);

        try{
            $client = self::exec();
            $response = $client->__soapCall($function, [self::$arguments]);
            return $response->{$function . 'Result'};
        } catch (\SoapFault $e){
            print_r($e->getMessage());
            return false;
        }
    }

    private static function exec()
    {
        return new \SoapClient('http://services.frenet.com.br/' . self::$service . '/' . self::$method . '.asmx?wsdl', array("soap_version" => SOAP_1_1,"trace" => 1));
    }

}