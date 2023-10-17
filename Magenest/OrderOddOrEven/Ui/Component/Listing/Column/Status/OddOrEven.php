<?php

namespace Magenest\OrderOddOrEven\Ui\Component\Listing\Column\Status;

use Magento\Ui\Component\Listing\Columns\Column;

class OddOrEven extends Column
{
    public const STATUS_ENABLED_TEXT = 'EVEN';
    public const STATUS_DISABLED_TEXT = 'ODD';

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!empty($item['entity_id'])) {
                $item['odd_or_even'] = $this->renderOddOrEvenStatus($item['entity_id']);
            }
        }

        return $dataSource;
    }

    /**
     * Rendering store visibility structure
     *
     * @param int $orderID
     *
     * @return string
     * @since 100.1.0
     */
    protected function renderOddOrEvenStatus(int $orderID)
    {
        $prepareHtml = '';
        if ($orderID) {
            if ($orderID % 2 == 0) {
                $prepareHtml .= '<span class="grid-severity-notice"><span>'
                    . self::STATUS_ENABLED_TEXT
                    . '</span></span>';
            } else {
                $prepareHtml .='<span class="grid-severity-critical"><span>'
                    . self::STATUS_DISABLED_TEXT
                    . '</span></span>';
            }
        }

        return $prepareHtml;
    }
}
