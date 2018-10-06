<?php
/**
 * Created by PhpStorm.
 * User: yagihash
 * Date: 2018/09/27
 * Time: 20:09
 */

namespace Tests\Unit;

use App\Exceptions\InsufficientRoleException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\PromotionRequest;
use Illuminate\Support\Facades\Hash;
use Exception;

class PromotionRequestTest extends TestCase
{
    use RefreshDatabase;

    protected static function createUser(int $role_id = User::ROLE_USER): User
    {
        return User::create([
            'name' => str_random(8),
            'password' => Hash::make(str_random(8)),
            'role_id' => $role_id,
        ]);
    }

    protected static function createRequest(string $user_id, int $role_id = User::ROLE_SETTER): PromotionRequest
    {
        return PromotionRequest::create([
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);
    }

    public function testRequestGeneration()
    {
        $user = self::createUser();
        $req = self::createRequest($user->id);
        $this->assertNotNull($req);
    }

    public function testRequestApprovalSuccess()
    {
        $user = self::createUser();
        $admin = self::createUser(User::ROLE_ADMIN);
        $req = self::createRequest($user->id);
        $req->approve($admin);
        $this->assertTrue($req->done);
    }

    public function testRequestApprovalFail()
    {
        $user = self::createUser();
        $not_admin = self::createUser();
        $req = self::createRequest($user->id);
        try {
            $req->approve($not_admin);
        } catch (Exception $e) {
            $this->assertInstanceOf(InsufficientRoleException::class, $e);
            $this->assertNull($req->done);
        }
    }

}