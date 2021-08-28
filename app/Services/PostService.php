<?php

namespace App\Services;

use App\Interfaces\PostServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

class PostService implements PostServiceInterface
{
    /**
     * @const string API_POST_URL
     */
    const API_POST_URL = 'https://jsonplaceholder.typicode.com/posts';

    /**
     * @const string API_COMMENTS_URL
     */
    const API_COMMENTS_URL = 'https://jsonplaceholder.typicode.com/comments';

    /**
     * @const string CACHE_DRIVER
     */
    const CACHE_DRIVER = 'file';

    /**
     * @const string CACHE_TIME
     */
    const CACHE_TIME = 300;

    /**
     * Load data from api web service.
     *
     * @param string $url
     * @param array $params
     * @return object
     */
    public function loadApiData(string $url, array $params): object
    {
        return Http::get($url, $params)->collect();
    }

    /**
     * (Caching layer)
     * Save api data into cache and than get.
     *
     * @param string $url
     * @param array $params
     * @return mixed|object
     * @throws InvalidArgumentException
     */
    public function getApiData(string $url, array $params = [])
    {
        $cache = Cache::store(self::CACHE_DRIVER);
        $cacheAddress = $params ? $url.'/post/'.$params['postId'] : $url;

        if ($cache->has($cacheAddress))
        {
            $apiData = $cache->get($cacheAddress);
        }
        else
        {
            $apiData = $this->loadApiData($url, $params);
            $cache->set($cacheAddress, $apiData, self::CACHE_TIME);
        }

        if ($apiData->isEmpty())
            abort(404);

        return $apiData;
    }

    /**
     * Get all post data from cache layer.
     *
     * @return Collection|mixed|Object
     * @throws InvalidArgumentException
     */
    public function posts()
    {
        return $this->getApiData(self::API_POST_URL);
    }

    /**
     * Get per post from all post cache layer to save memory.
     *
     * @param int $id
     * @return Collection|mixed|Object|null
     * @throws InvalidArgumentException
     */
    public function post(int $id)
    {
        return $this->getApiData(self::API_POST_URL)->firstWhere('id', $id);
    }

    /**
     * Get comment data by id from cache layer.
     *
     * @param int $postId
     * @return Collection|mixed|Object
     * @throws InvalidArgumentException
     */
    public function commentsByPostId(int $postId)
    {
        return $this->getApiData(self::API_COMMENTS_URL, ['postId' => $postId]);
    }

    /**
     * Paginate collection data for view.
     *
     * @return object
     */
    public function paginate($items, $perPage, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, null, ['path'=>url(request()->fullUrl())]);
    }

}
