<?php

namespace App\Interfaces;

use Psr\SimpleCache\InvalidArgumentException;

Interface PostServiceInterface
{
    /**
     * @param string $url
     * @param array $params
     * @return object
     */
    public function loadApiData(string $url, array $params): object;

    /**
     * @param string $url
     * @param array $params
     * @return mixed|object
     * @throws InvalidArgumentException
     */
    public function getApiData(string $url, array $params);

    /**
     * @return mixed
     */
    public function posts();

    /**
     * @param int $id
     * @return mixed
     */
    public function post(int $id);

    /**
     * @param int $postId
     * @return mixed
     */
    public function commentsByPostId(int $postId);

}
