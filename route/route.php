<?php

namespace College\Ddcollege\Route;
class route
{
    public function RouteToController($url, $routes)
    {
//        $extension = pathinfo($url, PATHINFO_EXTENSION);
//
//        // Check if the file extension is ".php"
//        if ($extension === 'php') {
//            $_SESSION["error_code"] = 403;
//            return $this->abort(403);
//        }

        if (array_key_exists($url, $routes)) {
            if ($this->CheckForRestricted($url)) {
                $_SESSION["error_code"] = 403;
                return $this->abort(403);
            }
            require $routes[$url];
        } else {
            $this->abort(404);
        }
        return false;
    }

    public function abort($code): bool|int
    {
        require "restricted.php";
        return http_response_code($code);
    }

    public function CheckForRestricted($url)
    {
        $arr = array("/managefaculty", "/register");
        foreach ($arr as $custom_array) {
            if ($custom_array == $url && $_SESSION["user_role"] != "admin") {
                return true;
            }
        }
        return false;
    }
}