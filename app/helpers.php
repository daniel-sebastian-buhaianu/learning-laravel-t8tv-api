<?php

use \App\Models\RumbleChannel;
use \App\Models\RumbleVideo;

/* Template */
if (!function_exists('name'))
{
    // function here
}

if (!function_exists('addRumbleVideosToDatabase'))
{
    function addRumbleVideosToDatabase($rumbleChannelUrl)
    {
        $countVideosAddedToDatabase = 0;

        $response = getRumbleChannelVideosData($rumbleChannelUrl);

        if(!empty($response['error']))
        {
            return array(
                'countVideosAddedToDatabase' => $countVideosAddedToDatabase,
                'error' => $response['error']
            );
        }

        $rumbleChannelIdInTable = $response['rumbleChannelIdInTable'];
        $videos = $response['data'];

        foreach($videos as $video)
        {
            $dataToValidate = [
                'title' => $video->title,
                'url' => $video->url
            ];

            $validator = Validator::make($dataToValidate, [
                'title' => [
                    'string',
                    'max:255',
                    'unique:rumble_video'
                ],
                'url' => [
                    'string',
                    'max:255',
                    'unique:rumble_video'
                ]
            ]);

            if (!$validator->fails()) 
            {
                $queryResult = addRumbleVideoToDatabase($video, $rumbleChannelIdInTable);

                if (true === $queryResult['success'])
                {
                    $countVideosAddedToDatabase++;
                }
            }
        }

        return array(
            'countVideosAddedToDatabase' => $countVideosAddedToDatabase,
            'error' => null
        );
    }
}

if (!function_exists('getRumbleChannelVideosData'))
{
    function getRumbleChannelVideosData($url)
    {
        $apiUrl = "https://dsb99.app/rumble/api/v1/channel?url=$url";
        $response = json_decode(makeGetRequest($apiUrl));

        if (empty($response->data->url) || empty($response->data->id))
        {
            return array(
                'data' => null,
                'error' => $response->message
            );
        }

        $queryString = parse_url($url, PHP_URL_QUERY);
        $queryString = $queryString ? "?$queryString" : '';

        $rumbleChannelId = $response->data->id;
        $apiUrl = 'https://dsb99.app/rumble/api/v1/channel/'.$rumbleChannelId.'/videos'.$queryString;
        $response = json_decode(makeGetRequest($apiUrl));

        $rumbleChannelIdInTable = getRumbleChannelIdInTable($rumbleChannelId);

        if (empty($rumbleChannelIdInTable))
        {
            return array(
                'data' => $response,
                'error' => 'Error: The videos belong to a rumble channel which is not in the database. Please add the rumble channel to the database first.'
            );
        }

        return array(
            'data' => $response->data->videos,
            'rumbleChannelIdInTable' => $rumbleChannelIdInTable,
            'error' => null
        );
    }
}

if (!function_exists('getRumbleChannelIdInTable'))
{
    function getRumbleChannelIdInTable($rumbleChannelId)
    {
        $queryResult = DB::table('rumble_channel')
                    ->where('rumble_id', $rumbleChannelId)
                    ->get('id')
                    ->first();

        if (empty($queryResult)) return null;

        return $queryResult->id;
    }
}

if (!function_exists('addRumbleVideoToDatabase'))
{
    function addRumbleVideoToDatabase($data, $rumbleChannelIdInTable)
    {
        try 
        {

            RumbleVideo::create([
                'rumble_channel_id' => $rumbleChannelIdInTable,
                'html' => $data->html,
                'url' => $data->url,
                'title' => $data->title,
                'thumbnail' => $data->thumbnail,
                'duration' => $data->duration,
                'uploaded_at' => convertISO8601ToMysqlDateTime($data->uploaded_at->datetime),
                'likes_count' => convertRumbleFollowersCountToInt($data->votes->up),
                'dislikes_count' => convertRumbleFollowersCountToInt($data->votes->down),
                'views_count' => convertRumbleFollowersCountToInt($data->counters->views),
                'comments_count' => convertRumbleFollowersCountToInt($data->counters->comments),
            ]);
        }
        catch (\Exception $e)
        {
            $errorInfo = $e->getMessage();

            return array(
                'success' => false,
                'error' => $errorInfo
            );
        }
        
        return array(
            'success' => true,
            'error' => null
        );
    }
}

if (!function_exists('addRumbleChannelToDatabase'))
{
    function addRumbleChannelToDatabase($data)
    {
        if (null === $data)
        {
            return array(
                'success' => false,
                'error' => 'Could not find any rumble channel with that URL. Please ensure the URL is valid or the channel exists.'
            );
        }

        try
        {
            $rumbleChannel = RumbleChannel::create([
                'rumble_id' => $data->id,
                'url' => "https://rumble.com/c/$data->id",
                'title' => $data->title,
                'joining_date' => convertRumbleJoiningDateToMysqlDateFormat($data->joining_date),
                'description' => $data->description,
                'banner' => $data->banner,
                'avatar' => $data->avatar,
                'followers_count' => convertRumbleFollowersCountToInt($data->followers_count),
                'videos_count' => convertRumbleVideosCountToInt($data->videos_count),
            ]);
        }
        catch (\Exception $e)
        {
            $errorInfo = $e->getMessage();

            return array(
                'success' => false,
                'error' => $errorInfo
            );
        }

        return array(
            'success' => true,
            'data' => $rumbleChannel,
            'error' => null
        );
    }
}

if (!function_exists('getRumbleChannelAboutData'))
{
    function getRumbleChannelAboutData($rumbleChannelUrl)
    {
        $apiUrl = "https://dsb99.app/rumble/api/v1/channel?url=$rumbleChannelUrl";
        $response = json_decode(makeGetRequest($apiUrl));

        if (empty($response->data->url) || empty($response->data->id))
        {
            return array(
                'data' => null,
                'error' => $response->message
            );
        }

        $rumbleChannelId = $response->data->id;
        $apiUrl = 'https://dsb99.app/rumble/api/v1/channel/'.$rumbleChannelId.'/about';
        $response = json_decode(makeGetRequest($apiUrl));
        $data = $response->data;
        $data->id = $rumbleChannelId;

        return array(
            'data' => $data,
            'error' => null
        );
    }
}

if (!function_exists('convertISO8601ToMysqlDateTime'))
{
    function convertISO8601ToMysqlDateTime($dateInIso8601)
    {
        $dateTime = new DateTime($dateInIso8601);
        $mysqlDateTime = $dateTime->format("Y-m-d H:i:s");
        
        return $mysqlDateTime;
    }
}

if (!function_exists('convertRumbleVideosCountToInt'))
{
    function convertRumbleVideosCountToInt($rumbleVideosCount)
    {
        return intval(getFirstWord($rumbleVideosCount));
    }
}

if (!function_exists('convertRumbleFollowersCountToInt'))
{
    function convertRumbleFollowersCountToInt($rumbleFollowersCount) 
    {
        $word = getFirstWord($rumbleFollowersCount);
        $wordLen = strlen($word);
        $lastChar = $word[$wordLen-1];

        switch ($lastChar) {

            case 'M':
                $numericValue = floatval(rtrim($word, 'M'));
                return intval($numericValue * 1000000);

            case 'K':
                $numericValue = floatval(rtrim($word, 'K'));
                return intval($numericValue * 1000);

            default:
                return intval($word);
        }
    }
}

if (!function_exists('getFirstWord'))
{
    function getFirstWord($string) 
    {
        $words = explode(" ", $string);
        return $words[0];
    }
}

if (!function_exists('convertRumbleJoiningDateToMysqlDateFormat'))
{
    function convertRumbleJoiningDateToMysqlDateFormat($rumbleJoiningDate) 
    {
        // Remove the "Joined " part from the rumble joining date
        $dateString = str_replace("Joined ", "", $rumbleJoiningDate);

        // Parse the date string
        $dateTime = DateTime::createFromFormat('M d, Y', $dateString);

        // Format the date as MySQL format
        $mysqlDate = $dateTime->format('Y-m-d');

        return $mysqlDate;
    }
}

if (!function_exists('makeGetRequest'))
{
    function makeGetRequest($url) 
    {
        // Initialize cURL
        $curl = curl_init($url);
        
        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return the response instead of printing it
        curl_setopt($curl, CURLOPT_HTTPGET, true); // Set the request method to GET

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for errors
        if ($response === false) return false;

        curl_close($curl);
        return $response;
    }
}