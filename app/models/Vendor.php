<?php

namespace models;
// Vendor class
use core\Model;

class Vendor extends Model
{

    public function __construct()
    {
        $this->table = "vendors";
        $this->columns = [
            "vendor_name",
            "address",
            "company",
            "contact_no",
            "email"
        ];
    }

    public function validate(array $data): bool
    {
        $this->errors = [];

        if (empty($data['name']))
            $this->errors['name'] = 'Name is required';

        if (empty($this->errors))
            return true;

        return false;
    }

    public function getVendors(): bool|array
    {
        return $this->select()->fetchAll();
    }

    public function addVendor($data): void
    {
        $this->insert($data);
    }

    public function deleteVendor($data)
    {
       
    }
}

