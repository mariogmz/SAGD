<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @coversDefaultClass \App\Http\Controllers\Api\V1\PasswordController
 */
class PasswordControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $endpoint = '/v1/password';

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->setUpMock('App\User');
    }

    public function setUpMock($class)
    {
        $mock = Mockery::mock($class);
        return $mock;
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @covers ::postEmail
     * @group email
     */
    public function test_POST_email_no_email_provided() {
        $endpoint = $this->endpoint . '/email';

        $this->post($endpoint)
            ->seeJson([
                'message' => 'No se envio el correo',
                'error' => 'Email invalido'
            ])
            ->assertResponseStatus(422);
    }

    /**
     * @covers ::postEmail
     * @group email
     */
    public function test_POST_email_reset_link_is_sent()
    {
        $endpoint = $this->endpoint . '/email';

        Password::shouldReceive('sendResetLink')
            ->once()
            ->withAnyArgs()
            ->andReturn('passwords.sent');

        $this->post($endpoint, ['email' => 'ogarcia@zegucom.com.ms'])
            ->seeJson([
                'message' => 'Correo con link para reestablecer contraseña enviado correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::postEmail
     * @group email
     */
    public function test_POST_email_reset_link_is_not_sent()
    {
        $endpoint = $this->endpoint . '/email';

        Password::shouldReceive('sendResetLink')
            ->once()
            ->withAnyArgs()
            ->andReturn('passwords.user');

        $this->post($endpoint, ['email' => 'ogarcia@zegucom.com.ms'])
            ->seeJson([
                'message' => 'No se envio el correo',
                'error' => 'Usuario invalido'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @covers ::postReset
     * @group reset
     */
    public function test_POST_reset_no_token_email_password_provided()
    {
        $endpoint = $this->endpoint . '/reset';

        $this->post($endpoint)
            ->seeJson([
                'message' => 'No se reestablecio la contraseña'
            ])
            ->assertResponseStatus(422);
    }

    /**
     * @covers ::postReset
     * @group reset
     */
    public function test_POST_reset_password_was_reset()
    {
        $endpoint = $this->endpoint . '/reset';

        Password::shouldReceive('reset')
            ->once()
            ->withAnyArgs()
            ->andReturn('passwords.reset');

        $this->post($endpoint, ['token' => 'abcd', 'email' => 'ogarcia@zegucom.com.mx',
            'password' => '12345678', 'password_confirmation' => '12345678'])
            ->seeJson([
                'message' => 'La contraseña fue reestablecida correctamente'
            ])
            ->assertResponseStatus(200);
    }

    /**
     * @covers ::postReset
     * @group reset
     */
    public function test_POST_reset_password_was_not_reset()
    {
        $endpoint = $this->endpoint . '/reset';

        Password::shouldReceive('reset')
            ->once()
            ->withAnyArgs()
            ->andReturn('');

        $this->post($endpoint, ['token' => 'abcd', 'email' => 'ogarcia@zegucom.com.mx',
            'password' => '12345678', 'password_confirmation' => '12345678'])
            ->seeJson([
                'message' => 'No se pudo reestablecer la contraseña',
            ])
            ->assertResponseStatus(400);
    }
}
