<?php
namespace Core;

final class Router
{

    /*private array $routes=[];
    public function get(string $path,callable $callback):void{
        $this->routes['GET'][$path]=$callback;
    }
    public function post(string $path,callable $callback):void{
        $this->routes['POST'][$path]=$callback;
    }
    public function resolve(Request $request){
        $path=$request->path();
        $method=$request->isPost() ? 'POST' : 'GET';
        $callback=$this->routes[$method][$path] ?? false;
        if($callback===false){
            http_response_code(404);
            return "Not Found";
        }
        return call_user_func($callback,$request);
    }*/
    private array $getRoutes = [];
    private array $postRoutes = [];
    private array $getRegexRoutes = [];

    public function get(string $path, callable $handler): void
    {
        $this->getRoutes[$path] = $handler;
    }
    public function post(string $path, callable $handler): void
    {
        $this->postRoutes[$path] = $handler;
    }
    public function getRegex(string $pattern, callable $handler): void
    {
        $this->getRegexRoutes[$pattern] = $handler;
    }
    public function dispatch(Request $request, Response $response)
    {
        //conaitre le path
        $path = $request->path();
        //connaître la méthode
        $method = $request->method();
        if ($method === 'GET' && isset($this->getRoutes[$path])) {
            $this->getRoutes[$path]($request, $response);
            return;
        }
        if ($method === 'POST' && isset($this->postRoutes[$path])) {
            $this->postRoutes[$path]($request, $response);
            return;
        }

        foreach ($this->getRegexRoutes as $pattern => $handler) {
            if (preg_match($pattern, $path, $matches)) {
                $handler($request, $response, $matches);
                return;

            }
           
        }
         $response->render('not-found', [], 404);


    }

}