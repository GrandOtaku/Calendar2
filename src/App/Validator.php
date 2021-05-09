<?php

namespace App;

class Validator
{

    private $data;
    protected $errors = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
    public function validates(array $data)
    {
        $this->errors = [];
        $this->data = $data;
    }

    public function validate(string $field, string $method, ...$parameters): bool
    {
        if (!isset($this->data[$field])) {
            $this->errors[$field] = "$field フィールドが入力されていません";
            return false;
        } else {
            return call_user_func([$this, $method], $field, ...$parameters);
        }
    }

    public function minLength(string $field, int $length): bool
    {
        if (mb_strlen($field) < $length) {
            $this->errors[$field] = "フィールドには $length 文字以上が必要です";
            return false;
        }
        return true;
    }
    public function date(string $field): bool
    {
        if (\DateTime::createFromFormat('Y-m-d', $this->data[$field]) === false) {
            $this->errors[$field] = "日付が有効ではないようです";
            return false;
        }
        return true;
    }
    public function time(string $field): bool
    {
        if (\DateTime::createFromFormat('H:i', $this->data[$field]) === false) {
            $this->errors[$field] = "時間は有効ではないようです";
            return false;
        }
        return true;
    }
    public function beforeTime(string $startField, string $endField)
    {
        if ($this->time($startField) && $this->time($endField)) {
            $start = \DateTime::createFromFormat('H:i', $this->data[$startField]);
            $end = \DateTime::createFromFormat('H:i', $this->data[$endField]);
            if($start->getTimestamp() > $end->getTimestamp()) {
                $this->errors[$startField] = "開始前に終了を開始することはできません";
                return false;
            }
            return true;
        }
        return false;
    }
}
