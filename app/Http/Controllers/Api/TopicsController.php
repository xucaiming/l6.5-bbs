<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\User;
use App\Http\Queries\TopicQuery;

class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return new TopicResource($topic);
    }

    public function destroy(Topic $topic)
    {

        $this->authorize('destroy', $topic);
        $topic->delete();
        return response(null, 204);
    }


    // 以下注释代码优化 抽象了app/Http/Queries/TopicQuery.php 查询类

    /*public function index(Request $request, Topic $topic)
    {
//        $query = $topic->query();
//        if($categoryId = $request->category_id){
//            $query->where('category_id', $categoryId);
//        }
//        $topics = $query
//                ->with('user', 'category')
//                ->withOrder($request->order)
//                ->paginate();

        // 引入 spatie/laravel-query-builder 扩展包后
        $topics = QueryBuilder::for(Topic::class)
                ->allowedIncludes('user', 'category')
                ->allowedFilters([  //搜索过滤
                    'title',  //模糊匹配
                    AllowedFilter::exact('category_id'), // 精准匹配
                    AllowedFilter::scope('withOrder')->default('recentReplied'), // 模型查询范围
                ])
                ->paginate();

        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request, User $user)
    {
        $query = $user->topics()->getQuery();

        $topics = QueryBuilder::for($query)
                ->allowedIncludes(['user', 'category']) // 模型关联关系
                ->allowedFilters([  //搜索过滤
                    'title',  //模糊匹配
                    AllowedFilter::exact('category_id'), // 精准匹配
                    AllowedFilter::scope('withOrder')->default('recentReplied'), // 模型查询范围
                ])
                ->paginate();
        return TopicResource::collection($topics);
    }

    public function show($topicId)
    {
        $topic = QueryBuilder::for(Topic::class)
                ->allowedIncludes(['user', 'category'])
                ->findOrFail($topicId);

        return new TopicResource($topic);
    }*/

    public function index(Request $request, TopicQuery $query)
    {
        $topics = $query->paginate();

        return TopicResource::collection($topics);
    }

    public function userIndex(Request $request, User $user, TopicQuery $query)
    {
        $topics = $query->where('user_id', $user->id)->paginate();

        return TopicResource::collection($topics);
    }

    public function show($topicId, TopicQuery $query)
    {
        $topic = $query->findOrFail($topicId);
        return new TopicResource($topic);
    }
}
