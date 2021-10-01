<?php

namespace AnexusPHP\Core;

use AnexusPHP\Business\Permission\Repository\PermissionCategoryMenuRepository;
use AnexusPHP\Business\Permission\Repository\PermissionMenuRepository;
use AnexusPHP\Business\Permission\Repository\PermissionModuleRepository;

class MenuLoader
{
    /**
     * @return string
     */
    public static function getMenu(): string
    {
        if (request()->isManager) {
            return self::buildCategoryMenu(PermissionCategoryMenuRepository::byApp(request()->app->getId()));
        }

        $modules = PermissionModuleRepository::byAuthfast(request()->sid->getAuthfast());
        $menu = PermissionMenuRepository::byModules($modules, request()->app->getId());

        $categories = [];
        foreach ($menu as $value) {
            $categories[] = $value->getCategoryId();
        }
        $categories = PermissionCategoryMenuRepository::byIdList(implode(', ', $categories));

        return self::buildCategoryMenu($categories, $menu);
    }

    /**
     * @param array $categories
     * @param array|null $menu
     * @return string
     */
    private static function buildCategoryMenu(array $categories, ?array $menu = null): string
    {
        $res = '<ul>';
        foreach ($categories as $value) {
            $res .= '<li class="sub"><a href="javascript:void(0)">' . $value->getDescription() . '</a>' . self::buildMenu($value->getMenu($menu)) . '</li>';
        }
        return $res . '</ul>';
    }

    /**
     * @param array $menu
     * @return string
     */
    private static function buildMenu(array $menu): string
    {
        $res = '<ul>';
        foreach ($menu as $value) {
            $res .= '<li><a href="' . $value->getLink() . '" target="' . $value->getTarget(true) . '"><i class="' . $value->getIcon() . '"></i>' . $value->getDescription() . '</a></li>';
        }
        return $res . '</ul>';
    }
}
