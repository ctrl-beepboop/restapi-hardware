<?php


namespace App\APICall;


use App\Action\POST\Room;
use App\Action\POST\User;

class POSTCall
{
    private string $request;
    private string $action;

    private function convertRequestUrl(string $request)
    {
        $request = explode('/', $request);

        $this->request = ucfirst($request[2]);

        if (isset($request[3])) {
            $this->action = $request[3];
        }
    }

    /**
     * @param string $request
     * @return POSTCall|null
     */
    public function callRequest(string $request)
    {
        $this->convertRequestUrl($request);

        if ($this->isRequestCallable()) {
            $functionString = [$this, 'callPOST' . $this->request];

            return call_user_func($functionString);
        }

        return null;
    }

    /**
     * @return bool
     */
    private function isRequestCallable(): bool
    {
        $namespace = 'App\\Action\\POST\\' . $this->request;
        $path = BASE_PATH . '/src/Action/POST/' . $this->request . '.php';

        if (!file_exists($path)) {
            return false;
        }

        if (!class_exists($namespace)) {
            return false;
        }

        return true;
    }

    /**
     * @return User
     */
    private function callPOSTUser(): User
    {
        return User::initPOSTUser($this, $this->action);
    }

    private function callPOSTRoom(): Room
    {
        return Room::initPOSTRoom($this, $this->action);
    }
}