<?php 

namespace App\View\Composers;

use App\Models\Post;
use App\Models\User;
use App\Services\AdminComposerService;
use Illuminate\View\View;

class AdminMainComposer
{
    public function compose(View $view)
    {
        $service = new AdminComposerService();

        $view->with([
            'admins' => User::where('is_admin', 1)->get(),
            // Widgets
            'users_count' => User::count('id'),
            'avg_views' => ceil(Post::avg('views')),
            'posts_count' => Post::count('id'),
            'avg_rating' => $service->getAvgRating(),
        ] + array_merge(
            $service->getPopularTags(),
            $service->getPopularCategories(),
            $service->getPopularPosts(),
            $service->getRecentPosts(),
        ));
    }
} 