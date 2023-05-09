<?php

namespace Motrack\Hoodie\Tests\Unit;

use Mockery;
use Illuminate\Http\JsonResponse;
use Motrack\Hoodie\Tests\TestCase;
use Motrack\Hoodie\Facades\Hoodie;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SuccessTest extends TestCase
{
    public function testSuccessResponse()
    {
        $message = 'success message';
        $response = Hoodie::respondSuccess($message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertTrue($response->getData()->success);
        $this->assertEquals($message, $response->getData()->message);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
    }

    public function testSuccessResponseWithHeaders()
    {
        $headers = ['Custom-Header' => 'the header value'];
        $response = Hoodie::respondSuccess(headers: $headers);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals('the header value', $response->headers->get('Custom-Header'));
    }

    public function testSuccessResponseWithResource()
    {
        // Create a mock JsonResource
        $data = ['id' => 1, 'name' => 'John Doe'];
        $jsonResource = new JsonResource($data);
        $response = Hoodie::respondWithResource($jsonResource, 'Success message');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));

        $expectedPayload = [
            'success' => true,
            'message' => 'Success message',
            'result' => $data,
        ];
        $this->assertEquals($expectedPayload, $response->getData(true));
    }

    public function testSuccessResponseWithResourceCollection(): void
    {
        $resources = [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Doe'],
        ];
        $resourceCollection = Mockery::mock(ResourceCollection::class);
        $resourceCollection->shouldReceive('response->getData')->andReturn($resources);
        $response = Hoodie::respondWithResourceCollection($resourceCollection, 'Success message', 200);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertTrue($response->getData()->success);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));

        $expectedPayload = [
            'success' => true,
            'message' => 'Success message',
            'result' => $resources,
        ];
        $this->assertEquals($expectedPayload, json_decode($response->getContent(), true));
    }

}
