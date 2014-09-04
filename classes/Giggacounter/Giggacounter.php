<?php
namespace Giggacounter;

/**
 * Main class for Giggacounting
 * 
 * @package  Giggacounter
 * @author   Alex Brims
 * @license  GNU GPL v3.0 
 */
class Giggacounter
{
	/**
	 * @var Api
	 */
	protected $_api;

	/**
	 * @var Counter
	 */
	protected $_counter;
	
	/**
	 * Construct! 
	 * 
	 * @param array  $config
	 * @param string $username
	 * @param Api    $api
	 */
	public function __construct(Api $api, Api\Counter $counter)
	{
		$this->_api     = $api;
		$this->_counter = $counter;
		
		return $this;
	}
	
	/**
	 * Do the full process
	 * 
	 * @param  string  $username
	 * @param  string  $sub_counter
	 * @throws Exception
	 * @return array
	 * @todo   Should perhaps return a result object, instead of an array?
	 */
	public function process($username, $sub_counter)
	{
		$counter_name = strtolower($this->_counter->get_class_name());
		$sub_counters = self::get_sub_counters($counter_name);
		
		if ($sub_counters AND ! array_key_exists($sub_counter, $sub_counters))
			throw new Exception('Invalid division for '.$counter_name.': '.$sub_counter);
		
		$data           = $this->_grab_data($username, $this->_counter);
		$formatted_data = $this->_get_formatted_results($sub_counter);
		
		return $formatted_data;
	}
	
	/**
	 * Wrapper for Counter class method
	 * 
	 * @param  string  $sub_counter
	 * @return array
	 * @author Alex Brims
	 */
	protected function _get_formatted_results($sub_counter)
	{
		return $this->_counter->get_formatted_results($sub_counter);
	}
	
	/**
	 * Wrapper for API class method
	 * 
	 * @param  string      $username
	 * @param  Api\Counter $result
	 * @return array
	 * @author Alex Brims
	 */
	protected function _grab_data($username, Api\Counter $result)
	{
		return $this->_api->grab_data($username, $result);
	}
	

	/**
	 * Get the available APIs from config.
	 * 
	 * @return array
	 * @access static
	 */
	public static function get_apis()
	{
		$return = array();
		
		foreach (\Kohana::$config->load('giggacounter.api') as $key => $api)
		{
			$return[$key] = \arr::get($api, 'api_fullname');
		}
		
		return $return;
	}
	
	/**
	 * Get the counters from config.
	 * 
	 * @return array
	 * @access static
	 */
	public static function get_counters()
	{
		return \Kohana::$config->load('giggacounter.counters');
	}

	/**
	 * Get the sub_counters from config.  Optional argument loads just
	 * the sub_counters for that type
	 * 
	 * @param  string
	 * @return array
	 * @access static
	 */
	public static function get_sub_counters($type=NULL)
	{
		if ($type)
			return \Kohana::$config->load('giggacounter.sub_counters.'.$type);
		else	
			return \Kohana::$config->load('giggacounter.sub_counters');
	}	
}