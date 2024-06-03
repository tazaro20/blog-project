<?php

namespace App\HTML;

class Form
{
    private $data;
    private $errors;

    public function __construct($data, $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label): string
    {
        $value = ($this->getValue($key));
        $type = $key === "password" ? "password" : "text";
        return <<<HTML
<div class="form-group">
    <label for="{$key}">{$label}</label>
    <input type="{$type}" id="{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>
    {$this->getErrorFeedback($key)}
</div>
HTML;
    }

    private function getValue(string $key): ?string
    {
        if (is_array($this->data)) {
            return $this->data[$key] ?? null;
        }
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        if (method_exists($this->data, $method)) {
            $value = $this->data->$method();
            if ($value instanceof \DateTimeInterface) {
                return $value->format('Y-m-d H:i:s');
            }
            return $value;
        }
        return null;
    }

    private function getInputClass(string $key): string
    {
        $inputClass = 'form-control';
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    private function getErrorFeedback(string $key): string
    {
        if (isset($this->errors[$key])) {
            $error = is_array($this->errors[$key]) ? implode('<br>', array_map('htmlspecialchars', $this->errors[$key])) : htmlspecialchars($this->errors[$key]);
            return '<div class="invalid-feedback">' . $error . '</div>';
        }
        return '';
    }

    public function textarea(string $key, string $label): string
    {
        $value = htmlspecialchars($this->getValue($key));
        return <<<HTML
<div class="form-group">
    <label for="field{$key}">{$label}</label>
    <textarea id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" required>{$value}</textarea>
    {$this->getErrorFeedback($key)}
</div>
HTML;
    }
}
