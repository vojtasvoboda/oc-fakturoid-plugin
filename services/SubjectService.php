<?php namespace VojtaSvoboda\Fakturoid\Services;

use stdClass;
use Exception;
use Fakturoid\Provider\SubjectsProvider;

/**
 * Subjects management.
 *
 * @see https://www.fakturoid.cz/api/v3/subjects
 * @package VojtaSvoboda\Fakturoid\Services
 */
class SubjectService extends BaseService
{
    public function getProvider(): SubjectsProvider
    {
        return $this->client->getSubjectsProvider();
    }

    /**
     * Get subjects. Returns array with subjects or Exception for bad params.
     *
     * Available parameters: since, updated_since, page, custom_id.
     *
     * @throws Exception
     * @api GET /api/v3/accounts/{slug}/subjects.json
     * @see https://www.fakturoid.cz/api/v3/subjects#subjects-index
     */
    public function getSubjects(array $params = []): array
    {
        try {
            $response = $this->getProvider()->list($params);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        return $response->getBody();
    }

    /**
     * Fulltext subjects search. Returns array with subjects.
     *
     * Following fields are being searched: name, full_name, email, email_copy, registration_no, vat_no and private_note.
     *
     * @throws Exception
     * @api GET /api/v3/accounts/{slug}/subjects/search.json
     * @see https://www.fakturoid.cz/api/v3/subjects#subjects-search
     */
    public function searchSubjects(string $query = null, int $page = null): array
    {
        try {
            $params = ['query' => $query, 'page' => $page];
            $response = $this->getProvider()->search($params);

        } catch (Exception $e) {
            $this->logException(__FUNCTION__, $params, $e);
            throw $e;
        }

        return $response->getBody();
    }

    /**
     * Get subject detail. Returns stdClass with subject or Exception if not found.
     *
     * @throws Exception
     * @api GET /api/v3/accounts/{slug}/subjects/{id}.json
     * @see https://www.fakturoid.cz/api/v3/subjects#subject-detail
     */
    public function getSubject(int $id): stdClass
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
     * Create new subject. Returns stdClass with subject when created or Exception with errors or when limit reached.
     *
     * @throws Exception
     * @api POST /api/v3/accounts/{slug}/subjects.json
     * @see https://www.fakturoid.cz/api/v3/subjects#create-subject
     */
    public function createSubject(array $data): stdClass
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
     * Update existing subject. Returns stdClass with subject when updated or Exception when not found or on failure.
     *
     * @throws Exception
     * @api PATCH /api/v3/accounts/{slug}/subjects/{id}.json
     * @see https://www.fakturoid.cz/api/v3/subjects#update-subject
     */
    public function updateSubject(int $id, array $data): stdClass
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
     * Delete existing subject. Returns 204 when delete or 404 when not found.
     *
     * @throws Exception
     * @api DELETE /api/v3/accounts/{slug}/subjects/{id}.json
     * @see https://www.fakturoid.cz/api/v3/subjects#delete-subject
     */
    public function deleteSubject(int $id): bool
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
