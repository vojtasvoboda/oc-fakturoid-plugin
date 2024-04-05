<?php namespace VojtaSvoboda\Fakturoid\Services;

use stdClass;
use Exception;
use Fakturoid\Provider\InvoicesProvider;

/**
 * Invoices management.
 *
 * @see https://www.fakturoid.cz/api/v3/invoices
 * @package VojtaSvoboda\Fakturoid\Services
 */
class InvoiceService extends BaseService
{
    public function getProvider(): InvoicesProvider
    {
        return $this->client->getInvoicesProvider();
    }

    /**
     * Get invoice detail. Returns stdClass with invoice or Exception if not found.
     *
     * @throws Exception
     * @api GET /api/v3/accounts/{slug}/invoices/{id}.json
     * @see https://www.fakturoid.cz/api/v3/invoices#invoice-detail
     */
    public function getInvoice(int $id): stdClass
    {
        try {
            $params = ['id' => $id];
            $response = $this->getProvider()->get($id);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        return $response->getBody();
    }

    /**
     * Get invoice detail PDF. Returns base64 encoded PDF or Exception if not found.
     *
     * @throws Exception
     * @api GET /api/v3/accounts/{slug}/invoices/{id}/download.pdf
     * @see https://www.fakturoid.cz/api/v3/invoices#download-invoice-pdf
     */
    public function getInvoicePdf(int $id): string
    {
        try {
            $params = ['id' => $id];
            $response = $this->getProvider()->getPdf($id);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        // could return HTTP 204 when PDF is not ready yet
        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_SUCCESS) {
            $this->logError(__FUNCTION__, $params, $response);
        }

        return $response->getBody();
    }

    /**
     * Fulltext invoices search. Returns array with invoices.
     *
     * Following fields are being searched: number, variable_symbol, client_name, note, private_note, footer_note and lines.
     *
     * @throws Exception
     * @api GET /api/v3/accounts/{slug}/invoices/search.json
     * @see https://www.fakturoid.cz/api/v3/invoices#fulltext-search
     */
    public function searchInvoices(string $query = null, int $page = null, array $tags = null): array
    {
        try {
            $params = ['query' => $query, 'page' => $page, 'tags' => $tags];
            $response = $this->getProvider()->search($params);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        return $response->getBody();
    }

    /**
     * Create new invoice. Returns stdClass with invoice or Exception when limit reached or on failure.
     *
     * @throws Exception
     * @api POST /api/v3/accounts/{slug}/invoices.json
     * @see https://www.fakturoid.cz/api/v3/invoices#create-invoice
     */
    public function createInvoice(array $data): stdClass
    {
        try {
            $response = $this->getProvider()->create($data);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $data, $e);
            throw $e;
        }

        // double check return code
        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_CREATED) {
            $this->logError(__FUNCTION__, $data, $response);
        }

        return $response->getBody();
    }

    /**
     * Update existing invoice. Returns stdClass with updated invoice or Exception when not found or on failure.
     *
     * @throws Exception
     * @api PATCH /api/v3/accounts/{slug}/invoices/{id}.json
     * @see https://www.fakturoid.cz/api/v3/invoices#update-invoice
     */
    public function updateInvoice(int $id, array $data): stdClass
    {
        try {
            $response = $this->getProvider()->update($id, $data);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $data, $e);
            throw $e;
        }

        // double check return code
        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_SUCCESS) {
            $this->logError(__FUNCTION__, $data, $response);
        }

        return $response->getBody();
    }

    /**
     * Update existing invoice. Returns true when fired or Exception when not found or on failure.
     *
     * Available events: mark_as_sent, cancel, undo_cancel, lock, unlock, mark_as_uncollectible, undo_uncollectible.
     *
     * @throws Exception
     * @api PATCH /api/v3/accounts/{slug}/invoices/{id}/fire.json
     * @see https://www.fakturoid.cz/api/v3/invoices#invoice-actions
     */
    public function fireInvoice(int $id, string $event): bool
    {
        try {
            $params = ['id' => $id, 'event' => $event];
            $this->getProvider()->fireAction($id, $event);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        return true;
    }

    /**
     * Delete existing invoice. Returns true when deleted or Exception when not found.
     *
     * @throws Exception
     * @api DELETE /api/v3/accounts/{slug}/invoices/{id}.json
     * @see https://www.fakturoid.cz/api/v3/invoices#delete-invoice
     */
    public function deleteInvoice(int $id): bool
    {
        try {
            $params = ['id' => $id];
            $response = $this->getProvider()->delete($id);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        // double check return code
        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_NO_CONTENT) {
            $this->logError(__FUNCTION__, $params, $response);
        }

        return true;
    }
}
