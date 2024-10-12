<?php

//Contains helper functions


function getBasePath()
{
    // Get the current script path
    $scriptPath = $_SERVER['PHP_SELF'];

    // Find the position of the last '/' in the path
    $lastSlashPosition = strrpos($scriptPath, '/');

    // If a '/' is found, return the path up to the last '/'
    if ($lastSlashPosition !== false) {
        return substr($scriptPath, 0, $lastSlashPosition + 1); // Include the last '/'
    }

    // Return an empty string if no '/' is found
    return '';
}


function getPath($uri)
{

    $path = substr($uri, strlen(getBasePath()));
    $path = strtok($path, '?');
    if (!isset($path) || trim($path) == "") $path = "/";
    return ["route" => $path, "params" => $_GET];
}
function getRequiredArguments(ReflectionMethod $reflectionMethod)
{
    $requiredArgs = [];
    foreach ($reflectionMethod->getParameters() as $parameter) {
        if (!$parameter->isOptional()) {
            echo $parameter->getName();
            $requiredArgs[$parameter->getName()] = null;
        }
    }
    return $requiredArgs;
}

function filterByRequiredArguments(array $otherArray, ReflectionMethod $reflectionMethod)
{
    $requiredArgs = getRequiredArguments($reflectionMethod);
    return array_intersect_key($otherArray, $requiredArgs);
}
