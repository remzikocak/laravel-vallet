<?php

declare(strict_types=1);

use RKocak\Vallet\Buyer;
use RKocak\Vallet\Exceptions\InvalidArgumentException;

it('can create a buyer', function () {
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

    expect($buyer->toArray())
        ->toBe([
            'buyerName'     => 'Remzi',
            'buyerSurName'  => 'Kocak',
            'buyerGsmNo'    => '5555555555',
            'buyerEmail'    => 'hey@remzikocak.com',
            'buyerIp'       => '127.0.0.1',
            'buyerAdress'   => 'Atasehir, Istanbul',
            'buyerCity'     => 'Istanbul',
            'buyerCountry'  => 'Turkey',
            'buyerDistrict' => 'Atasehir',
        ])
        ->toHaveCount(9);
});

test('throws exception when email is not valid', function () {
    $buyer = new Buyer();
    $buyer->setEmail('invalid-email');
})->throws(InvalidArgumentException::class);

test('throws exception when ip address is not valid', function () {
    $buyer = new Buyer();
    $buyer->setIp('invalid-ip');
})->throws(InvalidArgumentException::class);
