<?php

declare(strict_types=1);

namespace App;

class View
{
    public function render(string $page, array $params = []): void
    {
        $params = $this->escape($params);
        require_once("templates/layout.php");
    }

    private function escape(array $params): array
    {
        $clearParams = [];

        foreach($params as $key => $param) {

            // if(is_array($param)) {
            //     $clearParams[$key] = $this->escape($param);
            // } else if(is_int($param)) {
            //     $clearParams[$key] = $param;
            // } else if($param) {
            //     $clearParams[$key] = htmlentities($param);
            // } else {
            //     $clearParams[$key] = $param;
            // }

            switch (true) {
                case is_array($param):
                    $clearParams[$key] = $this->escape($param);
                    break;
                case(is_int($param)): 
                    $clearParams[$key] = $param; 
                    break;
                case($param): 
                    $clearParams[$key] = htmlentities($param);
                    break;
                default:
                    $clearParams[$key] = $param; 
                    break;

            }

        }

        return $clearParams;
    }

}