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
