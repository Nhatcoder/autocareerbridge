<?php

namespace App\Services\Custommer;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\User\UserRepositoryInterface;

/**
 * Class CustommerService
 * @package App\Services\Custommer
 *
 * @author Tran Van Nhat <trannhat7624@gmail.com>
 * @since 1.0.0
 */
class CustommerService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userReponsitory;

    /**
     * CustommerService constructor.
     * @param UserRepositoryInterface $userReponsitory
     */
    public function __construct(UserRepositoryInterface $userReponsitory)
    {
        $this->userReponsitory = $userReponsitory;
    }

    /**
     * Register a new user
     *
     * @param array $data
     */
    public function register(array $data)
    {
        if (empty($data)) {
            return null;
        }
        $this->userReponsitory->create($data);
    }

    /**
     * Login a user
     *
     * @param array $data
     */
    public function login(array $data)
    {
        if (empty($data)) {
            return ['success' => false, 'message' => 'Dữ liệu không đầy đủ.'];
        }
        $user = $this->userReponsitory->getUserByEmail($data['email']);
        $credentialsByEmail = ['email' => $data['email'], 'password' => $data['password']];

        if (auth()->guard('web')->attempt($credentialsByEmail)) {
            $user = auth()->guard('web')->user();
            if ($user->email_verified_at !== null && $user->active === ACTIVE) {
                return ['success' => true, 'message' => 'Đăng nhập thành công.', 'user' => $user];
            }

            if ($user->email_verified_at !== null && $user->active === INACTIVE) {
                return ['success' => false, 'message' => 'Tài khoản đang bị khóa.'];
            }
        }

        return ['success' => false, 'message' => 'Tài khoản không chính xác.'];
    }

    /**
     * Login a user by google
     */
    public function loginWithGoogle()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = $this->userReponsitory->getUserByEmail($googleUser->email);

        if (!$user) {
            $user = $this->userReponsitory->create([
                'name' => $googleUser->name,
                'avatar_path' => $googleUser->avatar,
                'email' => $googleUser->email,
                'password' => null,
                'role' => ROLE_USER,
                'active' => ACTIVE,
                'google_id' => $googleUser->id,
                'email_verified_at' => now(),
            ]);
        } else {
            $this->userReponsitory->update($user->id, [
                'google_id' => $googleUser->id
            ]);
        }

        auth()->guard('web')->login($user);

        return ['success' => true, 'message' => 'Đăng nhập thành công.', 'user' => $user];
    }

    /**
     * Update profile a user
     *
     * @param array $data
     */
    public function updateProfile($data)
    {
        $user = $this->userReponsitory->find($data['id']);
        if (empty($user) && empty($data)) {
            return null;
        }
        $user->update($data);
        return $user;
    }

    /**
     * Update password a user
     *
     * @param array $data
     */
    public function updatePassword($data)
    {
        $user = $this->userReponsitory->getUserById($data['id']);
        if (empty($user) && empty($data)) {
            return null;
        }

        if (Hash::check($data['password_old'], $user->password)) {
            $user->update([
                'password' => $data['password'],
            ]);
            return $user;
        }
    }

    /**
     * Update avatar a user
     *
     * @param array $data
     */
    public function updateAvatar($data): mixed
    {
        $user = $this->userReponsitory->find($data['id']);
        if (empty($user) && empty($data)) {
            return null;
        }

        if (!empty($user->avatar_path)) {
            $filePath = str_replace('/storage', '', $user->avatar_path);
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        if ($data['avatar_path'] && $data['avatar_path']->isValid()) {
            $data['avatar_path'] = $data['avatar_path']->store('avatars', 'public');
            $data['avatar_path'] = '/storage/' . $data['avatar_path'];
        }

        $user->update([
            'avatar_path' => $data['avatar_path'],
        ]);
        return $user;
    }
}
