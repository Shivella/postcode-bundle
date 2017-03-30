<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Tests\Services;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Usoft\PostcodeBundle\Services\AddressClient;

/**
 * Class AddressClientTest
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class AddressClientTest extends TestCase
{
    /** @var AddressClient */
    private $addressClient;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ClientInterface */
    private $guzzle;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ResponseInterface */
    private $response;

    /** @var \PHPUnit_Framework_MockObject_MockObject|StreamInterface */
    private $stream;

    public function setUp()
    {
        $this->guzzle   = $this->createClientInterfaceMock();
        $this->response = $this->createResponseInterfaceMock();
        $this->stream   = $this->createStreamInterfaceMock();

        $this->addressClient = new AddressClient($this->guzzle, 'secret-key');
    }

    public function testGetAddress()
    {
        $this->guzzle->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(file_get_contents(__DIR__ . '/response.json'));

        $this->assertInstanceOf('Usoft\PostcodeBundle\Model\Address', $this->addressClient->getAddress('1010AB', 18));
    }

    /**
     * @expectedException \Usoft\PostcodeBundle\Exceptions\InvalidPostcodeException
     */
    public function testGetAddressWithInvalidPostcode()
    {
        $this->guzzle->expects($this->never())
            ->method('send');

        $this->addressClient->getAddress('*@NXNI@', 18);
    }

    /**
     * @expectedException \Usoft\PostcodeBundle\Exceptions\InvalidApiResponseException
     */
    public function testGetAddressWithInvalidResponse()
    {
        $this->guzzle->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(401);

        $this->response->expects($this->never())
            ->method('getBody');

        $this->addressClient->getAddress('1010AB', 18);
    }

    /**
     * @expectedException \Usoft\PostcodeBundle\Exceptions\InvalidApiResponseException
     */
    public function testGetAddressWithInvalidJsonResponse()
    {
        $this->guzzle->expects($this->once())
            ->method('send')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(file_get_contents(__DIR__ . '/invalid.json'));

        $this->addressClient->getAddress('1010AB', 18);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ClientInterface
     */
    private function createClientInterfaceMock()
    {
        return $this->createMock('GuzzleHttp\ClientInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ResponseInterface
     */
    private function createResponseInterfaceMock()
    {
        return $this->createMock('Psr\Http\Message\ResponseInterface');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StreamInterface
     */
    private function createStreamInterfaceMock()
    {
        return $this->createMock('Psr\Http\Message\StreamInterface');
    }
}
