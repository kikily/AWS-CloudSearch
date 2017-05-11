<?php
//初始化AWS SDK (Initialize AWS SDK)
require 'AWSSDK/aws-autoloader.php';
//宣告使用CloudSearchDomain類別 (Declare the CloudSearchDomain class)
use Aws\CloudSearchDomain\CloudSearchDomainClient;

//建立CloudSearch連線 (Build the connection to CloudSearch)
$cloudsearch = new CloudSearchDomainClient([
	'version' => 'latest',
    'region'  => 'Your region',
	'endpoint'    => 'https://Your Search Endpoint', //Search Endpoint網址可以從你建立的Domain儀錶板中取得(You can get it from your domain Dashboard.)
    'credentials' => false
]);

//可以使用條件搜尋，相關條件可至AWS網站查詢 (Specifies a structured query that filters the results of a search without affecting how the results are scored and sorted. You can refer to the AWS website.)
$filterQuery = "(and (prefix field=title 'test1'))";
//根據傳入的搜尋條件取得搜尋結果 (Post search conditions and get a result array)
$result = $cloudsearch->search(array(
	'query'		=> 'test',
	'filterQuery'    => $filterQuery,                 //設定特定搜尋條件 (Specifies a structured query) (Optional)
	'sort'		=> 'startdate asc, article_id desc',  //可設定排序條件 (Specifies the fields or custom expressions to use to sort the search results.) (Optional)
	'size'  	=> 5,                                 //設定要回傳的筆數 (Specifies the maximum number of search hits to include in the response.) (Optional)
	'start' 	=> 0,                                 //設定取得從第幾筆開始的資料 (Specifies the offset of the first search hit you want to return.) (Optional)
	'return' 	=> 'topic,startdate'                  //設定回傳欄位 (Specifies the field and expression values to include in the response.) (Optional)
));

//取得搜尋結果筆數 (Get the number of hits)
$hitCount = $result->getPath('hits/found');
echo "Number of Hits: {$hitCount} <br><br>";

?>