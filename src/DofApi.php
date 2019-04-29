<?php

namespace DofApi;

/**
 * Wrapper for dof api
 */
class DofApi
{
    const DEFAULT_URL = 'https://dofapi2.herokuapp.com/';

    protected $url;
    protected $nb;

    /**
    * @param string $url Api link, default https://dofapi2.herokuapp.com/
    */
    function __construct(string $url = self::DEFAULT_URL)
    {
        $this->url = $url;
        $this->nb = 0;
    }


    /**
    *   Control Api response
    *   Throw expection if an error come up
    *
    * @param Array $res Api reponse
    */
    protected function controlRes($res)
    {
        if (empty($res)) {
            throw new NoResponseException('Empty response', []);
        }
    }

    protected function isAssoc($arr)
    {
        if ([] === $arr) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    protected function fetchParams($arr)
    {
        if (!$this->isAssoc($arr)) {
            return $arr;
        }

        $res = [];
        foreach ($arr as $k => $v) {
            $res[] = "$k: ".utf8_decode($v);
        }

        return $res;
    }

    /**
    * Execute GET request
    *
    * @param String $link Api link
    * @param Array $data Array who contain data to send, like ['name: param', ...] OR ['name' => param, ...]
    *
    * @return Array Api response
    */
    public function get(string $link, array $data = [])
    {
        Log::cyan("API(" . ++$this->nb . ") => GET $link");
        $curl = curl_init();

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->fetchParams(($data)));
        }

        return $this->exec($curl, $link);
    }

    /**
    * Execute API request
    *
    * @param  String $link Api link
    *
    * @return Array Api response
    *
    */
    protected function exec($curl, $link)
    {
        // Options configuration
        curl_setopt($curl, CURLOPT_URL, $this->url . $link);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 1500);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "UTF-8");

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        // Data
        $header = trim(substr($response, 0, $info['header_size']));
        $body = substr($response, $info['header_size']);

        $res = json_decode($body);

        curl_close($curl);

        $this->controlRes($res);

        return $res;
    }

    /********************************************************
    *                                                       *
    *              API requests helpers                     *
    *                                                       *
    *********************************************************/

    /**
    * Execute a count API request
    *
    * @param string $route Begining route
    * @param array $filter List of filters
    *
    * @return int Count return by API
    */
    protected function count(string $route, array $filter = [])
    {
        return $this->get("$route/count", ['filter' => json_encode($filter)])->count;
    }

    /**
    * Execute a get API request
    *
    * @param string $route Begining route
    *
    * @return Object Object
    */
    protected function getSingle(string $route, int $id)
    {
        return $this->get("${route}/$id");
    }

    /**
    * Execute a get API request
    *
    * @param string $route Begining route
    * @param array $filter List of filters
    *
    * @return Object Object
    */
    protected function getAll(string $route, array $filter = [])
    {
        return $this->get("${route}", ['filter' => json_encode($filter)]);
    }

    /********************************************************
    *                                                       *
    *                   API requests                        *
    *                                                       *
    *********************************************************/

    public function __call(string $name, array $args = []) {
        if (strtolower(substr($name, -5)) == 'count') {
            // Count routes
            return $this->count(strtolower(substr($name, 0, -5)), $args[0] ?? []);
        }
        if (strtolower(substr($name, 0, 3)) == 'get') {
            if (!empty($args) && is_int($args[0])) {
                // get single routes
                $name = strtolower(substr($name, 3));
                // Add 's' to the end if need
                $name = substr($name, -1) == 's' ? $name : $name . 's';
                return $this->getSingle($name, $args[0]);
            } else {
                // get all routes
                $name = strtolower(substr($name, 3));
                return $this->getAll($name, $args[1] ?? []);
            }
        }
    }

}
