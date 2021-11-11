<?php

declare(strict_types=1);

namespace Tests\Unit\app\Http\Controllers\API;

use Tests\TestCase;

/**
 * @todo:
 *      По хорошему этот класс должен выполнять такие тесты:
 *      - Авторизация если поля прошли проверку валидности и креденшелы верные. Результат - авторизация успешна.
 *      - Авторизация если поля прошли проверку валидности и креденшелы не верные. Результат - авторизация провалилась.
 *      - Авторизация если поля не прошли проверку валидности. Результат авторизация провалилась.
 */
final class UserControllerTest extends TestCase
{
    /**
     * @test
     */
    public function it_log_in_with_valid_input()
    {
        // Given
        $data = [
            'login'    => 'user1',
            'password' => '123123',
        ];

        $response = [
            'response'     => '1',
            'errorcode'    => '0',
            'errormessage' => null,
        ];

        // When

        // Then
        $this->post('/api/Auth', $data)
            ->assertStatus(200)
            ->assertJson($response);
    }

    /**
     * @test
     */
    public function it_not_log_in_with_invalid_input()
    {
        // Given
        $data = [
            'login'    => 'user12',
            'password' => '123123',
        ];

        $response = [
            'response'     => false,
            'errorcode'    => 500,
            'errormessage' => 'Invalid credentials',
        ];

        // When

        // Then
        $this->post('/api/Auth', $data)
            ->assertStatus(200)
            ->assertJson($response);
    }
}
