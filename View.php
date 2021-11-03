<?php


namespace app\src\core;


class View
{
    public string $title = '';
    public array $cssFiles = array();

    public array $jsFiles = array();
    public array $jsModules = array();
    public array $typeScriptModules = array();
    public array $jsLibs = array();

    public array $scripts = array();


    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();

        echo str_replace('{{content}}', $viewContent,  $layoutContent);
    }
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/src/views/layouts/$layout.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view, $params){

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/src/views/$view.php";
        return ob_get_clean();
    }



    public function addScripts(string $dir) {
        $files = scandir($dir);

    }


    public function addCss(array $files){
        foreach ($files as $file) {
            array_push($this->cssFiles, $file);
        }
    }
    public function addJs(array $files) {
        foreach ($files as $file) {
            array_push($this->jsFiles, $file);
        }
    }
    public function addJsModule(array $files) {
        foreach ($files as $file) {
            array_push($this->jsModules, $file);
        }
    }
    public function addTypeScript(array $files) {
        foreach ($files as $file) {
            array_push($this->typeScriptModules, $file);
        }
    }


    public function addJsLib(array $files) {
        foreach ($files as $file) {
            array_push($this->jsLibs, $file);
        }
    }
}