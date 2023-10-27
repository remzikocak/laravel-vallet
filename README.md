<p align="center"><img src="/laravel-vallet.png" alt="Laravel Options"></p>

# Vallet Integration for Laravel 10

This Package helps you to integrate [Vallet Payment Gateway](https://vallet.com.tr) in your Laravel Application.

This is an unofficial, third party package.
## Installation

You can install the package via composer:

```bash
composer require remzikocak/laravel-vallet
```

## Configuration

Publish the config file with:

```bash
php artisan vendor:publish --provider="RKocak\Vallet\ValletServiceProvider" --tag="config"
```

Add the following variables to your .env file and fill them with your credentials:

```bash
VALLET_USERNAME=
VALLET_PASSWORD=
VALLET_SHOPCODE=
VALLET_HASH=
VALLET_CALLBACK_OK_URL=
VALLET_CALLBACK_FAIL_URL=
```

``VALLET_CALLBACK_OK_URL`` and ``VALLET_CALLBACK_FAIL_URL`` are the urls that Vallet will redirect the user after payment is completed or failed.
Make sure that you have created a route for these URLs in your routes file.


## Usage

### How to Create a Payment

```php
use RKocak\Vallet\Facades\Vallet;
use RKocak\Vallet\Buyer;
use RKocak\Vallet\Enums\{Currency, Locale, ProductType};
use RKocak\Vallet\Exceptions\{RequestFailedException, InvalidArgumentException, BuyerNotSetException, LocaleNotSetException, CurrencyNotSetException};

class YourController {

    public function yourMethod()
    {
        // Create a new buyer object
        $buyer = new Buyer();
        $buyer->setName('Remzi')
              ->setSurname('Kocak')
              ->setEmail('hey@remzikocak.com')
              ->setCity('Istanbul')
              ->setCountry('Turkey')
              ->setDistrict('Atasehir')
              ->setPhoneNumber('5555555555')
              ->setAddress('Atasehir, Istanbul')
              ->setIp('127.0.0.1');
        
        // Create a new payment object
        $payment = Vallet::createPayment();
        
        // Set Payment Details
        $payment->setBuyer($buyer)
                ->setLocale(Locale::Turkish)
                ->setCurrency(Currency::Try)
                ->setConversationId('123456789')
                ->setOrderId('123456789')
                ->setProductName('Test Product')
                ->setTotalPrice(100)
                ->setOrderPrice(100)
                ->setProductType(ProductType::Digital);
                
        // Add Products
        $payment->addProduct(
            Product::make()
                ->setName('Test Product')
                ->setPrice(13.50)
                ->setType(ProductType::Digital)
        );
        
        try {
            // Send Payment Request
            $paymentLink = $payment->getLink();
            
            // You can redirect user to '$paymentLink' or you can use it as a href in your button
            // Depending on your needs
        } catch (RequestFailedException|InvalidArgumentException|BuyerNotSetException|LocaleNotSetException|CurrencyNotSetException $e) {
            // Handle Exception
        }    
    }

}
```

### Retrieve Payment Details

```php
use RKocak\Vallet\Facades\Vallet;
use RKocak\Vallet\Exceptions\{InvalidHashException, InvalidResponseException};

class YourController
{

    public function yourMethod(){
        try {
            // Retrieve Payment Details
            $response = Vallet::getResponse();
            $reponse->validate();
            
            
            if($response->isPaid()) {
                // Payment is paid
                $amount = $response->getAmount();
                $orderId = $response->getOrderId();
                $valletOrderId = $response->getValletOrderId();
                
                // Update your order status, send email etc.
            } else {
                // Payment is not paid, is pending or is awaiting verification
            }
        } catch (InvalidHashException|InvalidResponseException $e) {
            // Handle Exception
        }
    }

}
```

**Important:** You should store the ``$response->getValletOrderId()`` in your database. You will need it for refunding the payment.

### Refund Payment

```php
use RKocak\Vallet\Facades\Vallet;

class YourController {

    public function yourMethod()
    {
        $refund = Vallet::createRefund();

        try {
            // Set Refund Details
            $refund->setOrderId('123456789')
                   ->setValletOrderId('123456789')
                   ->setAmount(100);
            
            // Send Refund Request
            $response = $refund->process();
            
            if($response->success()) {
                $refundId = $response->getRefundId();
            } else {
                // Refund is not successful
            }
        } catch (InvalidArgumentException $e) {
            // Handle Exception
        }
    }

}
```

**Important:** You should store the ``$response->getRefundId()`` in your database. You will need it to get Support from Vallet Customer Service.


## Publishing Translation Files

Vallet Integration for Laravel comes with English, Turkish and German translations. If you want to customize them, you can publish them with:

```bash
php artisan vendor:publish --provider="RKocak\Vallet\ValletServiceProvider" --tag="lang"
```

## Testing

```bash
composer test
```