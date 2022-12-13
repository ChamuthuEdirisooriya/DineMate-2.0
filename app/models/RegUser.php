<?php

/**
 * User class
 */
class RegUser extends Model
{

    public function __construct()
    {
        $this->table = "reg_users";
        $this->primary_key = "user_id";
        $this->columns = [
            "user_id",
            "first_name",
            "last_name",
            "email",
            "password",
            "registered_date",
            "contact_no",
            "last_modified"
        ];
    }

    /**
     * Validate user data.
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        $this->errors = [];

        $exists = $this->findBy(['email' => $data['email']]);
        if ($exists)
            $this->errors["email"] = "Email already exists";

        if (empty($data["email"])) {
            $this->errors["email"] = "Email is required.";
        } else if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = "Email is not valid";
        }

        if (empty($data["first_name"]))
            $this->errors["first_name"] = "First name is required";

        if (empty($data["last_name"]))
            $this->errors["last_name"] = "Last name is required";

        if (empty($data["password"])) {
            $this->errors["password"] = "Password is required.";
        }
        if (empty($data["password_confirm"])) {
            $this->errors["password_confirm"] = "Password confirmation is required.";
        }
        if ($data["password"] !== $data["password_confirm"]) {
            $this->errors["password_confirm"] = "Passwords do not match.";
        }
        return empty($this->errors);
    }
}

