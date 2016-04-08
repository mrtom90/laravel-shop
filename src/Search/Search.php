<?php
/**
 * Created by EC-SOL.
 * Author: Pham Thai Duong
 * Date: 2016/02/22
 * Time: 18:48
 */

namespace Mrtom90\LaravelShop\Search;


use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Mockery\CountValidator\Exception;
use Monolog\Logger;
use Illuminate\Support\Facades\Config;

class Search
{
    protected $client;
    protected $index;
    protected $max_bulk_doc_index;

    /**
     *
     */
    public function __construct()
    {
        $this->index = Config::get('elasticsearch.index');
        $this->max_bulk_doc_index = Config::get('elasticsearch.max_doc_index_per_request');

        $connParams = array();
        $connParams['hosts'] = ['localhost:9200'];
        $connParams['logPath'] = storage_path() . '/logs/elasticsearch-' . php_sapi_name() . '.log';
        $connParams['logLevel'] = Logger::INFO;

        $params = array_merge($connParams, Config::get('elasticsearch.server'));

        $client = new Client($params);
        $this->client = $client;

    }

    /**
     * Set index
     * @param $index
     * @return $this
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param $type
     * @param $objectID
     * @return array
     */
    public function find($type, $objectID)
    {

        $params = [
            'index' => $this->index,
            'type' => $type,
            'id' => trim($objectID)
        ];
        try {
            $response = $this->client->get($params);
        } catch (Missing404Exception $e) {
            $response = [
                'found' => false
            ];
        } catch (BadRequest400Exception $e) {
            $response = [
                'found' => false
            ];
        } catch (Exception $e) {
            $response = [
                'found' => false
            ];
        }


        return $response;

    }


    /**
     * @param $type
     * @param $data
     * @return array|void
     */
    public function insert($type, $data)
    {
        if (!is_array($data))
            return abort(406, 'Data must be an array');
        if (!isset($data['objectID']) || empty(trim($data['objectID'])) || !ctype_alnum($data['objectID']))
            $data['objectID'] = uniqid(time());

        $body = $data;
        unset($body['objectID']);

        $params = [
            'index' => $this->index,
            'type' => $type,
            'id' => trim($data['objectID']),
            'body' => $body
        ];
        return $this->client->index($params);
    }

    /**
     * @param $type
     * @param $objectID
     * @param $data
     * @return array|mixed|void
     */
    public function update($type, $objectID, $data)
    {
        if (isset($data['objectID'])) {
            unset($data['objectID']);
        }
        if (empty(trim($objectID)))
            return abort(406, 'objectID is required. Only english character and number allowed.');


        $data['objectID'] = trim($objectID);
        return $this->insert($type, $data);
    }


    /**
     * @param $type
     * @param $objectID
     * @return array
     */
    public function delete($type, $objectID)
    {
        $params = [
            'index' => $this->index,
            'type' => $type,
            'id' => trim($objectID),
        ];

        $this->client->delete($params);
    }

    public function bulkInsert($type, $data)
    {
        if (count($data) > $this->max_bulk_doc_index)
            return abort(406, 'You can only index ' . $this->max_bulk_doc_index . ' per 1 request.');

        $params = [];
        foreach ($data as $item) {
            if (is_array($item)) {


                if (!isset($item['objectID']) || empty(trim($item['objectID']))) {
                    $item['objectID'] = uniqid(time());
                }


                $data = $item;
                unset($data['objectID']);
                $params['body'][] = array(
                    'index' => array(
                        '_id' => $item['objectID'],
                        '_index' => $this->index,
                        '_type' => $type
                    )
                );
                $params['body'][] = $data;
            }
        }
        if (count($params) <= 0) {
            return abort(406, 'Data length must greater than 1.');
        }


        return $this->client->bulk($params);

    }

    public function bulkUpdate($type, $data)
    {
        return $this->bulkInsert($type, $data);
    }

    /**
     * Get mapping
     *
     * @param null $type
     * @return array
     * @internal param $index
     */
    public function getMapping($type = null)
    {

        $params['index'] = $this->index;
        if (!empty($type))
            $params['type'] = $type;
        return $this->client->indices()->getMapping($params);
    }


    public function search($type = null, $field = null, $keyword = null)
    {
        $params['index'] = $this->index;
        if (!empty($type))
            $params['type'] = $type;
        $params['body']['query']['match'][$field] = $keyword;

        return $this->client->search($params);

    }
}