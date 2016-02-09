<?php
namespace Omnipay\WebMoney\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'merchantPurse' => 'Z123428476799',
            'secretKey' => '226778888',
            'testMode' => true
        ));
    }

    public function testSignHashException()
    {
        $this->setExpectedException('Omnipay\Common\Exception\InvalidResponseException', 'Invalid hash');
        new CompletePurchaseResponse($this->request, array(
            'LMI_MODE' => '1',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => '0B12E75431284D6FCC05D8AF02B90AC28A0788FB95C9FF6B655344022F0746E1',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));
    }

    public function testInvalidTestModeException()
    {
        $this->setExpectedException('Omnipay\Common\Exception\InvalidResponseException', 'Invalid test mode');
        new CompletePurchaseResponse($this->request, array(
            'LMI_MODE' => '0',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => '4F7D9FD1177DFDAE182F0E470296080DC47A843A32826147555F5C8959E7F6DD',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));
    }

    public function testSuccess()
    {
        $response = new CompletePurchaseResponse($this->request, array(
            'LMI_MODE' => '1',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => '0B12E75431284D6FCC05D8AF02B90AC28A0788FB95C9FF6B655344022F0746E5',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('1444212666', $response->getTransactionId());
        $this->assertSame('892', $response->getTransactionReference());
        $this->assertSame('Z123428476799', $response->getMerchantPurse());
        $this->assertSame('14.65', $response->getAmount());
        $this->assertSame('USD', $response->getCurrency());
        $this->assertTrue($response->getTestMode());
        $this->assertSame('1', $response->getMode());
        $this->assertSame('0B12E75431284D6FCC05D8AF02B90AC28A0788FB95C9FF6B655344022F0746E5', $response->getHash());
    }

    public function testSha256Hash()
    {
        $response = new CompletePurchaseResponse($this->request, array(
            'LMI_MODE' => '1',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => '0B12E75431284D6FCC05D8AF02B90AC28A0788FB95C9FF6B655344022F0746E5',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('1444212666', $response->getTransactionId());
        $this->assertSame('892', $response->getTransactionReference());
        $this->assertSame('Z123428476799', $response->getMerchantPurse());
        $this->assertSame('14.65', $response->getAmount());
        $this->assertSame('USD', $response->getCurrency());
        $this->assertTrue($response->getTestMode());
        $this->assertSame('1', $response->getMode());
        $this->assertSame('sha256', $response->getHashType());
        $this->assertSame('0B12E75431284D6FCC05D8AF02B90AC28A0788FB95C9FF6B655344022F0746E5', $response->getHash());
    }

    public function testMd5Hash()
    {
        $response = new CompletePurchaseResponse($this->request, array(
            'LMI_MODE' => '1',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => '1D3FFAFA982B134479C4AD1AE2CABB5C',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertSame('1444212666', $response->getTransactionId());
        $this->assertSame('892', $response->getTransactionReference());
        $this->assertSame('Z123428476799', $response->getMerchantPurse());
        $this->assertSame('14.65', $response->getAmount());
        $this->assertSame('USD', $response->getCurrency());
        $this->assertTrue($response->getTestMode());
        $this->assertSame('1', $response->getMode());
        $this->assertSame('md5', $response->getHashType());
        $this->assertSame('1D3FFAFA982B134479C4AD1AE2CABB5C', $response->getHash());
    }

    public function testInvalidHashTypeException()
    {
        $this->setExpectedException('Omnipay\Common\Exception\InvalidResponseException', 'Control sign forming method "SIGN" is not supported');
        new CompletePurchaseResponse($this->request, array(
            'LMI_MODE' => '1',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => '2E2A8871CBB577DE4AB3E47EBFA100EB8AD9C7AF6FB5580169B8273409863941BDA16647D2D2619D8FFF946D319FE35D758844214B02F46CBA7AE35AFE3F86940069',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));
    }

    public function testInvalidSignatureTypeException()
    {
        $this->setExpectedException('Omnipay\Common\Exception\InvalidResponseException', 'Invalid signature type');
        new CompletePurchaseResponse($this->request, array(
            'LMI_MODE' => '1',
            'LMI_PAYMENT_AMOUNT' => '14.65',
            'LMI_PAYEE_PURSE' => 'Z123428476799',
            'LMI_PAYMENT_NO' => '1444212666',
            'LMI_PAYER_WM' => '404521188333',
            'LMI_PAYER_PURSE' => 'Z366393600555',
            'LMI_PAYER_COUNTRYID' => 'AZ',
            'LMI_PAYER_IP' => '127.0.0.1',
            'LMI_SYS_INVS_NO' => '897',
            'LMI_SYS_TRANS_NO' => '892',
            'LMI_SYS_TRANS_DATE' => '20151007 13:07:36',
            'LMI_HASH' => 'ABD',
            'LMI_PAYMENT_DESC' => 'Test',
            'LMI_LANG' => 'en-US',
            'LMI_DBLCHK' => 'SMS'
        ));
    }
}
