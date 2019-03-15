<?php
declare(strict_types=1);

namespace App\Tests\UserInterface\Web\Controller;

use App\UserInterface\Web\Controller\HomeController;
use PHPUnit\Framework\TestCase;

/**
 * Class HomeControllerTest
 * @package App\Tests\UserInterface\Web\Controller
 */
class HomeControllerTest extends TestCase
{
    /**
     * @var HomeController
     */
    private $homeController;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->homeController = new HomeController();
    }

    /**
     * @test
     */
    public function homeOk(): void
    {
        $result = $this->homeController->home();

        $this->assertEmpty($result->getContent());
        $this->assertEquals(200, $result->getStatusCode());
    }
}

