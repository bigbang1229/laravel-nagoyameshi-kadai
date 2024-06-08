<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
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
    $user = factory(User::class)->create(); 
    $this->actingAs($user); 

    $response = $this->get('/admin/login');

    $response->assertStatus(403); 
}
public function testAuthenticatedAdminCanAccessAdminMemberList()
    {
        $admin = factory(User::class)->create(['role' => 'admin']); 
        $this->actingAs($admin); 

        $response = $this->get('/admin/login');

        $response->assertStatus(200); 
    }

}
