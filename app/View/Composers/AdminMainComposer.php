<?php 

namespace App\View\Composers;

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
        ] + array_merge(
            $service->getWidgets(),
            $service->getPopularTags(),
            $service->getPopularCategories(),
            $service->getPopularPosts(),
            $service->getRecentPosts(),
        ));
    }
} 