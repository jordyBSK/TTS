<?php
use GuzzleHttp\{Client};
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
class GraphHelper
{
    private static string $clientId;
    private static string $tenantId;
    private static Graph $userClient;
    public static string $userToken;
    
    public static function initializeGraphForUserAuth(): void
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $dotenv->required(['CLIENT_ID', 'TENANT_ID', 'GRAPH_USER_SCOPES', 'CLIENT_SECRET']);
        GraphHelper::$clientId = $_ENV['CLIENT_ID'];
        GraphHelper::$tenantId = $_ENV['TENANT_ID'];
        GraphHelper::$userClient = new Graph();
    }

    public static function login()
    {
        GraphHelper::initializeGraphForUserAuth();
        if ($_GET['action'] == 'login') {
            $login_url = "https://login.microsoftonline.com/" . GraphHelper::$tenantId . "/oauth2/v2.0/authorize";
            $params = array('client_id' => GraphHelper::$clientId,
                'redirect_uri' => 'http://localhost:8080/3Dpage.php',
                'response_type' => 'token',
                'response_mode' => 'form_post',
                'scope' => 'https://graph.microsoft.com/User.Read',
                'state' => $_SESSION['state']);
            header('Location: ' . $login_url . '?' . http_build_query($params));
        }
        echo '
    <script> url = window.location.href;
    i=url.indexOf("#");
    if(i>0) {
     url=url.replace("#","?");
     window.location.href=url;}
    </script>';
        if (array_key_exists('access_token', $_POST)) {
            $_SESSION['t'] = $_POST['access_token'];
            $token = $_SESSION['t'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token,
                'Conent-type: application/json'));
            curl_setopt($ch, CURLOPT_URL, "https://graph.microsoft.com/v1.0/me/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $rez = json_decode(curl_exec($ch), 1);
            if (array_key_exists('error', $rez)) {
                var_dump($rez['error']);
                die();
            } else {
                $_SESSION['msatg'] = 1;  //auth and verified
                $_SESSION['uname'] = $rez["displayName"];
                $_SESSION['id'] = $rez["id"];

            }
            curl_close($ch);
            header('Location: http://localhost:8080/3Dpage.php');
            //GET ROOM
            GraphHelper::$userClient->setAccessToken($token);
            $scheduleFile = fopen("schedules.json", "w");
            fwrite($scheduleFile, json_encode("application/json"));
            fclose($scheduleFile);
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
            $roomEmails = array_map(function ($filteredRooms) {
                $properties = $filteredRooms->getProperties();
                return $properties["emailAddress"];
            }, $filteredRooms);
            $globalarray = array();
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
                    array_push($globalarray, $scheduleData);

                }
            }
            $scheduleFile = fopen("schedules.json", "w");
            fwrite($scheduleFile, json_encode($globalarray));
            fclose($scheduleFile);
        }
        if ($_GET['action'] == 'logout') {
            unset ($_SESSION['msatg']);
            header('Location: http://localhost:8080/3Dpage.php');
        }

    }
}
