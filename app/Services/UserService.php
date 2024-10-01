<?php

namespace App\Services;

use App\Repositories\Interfaces\ICartRepository;
use App\Repositories\Interfaces\IUserPermissionRepository;
use App\Repositories\Interfaces\IUserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;



class UserService extends BaseService
{
    private $cartRepo;
    private $userPermissionRepo;
    public function __construct(
     IUserRepository $repository,
     ICartRepository $cartRepo,
     IUserPermissionRepository $userPermissionRepo)
    {
        $this->repository = $repository;
        $this->cartRepo = $cartRepo;
        $this->userPermissionRepo = $userPermissionRepo;
    }

    public function login(string $email, string $password)
    {
        $user = $this->repository->login($email, $password);

        if (!$user) {
            return null;
        }

        $token = $this->createToken($user);
        return $token;
    }
    public function register(array $data)
    {
        // $data['id_role'] = 2;
        // $data['money']= 0;
        $user = $this->create($data);
        $token =$this->createToken($user);

        return $token;
    }

    public function createToken($user)
    {
        $token = JWTAuth::customClaims(['sub=' > $user->id])->fromUser($user);

        return $token;
    }

    public function isAdmin($id)
    {
        $this->repository->isAdmin($id);

    }

    public function updateBySelf(array $data)
    {
        $userId = $this->getCurrentUserId();
        $user = $this->update($userId, $data );
        return $user;
    }

    public function create(array $data)
    {
        DB:: beginTransaction();
        try{
            //$userPermissionId = null;
        if(isset($data['permission_id']))
        {
            $userPermissionId = $data['permission_id'];
            unset($data['permission_id']);
        }
        $user = $this->repository->create($data);
        if($userPermissionId != null)
        {
            $userPermission= [
                'permission_id'=>$userPermissionId,
                'user_id'=> $user->id
            ];
            $this->userPermissionRepo->create($userPermission);

        }
        $userIdArray = ['user_id' => $user->id];
        $this->cartRepo->create($userIdArray);
        DB:: commit();

        return $user;

        }
        catch(Exception $e)
        {
            DB::rollBack();
            throw $e;
        }

    }

    public function getSelf()
    {
        $userPermissions = auth()->user()->userPermissions;
        foreach ($userPermissions as $userPermission) {
            $userPermission->permission;
        }
        return auth()->user();
    }

}
