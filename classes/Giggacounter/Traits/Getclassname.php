<?
namespace Giggacounter\Traits;

/**
 * Quick and easy way to get a namespace-free class name
 * 
 * @package  Giggacounter
 * @author   Alex Brims
 * @see      ReflectionClass
 */
trait Getclassname
{
	/**
	 * Returns the namespace-free class name.  Apparently this is the 
	 * fastest way to access it.
	 * 
	 * @return string
	 */
	public function get_class_name()
	{
		return (new \ReflectionClass($this))->getShortName();	
	}	
}
