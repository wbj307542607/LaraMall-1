<?php

namespace App\Presenters;

class AsidePresenter
{
    /**
     * 通过 URL 保持标签打开状态
     *
     * @param array $path
     * @return string
     * @author: Luoyan
     */
    public function openTag(array $path)
    {
        if (in_array(\Request::path(), $path)) {
            return 'open active';
        }
    }

    /**
     * 显示标签
     *
     * @param array $path
     * @return string
     * @author: Luoyan
     */
    public function displayBlock(array $path)
    {
        if (in_array(\Request::path(), $path)) {
            return 'style=display:block;overflow:hidden;';
        }
    }
}