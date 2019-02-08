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

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
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
