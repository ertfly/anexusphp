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
            exit('Root path is not a directory, not readable or not writable' . "\033[0m" . chr(10));
        }

        $panelName = 'App';
        if (isset($param['-p']) && trim($param['-p'] != '')) {
            $panelName = strtolower($param['-p']);
        }

        $this->assets($panelName);
        $this->routes($panelName, $param);
        $this->app($panelName, $param);
        $this->view($panelName, $param);
    }

    public static function help()
    {
        echo "    ___    _   ___  __" . chr(10);
        echo "   /   |  / | / / |/ /" . chr(10);
        echo "  / /| | /  |/ /|   / " . chr(10);
        echo " / ___ |/ /|  //   |  " . chr(10);
        echo "/_/  |_/_/ |_//_/|_|  " . chr(10);
        echo "                      " . chr(10);

        echo "\033[1;33m" . "Usage:" . "\033[0m" . chr(10);
        echo "\tphp anx create-panel [params]" . chr(10) . chr(10);

        echo "\033[1;33m" . "Params:" . "\033[0m" . chr(10);
        echo "\t-p [optional-panel-name]" . chr(10);
        echo "\t-ak [public-app-key]" . chr(10);
        echo "\t-sk [secret-key]" . chr(10);
        echo "\t--help - See this helper" . chr(10);


        exit(chr(10));
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

    private function routes($panelName, $param)
    {
        $app = ucwords($panelName);
        $module = ucwords($panelName);
        $path = strtolower(($app == 'App' ? '/' : '/' . $app));

        $index = $this->getTemplate('Route' . DS . 'PanelRoute', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{prefix}}' => $path,
            '{{route}}' => $app
        ]);

        $login = $this->getTemplate('Route' . DS . 'LoginRoute', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{prefix}}' => $path . 'account',
        ]);

        $files = [
            PATH_ROUTES . $app . DS . $module . 'Routes.php' => $index,
            PATH_ROUTES . $app . DS . 'AccountRoutes.php' => $login,
        ];

        foreach ($files as $key => $value) {
            $this->file_force_contents($key, $value);
        }
    }

    private function app($panelName, $param)
    {
        $app = ucwords($panelName);
        $module = ucwords($panelName);

        $login = $this->getTemplate('Controller' . DS . 'LoginController', [
            '{{app}}' => $app
        ]);

        $model = $this->getTemplate('Model' . DS . 'LoginModel', [
            '{{app}}' => $app,
            '{{app_key}}' => (isset($param['-ak']) && trim($param['-ak']) != '' ? $param['-ak'] : 'app-key'),
            '{{secret_key}}' => (isset($param['-sk']) && trim($param['-sk']) != '' ? $param['-sk'] : 'secret-key')
        ]);

        $index = $this->getTemplate('Controller' . DS . 'LoginIndexController', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{path}}' => strtolower($app),
        ]);

        $middleware = $this->getTemplate('Middleware' . DS . 'LoginMiddleware', [
            '{{app}}' => $app,
            '{{session_name}}' => strtolower($app)
        ]);

        $files = [
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . 'Account' . DS . 'Controllers' . DS . 'AccountController.php' => $login,
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . 'Account' . DS . 'Models' . DS . 'AccountModel.php' => $model,
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules' . DS . $module . DS . 'Controllers' . DS . $module . 'Controller.php' => $index,
            PATH_ROOT . 'src' . DS . $app . DS . 'Modules/Middleware.php' => $middleware,
        ];

        foreach ($files as $key => $value) {
            $this->file_force_contents($key, $value);
        }
    }

    private function view($panelName, $param)
    {
        $app = ucwords($panelName);
        $module = ucwords($panelName);

        $view = $this->getTemplate('View' . DS . 'Login', [
            '{{app}}' => $app,
            '{{module}}' => $module,
            '{{app_key}}' => (isset($param['-ak']) && trim($param['-ak']) != '' ? $param['-ak'] : 'app-key')
        ]);

        $initial = $this->getTemplate('View' . DS . 'InitialPanel');

        $template = $this->getTemplate('Template' . DS . 'PanelTemplate', [
            '{{app}}' => $app
        ]);

        $headerIn = $this->getTemplate('View' . DS . 'HeaderInPanel', [
            '{{app}}' => $app,
            '{{path}}' => strtolower($app) . '/'
        ]);
        $headerOut = $this->getTemplate('View' . DS . 'HeaderOutPanel', [
            '{{app}}' => $app,
            '{{path}}' => strtolower($app) . '/'
        ]);

        $footerIn = $this->getTemplate('View' . DS . 'FooterInPanel');
        $footerOut = $this->getTemplate('View' . DS . 'FooterOutPanel');
        $messageModal = $this->getTemplate('View' . DS . 'MessageModalPanel');
        $breadcrumb = $this->getTemplate('View' . DS . 'Breadcrumb');

        $files = [
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . 'account' . DS . 'index.phtml' => $view,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . strtolower($app) . DS . 'index.phtml' => $initial,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . 'include' . DS . 'headerIn.phtml' => $headerIn,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . 'include' . DS . 'headerOut.phtml' => $headerOut,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . 'include' . DS . 'footerIn.phtml' => $footerIn,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . 'include' . DS . 'footerOut.phtml' => $footerOut,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . 'include' . DS . 'messageModal.phtml' => $messageModal,
            PATH_ROOT . 'src' . DS . $app . DS . 'Views' . DS . 'include' . DS . 'breadcrumb.phtml' => $breadcrumb,
            PATH_ROOT . 'src' . DS . $app . DS . 'Template.php' => $template,
        ];

        foreach ($files as $key => $value) {
            $this->file_force_contents($key, $value);
        }
    }
}
