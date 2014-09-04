<?
namespace Giggacounter\Traits;

/**
 * Quick and easy way to get a value from the loaded config
 * 
 * @package  Giggacounter
 * @author   Alex Brims
 */
trait Getconfig
{
	/**
	 * Gets the relevant value from config
	 * 
	 * @param  string $key
	 * @return mixed 
	 */
	protected function _config($key)
	{
		return \Arr::path($this->_config, $key);
	}
}