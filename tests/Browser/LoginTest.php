<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_user_can_login_successfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('viewLogin'))
                ->assertSee('CHÀO MỪNG BẠN ĐẾN VỚI JOBPRO')
                ->type('email', 'ungvien2@gmail.com')
                ->type('password', 'TranVanNhat@123')
                ->press('ĐĂNG NHẬP')
                ->assertPathIs('/')
                ->assertSee('Đăng nhập thành công');
        });
    }

    public function login_fails_with_empty_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('viewLogin'))
                ->pause(2000)
                ->press('ĐĂNG NHẬP')
                ->pause(1000)
                ->assertSee('Email không được để trống.')
                ->assertSee('Mật khẩu không được để trống.');
        });
    }

    public function login_fails_with_invalid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('viewLogin'))
                ->pause(2000)
                ->type('email', 'ungvien2@gmail.com')
                ->type('password', 'TranVanNhat@12345')
                ->press('ĐĂNG NHẬP')
                ->pause(1000)
                ->assertSee('Thông tin đăng nhập không chính xác.');
        });
    }

    public function user_can_navigate_to_register_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('viewLogin'))
                ->pause(2000)
                ->assertSee('Đăng ký ngay')
                ->clickLink('Đăng ký ngay')
                ->pause(1000)
                ->assertPathIs('/dang-ky');
        });
    }
}
