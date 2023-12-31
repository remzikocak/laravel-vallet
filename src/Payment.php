<?php

declare(strict_types=1);

namespace RKocak\Vallet;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RKocak\Vallet\Contracts\PaymentContract;
use RKocak\Vallet\Enums\{Currency, Locale, ProductType};
use RKocak\Vallet\Exceptions\{BuyerNotSetException,
    CurrencyNotSetException,
    InvalidArgumentException,
    LocaleNotSetException,
    RequestFailedException};
use RKocak\Vallet\Traits\{HashesString, URLHelper};
use SensitiveParameter;

class Payment implements Arrayable, PaymentContract
{
    use HashesString, URLHelper;

    const VALLET_URL = 'https://www.vallet.com.tr/api/v1/create-payment-link';

    protected ?Buyer $buyer = null;

    protected ?Currency $currency = null;

    protected ?Locale $locale = null;

    protected array $products = [];

    protected array $requiredFields = [
        'productName', 'productData', 'productsTotalPrice', 'orderPrice', 'orderId', 'conversationId',
    ];

    protected array $data = [
        'productName'        => null,
        'productData'        => [],
        'productType'        => null,
        'productsTotalPrice' => 0,
        'orderPrice'         => 0,
        'orderId'            => null,
        'conversationId'     => null,
        'callbackOkUrl'      => null,
        'callbackFailUrl'    => null,
        'module'             => 'php',
    ];

    public function __construct(
        #[SensitiveParameter] private readonly ?string $username,
        #[SensitiveParameter] private readonly ?string $password,
        #[SensitiveParameter] private readonly ?string $shopCode,
        #[SensitiveParameter] private readonly ?string $hash,
        private readonly ?string $callbackOkUrl,
        private readonly ?string $callbackFailUrl,
    ) {

    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function setLocale(Locale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function setBuyer(Buyer $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setProductName(string $productName): self
    {
        if (Str::length($productName) > 200) {
            throw new InvalidArgumentException(__('vallet::vallet.productNameTooLong'));
        }

        return $this->setData('productName', $productName);
    }

    public function setConversationId(string $conversationId): self
    {
        return $this->setData('conversationId', $conversationId);
    }

    public function setOrderId(string $orderId): self
    {
        return $this->setData('orderId', $orderId);
    }

    public function setProductType(ProductType $type): self
    {
        return $this->setData('productType', $type->value);
    }

    public function setOrderPrice(float|int $price): self
    {
        return $this->setData('orderPrice', $price);
    }

    public function setTotalPrice(float|int $price): self
    {
        return $this->setData('productsTotalPrice', $price);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function addProduct(Product $product): PaymentContract
    {
        $this->data['productData'][] = $product->toArray();

        return $this;
    }

    /**
     * @throws BuyerNotSetException
     * @throws CurrencyNotSetException
     * @throws InvalidArgumentException
     * @throws LocaleNotSetException
     */
    public function toArray(): array
    {
        $this->validate();

        $data = [
            'username'        => $this->username,
            'password'        => $this->password,
            'shopCode'        => $this->shopCode,
            'callbackOkUrl'   => $this->getCallbackOkUrl(),
            'callbackFailUrl' => $this->getCallbackFailUrl(),
            'currency'        => $this->currency->value,
            'locale'          => $this->locale->value,
            'productData'     => $this->products,
            'productName'     => $this->data['productName'],
        ];

        return array_merge(
            $data,
            $this->buyer->toArray()
        );
    }

    /**
     * @throws BuyerNotSetException
     * @throws CurrencyNotSetException
     * @throws InvalidArgumentException
     * @throws LocaleNotSetException
     * @throws RequestFailedException
     */
    public function getLink(): string
    {
        $request = Http::withoutVerifying()
            ->asForm()
            ->post(self::VALLET_URL, $this->toArray());

        if ($request->failed()) {
            throw new RequestFailedException($request->body());
        }

        $response = $request->json();

        if ($request['status'] !== 'success' || ! isset($response['payment_page_url'])) {
            throw new RequestFailedException($response['errorMessage']);
        }

        return $response['payment_page_url'];
    }

    /**
     * @throws BuyerNotSetException
     * @throws CurrencyNotSetException
     * @throws InvalidArgumentException
     * @throws LocaleNotSetException
     */
    protected function validate(): void
    {
        if (empty($this->username) || empty($this->password) || empty($this->shopCode)) {
            throw new InvalidArgumentException(__('vallet::vallet.credentialsNotSet'));
        }

        if (empty($this->callbackOkUrl)) {
            throw new InvalidArgumentException(__('vallet::vallet.callbackOkUrlNotSet'));
        }

        if (empty($this->callbackFailUrl)) {
            throw new InvalidArgumentException(__('vallet::vallet.callbackFailUrlNotSet'));
        }

        if (is_null($this->buyer)) {
            throw new BuyerNotSetException();
        }

        if (is_null($this->currency)) {
            throw new CurrencyNotSetException();
        }

        if (is_null($this->locale)) {
            throw new LocaleNotSetException();
        }

        foreach ($this->requiredFields as $field) {
            if (empty($this->data[$field])) {
                throw new InvalidArgumentException(__('vallet::vallet.fieldNotSet', ['field' => $field]));
            }
        }
    }

    protected function setData(string $key, mixed $value): self
    {
        $this->data[trim($key)] = $value;

        return $this;
    }

    protected function getHashedData(): string
    {
        $str = $this->data['orderId'].$this->data['currency'].$this->data['orderPrice'].$this->data['productsTotalPrice'].$this->data['productType'].$this->callbackOkUrl.$this->callbackFailUrl;

        return $this->generateHash($this->username.$this->password.$this->shopCode.$str.$this->hash);
    }

    protected function getCallbackOkUrl(): string
    {
        return $this->toFullUrl($this->callbackOkUrl);
    }

    protected function getCallbackFailUrl(): string
    {
        return $this->toFullUrl($this->callbackFailUrl);
    }
}
