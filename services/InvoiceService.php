<?php namespace VojtaSvoboda\Fakturoid\Services;

use Fakturoid\Exception;

/**
 * Invoices management.
 *
 * @see https://fakturoid.docs.apiary.io/#reference/invoices/uprava-kontaktu
 * @package VojtaSvoboda\Fakturoid\Services
 */
class InvoiceService extends BaseService
{
    /**
     * Get invoice detail. Returns 200 or 404 if not found.
     *
     * @param int $id
     * @param array|null $headers
     * @return \stdClass|null
     * @throws Exception
     * @api GET /api/v2/accounts/<slug>/invoices/<id>.json
     * @see https://fakturoid.docs.apiary.io/#reference/invoices/invoice/detail-faktury
     */
    public function getInvoice($id, $headers = null)
    {
        try {
            $params = ['id' => $id];
            $response = $this->client->getInvoice($id, $headers);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_SUCCESS) {
            $this->logError(__FUNCTION__, $params, $response);
        }

        return $response->getBody();
    }

    /**
     * Get invoice detail PDF. Returns 200 or 404 if not found.
     *
     * @param int $id
     * @param array|null $headers
     * @return string|null
     * @throws Exception
     * @api GET /api/v2/accounts/<slug>/invoices/<id>.json
     * @see https://fakturoid.docs.apiary.io/#reference/invoices/invoice-pdf/stazeni-faktury-v-pdf
     */
    public function getInvoicePdf($id, $headers = null)
    {
        try {
            $params = ['id' => $id];
            $response = $this->client->getInvoicePdf($id, $headers);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_SUCCESS) {
            $this->logError(__FUNCTION__, $params, $response);
        }

        return $response->getBody();
    }

    /**
     * Fulltext invoices search. Returns only 200.
     *
     * @param string|null $query
     * @param int|null $page
     * @param array|null $headers
     * @return array|null
     * @throws Exception
     * @api GET /api/v2/accounts/slug/invoices/search.json?query=
     * @see https://fakturoid.docs.apiary.io/#reference/invoices/invoices-collection-fulltext-search/fulltextove-vyhledavani-ve-fakturach
     */
    public function searchInvoices($query = null, $page = null, $headers = null)
    {
        $params = [
            'query' => $query,
            'page' => $page,
        ];

        try {
            $response = $this->client->searchInvoices($params, $headers);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_SUCCESS) {
            $this->logError(__FUNCTION__, $params, $response);
        }

        return $response->getBody();
    }

    /**
     * Create new invoice. Returns 201 when created, 403 when limit reached or 422 on failure.
     *
     * @param array $data
     * @return \stdClass|null
     * @throws Exception
     * @api POST /api/v2/accounts/<slug>/invoices.json
     * @see https://fakturoid.docs.apiary.io/#reference/invoices/invoices-collection/nova-faktura
     */
    public function createInvoice(array $data)
    {
        try {
            $response = $this->client->createInvoice($data);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $data, $e);
            throw $e;
        }

        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_CREATED) {
            $this->logError(__FUNCTION__, $data, $response);
        }

        return $response->getBody();
    }

    /**
     * Update existing invoice. Returns 200 when updated, 404 when not found or 422 on failure.
     *
     * @param int $id
     * @param array $data
     * @return \stdClass|null
     * @throws Exception
     * @api PATCH /api/v2/accounts/<slug>/invoices/<id>.json
     * @see https://fakturoid.docs.apiary.io/#reference/invoices/invoice/uprava-faktury
     */
    public function updateInvoice($id, $data)
    {
        try {
            $response = $this->client->updateInvoice($id, $data);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $data, $e);
            throw $e;
        }

        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_SUCCESS) {
            $this->logError(__FUNCTION__, $data, $response);
        }

        return $response->getBody();
    }

    /**
     * Update existing invoice. Returns 200 when updated, 404 when not found or 422 on failure.
     *
     * Available parameters: paid_at', paid_amount, variable_symbol, bank_account_id.
     * Available events: mark_as_sent, deliver, pay, pay_proforma, pay_partial_proforma, remove_payment,
     *      deliver_reminder, cancel, undo_cancel, lock, unlock.
     *
     * @param int $id
     * @param string $event
     * @param array $params
     * @return \stdClass|null
     * @throws Exception
     * @see https://fakturoid.docs.apiary.io/#reference/invoices/invoice-actions/akce-nad-fakturou
     * @api PATCH /api/v2/accounts/<slug>/invoices/<id>/fire.json?event=
     */
    public function fireInvoice($id, $event, $params = [])
    {
        $data = $params;
        $data['event'] = $event;

        try {
            $response = $this->client->fireInvoice($id, $event, $params);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $data, $e);
            throw $e;
        }

        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_SUCCESS) {
            $this->logError(__FUNCTION__, $data, $response);
        }

        return $response->getBody();
    }

    /**
     * Delete existing invoice. Returns 204 when delete or 404 when not found.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     * @api DELETE /api/v2/accounts/<slug>/invoices/<id>.json
     * @see https://fakturoid.docs.apiary.io/#reference/invoices/invoice/smazani-faktury
     */
    public function deleteInvoice($id)
    {
        try {
            $params = ['id' => $id];
            $response = $this->client->deleteInvoice($id);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        $status = $response->getStatusCode();
        if ($status !== self::HTTP_RESPONSE_NO_CONTENT) {
            $this->logError(__FUNCTION__, $params, $response);
        }

        return true;
    }
}
