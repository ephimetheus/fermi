<?php

/**
 * This is Core, the frame of Charon. Core launches Registry and coordinates Events and render.
 * @author Paul Gessinger
 *
 */


class Core
{
	static $_self ;
	static $_registry ;
	static $starttime ;
	var $_controllers ;
	var $_controller_instances ;
	var $_agents ;
	var $_agent_instances ;
	var $_models = array() ;
	protected $agent ;
	protected $controller ;
	protected $action = 'index' ;
	protected $error_triggered = false ;
	var $events = array() ;
	var $launch_exception ;
	
	/**
	 * registers error exception to have custom handling of all php errors
	 */
	function __construct()
	{		
		header("Content-type: text/html; charset=utf-8");
		
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_RECOVERABLE_ERROR);
		
		function exception_error_handler($errno, $errstr, $errfile, $errline) 
		{			
			throw new ErrorException($errstr, 0, $errno, $errfile, $errline) ;
		}
		set_error_handler("exception_error_handler", E_ERROR | E_WARNING | E_PARSE | E_RECOVERABLE_ERROR) ;
		
		spl_autoload_register(array($this, 'loader')) ;
	}
	
	private function loader($class)
	{
		$places = array('classes', 'abstracts', 'interfaces') ;
			
		foreach(Registry::$_modules as $module)
		{
			foreach($places as $place)
			{
				if(file_exists(SYSPATH.'modules/'.$module.'/'.$place.'/'.$class.'.php'))
				{
					include SYSPATH.'modules/'.$module.'/'.$place.'/'.$class.'.php' ;
					return true ;
				}
			}
		}
		
		foreach($places as $place)
			{
				if(file_exists(SYSPATH.'resources/'.$place.'/'.$class.'.php'))
				{
					include SYSPATH.'resources/'.$place.'/'.$class.'.php' ;
					return true ;
				}
			}
		

		throw new Exception('Class "'.$class.'" could not be found.') ;
	}
	
	/**
	 * Is called directly from index.php. It's the starting point of the system and instanciates Core itself
	 * as well as Registry.
	 */
	public static function _launch()
	{
		
		Core::$_self = new Core ;
			
			
		try
		{
			$reg = new Registry ;		
		}
		catch(Exception $e)
		{
			throw new Exception('Registry was unable to launch. <br/><br/><pre>'.$e.'</pre>') ;
		}
		
		Core::$_registry = $reg ;
		Core::_()->reg = $reg ;
		
		
		Core::fireEvent('onClassesReady') ;
		Core::fireEvent('onAfterClassesReady') ;
		
		
		$mtime = microtime(); 
		$mtime = explode(" ",$mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		Core::$starttime = $mtime ;
			
		/*foreach(Core::$_agents as $agent)
		{
			Core::$_agent_instances[$agent] = new $agent ;
		}
		
		foreach(Core::$_controllers as $controller)
		{
			Core::$_controller_instances[$controller] = new $controller ;
		}*/
		
		
		
		Core::fireEvent('onCoreReady') ;

	}
	
	/**
	 * Is called after _launch() has finished, directly from index.php. _route() uses Request to
	 * determine the requested resource. It creates an Agent and dispatches the call of a specific
	 * Controller to it.
	 * 
	 * Set $force to true to bypass overwriting of default or set values through uri
	 * @param bool $force
	 */
	public function _route($force = false)
	{	
		if($this instanceof Core)
		{
			try 
			{
				if(count(Registry::$_errors) != 0)
				{
					throw new RegistryException(implode('<br />', Registry::$_errors)) ;
				}
					
				
				//print_r($request) ;
				
				$this->agent = Registry::get('default_agent') ;
				$this->controller = Registry::get('default_controller') ;
				
				$rounds = array('action', 'controller', 'agent') ;
				
				foreach($rounds as $round)
				{
					if($round_value = Request::get($round))
					{
						$this->$round = $round_value ;			
					}
					else
					{
						Request::set($round, $this->$round) ;
					}
				}	
				

				
				//echo $this->agent.'/'.$this->controller.'/'.$this->action ;


				Core::fireEvent('onRoute') ;
				
				if(!isset(Core::$_registry->agents[$this->agent]))
				{
					throw new RoutingException('Agent "'.$this->agent.'" could not be retrieved.') ;
				}
				if(!isset(Core::$_registry->controllers[$this->controller]))
				{
					throw new RoutingException('Controller "'.$this->controller.'" could not be retrieved.') ;
				}
				

				include Core::$_registry->agents[$this->agent] ;
				
				$this->agent_instance =  new $this->agent ;
				
				
				$this->agent_instance->notify() ;
				
				Core::fireEvent('onAgentDispatch') ;
				
				include Core::$_registry->controllers[$this->controller] ;
				$this->agent_instance->dispatch(new $this->controller, $this->action, $request['params']) ;
				
				
				
			}
			catch(Exception $e)
			{	
				
				$default_agent = Registry::get('default_agent') ;
				
				include Core::$_registry->agents[$default_agent] ;
				
				if(get_class($this->agent_instance) != $default_agent)
				{
					$this->agent_instance = new $default_agent ;
				}
				
				include Core::$_registry->controllers['ErrorController'] ;
				$this->agent_instance->dispatch(new ErrorController, 'display', array('exception' => $e)) ;
				
				
				/*if(!$this->error_triggered)
				{
					$this->error_triggered = true ;
					//$this->agent = 'DebugAgent' ;
					$this->controller = 'ErrorController' ;
					$this->task = 'display' ;
					Request::set('Exception', $e) ;
					Response::disableOutput();
					Core::resetEvents() ;
					$this->_route(true) ;
				}*/
				
			}
			
		}
		else
		{	
			return Core::_()->_route() ;
		}
	}
	
	
	/**
	 * returns an instance of Core, shortcut to Core::$_self
	 */
	function _()
	{
		return Core::$_self ;
	}
	
	
	/**
	 * Sets the agent to the one provided in $agent. Must implement the interface Agent.
	 * @param Agent $agent The Agent to set.
	 */
	function setAgent(Agent $agent)
	{
		if($this instanceof Core)
		{
			$this->agent = $agent ;
		}
		else
		{
			Core::_()->setAgent($agent) ;
		}
	}
	
	/**
	 * Uses Registry to retrieve an instance of the class given in $class. Returns a new one if there is none.
	 * @param string $class The class to retrieve.
	 * @return object
	 */	
	function get($class)
	{
		if($this instanceof Core)
		{
			return $this->reg->getInstance($class) ;
		}
		else
		{
			return Core::_()->get($class) ;
		}
	}
	
	function getModel($model)
	{
		if($this instanceof Core)
		{
			$arr = explode(':', $model) ;
			
			if(array_key_exists($arr[1], $this->_models))
			{
				$class = $arr[1].'Model' ;
				return new $class ;
			}
			else
			{
				
				
				if($arr[0] == 'core')
				{
					if(file_exists(SYSPATH.'resources/models/'.$arr[1].'Model.php'))
					{
						include SYSPATH.'resources/models/'.$arr[1].'Model.php' ;
						
						$this->_models[$arr[1]] = true ;
						
						$class = $arr[1].'Model' ;
						return new $class ;
					}
				}
				
				
				if($path = $this->reg->getModule($arr[0]))
				{
					if(file_exists($path.'models/'.$arr[1].'Model.php'))
					{
						include $path.'models/'.$arr[1].'Model.php' ;
					
						$this->_models[$arr[1]] = true ;
						
						$class = $arr[1].'Model' ;
						return new $class ;
					}
				}
				
				
				
				throw new ErrorException('Model "'.$model.'" could not be retrieved.') ;
				
			}
		}
		else
		{
			return Core::_()->getModel($model) ;
		}
	}
	
	
	/**
	 * registers an event listener to an event specified
	 * @param string The Event you want to add the listener to
	 * @param string/array Either a string name of a function or an array containing both reference to an object and method name
	 * @return void
	 */
	function addListener($event, $function)
	{
		if($this instanceof Core)
		{
			if(!array_key_exists($event, $this->events))
			{
				$this->events[$event] = new Event($event) ;
			}
			
			$this->events[$event]->registerListener($function) ;
		}
		else
		{
			return Core::$_self->addListener($event, $function) ;
		}
	}
	
	/**
	 * Fires an event executing all registered listeners
	 * @param string Event to be fired
	 * @return unknown_type All the returns of functions registered to the Event
	 */
	function fireEvent($event)
	{
		if($this instanceof Core)
		{
			if(!array_key_exists($event, $this->events))
			{
				$this->events[$event] = new Event($event) ;
				//$this->events[$event]->fired = true ;
			}
			else
			{
			
				$arg_arr = func_get_args() ;
				unset($arg_arr[0]) ;
			
				return call_user_func_array(array($this->events[$event], 'fire'), $arg_arr) ;
				//$this->events[$event]->fire($arg_arr) ;
			}
			
		}
		else
		{
			$arg_arr = func_get_args() ;
			return call_user_func_array(array(Core::$_self, 'fireEvent'), $arg_arr) ;
		}
	}
	
	/**
	 * Prevents the event from being fired again, despite being recharged.
	 * @param string $event
	 */
	function sealEvent($event)
	{
		if($this instanceof Core)
		{
			$this->events[$event]->seal() ;
		}
		else
		{
			return Core::$_self->sealEvent($event) ;
		}
	}
	
	/**
	 * Resets an event to its status previous to being fired. Enables it to be fired again.
	 * @param string $event The event to recharge
	 */
	function rechargeEvent($event)
	{
		if($this instanceof Core)
		{
			$this->events[$event]->recharge() ;
		}
		else
		{
			return Core::$_self->rechargeEvent($event) ;
		}
	}
	
	/**
	 * Works like rechargeEvent() but for all Events at once.
	 */
	function resetEvents()
	{
		if($this instanceof Core)
		{
			foreach($this->events as $event)
			{
				$event->recharge() ;
			}
		}
		else
		{
			return Core::$_self->rechargeEvent($event) ;
		}
	}
}