<?php

namespace PhpHare;

use PhpHare\db\Database;

class Application
{
    public static string $ROOT_DIR;

    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public View $view;

    public string $PublicDir;

    public Controller $controller;
    public static Application $app;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->userClass = User::class;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->controller = new Controller();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $primaryValue = $this->session->get('user');
        if ($primaryValue){
            $primaryKey = $this->userClass::primaryKey();
            $this->user =  $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function setPublicDir(string $dir) {
        $this->PublicDir = $dir;
    }

    public function dbConnect(array $config) {
        $this->db = new Database($config);
    }

    public function run(){
        try{
            echo $this->router->resolve();
        }catch (\Exception $e){
            $this->response->setStatusCode($e->getCode());
            $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }
    // DbModel $user??
    public function logout(){
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
}