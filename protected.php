<?php
require_once 'vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('assets/templates');

$twig = new Twig_Environment($loader, array(
    'cache' => 'cache',
));

if ( isset( $_COOKIE['mockauth'] ) && isset($_GET['error']) ) {
	$error_code = $_GET['error'];

	switch ($error_code) {
		// informational messages
		case '100':
			$header = '100 Continue';
    		$message = "The server has received the request headers and that the client should proceed to send the request body (in the case of a request for which a body needs to be sent; for example, a POST request). Sending a large request body to a server after a request has been rejected for inappropriate headers would be inefficient. To have a server check the request's headers, a client must send Expect: 100-continue as a header in its initial request and receive a 100 Continue status code in response before sending the body. The response 417 Expectation Failed indicates the request should not be continued.";
    		break;
    	case '101':
			$header = '101 Switching Protocols';
    		$message = "The requester has asked the server to switch protocols and the server has agreed to do so.";
    		break;
    	case '102':
			$header = '102 Processing (WebDAV; RFC 2518)';
    		$message = "A WebDAV request may contain many sub-requests involving file operations, requiring a long time to complete the request. This code indicates that the server has received and is processing the request, but no response is available yet.[8] This prevents the client from timing out and assuming the request was lost.";
			break;
		// 4xx Client Error
		// The 4xx class of status code is intended for situations in which 
		// the client seems to have erred.
		case '400':
			$header = '400 Bad Request';
			$message = "The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing).";
			break;
		case '401':
			$header = '401 Unauthorized';
			$message = "Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided. The response must include a WWW-Authenticate header field containing a challenge applicable to the requested resource.";
			break;
		case '402':
			$header = '402 Payment Required';
			$message = "Reserved for future use. The original intention was that this code might be used as part of some form of digital cash or micropayment scheme, but that has not happened, and this code is not usually used.";
			break;
		case '403':
			$header = '403 Forbidden';
			$message = "The request was a valid request, but the server is refusing to respond to it. 403 error semantically means \"unauthorized\", i.e. the user does not have the necessary permissions for the resource.";
			break;
		case '404':
			$header = '404 Not Found';
			$message = "The requested resource could not be found but may be available in the future. Subsequent requests by the client are permissible.";
			break;
		// 5xx Server Error
		// The server failed to fulfill an apparently valid request.
		case '500':
			$header = '500 Internal Server Error';
			$message = "A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.";
			break;
		case '501':
			$header = '501 Not Implemented';
			$message = "The server either does not recognize the request method, or it lacks the ability to fulfill the request. Usually this implies future availability (e.g., a new feature of a web-service API).";
			break;
		case '502':
			$header = '502 Bad Gateway';
			$message = "The server was acting as a gateway or proxy and received an invalid response from the upstream server.";
			break;
		case '503':
			$header = '503 Service Unavailable';
			$message = "The server is currently unavailable (because it is overloaded or down for maintenance). Generally, this is a temporary state.";
			break;
		case '504':
			$header = '504 Gateway Timeout';
			$message = "The server was acting as a gateway or proxy and did not receive a timely response from the upstream server.";
			break;

		default:
			$header = 'Oh snap!';
			$message = "This error hasn't been implemented yet.";
			break;
	}
	header('HTTP/1.0 '.$header);
	echo $twig->render('error.html', array('header_code' => $header, 'message' => $message));
}
elseif ( isset( $_COOKIE['mockauth'] ) ) {
	echo $twig->render('success.html', array('project_name' => 'Mock Auth', 'username' => $_COOKIE['mockauth']));
}
else {
	header('HTTP/1.0 403 Forbidden');
	echo $twig->render('403.html', array('project_name' => 'Mock Auth'));
} ?>