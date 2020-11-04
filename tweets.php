<?php

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $headers = array(
        "authorization: Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA",
        'x-csrf-token: e58da8d6a7b4574f544ab9eaa5de5c7e',
        'x-guest-token: 1324014500761071616',
        'x-twitter-active-user: yes',
        'x-twitter-client-language: en',
    );
    $resp = getContent("https://api.twitter.com/graphql/jMaTS-_Ea8vh9rpKggJbCQ/UserByScreenName?variables=%7B%22screen_name%22%3A%22" . urlencode($username) . "%22%2C%22withHighlightedLabel%22%3Atrue%7D", $headers);
    $resp = json_decode($resp);
    $profile_id = $resp->data->user->rest_id;

    $headers = array(
        "authorization: Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA",
        'x-csrf-token: e58da8d6a7b4574f544ab9eaa5de5c7e',
        'x-guest-token: 1324014500761071616',
        'x-twitter-active-user: yes',
        'x-twitter-client-language: en',
    );
    if (isset($_GET['nextPageCursor'])) {
        $nextPageCursor = $_GET['nextPageCursor'];
        $resp = getContent("https://api.twitter.com/2/timeline/profile/" . $profile_id . ".json?include_profile_interstitial_type=1&include_blocking=1&include_blocked_by=1&include_followed_by=1&include_want_retweets=1&include_mute_edge=1&include_can_dm=1&include_can_media_tag=1&skip_status=1&cards_platform=Web-12&include_cards=1&include_ext_alt_text=true&include_quote_count=true&include_reply_count=1&tweet_mode=extended&include_entities=true&include_user_entities=true&include_ext_media_color=true&include_ext_media_availability=true&send_error_codes=true&simple_quoted_tweet=true&include_tweet_replies=false&count=20&cursor=" . urlencode($nextPageCursor) . "&userId=" . $profile_id . "&ext=mediaStats%2ChighlightedLabel", $headers);
        $resp = json_decode($resp);
        $tweets = $resp->globalObjects->tweets;
        $nextPageCursor = $resp->timeline->instructions[0]->addEntries->entries;
        $nextPageCursor = $nextPageCursor[count($nextPageCursor) - 1];
        $nextPageCursor = $nextPageCursor->content->operation->cursor->value;
        $just_tweets = array("tweets" => array());
        foreach ($tweets as $tweet) {
            array_push($just_tweets['tweets'], $tweet->full_text);
        }
        $just_tweets['nextPageCursor'] = $nextPageCursor;
        echo json_encode($just_tweets);
    } else {
        $resp = getContent("https://api.twitter.com/2/timeline/profile/" . $profile_id . ".json?include_profile_interstitial_type=1&include_blocking=1&include_blocked_by=1&include_followed_by=1&include_want_retweets=1&include_mute_edge=1&include_can_dm=1&include_can_media_tag=1&skip_status=1&cards_platform=Web-12&include_cards=1&include_ext_alt_text=true&include_quote_count=true&include_reply_count=1&tweet_mode=extended&include_entities=true&include_user_entities=true&include_ext_media_color=true&include_ext_media_availability=true&send_error_codes=true&simple_quoted_tweet=true&include_tweet_replies=false&count=20&userId=" . $profile_id . "&ext=mediaStats%2ChighlightedLabel", $headers);
        $resp = json_decode($resp);
        $tweets = $resp->globalObjects->tweets;
        $nextPageCursor = $resp->timeline->instructions[0]->addEntries->entries;
        $nextPageCursor = $nextPageCursor[count($nextPageCursor) - 1];
        $nextPageCursor = $nextPageCursor->content->operation->cursor->value;
        $just_tweets = array("tweets" => array());
        foreach ($tweets as $tweet) {
            array_push($just_tweets['tweets'], $tweet->full_text);
        }
        $just_tweets['nextPageCursor'] = $nextPageCursor;
        echo json_encode($just_tweets);
    }
    /*$max_loop = 0;
    while (true) {
        $resp = getContent("https://api.twitter.com/2/timeline/profile/" . $profile_id . ".json?include_profile_interstitial_type=1&include_blocking=1&include_blocked_by=1&include_followed_by=1&include_want_retweets=1&include_mute_edge=1&include_can_dm=1&include_can_media_tag=1&skip_status=1&cards_platform=Web-12&include_cards=1&include_ext_alt_text=true&include_quote_count=true&include_reply_count=1&tweet_mode=extended&include_entities=true&include_user_entities=true&include_ext_media_color=true&include_ext_media_availability=true&send_error_codes=true&simple_quoted_tweet=true&include_tweet_replies=false&count=20&cursor=" . urlencode($nextPageCursor) . "&userId=" . $profile_id . "&ext=mediaStats%2ChighlightedLabel", $headers);
        $resp = json_decode($resp);
        $tweets = $resp->globalObjects->tweets;
        $nextPageCursor = $resp->timeline->instructions[0]->addEntries->entries;
        $nextPageCursor = $nextPageCursor[count($nextPageCursor) - 1];
        $nextPageCursor = $nextPageCursor->content->operation->cursor->value;
        if (count($tweets) == 0) {
            break;
        }
        foreach ($tweets as $tweet) {
            echo "<b>Tweet No. " . $counter++ . "</b><br>";
            echo "<pre>" . $tweet->full_text . "</pre><br>";
        }
        $max_loop++;
        if ($max_loop == 3) {
            break;
        }
    }*/
}


function getContent($url, $headers, $geturl = false)
{
    $ch = curl_init();
    $options = array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Mobile Safari/537.36',
        CURLOPT_ENCODING       => "utf-8",
        CURLOPT_AUTOREFERER    => false,
        CURLOPT_REFERER        => 'referer: https://twitter.com/',
        CURLOPT_COOKIEJAR      => 'twcookie.txt',
        CURLOPT_COOKIEFILE     => 'twcookie.txt',
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_MAXREDIRS      => 10,
    );
    curl_setopt_array($ch, $options);
    if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    }
    $data = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($geturl === true) {
        return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    }
    curl_close($ch);
    return strval($data);
}
