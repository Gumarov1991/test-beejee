<?php


namespace App\Components;


class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include 'App/config/routes.php';
    }

    public function run()
    {
        $uri = $this->getUri(mb_strlen(MAIN_DIRECTORY) - 1);


        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = '\App\Controllers\\' . ucfirst(array_shift($segments) . 'Controller');
                $actionName = 'action' . ucfirst(array_shift($segments));

                $controllerObject = new $controllerName;
                $result = call_user_func_array([$controllerObject, $actionName], $segments);

                if ($result != null) {
                    break;
                }
            }
        }
    }

    private function getUri($customUriCountSymbolsForCut = 0) : string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return substr(trim($_SERVER['REQUEST_URI'], '/'), $customUriCountSymbolsForCut);
        }
    }
}