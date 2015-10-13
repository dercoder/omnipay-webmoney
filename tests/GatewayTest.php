<?php
namespace Omnipay\WebMoney;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public $gateway;
    public $sslFile;
    public $sslKey;

    public function setUp()
    {
        parent::setUp();

        $class = new \ReflectionObject($this);
        $directory = dirname($class->getFileName());
        $this->sslFile = realpath($directory . '/Certificate/webmoney.pem');
        $this->sslKey = realpath($directory . '/Certificate/webmoney.key');

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setWebMoneyId('811333344777');
        $this->gateway->setMerchantPurse('Z123428476799');
        $this->gateway->setSecretKey('226778888');
        $this->gateway->setSsLFile($this->sslFile);
        $this->gateway->setSslKey($this->sslKey);
        $this->gateway->setTestMode(true);
    }

    public function testGateway()
    {
        $this->assertSame('811333344777', $this->gateway->getWebMoneyId());
        $this->assertSame('Z123428476799', $this->gateway->getMerchantPurse());
        $this->assertSame('226778888', $this->gateway->getSecretKey());
        $this->assertSame($this->sslFile, $this->gateway->getSslFile());
        $this->assertSame($this->sslKey, $this->gateway->getSslKey());
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction(array(
            'transactionId' => '1444212666'
        ));

        $this->assertSame('1444212666', $request->getTransactionId());
    }

    public function testPayout()
    {
        $request = $this->gateway->payout(array(
            'transactionId' => '1444111666',
            'requestNumber' => '111222333',
            'customerPurse' => 'Z123428476700',
            'protectionPeriod' => '60',
            'protectionCode' => 'xyZ123',
            'invoiceId' => '12345678',
            'onlyAuth' => false,
            'description' => 'Payout',
            'amount' => '12.46'
        ));

        $this->assertSame('1444111666', $request->getTransactionId());
        $this->assertSame('111222333', $request->getRequestNumber());
        $this->assertSame('Z123428476700', $request->getCustomerPurse());
        $this->assertSame(60, $request->getProtectionPeriod());
        $this->assertSame('xyZ123', $request->getProtectionCode());
        $this->assertSame(12345678, $request->getInvoiceId());
        $this->assertSame(0, $request->getOnlyAuth());
        $this->assertSame('12.46', $request->getAmount());
    }
}
