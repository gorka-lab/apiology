<?php
namespace Apiology;

require_once 'Classes/httpStatusCodesClass.php';
use Apiology\Classes\{HTTP};

class Init extends HTTP
{

	private $http_response = array();
	private $http_status_code;
	private $request_uri;
	private $file;
	private $resource;
	private $sub_resource = array();
	private $request_method = array();

	public function __construct(){
		$this->request_uri = $_SERVER['REQUEST_URI'];
		$this->request_method = $_SERVER['REQUEST_METHOD'];

		// Check if the Server's Request Method is GET
		// If not, sent them a 400 HTTP status Code
		if($this->request_uri === '/')
		{
			if($this->request_method === 'GET'){
				parent::jsonResponse(200, 'Welcome to apiology!');
			} else {
				parent::jsonResponse(400, 'Please check your code');
			}
		}
		else
		{
			self::getResource(self::getURI($this->request_uri));
		}
	}

	private function getURI($_uri){
		return explode('/', filter_var(trim($_uri, '/'), FILTER_SANITIZE_URL));
	}

	private function getResource($_resource){
		$this->file = RESOURCES . $_resource[0] . '.php';
		if(file_exists($this->file))
		{
			require $this->file;
			$this->resource = ucfirst($_resource[0]);
			$this->resource = "Apiology\\Resources\\{$this->resource}";
			$this->resource = new $this->resource();

			if(count($_resource) === 1)
			{
				$this->resource->main();
			}
			else
			{
				if(count($_resource) > 1)
				{
					if(method_exists($this->resource, $_resource[1]) && is_callable($_resource[1], true, $method))
					{
						if(count($_resource) > 3)
						{
							$this->resource->$method(self::get_subresources($_resource));
						} 
						else
						{
							$this->resource->$method();
						}
					}
				} else {
					parent::jsonResponse(404, 'No Child Resource found, please enter a valid child resource');
				}
			}
		}
		else
		{
			parent::jsonResponse(404, 'No Resource found, please enter a valid resource');
		}
	}

	private function get_subresources($_subresources)
	{
		$this->sub_resource = array_splice($_subresources, 2);

		return $this->sub_resource;
	}

}