<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Support\Facades\Http;
use RKocak\Vallet\Contracts\RefundContract;
use RKocak\Vallet\Exceptions\{InvalidArgumentException, RequestFailedException};
use RKocak\Vallet\Traits\HashesString;
use SensitiveParameter;

class Refund implements RefundContract
{
    use HashesString;

    const VALLET_REFUND_URL = 'https://www.vallet.com.tr/api/v1/create-refund';

    protected float|int $amount = 0;

    protected ?string $orderId = null;

    protected int $valletOrderId = 0;

    public function __construct(
        #[SensitiveParameter] private readonly ?string $username,
        #[SensitiveParameter] private readonly ?string $password,
        #[SensitiveParameter] private readonly ?string $shopCode,
        #[SensitiveParameter] private readonly ?string $hash,
    ) {

    }

    public function setAmount(int|float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function setValletOrderId(int $orderId): self
    {
        $this->valletOrderId = $orderId;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function process(): RefundResponse
    {
        if (! $this->amount) {
            throw new InvalidArgumentException(__('vallet::vallet.amountNotSet'));
        }

        if (! $this->orderId || ! $this->valletOrderId) {
            throw new InvalidArgumentException(__('vallet::vallet.orderIdNotSet'));
        }

        $hashStr = $this->username.$this->password.$this->shopCode.$this->valletOrderId.$this->orderId.$this->amount.$this->hash;
        $hash    = $this->generateHash($hashStr);

        $request = Http::withoutVerifying()->asForm()->post(static::VALLET_REFUND_URL, [
            'userName'      => $this->username,
            'password'      => $this->password,
            'shopCode'      => $this->shopCode,
            'valletOrderId' => $this->valletOrderId,
            'orderId'       => $this->orderId,
            'amount'        => $this->amount,
            'hash'          => $hash,
            'hashString'    => $hashStr,
        ]);

        if ($request->failed()) {
            throw new RequestFailedException(__('vallet::vallet.requestFailed'));
        }

        return new RefundResponse(
            $request->json()
        );
    }
}
