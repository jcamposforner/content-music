<?php

namespace App\Http\Controllers;

use App\Content;
use App\Http\Requests\ContentRequest;
use App\Repositories\ContentRepositoryInterface;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class ContentController extends Controller
{
    /**
     * @var ContentRepositoryInterface
     */
    protected $repository;

    /**
     * ContentController constructor.
     * @param ContentRepositoryInterface $repository
     */
    public function __construct(ContentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $content = Content::with(['user', 'image'])->limit(25)->get();

        return response()->json([
            'status'  => 200,
            'data'    => $content,
            'message' => ''
        ]);
    }

    /**
     * @param ContentRequest $request
     * @param Content $content
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(ContentRequest $request, Content $content)
    {
        $content->title       = $request->title;
        $content->description = $request->description;
        $content->src         = Uuid::generate()->string;
        $content->user()->associate($request->user());
        $content->save();

        return response()->json([
            'status'  => 201,
            'data'    => $content,
            'message' => 'Successfully created'
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $content = $this->repository->find($id);

        return response()->json([
            'status'  => 200,
            'data'    => $content,
            'message' => 'Edited'
        ]);
    }

    /**
     * @param ContentRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContentRequest $request, $id)
    {
        $content = Content::findOrFail($id);

        if (!$this->canChange($request, $content)) {
            return $this->unauthorizedResponse();
        }

        $content->title = $request->title;
        $content->description = $request->description;
        $content->save();

        return response()->json([
            'status'  => 200,
            'data'    => $content,
            'message' => 'Edited'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $content = Content::findOrFail($id);
        if (!$this->canChange($request, $content)) {
            return $this->unauthorizedResponse();
        }

        $content->delete();

        return response()->json([
            'status'  => 204,
            'data'    => '',
            'message' => 'Deleted'
        ]);
    }

    /**
     * @param Request $request
     * @param $content
     * @return bool
     */
    protected function canChange(Request $request, $content): bool
    {
        return $request->user()->id === $content->user_id;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorizedResponse(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 403,
            'data' => '',
            'message' => 'Unauthorized'
        ]);
    }
}
