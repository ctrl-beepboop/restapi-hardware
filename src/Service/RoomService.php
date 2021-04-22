<?php


namespace App\Service;


class RoomService
{
    private string $path = BASE_PATH . '/uploads/rooms/';
    private string $filetype;
    private string $newFilename;

    private array $allowedExtensions = [
        'gif', 'jpeg', 'jpg', 'pjpeg', 'png'
    ];

    public function __construct()
    {
        $this->setFileType();
    }

    private function setFileType(): string
    {
        $temp = explode(".", $_FILES["roomImage"]["name"]);
        return $this->filetype = end($temp);
    }

    public function setNewFilename(string $newfilename): string
    {
        return $this->newFilename = $newfilename;
    }

    public function isFileTypeAllowed(): bool
    {
        if (in_array($this->filetype, $this->allowedExtensions)) {
            return true;
        }

        return false;
    }

    public function uploadFile(): bool
    {
        return move_uploaded_file($_FILES["roomImage"]["tmp_name"], $this->path . $this->newFilename . '.' . $this->filetype);
    }


}