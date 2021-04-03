<?php namespace VojtaSvoboda\Fakturoid\Services;

use Fakturoid\Exception;

/**
 * Subjects management.
 *
 * @see https://fakturoid.docs.apiary.io/#reference/subjects/uprava-kontaktu
 * @package VojtaSvoboda\Fakturoid\Services
 */
class SubjectService extends BaseService
{
    /**
     * Get subjects. Returns 200 or 400 for bad params.
     *
     * Available parameters: since, updated_since, page, custom_id.
     *
     * @param array|null $params
     * @return array|null
     * @throws Exception
     * @api GET /api/v2/accounts/<slug>/subjects.json
     * @see https://fakturoid.docs.apiary.io/#reference/subjects/subjects-collection/seznam-vsech-kontaktu
     */
    public function getSubjects($params = null)
    {
        try {
            $response = $this->client->getSubjects($params);

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
     * Fulltext subjects search. Returns only 200.
     *
     * @param string|null $query
     * @param array|null $headers
     * @return array|null
     * @throws Exception
     * @api GET /api/v2/accounts/<slug>/subjects/search.json?query=
     * @see https://fakturoid.docs.apiary.io/#reference/subjects/subjects-collection-fulltext-search/fulltextove-vyhledavani-v-kontaktech
     */
    public function searchSubjects($query = null, $headers = null)
    {
        try {
            $params = ['query' => $query];
            $response = $this->client->searchSubjects($params, $headers);

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
     * Get subject detail. Returns 200 or 404 if not found.
     *
     * @param int $id
     * @param array|null $headers
     * @return \stdClass|null
     * @throws Exception
     * @api GET /api/v2/accounts/<slug>/subjects/<id>.json
     * @see https://fakturoid.docs.apiary.io/#reference/subjects/subject/detail-kontaktu
     */
    public function getSubject($id, $headers = null)
    {
        try {
            $params = ['id' => $id];
            $response = $this->client->getSubject($id, $headers);

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
     * Create new subject. Returns 201 when created, 403 when limit reached or 422 on failure.
     *
     * @param array $data
     * @return \stdClass|null
     * @throws Exception
     * @api POST /api/v2/accounts/<slug>/subjects.json
     * @see https://fakturoid.docs.apiary.io/#reference/subjects/subjects-collection/novy-kontakt
     */
    public function createSubject(array $data)
    {
        try {
            $response = $this->client->createSubject($data);

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
     * Update existing subject. Returns 200 when updated, 404 when not found or 422 on failure.
     *
     * @param int $id
     * @param array $data
     * @return \stdClass|null
     * @throws Exception
     * @api PATCH /api/v2/accounts/<slug>/subjects/<id>.json
     * @see https://fakturoid.docs.apiary.io/#reference/subjects/subject/uprava-kontaktu
     */
    public function updateSubject($id, $data)
    {
        try {
            $response = $this->client->updateSubject($id, $data);

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
     * Delete existing subject. Returns 204 when delete or 404 when not found.
     *
     * @param int $id
     * @return bool
     * @throws Exception
     * @api DELETE /api/v2/accounts/<slug>/subjects/<id>.json
     * @see https://fakturoid.docs.apiary.io/#reference/subjects/subject/smazani-kontaktu
     */
    public function deleteSubject($id)
    {
        try {
            $params = ['id' => $id];
            $response = $this->client->deleteSubject($id);

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
