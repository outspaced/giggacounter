<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Giggacounter
 *
 * @package    Giggacounter
 * @author     Alex Brims
 * @copyright  (c) 2014 Alex Brims
 * @license    GNU GPL v3.0
 */
use Giggacounter\Giggacounter as Giggacounter;
use Giggacounter\Api as Api;
use Giggacounter\Api\Counter as Counter;
use Giggacounter\Traits\Media as Media;
use Giggacounter\Exception as Exception;

class Controller_Giggacounter extends Controller {
	
	/**
	 * For action_media method
	 */
	use Media;
	
	/**
	 * @var array
	 */
	protected $_scripts = array(
		'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
		'https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js',	
		'/giggacounter/media/giggacounter.js');
	
	public function action_index()
	{
		if ($this->request->post())
		{
			// Load the relevant post fields into variables
			$post_fields = array('api', 'username', 'counter', 'sub_counter');
			foreach ($post_fields as $post_field)
			{
				$$post_field = $this->request->post($post_field);
			}
			
			try 
			{
				// Load the meat and bones
				$config  = \Kohana::$config->load('giggacounter.api.'.$api);
				$counter = Counter::factory($counter, $config);
				$api     = Api::factory($api, $config);
				
				// Go!
				$giggacounter = new Giggacounter($api, $counter);
				$formatted_results = $giggacounter->process($username, $sub_counter);
				
				\Kohana::$log->add(Log::INFO, print_r($this->request->post(), TRUE));
				
				$body = View::factory('chart')
					->set('result',      $formatted_results)
					->set('chart_title', $counter->get_chart_title());
			}
			catch(Exception $e)
			{
				$body = View::factory('error')
					->set('error', $e->getMessage());
			}
			catch(\Exception $e)
			{
				\Kohana::$log->add(Log::ERROR, $e->getTraceAsString());
				
				// We don't want to disclose this error
				$body = View::factory('error')
					->set('error', "Oh no!  An error! It's been logged and we'll fix it as soon as possible");
			}
		}
		else
		{
			$body = View::factory('form')
				->set('apis',         Giggacounter::get_apis())
				->set('counters',     Giggacounter::get_counters())
				->set('sub_counters', Giggacounter::get_sub_counters());
		}
					
		$this->_render($body);				
	}
	
	/**
	 * Adds the header and footer to the view for rendering
	 * 
	 * @param  View
	 * @return Response
	 * @todo   Add in the ability to return JSON
	 */
	protected function _render($body)
	{
		// So I want to add in the capability to render JSON here
		$header = View::factory('header')
			->set('scripts', $this->_scripts);
		
		$footer = View::factory('footer');
		
		$body->set('header', $header)
			->set('footer', $footer);
		
		return $this->response->body($body);
	}
}
