<?php
/**
 * AlertControllerTest.php
 * Definition of class AlertControllerTest
 *
 * Created 31/08/14 10:30
 *
 * @author Rasanga Perera <rasangaperera@gmail.com>
 * Copyright (c) 2014, The MIT License (MIT)
 */

namespace Ras\Bundle\AlertNotificationBundle\Tests\Controller;


use Ras\Bundle\AlertNotificationBundle\Service\AlertReportingService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AlertControllerTest extends WebTestCase
{

    /**
     * @test
     * @covers \Ras\Bundle\AlertNotificationBundle\Controller\AlertController::displayAlertsAction
     */
    public function testDisplayAlerts()
    {
        $client = static::createClient();
        $client->request('GET', '/display_alerts');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client = static::createClient();
        /** @var AlertReportingService $alertService */
        $alertService = $client->getContainer()->get('Ras.Alert.AlertReportingService');
        $alertMessage = "Test error message";
        $alertService->addError($alertMessage);
        $crawler1 = $client->request('GET', '/display_alerts');

        $this->assertTrue($crawler1->filter("html:contains(\"{$alertMessage}\")")->count() > 0);

        $crawler2 = $client->request('GET', '/display_alerts');

        $this->assertTrue($crawler2->filter("html:contains(\"{$alertMessage}\")")->count() === 0);
    }

}
 