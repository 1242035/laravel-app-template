<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\User\IndexRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Requests\Api\V1\User\DestroyRequest;
use App\Http\Requests\Api\V1\User\EditRequest;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Http\Resources\Api\V1\User\UserResource;

use App\Repositories\Api\UserRepository;

class UserController extends Controller
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    // list, pigination
    protected function index(IndexRequest $request)
    {
        $list = $this->repository->getAll([]);
        return $this->_success( UserResource::collection( $list ) );
    }

    //create new record
    protected function store(StoreRequest $request)
    {
        $data = $request->all();
        $item = $this->repository->store( $data );
        return $this->_success( new UserResource( $item ) );
    }

    //delete one item
    protected function destroy(StoreRequest $request, $id)
    {
        $item = $this->repository->getById( $id );
        if( isset( $item->id ) )
        {
            $copy = $item;
            $item->delete();
            return $this->_success( new UserResource( $copy ) );
        }
        return $this->_error( ['message' => 'not found'] , 404 );
    }

    //get one item
    protected function show(EditRequest $request, $id)
    {
        $item = $this->repository->getById( $id );
        return $this->_success( new UserResource( $item ) );
    }

    protected function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $item = $this->repository->update( $data , $id);
        return $this->_success( new UserResource( $item ) );
    }
}
