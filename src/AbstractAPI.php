<?php 
namespace Dancesmile\Foundation;
use Dancesmile\Dttp;

Abstract class AbstractApi{


	protected $http;


	public function getHttp()
	{
		if(is_null($this->http)){
			$this->http = Dttp::client();
		}
		return $this->http;
	}



	public function middware()
	{
	}

}