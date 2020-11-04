# Twitter Tweet Scraper API using PHP
A php curl based twitter tweets scraper API developed by Tufayel Ahmed

# Purpose
This API was built for those who wants to collect tweets programmatically from profiles or those who wants to delete their twitter account but wants to backup their tweets.

# Some Helpful Information
* There are 20 tweets returned per each request made.
* Twitter has rate limiting feature, so don't plan to go mad.
* I am not hosting this API just to play safe.
* To bypass rate limit, implement rotating proxies if you plan to use it in production level.

# Documentation
## GET /tweets.php
### Parameter:<br>
<code>username</code> - twitter username of target account (<i><b>required</b></i>)<br>
<code>nextPageCursor</code> - token for accessing next tweets/pagination (<i><b>not required</b></i> for initial API call, <i><b>required</b></i> for accessing next pages)<br>
### Example:
* For accessing first page:<br>
<code>/tweets.php?username=tufayel_cse</code>
### Sample Response:
<pre>{
  "tweets":["tweet body here", "another tweet body here"],
  "nextPageCursor":"HBaGwLrlrJv63SAAAA=="
}</pre>

* For accessing next pages and so on(<i>set nextPageCursor value received in previous request</i>):<br>
<code>/tweets.php?username=tufayel_cse&nextPageCursor=HBaGwLrlrJv63SAAAA==</code>
### Sample Response:
<pre>{
  "tweets":["next page tweets"],
  "nextPageCursor":"HBaGwvdfgfv63SAAAA=="
}</pre>
