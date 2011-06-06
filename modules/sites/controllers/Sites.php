<?php
/**
 * The Site controller shows the site specified.
 * @author Paul Gessinger
 *
 */
class Sites extends FermiController
{
	/**
	 * register the task index
	 */
	function __construct()
	{
		parent::__construct();
		
		Response::bindTemplateFunction('site', function($site) { 
			return HTML::sitelink('Index', 'Sites', 'index', $site) ;
		}) ;
		
		Response::bindTemplateFunction('link', function($agent, $controller, $task) { 
		
		}) ;
	}
	
	function modelAction()
	{
		
		$site = Core::getModel('sites:Site')->find('name=?', array('index')) ;
		$user = Core::getModel('core:User')->find('name=?', array('paul')) ;
		
		$new_role = Core::getModel('core:Role') ;
		$new_role->name = 'super' ;
		$new_role->save() ;
		
		
		
		
		Response::render() ;
	}
	

	/**
	 * retrieves the data belonging to the site requested and forwards it to the template
	 */
	function indexAction()
	{
		$site = 'index' ;
		
		if($param = Request::get('default'))
		{
			$site = $param ;
		}
		elseif($param = Request::get('site'))
		{
			$site = $param ;
		}
		
		Request::set('site', $site) ;
		
		/*$index = Core::getModel('sites:Site') ;
		$index->name = 'hans' ;
		//$index->find('name=?', array('hans')) ;
		$index->content =  'Serious business' ;
		
		if(($errors = $index->save()) !== true)
		{
			var_dump($errors) ;	
		}*/
		
		
		

		$this->site_content = Response::getTemplate('sites:page.phtml') ;


		if($site_db = Core::getModel('sites:Site')->find('name=?', array($site)))
		{
			$this->site_content->text = $site_db->content ;
		}
		else
		{
			$this->site_content->text = 'Whoops, looks like this site doesn\'t exist.' ;
		}
		
		$site_tpl = Response::getTemplate('sites:page.phtml', array('text' => $this->site_content->text)) ;
		
		
		
		Response::bind('main', $site_tpl) ;
		Response::render() ;
		
		/*$contents = array(
		'index' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
		',
		'hans' => 'Deine mutter'
		) ;
		
		if(isset($contents[$site]))
		{
			$this->site_content = Response::getTemplate('sites:page.phtml', array('text' => $contents[$site])) ;
		}
		else
		{
			$this->site_content = Response::getTemplate('sites:page.phtml', array('text' => 'Whoops, looks like this site doesn\'t exist.')) ;
		}*/
		
	}
}