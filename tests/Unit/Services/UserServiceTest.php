<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Models\User;
use Mockery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function test_register_method_creates_a_new_user(): void
    {
        $user = new User([
            'name' => 'user name',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);

        $data = [
            'name' => 'user name',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ];

        $this->userRepositoryMock->shouldReceive('create')->once()->with($data)->andReturn($user);

        $result = $this->userService->register($data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['email'], $result->email);
    }

    public function test_get_users_method_returns_all_users(): void
    {
        $users = new Collection([
            new User([
                'name' => 'user name',
                'email' => 'test@example.com',
                'is_admin' => false,
            ]),
            new User([
                'name' => 'user name 2',
                'email' => 'test2@example.com',
                'is_admin' => false,
            ]),
        ]);
        
        $this->userRepositoryMock->shouldReceive('all')
        ->once()
        ->with(['*'])
        ->andReturn($users);

        $result = $this->userService->getUsers(['*']);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($users->count(), $result->count());
        $this->assertEquals($users->first()->name, $result->first()->name);
        $this->assertEquals($users->first()->email, $result->first()->email);
        $this->assertEquals($users->first()->password, $result->first()->password);
        $this->assertEquals($users->first()->is_admin, $result->first()->is_admin);
    }


    public function test_find_methods_calls_the_repository_find_method(): void
    {
        $user = new User([
            'name' => 'user name',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);

        $this->userRepositoryMock->shouldReceive('find')->once()->with(1)->andReturn($user);

        $result = $this->userService->getUserById(1);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->name, $result->name);
        $this->assertEquals($user->email, $result->email);
        $this->assertEquals($user->is_admin, $result->is_admin);
    }
}
