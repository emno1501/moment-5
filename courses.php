<?php
//Headerinfo: typ: JSON, Tillåt att webbtjänst är tillgänglig utanför egen domän, tillåt PUT & DELETE.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");

//Inkludera klass-filer
spl_autoload_register(function ($class) {
    include $class . ".class.php";
});

//Värden för databasanslutning
define("DBHOST", "studentmysql.miun.se");
define("DBUSER", "emno1501");
define("DBPASS", "7sr8zjuo");
define("DBDATABASE", "emno1501");


$method = $_SERVER["REQUEST_METHOD"]; //Läsa in HTTP-metod
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); //Hämta värde som skickats i sökvägen
$input = json_decode(file_get_contents('php://input'),true); //Läsa in data från anrop och konvertera till JSON
$c = new Course(); //Ny instans av klass
$response = "";

//Kontrollera att första värdet i sökväg är "courses"
if($request[0] != "courses"){ 
	http_response_code(404);
	exit();
}

/* Switch-sats för HTTP-metoder som anropar metoder i Course-klassen för att hämta, 
lagra, uppdatera eller ta bort data i databasen */
switch($method) {
    case "GET": //Hämta data
        if($response = $c->getCourses()) {
            http_response_code(201); //Anrop ok
        } else {
            http_response_code(404); //Fel
            $response = array("message" => "Kurser kunde inte hittas.");
        }
        break;
    case "POST": //Lägg till data
        if( isset($input["code"]) && isset($input["name"]) && isset($input["progression"]) && isset($input["plan"])) { 
            $code = $input["code"];
            $name = $input["name"];
            $prog = $input["progression"];
            $plan = $input["plan"];
            if($c->addCourse($code, $name, $prog, $plan)) {
                http_response_code(201); //Anrop ok
                $response = array("message" => "Kurs tillagd");
            } else {
                http_response_code(500); //Serverfel
                $response = array("message" => "Kurs kunde inte uppdateras.");
            }
        } else {
            http_response_code(404); //Fel
            $response = array("message" => "Kurs kunde inte uppdateras.");
        }
        break;
    case "PUT": //Uppdatera data
        if(isset($request[1]) && isset($input["code"]) && isset($input["name"]) && isset($input["progression"]) && isset($input["plan"])) {
            $id = $request[1];
            $code = $input["code"];
            $name = $input["name"];
            $prog = $input["progression"];
            $plan = $input["plan"];
            if($c->updateCourse($id, $code, $name, $prog, $plan)) {
                http_response_code(201); //Anrop ok
                $response = array("message" => "Kurs tillagd");
            } else {
                http_response_code(500); //Serverfel
                $response = array("message" => "Kurs kunde inte uppdateras.");
            }
        } else {
            http_response_code(404); //Fel
            $response = array("message" => "Kurs kunde inte uppdateras.");
        }
        break;
    case "DELETE": //Ta bort data
        if(isset($request[1])) {
            $id = $request[1];
            if($c->deleteCourse($id)) {
                http_response_code(201); //Anrop ok
                $response = array("message" => "Kurs borttagen");
            } else {
                http_response_code(500); //Serverfel
                $response = array("message" => "Kurs kunde inte raderas");
            }
        } else {
            http_response_code(404); //Fel
            $response = array("message" => "Kurs kunde inte tas bort.");
        }
        break;
}
//Konvertera till JSON-format
echo json_encode($response);