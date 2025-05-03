<?php

namespace Aaran\ExternalPartners\Frappe\ErpNext\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Exception;

class ErpNextService
{
    public mixed $baseUrl;
    public mixed $apiKey;
    public mixed $apiSecret;

    public function __construct()
    {
        $this->baseUrl = 'https://techmedia.co.in/';
        $this->apiKey = 'be958bbb06ddff6';
        $this->apiSecret = 'f6344b61729e7e0';
    }

    /**
     * Initialize the HTTP client with headers
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    public function client()
    {
        return Http::withHeaders([
            'Authorization' => 'token ' . $this->apiKey . ':' . $this->apiSecret,
            'Accept' => 'application/json',
        ])->withoutVerifying(); // <- Add this line
    }

    /**
     * Get a list of records for a specific Doctype.
     *
     * @param string $doctype
     * @param array $filters
     * @return array
     */
    public function get($doctype, $filters = [])
    {
        try {
            $url = $this->baseUrl . "/api/resource/{$doctype}";
            $response = $this->client()->get($url, $filters);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Get a specific record by Doctype and name.
     *
     * @param string $doctype
     * @param string $name
     * @return array
     */
    public function find($doctype, $name)
    {
        try {
            $url = $this->baseUrl . "/api/resource/{$doctype}/{$name}";
            $response = $this->client()->get($url);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Create a new record for a specific Doctype.
     *
     * @param string $doctype
     * @param array $data
     * @return array
     */
    public function create($doctype, array $data)
    {
        try {
            $url = $this->baseUrl . "/api/resource/{$doctype}";
            $response = $this->client()->post($url, $data);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Update an existing record for a specific Doctype.
     *
     * @param string $doctype
     * @param string $name
     * @param array $data
     * @return array
     */
    public function update($doctype, $name, array $data)
    {
        try {
            $url = $this->baseUrl . "/api/resource/{$doctype}/{$name}";
            $response = $this->client()->put($url, $data);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Delete a specific record.
     *
     * @param string $doctype
     * @param string $name
     * @return array
     */
    public function delete($doctype, $name)
    {
        try {
            $url = $this->baseUrl . "/api/resource/{$doctype}/{$name}";
            $response = $this->client()->delete($url);

            return $this->handleResponse($response);
        } catch (Exception $e) {
            return $this->handleError($e);
        }
    }

    /**
     * Handle the response from ERPNext API.
     *
     * @param Response $response
     * @return array
     */
    public function handleResponse(Response $response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        return $this->handleError(new Exception('API Request Failed: ' . $response->body()));
    }

    /**
     * Handle errors from ERPNext API.
     *
     * @param Exception $e
     * @return array
     */
    public function handleError(Exception $e)
    {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }
}

