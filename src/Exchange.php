<?php

namespace SunMedia;

class Exchange implements ExchangeInterface
{
    /**
     * @var array
     */
    public $currentCampaigns = [];

    /**
     * @param UserInterface $user
     * @return CampaignInterface|void|null
     */
    public function match(UserInterface $user): ?CampaignInterface {
        $validCampaign = null;
        foreach($this->currentCampaigns as $currentCampaign) {
            $campaignRangeAge = explode(":", $currentCampaign->ageSegment());
            if ($user->age() >= $campaignRangeAge[0] && $user->age() <= $campaignRangeAge[1]
                && $user->gender() == $currentCampaign->gender()
                && $user->device() == $currentCampaign->device()) {
                if ($currentCampaign->priority() == 'high') {
                    return $currentCampaign;
                }
                $validCampaign = $currentCampaign;
            }
        }
        return $validCampaign;
    }

    /**
     * @param CampaignInterface $campaign
     */
    public function addCampaign(CampaignInterface $campaign): void {
        $this->currentCampaigns[] = $campaign;
    }

    /**
     * @param CampaignInterface $campaign
     */
    public function removeCampaign(CampaignInterface $campaign): void {
        $campaignId = $campaign->id();
        for($index = 0; $index < count($this->currentCampaigns); $index++) {
            if ($this->currentCampaigns[$index]->id() == $campaignId) {
                unset($this->currentCampaigns[$index]);
                break;
            }
        }
    }

    /**
     * @return array|void
     */
    public function campaigns(): array {
        return $this->currentCampaigns;
    }

    /**
     * @param int $id
     * @return CampaignInterface|void|null
     */
    public function getCampaignById(int $id): ?CampaignInterface {
        for($index = 0; $index < count($this->currentCampaigns); $index++) {
            if ($this->currentCampaigns[$index]->id() == $id) {
                return $this->currentCampaigns[$index];
            }
        }
        return null;
    }
}
