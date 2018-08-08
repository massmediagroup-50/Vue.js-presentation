<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAddressToFirmProfileRequest;
use App\Http\Requests\AddEmployeeToFirmProfileRequest;
use App\Http\Requests\UpdateFirmProfileRequest;
use App\Services\FirmProfileService;

class FirmProfileController extends Controller
{
    protected $user;
    protected $firm;
    protected $service;

    /**
     * FirmProfileController constructor.
     * @param FirmProfileService $firmProfileService
     */
    public function __construct(FirmProfileService $firmProfileService)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->firm = $this->user ? $this->user->firm : null;

            return $next($request);
        });

        $this->service = $firmProfileService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return response()->json([
            'profile' => $this->user->firm->transformed()
        ]);
    }

    /**
     * @param UpdateFirmProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFirmProfileRequest $request)
    {
        $input = $request->json('profile');
        $this->service->update($this->firm, $this->user, $input);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param AddAddressToFirmProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAddress(AddAddressToFirmProfileRequest $request)
    {
        $input = $request->json('address');
        $this->service->addAddress($this->firm, $input);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeAddress($id)
    {
        $this->service->removeAddress($this->firm, $id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param AddEmployeeToFirmProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addEmployee(AddEmployeeToFirmProfileRequest $request)
    {
        $input = $request->json('employee');
        $this->service->addEmployee($this->firm, $input);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function removeEmployee($id)
    {
        $this->service->removeEmployee($this->firm, $id);

        return response()->json([
            'success' => true
        ]);
    }
}
