<?php

use \Robo\Tasks;
use \coverallskit\robo\loadTasks as CoverallsKitTasks;
use \holyshared\peridot\robo\loadTasks as PeridotTasks;


/**
 * Class RoboFile
 */
class RoboFile extends Tasks
{

    use CoverallsKitTasks;
    use PeridotTasks;

    public function specAll()
    {
        $result = $this->taskPeridot()
            ->directoryPath('spec')
            ->run();

        return $result;
    }

    public function coverallsUpload()
    {
        $result = $this->taskCoverallsKit()
            ->configureBy('.coveralls.toml')
            ->run();

        return $result;
    }

}
