<?php

use Microsoft\Graph\Graph;
use Microsoft\Graph\Http;
use Microsoft\Graph\Model;
use GuzzleHttp\{Client};
class GraphHelper
{
    private static Client $tokenClient;
    private static string $clientId = '';
    private static string $tenantId = '';
    private static string $graphUserScopes = '';
    private static Graph $userClient;
    private static string $userToken;

    public static function initializeGraphForUserAuth(): void
    {
        GraphHelper::$tokenClient = new Client();
        GraphHelper::$clientId = $_ENV['CLIENT_ID'];
        GraphHelper::$tenantId = $_ENV['TENANT_ID'];
        GraphHelper::$graphUserScopes = $_ENV['GRAPH_USER_SCOPES'];
        GraphHelper::$userClient = new Graph();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public static function getUserToken(): string
    {
        // If we already have a user token, just return it
        // Tokens are valid for one hour, after that it needs to be refreshed
        if (isset(GraphHelper::$userToken)) {
            return GraphHelper::$userToken;
        }

        // https://learn.microsoft.com/azure/active-directory/develop/v2-oauth2-device-code
        $deviceCodeRequestUrl = 'https://login.microsoftonline.com/' . GraphHelper::$tenantId . '/oauth2/v2.0/devicecode';
        $tokenRequestUrl = 'https://login.microsoftonline.com/' . GraphHelper::$tenantId . '/oauth2/v2.0/token';

        // First POST to /devicecode
        $deviceCodeResponse = json_decode(GraphHelper::$tokenClient->post($deviceCodeRequestUrl, [
            'form_params' => [
                'client_id' => GraphHelper::$clientId,
                'scope' => GraphHelper::$graphUserScopes
            ]
        ])->getBody()->getContents());

        // Display the user prompt
        print($deviceCodeResponse->message . PHP_EOL);

        // Response also indicates how often to poll for completion
        // And gives a device code to send in the polling requests
        $interval = (int)$deviceCodeResponse->interval;
        $device_code = $deviceCodeResponse->device_code;

        // Do polling - if attempt times out the token endpoint
        // returns an error
        while (true) {
            sleep($interval);

            // POST to the /token endpoint
            $tokenResponse = GraphHelper::$tokenClient->post($tokenRequestUrl, [
                'form_params' => [
                    'client_id' => GraphHelper::$clientId,
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:device_code',
                    'device_code' => $device_code
                ],
                // These options are needed to enable getting
                // the response body from a 4xx response
                'http_errors' => false,
                'curl' => [
                    CURLOPT_FAILONERROR => false
                ]
            ]);

            if ($tokenResponse->getStatusCode() == 200) {
                // Return the access_token
                $responseBody = json_decode($tokenResponse->getBody()->getContents());
                GraphHelper::$userToken = $responseBody->access_token;
                return $responseBody->access_token;
            } else if ($tokenResponse->getStatusCode() == 400) {
                // Check the error in the response body
                $responseBody = json_decode($tokenResponse->getBody()->getContents());
                if (isset($responseBody->error)) {
                    $error = $responseBody->error;
                    // authorization_pending means we should keep polling
                    if (strcmp($error, 'authorization_pending') != 0) {
                        throw new Exception('Token endpoint returned ' . $error, 100);
                    }
                }
            }
        }
    }

    /**
     * @throws \Microsoft\Graph\Exception\GraphException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public static function getRoom(): void
    {
        $token = GraphHelper::getUserToken();
        GraphHelper::$userClient->setAccessToken($token);
        $graph = new Graph();
        $graph->setBaseUrl("https://graph.microsoft.com/v1.0/");
        $graph->setAccessToken($token);
        $rooms = $graph->createRequest("GET", "https://graph.microsoft.com/v1.0/places/microsoft.graph.room")
            ->setReturnType(Model\Room::class)
            ->execute();
        $filteredRooms = array_filter($rooms, function ($room) {
            return str_contains($room->getDisplayName(), "Lausanne");
        });
        $jsonData = json_encode($filteredRooms);
        file_put_contents("rooms.json", $jsonData);
        $roomEmails = array_map(function($filteredRooms) {
            $properties = $filteredRooms->getProperties();
            return $properties["emailAddress"];
        }, $filteredRooms);
        foreach ($roomEmails as $roommail) {
            $currentTime = time();
            $startDateTime = date("c", $currentTime);
            $endDateTime = date("c", $currentTime + 1);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://graph.microsoft.com/v1.0/users/" . urlencode($roommail) . "/calendar/calendarView?startDateTime=" . urlencode($startDateTime) . "&endDateTime=" . urlencode($endDateTime),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer " . $token,
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $schedules = json_decode($response);
                $availability = "Available";
                if (count($schedules->value) > 0) {
                    $availability = "Not available";
                }

                $scheduleData = array(
                    "roomName" => $roommail,
                    "availability" => $availability
                );

                $scheduleFile = fopen("schedules.json", "a");
                fwrite($scheduleFile, "\n".json_encode($scheduleData, JSON_PRETTY_PRINT));
                fclose($scheduleFile);

                echo "Schedules saved in schedules.json";
            }
            }
        }
}
