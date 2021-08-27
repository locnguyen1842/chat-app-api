<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseFormRequest extends FormRequest
{
    private function setDefaults()
    {
        $defaults = [];
        foreach ($this->defaults() as $key => $default) {
            if (is_null($this->$key)) {
                $defaults[$key] = $default;
            }
        }

        $this->merge($defaults);
    }


    /**
     * Set the default value for request field if this is null
     * This function will execute before validation so make sure your default value is match with the rule validation.
     *
     * @return array
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * Validate the class instance.
     *
     * @return void
     */
    public function validateResolved()
    {
        $this->setDefaults();

        $this->prepareForValidation();

        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        }

        $instance = $this->getValidatorInstance();

        if ($instance->fails()) {
            $this->failedValidation($instance);
        }

        $this->passedValidation();
    }
}
