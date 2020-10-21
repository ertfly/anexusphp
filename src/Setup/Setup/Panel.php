<?php

namespace AnexusPHP\Setup\Setup;

use AnexusPHP\Interfaces\Anx\AnxInterface;
use AnexusPHP\Setup\Anx;

class Panel extends Anx implements AnxInterface
{
    public function __construct($param, $option)
    {
        $this->run($param, $option);
    }

    public function run(array $param = [], array $option = []): void
    {
        if (!is_dir(PATH_ROOT) || !is_readable(PATH_ROOT) || !is_writable(PATH_ROOT)) {
            exit('Root path is not a directory, not readable or not writable' . chr(10));
        }

        if (!empty($param['-p'] && trim($param['-p'] != ''))) {
            $panelName = strtolower($param['-p']);
        } else {
            exit('Please, enter the panel name!' . chr(10));
        }

        $this->assets($panelName);
        $this->routes($panelName, $param);
    }

    private function assets($panelName)
    {
        $files = [
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'css' . DS . 'base_in.css' => file_get_contents(Anx::PATH_BASE . 'Css' . DS . 'base_in.css'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'css' . DS . 'base_out.css' => file_get_contents(Anx::PATH_BASE . 'Css' . DS . 'base_out.css'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'css' . DS . 'login.css' => file_get_contents(Anx::PATH_BASE . 'Css' . DS . 'login.css'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'js' . DS . 'jquery.kurios.js' => file_get_contents(Anx::PATH_BASE . 'Js' . DS . 'jquery.kurios.js'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'js' . DS . 'resumable.js' => file_get_contents(Anx::PATH_BASE . 'Js' . DS . 'resumable.js'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'img' . DS . 'bandeira-br.png' => file_get_contents(Anx::PATH_BASE . 'Img' . DS . 'bandeira-br.png'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'img' . DS . 'favicon.png' => file_get_contents(Anx::PATH_BASE . 'Img' . DS . 'favicon.png'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'img' . DS . 'logo-topo.png' => file_get_contents(Anx::PATH_BASE . 'Img' . DS . 'logo-topo.png'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'img' . DS . 'logo.png' => file_get_contents(Anx::PATH_BASE . 'Img' . DS . 'logo.png'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'img' . DS . 'no-user.png' => file_get_contents(Anx::PATH_BASE . 'Img' . DS . 'no-user.png'),
            PATH_PUBLIC . 'assets' . DS . $panelName . DS . 'img' . DS . 'sem-imagem.jpg' => file_get_contents(Anx::PATH_BASE . 'Img' . DS . 'sem-imagem.jpg'),
        ];

        foreach ($files as $key => $value) {
            $this->file_force_contents($key, $value);
        }
    }

    private function routes($panelName, $param) {
        $app = ucwords($panelName);
        $module = ucwords($panelName);
        $path = strtolower((isset($param['-r']) && trim($param['-r']) != '' ? $param['-r'] : '/' . ($app == $module ? $app : $app . '/' . $module)));

        $index = $this->getTemplate('Route' . DS . 'IndexRoute', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{prefix}}' => $path,
            '{{route}}' => $app
        ]);

        $login = $this->getTemplate('Route' . DS . 'LoginRoute', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{prefix}}' => $path . '/account',
        ]);

        $files = [
            PATH_ROUTES . $app . DS . $module . 'Routes.php' => $index,
            PATH_ROUTES . $app . DS . 'AccountRoutes.php' => $login,
        ];

        foreach ($files as $key => $value) {
            $this->file_force_contents($key, $value);
        }
    }

    private function app() {

    }
}
