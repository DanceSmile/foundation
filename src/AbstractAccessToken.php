<?php 
namespace Dancesmile\Foundation;

use Dancesmile\Dttp;
use  Doctrine\Common\Cache\FilesystemCache;
use Dancesmile\Foundation\Log;

abstract class AbstractAccessToken{




	protected $cacheEngine;
	protected $http;


	
	protected $tokenJsonKey;
	protected $expiresJsonKey;


	protected $cachePrefix;
	protected $appId;
	protected $appSecret;



	

	abstract public function getTokenFromServer();

	abstract public function checkTokenResponse( $response);



	public function getHttp()
	{
		return $this->http ?? $this->http = Dttp::client();
	}
	public function setHttp($http)
	{
		$this->http = $http;
		return $this;
	}


	public function getToken($forceRefresh = false)
	{

		$cached = $this->getCacheEngine()->fetch($this->getCacheKey());
        if ($forceRefresh || empty($cached)) {
            $result = $this->getTokenFromServer();
            $this->checkTokenResponse($result);
            $this->setToken(
                $token = $result[$this->tokenJsonKey],
                $this->expiresJsonKey ? $result[$this->expiresJsonKey] : null
            );
            return $token;
        }
        return $cached;		
	}

	public function setToken( $token, $expires = 86400 )
	{

        if ($expires) {
            $this->getCacheEngine()->save($this->getCacheKey(), $token, $expires);
        }
        return $this;

	}

	public function getCacheKey()
	{
		return $this->cahcePrefix.$this->appId;
	}

	public function setAppId($appId)
	{
		$this->appId = $appId;
	}

	public function getAppId()
	{
		return $this->appId;
	}

	public function setAppSecrect($secrect)
	{

		$this->appSecret = $secrect;
		
	}

	public function getAppSecrect()
	{
		return $this->appSecret;
	}





	public function setCacheEngine(Cache $cache )
	{
		$this->cacheEngine = $cache;
	}

	public function getCacheEngine()
	{
		return $this->cacheEngine ?? $this->cache = new FilesystemCache(sys_get_temp_dir());
	}









} 