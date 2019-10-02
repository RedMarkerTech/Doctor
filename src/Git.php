<?php


namespace App\Diagnostics;

use Exception;

class Git
{
    private $appRoot;

    public function setAppRoot($appRoot)
    {
        $this->appRoot = $appRoot;
    }
    public function getCommitHash()
    {
        if (!$this->appRoot){
            throw new Exception('appRoot not found');
        }

        $hash =  file_get_contents($this->appRoot . '/.git/refs/heads/' . $this->getCurrentBranch());

        return trim($hash); //trim the contents to remove the new line at the end
    }

    private function getCurrentBranch()
    {
        //Get an array of references ["ref: refs/heads/staging\n"]
        $arrayOfReferences = file($this->appRoot . '/.git/HEAD', FILE_USE_INCLUDE_PATH);

        $reference = $arrayOfReferences[0];

        $branchName = explode("/", $reference, 3); //seperate out by the "/" in the string

        return trim($branchName[2]); //the result needs to be trimmed as it has a "\n" at the end
    }
}
