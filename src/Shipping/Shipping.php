<?php

namespace Frenet\Shipping;

use RestClient;

class Shipping {

    public static function getShippingQuote($api, $data)
    {

        $validate = self::validate($data);
        if(!$validate['status']){
            return $validate;
        }

        $shippingItemArray = [];

        foreach ($data['itens'] as $item){
            $shippingItem = new \stdClass();
            $shippingItem->Weight = isset($item['weight']) ? $item['weight'] : null;
            $shippingItem->Length = isset($item['length']) ? $item['length'] : null;
            $shippingItem->Height = isset($item['height']) ? $item['height'] : null;
            $shippingItem->Width = isset($item['width']) ? $item['width'] : null;
            $shippingItem->Diameter = isset($item['diameter']) ? $item['diameter'] : null;
            $shippingItem->SKU = isset($item['sku']) ? $item['sku'] : null;
            $shippingItem->Category = isset($item['category']) ? $item['category'] : null;
            $shippingItem->isFragile = isset($item['isFragile']) ? $item['isFragile'] : null;

            $shippingItemArray[] = $shippingItem;
        }

        $response = $api::get("GetShippingQuote", [
            'RecipientCEP' => $data['cep'],
            'ShipmentInvoiceValue' => $data['total'],
            'ShippingItemArray' => $shippingItemArray,
        ]);

        if(!$response){
            return [
                'status' => '404',
                'error' => 'Houve um erro ao consultar os fretes cadastrados;'
            ];
        }

        return [
            'status' => 200,
            'data' => $response->ShippingSevicesArray->ShippingSevices
        ];
    }

    private static function validate($data)
    {
        if(!isset($data['cep'])|| empty($data['cep'])){
            return [
                'status' => false,
                'erro' => 'Parâmetro(cep) obrigatório'
            ];
        }
        if(!isset($data['total'])|| empty($data['total'])){
            return [
                'status' => false,
                'erro' => 'Parâmetro(total) obrigatório'
            ];
        }
        if(!isset($data['itens']) || empty($data['itens'])){
            return [
                'status' => false,
                'erro' => 'Parâmetro[itens] é obrigatório e não pode estar vazio'
            ];
        }

        return [
            'status' => true
        ];
    }

}