<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsIn implements Rule
{
    /**
     * @var string
     */
    public $table;

    /**
     * @var null|string
     */
    public $column;

    public $allowEmpty = false;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param null|string $column
     */
    public function __construct(string $table, ?string $column = 'id')
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function canBeEmpty()
    {
        $this->allowEmpty = true;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (empty($value) && $this->allowEmpty) {
            return true;
        }

        return DB::table($this->table)
            ->whereIn($this->column, $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.exists', ['attribute' => 'user_ids']);
    }
}
