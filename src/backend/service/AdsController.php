<?php declare(strict_types=1);

namespace service;

use service\Service;

class AdsController extends Service
{
    public function create(array $arrayToValidate)
    {
        $validationObject = $this->inputValidator->check($arrayToValidate);
        $validData = $this->inputValidator->callMethod($validationObject, 'getValidData');

        return $this->model->get('Ad')->create('ads', $validData);
    }

    public function update(array $arrayToValidate): bool
    {
        $validationObject = $this->inputValidator->check($arrayToValidate);
        $validData = $this->inputValidator->callMethod($validationObject, 'getValidData');

        return $this->model->get('Ad')->update('ads', $validData);
    }

    public function updateLimit(int $id): bool
    {
        $validationObject = $this->inputValidator->check(['id' => $id]);
        $validData = $this->inputValidator->callMethod($validationObject, 'getValidData');

        return $this->model->get('Ad')->query("UPDATE ads as a SET a.limit=a.limit-1 WHERE id=%i", $validData['id']);
    }

    public function getById(int $id)
    {
        $validationObject = $this->inputValidator->check(['id' => $id]);
        $validData = $this->inputValidator->callMethod($validationObject, 'getValidData');

        return $this->model->get('Ad')->getById($validData['id']);
    }

}
