<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Support\Carbon;
use RKocak\Vallet\Contracts\ResponseContract;
use RKocak\Vallet\Enums\{Currency, ProductType};
use RKocak\Vallet\Exceptions\{InvalidHashException, InvalidResponseException};
use RKocak\Vallet\Traits\URLHelper;

class Response implements ResponseContract
{
    use URLHelper;

    protected array $responseFields = [
        'status', 'paymentStatus', 'hash', 'paymentCurrency', 'paymentAmount', 'paymentType', 'paymentTime', 'conversationId', 'orderId', 'shopCode', 'orderPrice',
        'productsTotalPrice', 'productType', 'callbackOkUrl', 'callbackFailUrl', 'valletOrderId',
    ];

    /**
     * @throws InvalidHashException
     * @throws InvalidResponseException
     */
    public function validate(): void
    {
        foreach ($this->responseFields as $fieldName) {
            if (! request()->has($fieldName) || empty(request()->input($fieldName))) {
                throw new InvalidResponseException(__('Response field :field is missing.', ['field' => $fieldName]));
            }
        }

        $hashStr = request()->input('orderId', '').
            request()->input('paymentCurrency', '').
            request()->input('orderPrice', '').
            request()->input('productsTotalPrice', '').
            request()->input('productType', '').
            config('vallet.shopcode').
            config('vallet.hash');
        $generatedHash = base64_encode(pack('H*', sha1($hashStr)));

        if ($generatedHash !== request()->input('hash')) {
            throw new InvalidHashException(__('Hash is invalid.'));
        }
    }

    public function getOrderId(): string
    {
        return request()->input('orderId');
    }

    public function getCurrency(): Currency
    {
        return Currency::from(request()->input('paymentCurrency'));
    }

    public function getOrderPrice(): string
    {
        return request()->input('orderPrice');
    }

    public function getProductsTotalPrice(): string|float
    {
        return request()->input('productsTotalPrice');
    }

    public function getProductType(): ProductType
    {
        return ProductType::from(request()->input('productType'));
    }

    public function getShopCode(): string
    {
        return request()->input('shopCode');
    }

    public function getHash(): string
    {
        return request()->input('hash');
    }

    public function getStatus(): string
    {
        return request()->input('paymentStatus');
    }

    public function getAmount(): string|float
    {
        return request()->input('paymentAmount');
    }

    public function getPaymentType(): string
    {
        return request()->input('paymentType');
    }

    public function getPaymentTime(): Carbon
    {
        return Carbon::parse(request()->input('paymentTime'));
    }

    public function getConversationId(): string
    {
        return request()->input('conversationId');
    }

    public function getCallbackOkUrl(): string
    {
        return request()->input('callbackOkUrl');
    }

    public function getCallbackFailUrl(): string
    {
        return request()->input('callbackFailUrl');
    }

    public function isPaid(): bool
    {
        return $this->getStatus() === 'paymentOk';
    }

    public function isNotPaid(): bool
    {
        return $this->getStatus() === 'paymentNotPaid';
    }

    public function isAwaitingVerification(): bool
    {
        return $this->getStatus() === 'paymentVerification';
    }

    public function isPending(): bool
    {
        return $this->getStatus() === 'paymentWait';
    }

    public function getValletOrderId(): int
    {
        return (int) request()->input('valletOrderId');
    }
}
