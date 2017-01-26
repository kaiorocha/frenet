# SDK FRENET PARA PHP

##Instalação
Via composer
> composer require kaiorocha/frenet

### Exemplo de utilização

```php
//Configure as informações do cadastro
$config = Frenet::init([
            'service' => 'logistics',
            'method' => 'ShippingQuoteWS',
            'Username' => '',
            'Password' => '',
            'SellerCEP' => '04542051',
        ]);
        
//Instancia o serviço Shipping
$test = new \Shipping\Shipping();

//Chama o método getShippingQuote passando as configurações definidas como primeiro parametro e um array contendo, Itens(Array), CEP(String) e TOTAL(Float) do carrinho como segundo parâmetro.
print_r($test::getShippingQuote($config, [
    'itens' => [
        [
            'weight' => 1,
            'length' => 1,
            'height' => 1,
            'width' => 1,
            'diameter' => 0,
            'sku' => 'SKU-001',
            'category' => 'Tests',
            'isFragile' => false,
        ]
    ],
    'cep' => '07716135',
    'total' => 109.90
]));
```
