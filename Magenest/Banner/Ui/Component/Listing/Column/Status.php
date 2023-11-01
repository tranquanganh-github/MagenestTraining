<?php

namespace Magenest\Banner\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    public const STATUS_ENABLED_TEXT = 'Enable';

    public const STATUS_DISABLED_TEXT = 'Disable';

    public const STATUS_ENABLED_VALUE = 1;

    public const STATUS_DISABLED_VALUE = 0;

    /**
     * @inheirtDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (isset($item['is_active'])) {
                $item['is_active'] = $this->renderStatus($item['is_active']);
            }
        }

        return $dataSource;
    }

    /**
     * Rendering store visibility structure
     *
     * @param mixed $status
     *
     * @return string
     * @since 100.1.0
     */
    protected function renderStatus(mixed $status)
    {
        $html = '';
        if ((int)$status === self::STATUS_ENABLED_VALUE) {
            $html .= '<span class="grid-severity-notice"><span>'
                . self::STATUS_ENABLED_TEXT
                . '</span></span>';
        } elseif ((int)$status === self::STATUS_DISABLED_VALUE) {
            $html .= '<span class="grid-severity-critical"><span>'
                . self::STATUS_DISABLED_TEXT
                . '</span></span>';
        }

        return $html;
    }
}
