<?php 

namespace App\View\Composers;

use App\Models\User;
use App\Services\AdminComposerService;
use Illuminate\View\View;

class AdminMainComposer
{
    public function compose(View $view)
    {
        $view->with([
            'admins' => User::where('is_admin', 1)->get(),
        ] + array_merge(
            AdminComposerService::getWidgets(),
            AdminComposerService::getPopularTags(),
            AdminComposerService::getPopularCategories(),
            AdminComposerService::getPopularPosts(),
            AdminComposerService::getRecentPosts(),
        ));
    }
} 