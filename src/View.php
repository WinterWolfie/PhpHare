<?php


namespace PhpHare;


class View
{
    public string $viewDir;
    public string $layoutDir;

    public string $layout;


    public function setViewDir(string $dir) {
        $this->viewDir = $dir;
    }
    public function setLayoutDir(string $dir) {
        $this->layoutDir = $dir;
    }
    public function setMainLayout(string $layout) {
        $this->layout = $layout;
    }



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
        $layout = $this->layout;
        if (Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        include_once Application::$ROOT_DIR. $this->layoutDir . $layout . ".php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view, $params){

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . $this->viewDir . $view . ".php";
        return ob_get_clean();
    }


    public array $cssFiles = array();
    public array $scripts = array();
    public array $jsLibs = array();

    public function addCss(array $files){
        foreach ($files as $file) {
            array_push($this->cssFiles, $file);
        }
    }

    public function addScript(array $files) {
        foreach ($files as $file) {
            array_push($this->scripts, $file);
        }
    }

    public function addJsLib(array $files) {
        foreach ($files as $file) {
            array_push($this->jsLibs, $file);
        }
    }
}