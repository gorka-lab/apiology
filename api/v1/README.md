# apiology
PHP REST API FrameWork

## Getting Started

By convention every API path should have its version so the Root path of this framework should eb always /api/vX/

If it's going to be used in a path different as in the *root (/api/vX/)*, change the ***RewriteBase*** from the .htaccess to the path that is going to be used


## How to use it
This API uses REST JSON via HTTP, so every message should be in a JSON format

### Resources
Each resource will be a class inside the *Apiology/Resources* folder. Just set up a class with its own name just as shown in the sample.php Class.


### Methods
The main Method inisde each class should be main() which do not need to get any parameters.

If a method with parameters is needed, use the sample_method_two() structure code provided in the ***Sample*** Class

- Handle HTTP REQUEST METHODS inside each method, so for example, if only a method GET allowed, try to only accept GET requests

Example:

```php 
public function sample_method()
{
	if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		#Code...
	}
	else
	{
		parent::get_header(400, true, "We only accept GET Requests");
	}
}
```


### Headers
Headers were set in a file called headersClass.php, instantiated inside the ***Init()*** Class and with its namespace declared, so no need to instantiated

Hints about Headers

1. To use it just call the ***get_header()*** method. 

2. This method requires 3 parameters except the one by default **Code Client Error 417**

```php
parent::get_header(int, boolean, string)
```

- int [HTTP Status Code]: use HTTP status Code to identify the header
- bolean: true/false
	- true: with a JSON message
	- false: with no message. Important: it needs to be followed by null in the next parameter
- string/null: Use a string to give a message or null if you set false

Example:
```php
parent::get_header(200, true, "It's all good!");
```


--------------------

## Contributing
Always available to improve, so if you want to contribute just create a branch and let me know.

Thanks!!!!