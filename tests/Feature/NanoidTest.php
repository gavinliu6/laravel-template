<?php

use Illuminate\Support\Str;

describe('Nanoid functionality', function () {
    it('generates a valid nanoid with correct length and characters', function () {
        $nanoid = Str::nanoid();

        expect($nanoid)
            ->toBeString()
            ->toHaveLength(12)
            ->toMatch('/^[0-9a-z]{12}$/');
    });

    it('generates unique nanoids on multiple calls', function () {
        $nanoids = collect(range(1, 10))->map(fn () => Str::nanoid());

        expect($nanoids)
            ->toHaveCount(10);

        // Each nanoid should have correct format
        $nanoids->each(function ($nanoid) {
            expect($nanoid)
                ->toHaveLength(12)
                ->toMatch('/^[0-9a-z]{12}$/');
        });

        // All nanoids should be unique
        expect($nanoids->unique()->count())->toBe(10);
    });

    it('validates correct nanoid strings', function () {
        $validNanoids = [
            'a1b2c3d4e5f6',
            '0123456789ab',
            'abcdefghijkl',
            'z9y8x7w6v5u4',
        ];

        foreach ($validNanoids as $nanoid) {
            expect(Str::isNanoid($nanoid))->toBeTrue();
        }
    });

    it('rejects invalid nanoid strings', function () {
        $invalidCases = [
            'short', // Too short
            'toolongstringhere', // Too long
            'a1b2c3d4e5fG', // Contains uppercase
            'a1b2c3d4e5f!', // Contains special characters
            'a1b2c3d4e5f ', // Contains space
            '', // Empty string
            null, // Null value
            123, // Integer
            [], // Array
        ];

        foreach ($invalidCases as $invalid) {
            expect(Str::isNanoid($invalid))->toBeFalse();
        }
    });

    it('works with Stringable objects', function () {
        $validNanoid = 'a1b2c3d4e5f6';
        $invalidNanoid = 'invalid';

        expect(Str::of($validNanoid)->isNanoid())->toBeTrue();
        expect(Str::of($invalidNanoid)->isNanoid())->toBeFalse();
    });

    it('generates nanoids with consistent format', function () {
        $nanoids = collect(range(1, 100))->map(fn () => Str::nanoid());

        // All should be exactly 12 characters
        expect($nanoids->every(fn ($id) => strlen($id) === 12))->toBeTrue();

        // All should only contain lowercase alphanumeric characters
        expect($nanoids->every(fn ($id) => preg_match('/^[0-9a-z]{12}$/', $id)))->toBeTrue();
    });
});
