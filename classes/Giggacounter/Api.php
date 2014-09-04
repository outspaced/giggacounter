<?php 
namespace Giggacounter;

use Giggacounter\Exception as Exception;
use Giggacounter\Traits\Getconfig as Getconfig;

/**
 * Base class for API access
 * 
 * @package  Giggacounter
 * @category Api
 * @author   Alex Brims
 * @license  GNU GPL v3.0 
 */
abstract class Api
{
	use Getconfig;
		
	/**
	 * @var array
	 */
	protected $_config;
	
	/**
	 * Construct!
	 * 
	 * @param  array  $config
	 * @param  string $username
	 * @return self
	 * @throws Exception
	 */
	public function __construct(array $config = NULL)
	{
		if ($config)
		{ 
			$this->_config = $config;
		}
		else
		{
			$this->_config = \Kohana::$config->load('giggacounter.api.default');
		}

		if ( ! $this->_config('api_key'))
			throw new Exception('No API key specified in config');
		
		return $this;
	}

	/**
	 * Converts the result from the API request to an array
	 * 
	 * @param  string $key
	 * @return array
	 * @throws Exception
	 */
	protected function _convert_result_to_array($string)
	{
		switch ($this->_config('api_result_format'))
		{
			case 'json':
				return json_decode($string, TRUE);
			case 'xml':
				$parser = xml_parser_create();
				xml_parse_into_struct($parser, $string, $result);
				xml_parser_free($parser);
				
				return $result;
			default:
				throw new Exception('API config did not have valid result format set');
		}
	}
	
	/**
	 * Returns the API URL with all substitutions and the page number
	 * 
	 * @param  int  $page
	 * @return string
	 */
	protected function _get_api_url($username, $page)
	{
		// Find the keys and replace with values
		$find = array('<username>', '<api_key>', '<result_format>', '<page>');
		$replace = array($username, $this->_config('api_key'), $this->_config('api_result_format'), $page);
		
		return str_replace($find, $replace, $this->_config('api_url'));
	}
	
	/**
	 * Factorise!
	 * 
	 * @param  string     $api 
	 * @param  array      $config
	 * @return Api
	 * @throws Exception
	 */
	public static function factory($api, array $config=NULL)
	{
		switch ($api)
		{
			case 'lastfm':
				return new  Api\Lastfm($config);
			case 'songkick':
				return new  Api\Songkick($config);
			default:
				throw new Exception('Invalid API selected');
		}
	}
	
	/**
	 * Gets the data from the API (caching along the way)
	 * 
	 * @param  string      $username
	 * @param  Api\Counter $counter
	 * @throws Exception
	 * @return array
	 */
	public function grab_data($username, Api\Counter $counter)
	{
		$page = 0;

		// CACHE
		$cache = \HTTP_Cache::factory('file');
		$cache->allow_private_cache(TRUE);

		// REQUEST CACHE
		$request_cache = \Request_Client_External::factory()->cache($cache);

		while(TRUE)
		{
			$page++;
			
			// REQUEST
			$request = \Request::factory($this->_get_api_url($username, $page));
			
			// CLIENT
			$client = $request->client($request_cache);
	
			// GO!!
			$result    = $client->execute($request)->body();
			$page_data = $this->_convert_result_to_array($result);
			
			// Give up now if no result
			if ( ! is_array($page_data))
				throw new Exception('Failed to get a result from API');
			
			// Only continue if we are not finished
			if ( ! $this->_continue($page_data))	
				break;
			
			// Collect results
			$counter->add_result($page_data);
		}		
		
		return $counter;
	}
}
