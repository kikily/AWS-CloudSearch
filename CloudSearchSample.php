<?php
//Initialize AWS SDK
require 'AWSSDK/aws-autoloader.php';
//Declare the CloudSearchDomain class
use Aws\CloudSearchDomain\CloudSearchDomainClient;

//Build the connection to CloudSearch
$cloudsearch = new CloudSearchDomainClient([
	'version' => 'latest',
	'region'  => 'Your region',
	'endpoint'    => 'https://Your Search Endpoint', //You can get it from your domain Dashboard.
	'credentials' => false
]);

//Specifies a structured query that filters the results of a search without affecting how the results are scored and sorted. You can refer to the AWS website.
$filterQuery = "(and (prefix field=title 'test1'))";
//Post search conditions and get a result array
$result = $cloudsearch->search(array(
	'query'		=> 'test',
	'filterQuery'    => $filterQuery,                     //Specifies a structured query (Optional)
	'sort'		=> 'startdate asc, article_id desc',  //Specifies the fields or custom expressions to use to sort the search results. (Optional)
	'size'  	=> 5,                                 //Specifies the maximum number of search hits to include in the response. (Optional)
	'start' 	=> 0,                                 //Specifies the offset of the first search hit you want to return. (Optional)
	'return' 	=> 'topic,startdate'                  //Specifies the field and expression values to include in the response. (Optional)
));

//Get the number of hits and print it.
$hitCount = $result->getPath('hits/found');
echo "Number of Hits: {$hitCount} <br><br>";

?>
