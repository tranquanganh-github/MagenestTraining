<?php

namespace Magenest\Banner\Block\Adminhtml\Edit\Button;

class Back extends Generic
{
    /**
     * Get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get url for movie
     *
     * @return string
     */
    protected function getBackUrl()
    {
        return $this->getUrl('magenest/banner/index');
    }
}
