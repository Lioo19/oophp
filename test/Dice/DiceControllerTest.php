<?php

namespace Lioo19\Dice;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceControllerTest extends TestCase
{
    private $controller;
    private $app;

    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp(): void
    {
        global $di;

        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $this->app = $app;
        $di->set("app", $app);

        // Create and initiate the controller
        $this->controller = new DiceController();
        $this->controller->setApp($app);
        // $this->controller->initialize();
    }

    /**
     * Call the controller debug action.
     */
    public function testDebugAction()
    {
        $res = $this->controller->debugAction();
        $this->assertIsString($res);
        $this->assertContains("Debug", $res);
    }

    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller init action.
     */
    public function testInitAction()
    {
        $res = $this->controller->initAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller startdice action.
     * Get
     */
    public function testStartDiceAction()
    {
        $res = $this->controller->startdiceAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller startdicePOST action.
     */
    public function testStartDiceActionPost()
    {
        $res = $this->controller->startdiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller playdice action.
     * Get
     */
    public function testPlayDiceAction()
    {
        $res = $this->controller->playdiceAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $res = $this->controller->playdiceAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller playdicePOST action.
     */
    public function testPlayDiceActionPost()
    {
        $res = $this->controller->playDiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $this->app->request->setPost("throwcomputer", "throwcomputer");
        $res = $this->controller->playDiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $this->app->request->setPost("throwcomputer", "throwcomputer");
        // $this->app = "computerChoseSave";
        // HUR SÄTTER MAN VARIABLER TILL SAKER??
        $res = $this->controller->playDiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $this->app->request->setPost("newturn", "newturn");
        $res = $this->controller->playDiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $this->app->request->setPost("save", "save");
        $res = $this->controller->playDiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $this->app->request->setPost("throw", "throw");
        $res = $this->controller->playDiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);

        $this->app->request->setPost("restart", "Restart");
        $res = $this->controller->playDiceActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller playdicePOST action.
     */
    public function testThrowAction()
    {
        $res = $this->controller->throwAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller playdicePOST action.
     */
    public function testSaveAction()
    {
        $res = $this->controller->saveAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller playdicePOST action.
     */
    public function testNewturnAction()
    {
        $res = $this->controller->newturnAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller winorlose action.
     * Get
     */
    public function testWinorloseAction()
    {
        $res = $this->controller->winorloseAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller winorlose action.
     * Post
     */
    public function testWinorloseActionPost()
    {
        $res = $this->controller->winorloseActionPost();
        $this->assertNull($res);
        $this->app->request->setPost("restart", "Restart");
        $res = $this->controller->winorloseActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
