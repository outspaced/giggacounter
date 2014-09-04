<?php
namespace Giggacounter\Api;
use Giggacounter\Exception as Exception;
use Giggacounter\Traits\Getclassname as Getclassname;
use Giggacounter\Traits\Getconfig as Getconfig;

/**
 * Base class for handling the counters for API results
 * 
 * @package  Giggacounter
 * @category Counter
 * @author   Alex Brims
 * @license  GNU GPL v3.0  
 */
abstract class Counter
{
	use Getclassname;
	use Getconfig;
		
	/**
	 * @var array
	 */
	protected $_config;
	
	/**
	 * @var array
	 */
	protected $_data = array();
		
	/**
	 * @var string
	 */
	protected $_chart_title;
	
	/**
	 * Construct!
	 * 
	 * @param  array $config
	 * @return self
	 */
	public function __construct(array $config=NULL)
	{
		if ($config)
		{ 
			$this->_config = $config;
		}
		else
		{
			$this->_config = \Kohana::$config->load('giggacounter.api.default');
		}
		
		return $this;
	}	

	/**
	 * Adds increments the count for $data[$key], or initialises to 1 if not set
	 * 
	 * @param  array  $data
	 * @param  string $key
	 * @return array
	 */
	protected function _add_count(array $data, $key)
	{
		$key = addslashes($key);
		
		if (isset($data[$key]))
		{
			$data[$key]++;
		}
		else
		{
			$data[$key] = 1;
		}
		
		return $data;
	}	
		
	/**
	 * Takes the raw input array from the API and extracts the dates into a 
	 * single-dimensional array
	 * 
	 * @param  array $array
	 * @return array
	 */
	protected function _extract_target_fields(array $api_data)
	{
		// Need the namespace-free classname, this is apparently the 
		// best way performance-wise to get that
		$class_name = strtolower($this->get_class_name());
		$extracted_data = array();

		// Loop through the events from the result, and extract the date field
		foreach (\Arr::path($api_data, $this->_config('events.key')) as $key => $event)
		{
			$extracted_data[] = \Arr::path($event, $this->_config('events.fields.'.$class_name));
		}

		return $extracted_data;
	}	
	
	
	/**
	 * Extracts the relevant results and adds them to the result array
	 * 
	 * @param  array $result
	 * @param  array $data
	 * @return array
	 */
	public function add_result(array $page_data)
	{
		$result      = $this->_extract_target_fields($page_data);
		$this->_data = array_merge($this->_data, $result);
		
		return $this->_data;
	}
	
	/**
	 * Factory!
	 * 
	 * @param  string $counter 
	 * @param  array  $config
	 * @return self
	 */
	public static function factory($counter, array $config=NULL)
	{
		$class_name = __NAMESPACE__.'\Counter\\'.ucwords($counter);
		
		if (class_exists($class_name))
			return new $class_name($config);
		
		throw new Exception('Invalid result counter type: '.$counter);	
	}
	
	/**
	 * Returns the title from the subclass
	 * 
	 * @return string
	 */
	public function get_chart_title()
	{
		return $this->_chart_title;	
	}
	
	/**
	 * Formats the result array according to the desired result
	 * 
	 * @param  string $sub_counter
	 * @return array
	 * @todo   The max_count config should be specified by counter, not by API 
	 */
	public function get_formatted_results($sub_counter=NULL)
	{
		$formatted_data = array();
		
		// Sort into a key => count array
		foreach ($this->_data as $item)
		{
			$formatted_data = $this->_add_count($formatted_data, $item);
		}

		// Highest count first
		arsort($formatted_data);
		
		// Return the maximum specified number of results
		$formatted_data = array_slice($formatted_data, 0, $this->_config('max_count'));
		
		return $formatted_data;
	}
}