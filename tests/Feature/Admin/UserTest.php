<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Userモデルをインポート

class UserTest extends TestCase
{
    use RefreshDatabase; // データベースの初期化を追加

    /**
     * A basic feature test example.
     */
    public function test_user_not_login_administrator(): void
    {
        $response = $this->get('/admin/index');

        $response->assertRedirect('/admin/login');
    }

    public function testAuthenticatedUserCannotAccessAdminMemberList()
    {
        $user = User::factory()->create(); // factoryメソッドの修正
        $this->actingAs($user); 

        $response = $this->get('/admin/member-list');

        $response->assertStatus(403); 
    }

    public function testAuthenticatedAdminCanAccessAdminMemberList()
    {
        $admin = User::factory()->create(['role' => 'admin']);  // factoryメソッドの修正
        $this->actingAs($admin); 

        $response = $this->get('/admin/member-list');

        $response->assertStatus(200); 
    }

    public function testUnauthenticatedUserCannotAccessMemberDetail()
    {
        $response = $this->get('/admin/users/1'); 

        $response->assertRedirect('/login'); 
    }

    public function testAuthenticatedUserCannotAccessAdminMemberDetail()
    {
        $user = User::factory()->create(); // factoryメソッドの修正
        $this->actingAs($user);

        $response = $this->get('/admin/users/1'); 

        $response->assertStatus(403);
    }

    public function testAuthenticatedAdminCanAccessAdminMemberDetail()
    {
        $admin = User::factory()->create(['role' => 'admin']); // factoryメソッドの修正
        $this->actingAs($admin);

        $response = $this->get('/admin/users/1'); 
        $response->assertStatus(200);
    }
}
