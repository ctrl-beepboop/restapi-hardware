<?php


namespace App\Action\POST;


use App\APICall\POSTCall;
use App\DataMapper\Mapper;
use App\Service\RoomService;

class Room
{
    /**
     * @param POSTCall $call
     * @param string $action
     * @return Room
     */
    public static function initPOSTRoom(POSTCall $call, string $action): Room
    {
        return new self($action);
    }

    /**
     * Room constructor.
     * @param string $action
     */
    private function __construct(string $action)
    {
        $actionToCall = [$this, $action];

        return call_user_func($actionToCall);
    }

    private function upload(): void
    {
        $serviceClass = new RoomService();

        if (!$serviceClass->isFileTypeAllowed()) {
            exit();
        }

        $mapper = new Mapper();
        $selectStmt = $mapper->buildStmt('SELECT * FROM `rooms`');
        $selectStmt->executeStmt();
        $roomCount = $selectStmt->count() + 1;

        $filename = "Room-{$roomCount}";

        $serviceClass->setNewFilename($filename);

        if ($serviceClass->uploadFile()) {
            $insertStmt = $mapper->buildStmt('INSERT INTO `rooms` (`room_title`, `active`, `order`) VALUES (:title, :active, :order)');
            $insertStmt->bindValues(['title' => $filename, 'active' => 1, 'order' => $roomCount]);
            $insertStmt->executeStmt();
        }

        exit();
    }


}