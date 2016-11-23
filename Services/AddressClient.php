<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpFoundation\Response;
use Usoft\PostcodeBundle\Exceptions\InvalidApiResponse;
use Usoft\PostcodeBundle\Model\Address;

/**
 * Class AddressClient
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class AddressClient
{
    /** @var ClientInterface */
    private $client;

    /** @var string */
    private $apiKey;

    /**
     * @param ClientInterface $client
     * @param string          $apiKey
     */
    public function __construct(ClientInterface $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $zipcode
     * @param string $number
     *
     * @return Address
     */
    public function getAddress($zipcode, $number)
    {
        if (0 === preg_match('/^[1-9]{1}[0-9]{3}[\s]{0,1}[a-z]{2}$/i', $zipcode)) {
            return null;
        }

        $header = ['X-Api-Key' => $this->apiKey];
        $url = sprintf('https://postcode-api.apiwise.nl/v2/addresses/?postcode=%s&number=%d', $zipcode, (int) $number);
        $request = new Request('GET', $url, $header);

        try {
            $response = $this->client->send($request);

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new InvalidApiResponse('The API does not return a 200 status-code');
            }

            $data = json_encode($response->getBody()->getContents(), true);

            if (false === isset($data['_embedded']['addresses'][0])) {
                return null;
            }

            $address = $data['_embedded']['addresses'][0];

            $city = $address['city']['label'];
            $street = $address['street'];

            return new Address($street, $zipcode, $city, $number);

        } catch (\Exception $exception) {
            throw new InvalidApiResponse($exception->getMessage());
        }
    }
}
