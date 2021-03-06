<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/../backend/rbx.php");

    header("Content-Type: text/plain");
    
    $key = get_api_key($_GET["apiKey"]);

    if (!$key || $key["usage"] !== "get_security_information")
    {
        exit(json_encode([
            "Message" => "No HTTP resource was found that matches the request URI 'https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ."'."
        ]));
    }

    $statement = $GLOBALS["sql"]->prepare("SELECT `numeric_version` FROM `client_versions` WHERE `year` = ? AND `latest` = 1");
    $statement->execute([$key["version"]]);
    
    $data = [];

    foreach ($statement as $result)
    {
        $data[] = $result["numeric_version"];
    }

    exit(json_encode([
        "data" => $data
    ]));
?>