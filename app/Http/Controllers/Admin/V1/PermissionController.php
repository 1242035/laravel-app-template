<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Requests\Admin\V1\Permission\IndexRequest;
use App\Http\Requests\Admin\V1\Permission\UpdateRequest;
use App\Http\Requests\Admin\V1\Permission\DestroyRequest;
use App\Http\Requests\Admin\V1\Permission\EditRequest;
use App\Http\Requests\Admin\V1\Permission\StoreRequest;
use App\Http\Resources\Admin\V1\PermissionResource as ItemResource;

use App\Repositories\Admin\PermissionRepository;

class PermissionController extends Controller
{
    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }
    // list, pigination
    protected function index(IndexRequest $request)
    {
        $list = $this->repository->getAll([]);
        return $this->_success( ItemResource::collection( $list ) );
    }

    //create new record
    protected function store(StoreRequest $request)
    {
        $data = $request->all();
        $item = $this->repository->store( $data );
        return $this->_success( new ItemResource( $item ) );
    }

    //delete one item
    protected function destroy(StoreRequest $request, $id)
    {
        $item = $this->repository->getById( $id );
        if( isset( $item->id ) )
        {
            $copy = $item;
            $item->delete();
            return $this->_success( new ItemResource( $copy ) );
        }
        return $this->_error( ['message' => 'not found'] , 404 );
    }

    //get one item
    protected function show(EditRequest $request, $id)
    {
        $item = $this->repository->getById( $id );
        return $this->_success( new ItemResource( $item ) );
    }

    protected function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $item = $this->repository->update( $data , $id);
        return $this->_success( new ItemResource( $item ) );
    }
}
