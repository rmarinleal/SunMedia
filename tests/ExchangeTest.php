<?php

namespace SunMedia\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SunMedia\CampaignInterface;
use SunMedia\Exchange;
use SunMedia\ExchangeInterface;
use SunMedia\UserInterface;

class ExchangeTest extends TestCase
{
    public function test_exchange_is_created()
    {
        $exchange = new Exchange();

        $this->assertInstanceOf(ExchangeInterface::class, $exchange);
    }

    public function test_exchange_add_high_priority_campaign()
    {
        $campaign = $this->createMock(CampaignInterface::class);
        $campaign->method('id')->willReturn(1);
        $campaign->method('priority')->willReturn('high');
        $exchange = new Exchange();

        $exchange->addCampaign($campaign);

        $campaigns = $exchange->campaigns();

        $this->assertEquals(1, count($campaigns));
        $campaign = array_pop($campaigns);
        $this->assertEquals(1, $campaign->id());
    }

    public function test_exchange_adds_low_priority_campaign()
    {
        $campaign = $this->createMock(CampaignInterface::class);
        $campaign->method('id')->willReturn(1);
        $campaign->method('priority')->willReturn('low');
        $exchange = new Exchange();

        $exchange->addCampaign($campaign);

        $campaigns = $exchange->campaigns();

        $this->assertEquals(1, count($campaigns));
        $campaign = array_pop($campaigns);
        $this->assertEquals(1, $campaign->id());
    }

    public function test_exchange_removes_high_priority_campaign()
    {
        $campaign = $this->createMock(CampaignInterface::class);
        $campaign->method('id')->willReturn(1);
        $campaign->method('priority')->willReturn('high');
        $exchange = new Exchange();
        $exchange->addCampaign($campaign);

        $exchange->removeCampaign($campaign);

        $expectedCampaign = $exchange->getCampaignById(1);
        $this->assertNull($expectedCampaign);
    }

    public function test_exchange_removes_low_priority_campaign()
    {
        $campaign = $this->createMock(CampaignInterface::class);
        $campaign->method('id')->willReturn(1);
        $campaign->method('priority')->willReturn('low');
        $exchange = new Exchange();
        $exchange->addCampaign($campaign);

        $exchange->removeCampaign($campaign);

        $expectedCampaign = $exchange->getCampaignById(1);
        $this->assertNull($expectedCampaign);
    }

    public function test_exchange_matches_high_priority_before_low_priority()
    {
        $user = $this->createMock(UserInterface::class);
        $user->method('age')->willReturn(22);
        $user->method('gender')->willReturn('female');
        $user->method('device')->willReturn('mobile');
        $campaign1 = $this->createCampaignMock([
            'priority' => 'high',
            'id' => 1,
        ]);
        $campaign2 = $this->createCampaignMock([
            'priority' => 'low',
            'id' => 2,
        ]);
        $exchange = new Exchange();
        $exchange->addCampaign($campaign1);
        $exchange->addCampaign($campaign2);
        $expectedCampaign = $exchange->match($user);
        $this->assertEquals(1, $expectedCampaign->id());
    }

    public function test_exchange_matches_low_priority_campaigns()
    {
        $campaign = $this->createCampaignMock([
            'priority' => 'low',
        ]);
        $user = $this->createMock(UserInterface::class);
        $user->method('age')->willReturn(22);
        $user->method('gender')->willReturn('female');
        $user->method('device')->willReturn('mobile');
        $exchange = new Exchange();
        $exchange->addCampaign($campaign);

        $expectedCampaign = $exchange->match($user);

        $this->assertEquals(1, $expectedCampaign->id());
    }

    public function test_exchange_matches_high_priority_campaigns()
    {
        $campaign = $this->createCampaignMock();
        $user = $this->createMock(UserInterface::class);
        $user->method('age')->willReturn(23);
        $user->method('gender')->willReturn('female');
        $user->method('device')->willReturn('mobile');
        $exchange = new Exchange();
        $exchange->addCampaign($campaign);

        $expectedCampaign = $exchange->match($user);

        $this->assertEquals(1, $expectedCampaign->id());
    }

    public function test_exchange_do_not_matches_user_with_age_segment()
    {
        $campaign = $this->createCampaignMock();
        $user = $this->createMock(UserInterface::class);
        $user->method('age')->willReturn(30);
        $user->method('gender')->willReturn('female');
        $user->method('device')->willReturn('mobile');
        $exchange = new Exchange();
        $exchange->addCampaign($campaign);

        $expectedCampaign = $exchange->match($user);

        $this->assertNull($expectedCampaign);
    }

    public function test_exchange_do_not_matches_user_with_gender()
    {
        $campaign = $this->createCampaignMock();
        $user = $this->createMock(UserInterface::class);
        $user->method('age')->willReturn(22);
        $user->method('gender')->willReturn('male');
        $user->method('device')->willReturn('mobile');
        $exchange = new Exchange();
        $exchange->addCampaign($campaign);

        $expectedCampaign = $exchange->match($user);

        $this->assertNull($expectedCampaign);
    }

    public function test_exchange_do_not_matches_user_with_device()
    {
        $campaign = $this->createCampaignMock();
        $user = $this->createMock(UserInterface::class);
        $user->method('age')->willReturn(22);
        $user->method('gender')->willReturn('female');
        $user->method('device')->willReturn('desktop');
        $exchange = new Exchange();
        $exchange->addCampaign($campaign);

        $expectedCampaign = $exchange->match($user);

        $this->assertNull($expectedCampaign);
    }

    /**
     * @param array $data
     * @return MockObject|CampaignInterface
     */
    private function createCampaignMock(array $data = [])
    {
        $campaign = $this->createMock(CampaignInterface::class);
        $campaign->method('id')->willReturn($data['id'] ?? 1);
        $campaign->method('priority')->willReturn($data['priority'] ?? 'high');
        $campaign->method('gender')->willReturn($data['gender'] ?? 'female');
        $campaign->method('device')->willReturn($data['device'] ?? 'mobile');
        $campaign->method('ageSegment')->willReturn($data['ageSegment'] ?? '20:25');
        return $campaign;
    }
}
