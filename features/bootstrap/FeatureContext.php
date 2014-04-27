<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Tester\ApplicationTester;
use Behat\Gherkin\Node\TableNode;


/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{

    private $filesystem;
    private $testFolderPath;
    private $applicationTester;

    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->testFolderPath = __DIR__."/../../_test";

        $application = new \Mariposa\Console\Application("0.1.0");
        $application->setAutoExit(false);
        $this->applicationTester = new ApplicationTester($application);
    }

    /**
     * @BeforeScenario
     */
    public function createTestBlogFolder()
    {
        if ($this->filesystem->exists($this->testFolderPath)) {
            $this->filesystem->remove($this->testFolderPath);
        }
        $this->filesystem->mkdir($this->testFolderPath);
    }


    /**
     * @Given I have an :arg1 file that contains :arg2
     */
    public function iHaveAnFileThatContains($filename, $contents)
    {
        $fullFilePath = $this->testFolderPath . "/" . $filename;
        file_put_contents($fullFilePath, $contents);
    }


    /**
     * @When I run mariposa build
     */
    public function iRunMariposaBuild()
    {

        $this->applicationTester->run(array(
            'build',
            '--source' => $this->testFolderPath,
            '--dest' => $this->testFolderPath . '/site'
        ));
    }

    /**
     * @Then the site directory should exist
     */
    public function theSiteDirectoryShouldExist()
    {
        $siteDirPath = $this->testFolderPath . "/site";
        return $this->filesystem->exists($siteDirPath);
    }

    /**
     * @Given I should see :arg1 in :arg2
     */
    public function iShouldSeeIn($content, $filename)
    {

        $fullFilePath = $this->testFolderPath . "/" . $filename;
        if (!$this->filesystem->exists($fullFilePath)) {
            throw new \Exception($fullFilePath. " does not exist");
        }


        $fileContents = file_get_contents($fullFilePath);
        if (strpos($fileContents, $content) === FALSE ){
            throw new \Exception($filename . " does not contain '".$content."'");
        }
    }

    /**
     * @Given I have a :arg1 directory
     */
    public function iHaveADirectory($directoryName)
    {
        if (!$this->filesystem->exists($this->testFolderPath . "/" . $directoryName)) {
            $this->filesystem->mkdir($this->testFolderPath . "/" . $directoryName);
        }
    }

    /**
     * @Given I have the following post:
     */
    public function iHaveTheFollowingPost(TableNode $table)
    {
        $headers = $table->getRow(0);
        $data = $table->getRow(1);

        $post = array();

        foreach ($headers as $key => $header) {
            $post[$header] = $data[$key];
        }

        $content = <<<HEREDOC
---
title: {$post['title']}
layout: default
---
{$post['content']}
HEREDOC;

        $filename = $post['date'].".markdown";
        $this->filesystem->dumpFile($this->testFolderPath . "/posts/".$filename, $content);
    }
}
