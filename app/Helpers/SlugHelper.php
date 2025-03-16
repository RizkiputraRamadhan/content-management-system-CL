<?php
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

if (!function_exists('slugVerifiedCreate')) {
    /**
     * Generate a verified slug for creation.
     *
     * @param string $path
     * @param string $name
     * @param string $table
     * @return string|null
     */
    function slugVerified(string $name): ?string
    {
        $slug = Str::slug($name) . '-' . strtolower(Str::random(5));
        return $slug;
    }
}
