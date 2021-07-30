<?php

namespace controller;

use Exception;
use service\AdsController as ServiceAdsController;

class AdsController extends Base
{
    function __construct()
    {
        $this->service = new ServiceAdsController();
    }

    protected function OnInput()
    {
        parent::OnInput();
    }

    protected function OnOutput()
    {
        parent::OnOutput();
    }


    /**
     * Get all ads
     * 
     * GET
     * 
     * @return array [
     *  {
     *      "id": "1",
     *      "text": "Advertisement1",
     *      "price": "300",
     *      "limit": "1000",
     *      "banner": "https://linktoimage1.png"
     *  },
     *  {
     *      "id": "2",
     *      "text": "Advertisement5",
     *      "price": "400",
     *      "limit": "1100",
     *      "banner": "https://linktoimage2.png"
     *  }
     * ]
     */
    public function GETAction()
    {
        $ads = $this->model->get('Ad')->getAll();
        return $ads ?? [];
    }

    /**
     * Сreate new ad
     * 
     * POST {
     *  text=Advertisement1,
     *  price=300,
     *  limit=1000,
     *  banner=https://linktoimage.png
     * }
     * 
     * @param string text
     * @param int price
     * @param int limit
     * @param string banner
     * @return array [
     *  "message": "OK",
     *  "code": 200,
     *  "data": {
     *      "id": 1,
     *      "text": "Advertisement1",
     *      "banner": "https://linktoimage.png"   
     *  }
     * ]
     * 
     */
    public function POSTAction()
    {
        $id = $this->service->create($this->input);

        return [
            'id'     => $id,
            'text'   => $this->input['text'],
            'banner' => $this->input['banner']
        ];
    }

    /**
     * Edit existing ad
     * 
     * POST /:id {
     *  text=Advertisement1,
     *  price=450,
     *  limit=1200,
     *  banner=https://linktoimage.png
     * }
     */
    public function derPOSTAction()
    {
        $ad = $this->service->getById($this->last);
        if (isset($ad) && !empty($ad)) {
            if (!empty($this->input)) {
                $this->input['id'] = $this->last;
                $edit = $this->service->update($this->input);
                if (!$edit) {
                    throw new Exception('Update error', 500);
                }
            } else {
                throw new Exception('Invalid data', 400);
            }
        } else {
            throw new Exception('Invalid id', 400);
        }

        return [
            'id'     => $this->input['id'],
            'text'   => $this->input['text'],
            'banner' => $this->input['banner']
        ];
    }

    /**
     * Get most relevant ad
     * 
     * GET
     * 
     * @return array [
     *  "message": "OK",
     *  "code": 200,
     *  "data": {
     *      "id": 1,
     *      "text": "Advertisement1",
     *      "banner": "https://linktoimage.png"   
     *  }
     * ]
     */
    public function relevantAction()
    {
        if (!$this->isGet()) {
            throw new Exception('Invalid method', 405);
        }

        $relevantAd = $this->model->get('Ad')->getRelevant();
        if (isset($relevantAd) && !empty($relevantAd)) {
            $updateLimit = $this->service->updateLimit($relevantAd['id']);
            if (!$updateLimit) {
                throw new Exception('Update limit error', 500);
            }
        } else {
            $relevantAd = [];
        }

        return $relevantAd;
    }

}
